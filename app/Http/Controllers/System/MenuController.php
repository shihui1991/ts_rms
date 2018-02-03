<?php
/*
|--------------------------------------------------------------------------
| 功能与菜单
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\System;
use App\Http\Model\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class MenuController extends BaseController
{
    /* ========== 初始化 ========== */
    public function __construct()
    {
        parent::__construct();

        $url=request()->getPathInfo();
        $current_url=url()->current();
        $parameters=request()->route()->parameters;
        if(!blank($parameters)){
            foreach ($parameters as $parameter){
                $url=str_replace('/'.$parameter,'',$url);
                $current_url=str_replace('/'.$parameter,'',$current_url);
            }
        }

        View::share([
            'model'=>new Menu(),
            'current_url'=>$current_url,
        ]);
    }

    /* ========== 默认列表 ========== */
    public function index(Request $request)
    {
        /* ********** 查询条件 ********** */
        /* ++++++++++ 上级 ID ++++++++++ */
        $id=$request->input('id')?$request->input('id'):0;
        $where[]=['parent_id',$id];

        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $menus=Menu::withTrashed()
                ->select(['id','parent_id','module','name','login','icon','url','method','display','auth','sort','deleted_at'])
                ->withCount(['childs'=>function($query){
                    $query->withTrashed();
                }])
                ->where($where)
                ->sharedLock()
                ->orderBy('sort','asc')
                ->get();

            if(blank($menus)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $data=$menus;
            $url='';
        }catch (\Exception $exception){
            $menus=collect();
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=$menus;
            $url='';
        }
        DB::commit();
        $infos['menus']=$menus;

        /* ++++++++++ 结果 ++++++++++ */
        if($request->ajax()){
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
        }else{
            return view('system.menu.index',$infos);
        }
    }

    /* ========== 全列表 ========== */
    public function all(Request $request){
        $select=['id','parent_id','module','name','login','icon','url','method','display','auth','sort','deleted_at'];
        
        /* ********** 查询条件 ********** */
        $where=[];
        /* ++++++++++ 名称 ++++++++++ */
        $name=trim($request->input('name'));
        if($name){
            $where[]=['name','like','%'.$name.'%'];
            $infos['name']=$name;
        }
        /* ++++++++++ 路由地址 ++++++++++ */
        $url=trim($request->input('url'));
        if($url){
            $where[]=['url','like','%'.$url.'%'];
            $infos['url']=$url;
        }
        /* ++++++++++ 状态 ++++++++++ */
        $display=$request->input('display');
        if(is_numeric($display)){
            $where[]=['display',$display];
            $infos['display']=$display;
        }
        /* ********** 排序 ********** */
        $ordername=$request->input('ordername');
        $ordername=$ordername?$ordername:'sort';
        $infos['ordername']=$ordername;

        $orderby=$request->input('orderby');
        $orderby=$orderby?$orderby:'asc';
        $infos['orderby']=$orderby;
        /* ********** 每页条数 ********** */
        $nums=[15,30,50,100,200];
        $infos['nums']=$nums;
        $displaynum=$request->input('displaynum');
        $displaynum=$displaynum?$displaynum:15;
        $infos['displaynum']=$displaynum;
        /* ********** 是否删除 ********** */
        $deleted=$request->input('deleted');

        $model=new Menu();
        if(is_numeric($deleted) && in_array($deleted,[0,1])){
            $infos['deleted']=$deleted;
            if($deleted){
                $model=$model->onlyTrashed();
            }
        }else{
            $model=$model->withTrashed();
        }
        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $menus=$model->where($where)->select($select)->orderBy($ordername,$orderby)->sharedLock()->paginate($displaynum);
            if(blank($menus)){
                throw new \Exception('没有符合条件的数据',404404);
            }

            $code='error';
            $msg='查询成功';
            $data=$menus;
            $url='';
        }catch (\Exception $exception){
            $menus=collect();
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=$menus;
            $url='';
        }
        DB::commit();
        $infos['menus']=$menus;
        $infos[$code]=$msg;
        /* ********** 结果 ********** */
        if($request->ajax()){
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
        }else{
            return view('system.menu.all',$infos);
        }
    }

    /* ========== 添加 ========== */
    public function add(Request $request,$id=0){
        $model=new Menu();
        /* ********** 保存 ********** */
        if($request->isMethod('post')){
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules=[
                'parent_id'=>['required','regex:/^[0-9]+$/'],
                'name'=>'required',
                'url'=>'required',
                'display'=>'boolean',
                'sort'=>'nullable|integer',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'parent_id.regex'=>'选择正确的上级菜单',
                'boolean'=>':attribute 选择正确的选项',
                'integer'=>':attribute 必须是整数',
            ];
            $this->validate($request,$rules,$messages,$model->columns);

            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try{
                /* ++++++++++ 批量赋值 ++++++++++ */
                $menu=$model;
                $menu->fill($request->input());
                $menu->addOther($request);
                $menu->save();
                if(blank($menu)){
                    throw new \Exception('添加失败',404404);
                }
                $code='success';
                $msg='添加成功';
                $data=$menu;
                if(blank($request->input('sub_type'))){
                    $url=route('sys_menu');
                }else{
                    $url=route('sys_menu_all');
                }
                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'添加失败';
                $data=[];
                $url='';
                DB::rollBack();
            }
            /* ++++++++++ 结果 ++++++++++ */
            if($request->ajax()){
                return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
            }else{
                return redirect()->back()->withInput()->with($code,$msg);
            }
        }
        /* ********** 视图 ********** */
        else{
            /* ++++++++++ 是否通过添加子菜单进入 ++++++++++ */
            $parent=['id'=>$id,'name'=>''];
            if($id){
                DB::beginTransaction();
                $parent['name']=Menu::withTrashed()->where('id',$id)->sharedLock()->value('name');
                DB::commit();
            }
            $infos['parent']=$parent;
            $infos['sub_type']=$request->input('sub_type')??'';
            $infos['module'] = $request->input('module');
            /* ++++++++++ 输出视图 ++++++++++ */
            return view('system.menu.modify',$infos);
        }
    }

    /* ========== 详情 ========== */
    public function info(Request $request,$id=0){
        /* ********** 当前数据 ********** */
        DB::beginTransaction();
        $infos['infos']=Menu::withTrashed()
            ->with(['father'=>function($query){
                $query->withTrashed()->select(['id','name','icon']);
            }])
            ->sharedLock()
            ->find($id);
        DB::commit();
        $infos['sub_type'] = $request->input('sub_type');
        /* ********** 输出视图 ********** */
        return view('system.menu.modify',$infos);
    }

    /* ========== 修改 ========== */
    public function edit(Request $request,$id=0){
        $model=new Menu();
       if($request->isMethod('post')){
           /* ********** 表单验证 ********** */
           $rules=[
               'name'=>'required',
               'url'=>'required',
               'display'=>'boolean',
               'sort'=>'nullable|integer',
           ];
           $messages=[
               'required'=>':attribute 为必须项',
               'boolean'=>':attribute 选择正确的选项',
               'integer'=>':attribute 必须是整数',
           ];
           $this->validate($request,$rules,$messages,$model->columns);

           /* ********** 更新 ********** */
           DB::beginTransaction();
           try{
               if($request->input('parent_id')){
                   throw new \Exception('禁止修改上级菜单',404404);
               }
               /* ++++++++++ 锁定数据模型 ++++++++++ */
               $menu=Menu::withTrashed()
                   ->withCount(['childs'=>function($query){
                       $query->withTrashed();
                   }])
                   ->lockForUpdate()
                   ->find($id);

               if(blank($menu)){
                   throw new \Exception('指定数据项不存在',404404);
               }
               /* ++++++++++ 处理其他数据 ++++++++++ */
               $menu->fill($request->input());
               $menu->editOther($request);
               $menu->save();
               if(blank($menu)){
                   throw new \Exception('修改失败',404404);
               }
               $code='success';
               $msg='修改成功';
               $data=$menu;
               if(blank($request->input('sub_type'))){
                   $url=route('sys_menu');
               }else{
                   $url=route('sys_menu_all');
               }
               DB::commit();
           }catch (\Exception $exception){

               $code='error';
               $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
               $data=[];
               $url='';
               DB::rollBack();
           }
           /* ********** 结果 ********** */
           if($request->ajax()){
               return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
           }else{
               return redirect()->back()->withInput()->with($code,$msg);
           }
       }else{
           /* ********** 当前数据 ********** */
           DB::beginTransaction();
           $infos['infos']=Menu::withTrashed()
               ->with(['father'=>function($query){
                   $query->withTrashed()->select(['id','name','icon']);
               }])
               ->sharedLock()
               ->find($id);
           DB::commit();
           /* ********** 输出视图 ********** */
           return view('system.menu.modify',$infos);
       }

    }

    /* ========== 排序 ========== */
    public function sort(Request $request){
        /* ********** 验证选择数据项 ********** */
        $ids=$request->input('ids');
        if(!$ids){

            $code='warning';
            $msg='至少选择一项';
            $data=[];
            $url='';
            if($request->ajax()){
                return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
            }else{
                return redirect()->back()->withInput()->with($code,$msg);
            }
        }
        /* ********** 验证数据 ********** */
        $sorts=$request->input('sorts');
        if(blank($sorts)){

            $code='warning';
            $msg='请输入排序数据';
            $data=[];
            $url='';
            if($request->ajax()){
                return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
            }else{
                return redirect()->back()->withInput()->with($code,$msg);
            }
        }

        /* ********** 更新 ********** */
        DB::beginTransaction();
        try{
            /* ++++++++++ 锁定数据 ++++++++++ */
            $menu_ids=Menu::withTrashed()->whereIn('id',$ids)->lockForUpdate()->pluck('id');
            if(blank($menu_ids)){
                throw new \Exception('没有可排序数据');
            }
            /* ++++++++++ 整理数据 ++++++++++ */
            $values=[];
            $time=date('Y-m-d H:i:s');
            foreach ($menu_ids as $id){
                $values[]=[
                    'id'=>$id,
                    'sort'=>(int)$sorts[$id],
                    'updated_at'=>$time
                ];
            }
            /* ++++++++++ 生成更新sql ++++++++++ */
            $sqls=batch_update_sql('a_menu',['id','sort','updated_at'],$values,['sort','updated_at'],'id');
            if(!$sqls){
                throw new \Exception('数据异常，请重新输入');
            }
            /* ++++++++++ 批量更新 ++++++++++ */
            foreach ($sqls as $sql){
                DB::statement($sql);
            }


            $code='success';
            $msg='排序成功';
            $data=$values;
            $url='';
            DB::commit();
        }catch (\Exception $exception){

            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=[];
            $url='';
            DB::rollBack();
        }
        /* ********** 结果 ********** */
        if($request->ajax()){
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
        }else{
            return redirect()->back()->withInput()->with($code,$msg);
        }
    }

    /* ========== 状态 ========== */
    public function display(Request $request,$display){
        $model=new Menu();
        /* ********** 验证数据 ********** */
        $keys=array_keys($model->getDisplayAttribute());
        if(!in_array($display,$keys)){

            $code='error';
            $msg='错误操作';
            $data=[];
            $url='';
            if($request->ajax()){
                return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
            }else{
                return redirect()->back()->withInput()->with($code,$msg);
            }
        }
        /* ********** 验证选择数据项 ********** */
        $ids=$request->input('ids');
        if(!$ids){

            $code='warning';
            $msg='至少选择一项';
            $data=[];
            $url='';
            if($request->ajax()){
                return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
            }else{
                return redirect()->back()->withInput()->with($code,$msg);
            }
        }

        /* ********** 更新 ********** */
        DB::beginTransaction();
        try{
            /* ++++++++++ 锁定数据 ++++++++++ */
            $menu_ids=Menu::withTrashed()->whereIn('id',$ids)->lockForUpdate()->pluck('id');
            if(blank($menu_ids)){
                throw new \Exception('没有可修改数据');
            }
            /* ++++++++++ 批量更新 ++++++++++ */
            Menu::whereIn('id',$menu_ids)->update(['display'=>$display]);


            $code='success';
            $msg='修改成功';
            $data=$menu_ids;
            $url='';
            DB::commit();
        }catch (\Exception $exception){

            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=[];
            $url='';
            DB::rollBack();
        }
        /* ********** 结果 ********** */
        if($request->ajax()){
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
        }else{
            return redirect()->back()->withInput()->with($code,$msg);
        }
    }

    /* ========== 删除 ========== */
    public function delete(Request $request){
        /* ********** 验证选择数据项 ********** */
        $ids=$request->input('ids');
        if(!$ids){

            $code='warning';
            $msg='至少选择一项';
            $data=[];
            $url='';
            if($request->ajax()){
                return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
            }else{
                return redirect()->back()->withInput()->with($code,$msg);
            }
        }
        /* ********** 删除 ********** */
        DB::beginTransaction();
        try{
            /* ++++++++++ 锁定数据 ++++++++++ */
            $menus=Menu::select(['id'])->withCount('childs')->whereIn('id',$ids)->lockForUpdate()->get();
            if(blank($menus)){
                throw new \Exception('没有可删除数据');
            }
            $success_ids=[];
            $fail_ids=[];
            foreach ($menus as $menu){
                if($menu->childs_count){
                    $fail_ids[]=$menu->id;
                }else{
                    $success_ids[]=$menu->id;
                }
            }
            if(blank($success_ids)){
                throw new \Exception('存在子级，禁止删除');
            }
            /* ++++++++++ 批量删除 ++++++++++ */
            Menu::whereIn('id',$success_ids)->delete();


            if(blank($fail_ids)){
                $code='success';
                $msg='全部删除成功';
            }else{
                $code='warning';
                $msg='部分存在子级，禁止删除';
            }
            $data=$success_ids;
            $url='';
            DB::commit();
        }catch (\Exception $exception){

            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=[];
            $url='';
            DB::rollBack();
        }
        /* ********** 结果 ********** */
        if($request->ajax()){
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
        }else{
            return redirect()->back()->withInput()->with($code,$msg);
        }
    }

    /* ========== 恢复 ========== */
    public function restore(Request $request){
        /* ********** 验证选择数据项 ********** */
        $ids=$request->input('ids');
        if(!$ids){

            $code='warning';
            $msg='至少选择一项';
            $data=[];
            $url='';
            if($request->ajax()){
                return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
            }else{
                return redirect()->back()->withInput()->with($code,$msg);
            }
        }
        /* ********** 恢复 ********** */
        DB::beginTransaction();
        try{
            /* ++++++++++ 锁定数据 ++++++++++ */
            $menu_ids=Menu::onlyTrashed()->whereIn('id',$ids)->lockForUpdate()->pluck('id');
            if(blank($menu_ids)){
                throw new \Exception('没有可恢复的数据');
            }
            /* ++++++++++ 批量恢复 ++++++++++ */
            Menu::whereIn('id',$menu_ids)->restore();


            $code='success';
            $msg='恢复成功';
            $data=$menu_ids;
            $url='';
            DB::commit();
        }catch (\Exception $exception){

            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=[];
            $url='';
            DB::rollBack();
        }
        /* ********** 结果 ********** */
        if($request->ajax()){
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
        }else{
            return redirect()->back()->withInput()->with($code,$msg);
        }
    }

    /* ========== 销毁 ========== */
    public function destroy(Request $request){
        /* ********** 验证选择数据项 ********** */
        $ids=$request->input('ids');
        if(!$ids){

            $code='warning';
            $msg='至少选择一项';
            $data=[];
            $url='';
            if($request->ajax()){
                return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
            }else{
                return redirect()->back()->withInput()->with($code,$msg);
            }
        }
        /* ********** 销毁 ********** */
        DB::beginTransaction();
        try{
            /* ++++++++++ 锁定数据 ++++++++++ */
            $menu_ids=Menu::onlyTrashed()->whereIn('id',$ids)->lockForUpdate()->pluck('id');
            if(blank($menu_ids)){
                throw new \Exception('只能销毁已删除的数据');
            }
            /* ++++++++++ 批量销毁 ++++++++++ */
            Menu::whereIn('id',$menu_ids)->forceDelete();


            $code='success';
            $msg='销毁成功';
            $data=$menu_ids;
            $url='';
            DB::commit();
        }catch (\Exception $exception){

            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=[];
            $url='';
            DB::rollBack();
        }
        /* ********** 结果 ********** */
        if($request->ajax()){
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
        }else{
            return redirect()->back()->withInput()->with($code,$msg);
        }
    }
}
