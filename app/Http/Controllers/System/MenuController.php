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
use Illuminate\Support\Facades\Validator;

class MenuController extends BaseController
{
    /* ========== 初始化 ========== */
    public function __construct()
    {
        parent::__construct();

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
            $menus=Menu::withCount('childs')
                ->where($where)
                ->sharedLock()
                ->orderBy('module','asc')
                ->orderBy('sort','asc')
                ->get();

            if(blank($menus)){
                throw new \Exception('没有符合条件的数据',404404);
            }

            $code='success';
            $msg='查询成功';
            $sdata=$menus;
            $edata=new Menu();
            $url=null;
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=new Menu();
            $url=null;
        }
        DB::commit();

        /* ++++++++++ 结果 ++++++++++ */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view('system.menu.index')->with($result);
        }
    }
    
    /* ========== 添加 ========== */
    public function add(Request $request){
        if($request->isMethod('get')){
            $id=$request->input('id');
            $menu=null;
            if($id){
                DB::beginTransaction();
                $menu=Menu::select(['id','module','name'])->sharedLock()->find($id);
                DB::commit();
            }
            if(blank($menu)){
                $id=0;
                $module=null;
                $name=null;
            }else{
                $module=$menu->module;
                $name=$menu->name;
            }

            $result=['code'=>'success','message'=>'请求成功','sdata'=>['id'=>$id,'module'=>$module,'name'=>$name],'edata'=>new Menu(),'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('system.menu.add')->with($result);
            }
        }
        /* ********** 保存 ********** */
        else{
            $model=new Menu();
            $modules=$model->getModuleAttribute();
            $keys=array_keys($modules);
            $keys_str=implode(',',$keys);
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules=[
                'parent_id'=>['required','regex:/^[0-9]+$/'],
                'name'=>'required',
                'module'=>'nullable|in:'.$keys_str,
                'url'=>'required',
                'login'=>'required|boolean',
                'auth'=>'required|boolean',
                'display'=>'required|boolean',
                'sort'=>'nullable|integer',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'parent_id.regex'=>'选择正确的上级',
                'in'=>':attribute 选择正确的选项',
                'boolean'=>':attribute 选择正确的选项',
                'integer'=>':attribute 必须是整数',
            ];


            $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }

            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try{
                /* ++++++++++ 批量赋值 ++++++++++ */
                $menu=$model;
                $menu->fill($request->input());
                $menu->addOther($request);
                $menu->save();
                if(blank($menu)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=$menu;
                $edata=null;
                $url=route('sys_menu');

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'保存失败';
                $sdata=null;
                $edata=null;
                $url=null;

                DB::rollBack();
            }
            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }

    /* ========== 详情 ========== */
    public function info(Request $request){
        $id=$request->input('id');
        if(!$id){
            $result=['code'=>'error','message'=>'请先选择数据','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('system.error')->with($result);
            }
        }
        /* ********** 获取数据 ********** */
        DB::beginTransaction();
        $menu=Menu::withTrashed()
            ->with(['father'=>function($query){
                $query->withTrashed()->select(['id','name']);
            }])
            ->sharedLock()
            ->find($id);
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($menu)){
            $code='error';
            $msg='数据不存在';
            $sdata=null;
            $edata=null;
            $url=null;

            $view='system.error';
        }else{
            $code='success';
            $msg='查询成功';
            $sdata=$menu;
            $edata=new Menu();
            $url=null;

            $view='system.menu.info';
        }
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view($view)->with($result);
        }
    }

    /* ========== 修改 ========== */
    public function edit(Request $request){
        $id=$request->input('id');
        if(!$id){
            $result=['code'=>'error','message'=>'请先选择数据','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('system.error')->with($result);
            }
        }
        $model=new Menu();

        if($request->isMethod('get')){
            /* ********** 获取数据 ********** */
            DB::beginTransaction();
            $menu=Menu::withTrashed()
                ->with(['father'=>function($query){
                    $query->withTrashed()->select(['id','name']);
                }])
                ->sharedLock()
                ->find($id);
            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($menu)){
                $code='error';
                $msg='数据不存在';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='system.error';
            }else{
                $code='success';
                $msg='查询成功';
                $sdata=$menu;
                $edata=$model;
                $url=null;

                $view='system.menu.edit';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }
        /* ********** 保存 ********** */
        else{
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules=[
                'name'=>'required',
                'url'=>'required',
                'login'=>'required|boolean',
                'auth'=>'required|boolean',
                'display'=>'required|boolean',
                'sort'=>'nullable|integer',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'boolean'=>':attribute 选择正确的选项',
                'integer'=>':attribute 必须是整数',
            ];

            $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }

            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try{
                /* ++++++++++ 批量赋值 ++++++++++ */
                $menu=Menu::withTrashed()->sharedLock()->find($id);
                $menu->fill($request->input());
                $menu->editOther($request);
                $menu->save();
                if(blank($menu)){
                    throw new \Exception('修改失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=$menu;
                $edata=null;
                $url=route('sys_menu');

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'保存失败';
                $sdata=null;
                $edata=$menu;
                $url=null;

                DB::rollBack();
            }
            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }
}
