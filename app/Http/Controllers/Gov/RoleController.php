<?php
/*
|--------------------------------------------------------------------------
| 权限与角色
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;


use App\Http\Model\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends BaseController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {

    }

    /* ++++++++++ 首页 ++++++++++ */
    public function index(Request $request)
    {
        /* ********** 查询条件 ********** */
        /* ++++++++++ 上级 ID ++++++++++ */
        $id=$request->input('id')?$request->input('id'):0;
        $where[]=['parent_id',$id];

        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $roles=Role::withTrashed()
                ->select(['id','parent_id','name','admin','deleted_at'])
                ->withCount(['childs'=>function($query){
                    $query->withTrashed();
                }])
                ->with(['dept'])
                ->where($where)
                ->sharedLock()
                ->get();

            if(blank($roles)){
                throw new \Exception('没有符合条件的数据',404404);
            }

            $error=0;
            $code='success';
            $msg='查询成功';
            $data=$roles;
            $url='';
        }catch (\Exception $exception){
            $roles=collect();

            $error=1;
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=$roles;
            $url='';
        }
        DB::commit();
        $infos['roles']=$roles;

        /* ++++++++++ 结果 ++++++++++ */
        if($request->ajax()){
            return response()->json(['error'=>$error,'code'=>$code,'message'=>$msg,'data'=>$data,'url'=>$url]);
        }else{
            return view('gov.role.index',$infos);
        }
    }

    /* ========== 全列表 ========== */
    public function all(Request $request){
        $select=['id','parent_id','name','type','deleted_at'];

        /* ********** 查询条件 ********** */
        $where=[];
        /* ++++++++++ 名称 ++++++++++ */
        $name=trim($request->input('name'));
        if($name){
            $where[]=['name','like','%'.$name.'%'];
            $infos['name']=$name;
        }
        /* ++++++++++ 类型 ++++++++++ */
        $admin=$request->input('admin');
        if(is_numeric($admin)){
            $where[]=['admin',$admin];
            $infos['admin']=$admin;
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

        $model=new Role();
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
            $roles=$model->where($where)->select($select)->orderBy($ordername,$orderby)->sharedLock()->paginate($displaynum);
            if(blank($roles)){
                throw new \Exception('没有符合条件的数据',404404);
            }

            $error=1;
            $code='error';
            $msg='查询成功';
            $data=$roles;
            $url='';
        }catch (\Exception $exception){
            $roles=collect();

            $error=1;
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=$roles;
            $url='';
        }
        DB::commit();
        $infos['roles']=$roles;
        $infos[$code]=$msg;

        /* ********** 结果 ********** */
        if($request->ajax()){
            return response()->json(['error'=>$error,'code'=>$code,'message'=>$msg,'data'=>$data,'url'=>$url]);
        }else{
            return view('gov.role.all',$infos);
        }
    }

    /* ========== 添加 ========== */
    public function add(Request $request,$id=0){
        $model=new Role();
        /* ********** 保存 ********** */
        if($request->isMethod('post')){
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules=[
                'parent_id'=>['required','regex:/^[0-9]+$/'],
                'name'=>'required|unique:role',
                'admin'=>'required'
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'parent_id.regex'=>'选择正确的上级菜单',
                'unique'=>':attribute 已存在'
            ];

            $this->validate($request,$rules,$messages,$model->columns);

            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try{
                /* ++++++++++ 批量赋值 ++++++++++ */
                $role=$model;
                $role->fill($request->input());
                $role->setOther($request);
                $role->save();

                $error=0;
                $code='success';
                $msg='添加成功';
                $data=$role;
                $url='';
                DB::commit();
            }catch (\Exception $exception){
                $error=1;
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'添加失败';
                $data=[];
                $url='';
                DB::rollBack();
            }
            /* ++++++++++ 结果 ++++++++++ */
            if($request->ajax()){
                return response()->json(['error'=>$error,'code'=>$code,'message'=>$msg,'data'=>$data,'url'=>$url]);
            }else{
                return redirect()->back()->withInput()->with($code,$msg);
            }
        }
        /* ********** 视图 ********** */
        else{
            /* ++++++++++ 当前上级 ++++++++++ */
            $parent=['id'=>$id,'name'=>''];
            if($id){
                DB::beginTransaction();
                $parent['name']=role::withTrashed()->where('id',$id)->sharedLock()->value('name');
                DB::commit();
            }
            $infos['parent']=$parent;

            /* ++++++++++ 输出视图 ++++++++++ */
            return view('gov.role.add',$infos);
        }
    }

    /* ========== 详情 ========== */
    public function info(Request $request,$id){

        /* ********** 当前数据 ********** */
        DB::beginTransaction();
        $role=Role::withTrashed()
            ->with(['father'=>function($query){
                $query->withTrashed()->select(['id','name']);
            }])
            ->sharedLock()
            ->find($id);

        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($role)){
            $error=1;
            $code='warning';
            $msg='数据不存在';
            $data=[];
            $url='';
        }else{
            $error=0;
            $code='success';
            $msg='获取成功';
            $data=$role;
            $url='';
        }
        $infos=[
            'error'=>$error,
            'code'=>$code,
            'msg'=>$msg,
            'data'=>$data,
            'url'=>$url,
        ];

        /* ********** 输出视图 ********** */
        return view('gov.role.info',$infos);
    }

    /* ========== 修改 ========== */
    public function edit(Request $request,$id){
        $model=new Role();
        if($request->isMethod('post')){
            /* ********** 表单验证 ********** */
            $rules=[
                'parent_id'=>['required','regex:/^[0-9]+$/'],
                'name'=>'required|unique:role',
                'admin'=>'required'
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'parent_id.regex'=>'选择正确的上级菜单',
                'unique'=>':attribute 已存在'
            ];
            $this->validate($request,$rules,$messages,$model->columns);

            /* ********** 更新 ********** */
            DB::beginTransaction();
            try{
                if($request->input('parent_id')){
                    throw new \Exception('非法操作',404404);
                }
                /* ++++++++++ 锁定数据模型 ++++++++++ */
                $role=Role::withTrashed()
                    ->withCount(['childs'=>function($query){
                        $query->withTrashed();
                    }])
                    ->lockForUpdate()
                    ->find($id);

                if(blank($role)){
                    throw new \Exception('指定数据项不存在',404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $role->fill($request->input());
                $role->setOther($request);
                $role->save();

                $error=0;
                $code='success';
                $msg='修改成功';
                $data=$role;
                $url='';
                DB::commit();
            }catch (\Exception $exception){
                $error=1;
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $data=[];
                $url='';
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            if($request->ajax()){
                return response()->json(['error'=>$error,'code'=>$code,'message'=>$msg,'data'=>$data,'url'=>$url]);
            }else{
                return redirect()->back()->withInput()->with($code,$msg);
            }
        }else{
            /* ********** 当前数据 ********** */
            DB::beginTransaction();
            $role=role::withTrashed()
                ->with(['father'=>function($query){
                    $query->withTrashed()->select(['id','name','icon']);
                }])
                ->sharedLock()
                ->find($id);
            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($role)){
                $error=1;
                $code='warning';
                $msg='数据不存在';
                $data=[];
                $url='';
            }else{
                $error=0;
                $code='success';
                $msg='获取成功';
                $data=$role;
                $url='';
            }
            $infos=[
                'error'=>$error,
                'code'=>$code,
                'msg'=>$msg,
                'data'=>$data,
                'url'=>$url,
            ];
            /* ********** 输出视图 ********** */
            return view('gov.role.edit',$infos);
        }
    }

    /* ========== 删除 ========== */
    public function delete(Request $request){
        /* ********** 验证选择数据项 ********** */
        $ids=$request->input('ids');
        if(!$ids){
            $error=1;
            $code='warning';
            $msg='至少选择一项';
            $data=[];
            $url='';
            if($request->ajax()){
                return response()->json(['error'=>$error,'code'=>$code,'message'=>$msg,'data'=>$data,'url'=>$url]);
            }else{
                return redirect()->back()->withInput()->with($code,$msg);
            }
        }
        /* ********** 删除 ********** */
        DB::beginTransaction();
        try{
            /* ++++++++++ 锁定数据 ++++++++++ */
            $roles=Role::select(['id'])->withCount('childs')->whereIn('id',$ids)->lockForUpdate()->get();
            if(blank($roles)){
                throw new \Exception('没有可删除数据');
            }
            $success_ids=[];
            $fail_ids=[];
            foreach ($roles as $role){
                if($role->childs_count){
                    $fail_ids[]=$role->id;
                }else{
                    $success_ids[]=$role->id;
                }
            }
            if(blank($success_ids)){
                throw new \Exception('存在子级，禁止删除');
            }
            /* ++++++++++ 批量删除 ++++++++++ */
            Role::whereIn('id',$success_ids)->delete();

            $error=0;
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
            $error=1;
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=[];
            $url='';
            DB::rollBack();
        }
        /* ********** 结果 ********** */
        if($request->ajax()){
            return response()->json(['error'=>$error,'code'=>$code,'message'=>$msg,'data'=>$data,'url'=>$url]);
        }else{
            return redirect()->back()->withInput()->with($code,$msg);
        }
    }

    /* ========== 恢复 ========== */
    public function restore(Request $request){
        /* ********** 验证选择数据项 ********** */
        $ids=$request->input('ids');
        if(!$ids){
            $error=1;
            $code='warning';
            $msg='至少选择一项';
            $data=[];
            $url='';
            if($request->ajax()){
                return response()->json(['error'=>$error,'code'=>$code,'message'=>$msg,'data'=>$data,'url'=>$url]);
            }else{
                return redirect()->back()->withInput()->with($code,$msg);
            }
        }
        /* ********** 恢复 ********** */
        DB::beginTransaction();
        try{
            /* ++++++++++ 锁定数据 ++++++++++ */
            $role_ids=Role::onlyTrashed()->whereIn('id',$ids)->lockForUpdate()->pluck('id');
            if(blank($role_ids)){
                throw new \Exception('没有可恢复的数据');
            }
            /* ++++++++++ 批量恢复 ++++++++++ */
            Role::whereIn('id',$role_ids)->restore();

            $error=0;
            $code='success';
            $msg='恢复成功';
            $data=$role_ids;
            $url='';
            DB::commit();
        }catch (\Exception $exception){
            $error=1;
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=[];
            $url='';
            DB::rollBack();
        }
        /* ********** 结果 ********** */
        if($request->ajax()){
            return response()->json(['error'=>$error,'code'=>$code,'message'=>$msg,'data'=>$data,'url'=>$url]);
        }else{
            return redirect()->back()->withInput()->with($code,$msg);
        }
    }

    /* ========== 销毁 ========== */
    public function destroy(Request $request){
        /* ********** 验证选择数据项 ********** */
        $ids=$request->input('ids');
        if(!$ids){
            $error=1;
            $code='warning';
            $msg='至少选择一项';
            $data=[];
            $url='';
            if($request->ajax()){
                return response()->json(['error'=>$error,'code'=>$code,'message'=>$msg,'data'=>$data,'url'=>$url]);
            }else{
                return redirect()->back()->withInput()->with($code,$msg);
            }
        }
        /* ********** 销毁 ********** */
        DB::beginTransaction();
        try{
            /* ++++++++++ 锁定数据 ++++++++++ */
            $role_ids=Role::onlyTrashed()->whereIn('id',$ids)->lockForUpdate()->pluck('id');
            if(blank($role_ids)){
                throw new \Exception('只能销毁已删除的数据');
            }
            /* ++++++++++ 批量销毁 ++++++++++ */
            Role::whereIn('id',$role_ids)->forceDelete();

            $error=0;
            $code='success';
            $msg='销毁成功';
            $data=$role_ids;
            $url='';
            DB::commit();
        }catch (\Exception $exception){
            $error=1;
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=[];
            $url='';
            DB::rollBack();
        }
        /* ********** 结果 ********** */
        if($request->ajax()){
            return response()->json(['error'=>$error,'code'=>$code,'message'=>$msg,'data'=>$data,'url'=>$url]);
        }else{
            return redirect()->back()->withInput()->with($code,$msg);
        }
    }
}