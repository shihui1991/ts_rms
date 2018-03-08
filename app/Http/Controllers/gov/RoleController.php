<?php
/*
|--------------------------------------------------------------------------
| 权限与角色
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use App\Http\Model\Menu;
use App\Http\Model\Role;
use App\Http\Model\Rolemenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoleController extends BaseauthController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ++++++++++ 列表 ++++++++++ */
    public function index(Request $request)
    {
        /* ********** 查询条件 ********** */
        /* ++++++++++ 上级 ID ++++++++++ */
        $id=$request->input('id')?$request->input('id'):0;
        $where[]=['parent_id',$id];
        $where[]=['id','<>',1];
        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $roles=Role::withTrashed()
                ->withCount(['childs'=>function($query){
                    $query->withTrashed();
                }])
                ->where($where)
                ->sharedLock()
                ->get();

            if(blank($roles)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$roles;
            $edata=null;
            $url=null;
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=null;
            $url=null;
        }
        DB::commit();

        /* ++++++++++ 结果 ++++++++++ */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view('gov.role.index')->with($result);
        }
    }

    /* ========== 添加 ========== */
    public function add(Request $request){
        $model=new Role();

        if($request->isMethod('get')){
            $id=$request->input('id');
            $name='';
            if($id){
                DB::beginTransaction();
                $name=Role::withTrashed()->where('id',$id)->sharedLock()->value('name');
                DB::commit();
            }
            if(!$name){
                $id=0;
            }

            $menus=Menu::withTrashed()
                ->where([
                    ['module',0],
                    ['login',1],
                ])
                ->select(['id','parent_id','name','auth'])
                ->get();

            $menu_tree='';
            if(filled($menus)){
                $array=[];
                foreach ($menus as $menu){
                    $menu->checked=$menu->getOriginal('auth')==0?'checked':'';
                    $array[]=$menu;
                }
                $str="<tr data-tt-id='\$id' data-tt-parent-id='\$parent_id'>
                          <td>\$name</td>
                          <td><input type='checkbox' name='menu_ids[]' value='\$id' \$checked onclick='upDown($(this))' id='id-\$id' data-id='\$id' data-parent-id='\$parent_id'></td>
                      </tr>";

                $menu_tree=get_tree($array,$str,0,1,['','',''],'');
            }

            $result=['code'=>'success','message'=>'请求成功','sdata'=>['id'=>$id,'name'=>$name,'menus'=>$menu_tree],'edata'=>$model,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.role.add')->with($result);
            }

        }
        /* ++++++++++ 保存 ++++++++++ */
        else{
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules=[
                'parent_id'=>['required','regex:/^[0-9]+$/'],
                'name'=>'required|unique:role',
                'type'=>'required|boolean',
                'menu_ids'=>'required'
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'parent_id.regex'=>'错误操作',
                'unique'=>':attribute 已存在',
                'boolean'=>'错误操作',
                'menu_ids.required'=>'选择权限',
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
                $role=$model;
                $role->fill($request->input());
                $role->addOther($request);
                $role->save();
                if(blank($role)){
                    throw new \Exception('保存失败',404404);
                }

                $menu_ids=Menu::withTrashed()
                    ->whereIn('id',$request->input('menu_ids'))
                    ->where('auth',1)
                    ->sharedLock()
                    ->pluck('id');

                if(filled($menu_ids)){
                    $values=[];
                    foreach($menu_ids as $menu_id){
                        $values[]=[
                            'role_id'=>$role->id,
                            'menu_id'=>$menu_id,
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s'),
                        ];
                    }
                    $ins_field=['role_id','menu_id','created_at','updated_at'];
                    $sqls=batch_update_or_insert_sql('role_menu',$ins_field,$values,$ins_field);
                    if(!$sqls){
                        throw new \Exception('保存失败',404404);
                    }
                    foreach ($sqls as $sql){
                        DB::statement($sql);
                    }
                }

                $code='success';
                $msg='保存成功';
                $sdata=$role;
                $edata=null;
                $url=route('g_role');

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
                return view('gov.error')->with($result);
            }
        }
        /* ********** 获取数据 ********** */
        DB::beginTransaction();
        $role=Role::withTrashed()
            ->with(['father'=>function($query){
                $query->withTrashed()->select(['id','name']);
            },'menus'=>function($query){
                $query->withTrashed()->select(['id','name','icon']);
            }])
            ->sharedLock()
            ->find($id);
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($role)){
            $code='error';
            $msg='数据不存在';
            $sdata=null;
            $edata=null;
            $url=null;

            $view='gov.error';
        }else{
            $code='success';
            $msg='查询成功';
            $sdata=$role;
            $edata=new Role();
            $url=null;

            $view='gov.role.info';
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
                return view('gov.error')->with($result);
            }
        }

        if($request->isMethod('get')){
            /* ********** 获取数据 ********** */
            DB::beginTransaction();
            $role=Role::withTrashed()
                ->with(['father'=>function($query){
                    $query->withTrashed()->select(['id','name']);
                }])
                ->sharedLock()
                ->find($id);

            $menu_ids=Rolemenu::where('role_id',$id)->sharedLock()->pluck('menu_id');

            $menus=Menu::withTrashed()
                ->where([
                    ['module',0],
                    ['login',1],
                ])
                ->select(['id','parent_id','name','auth'])
                ->get();

            $menu_tree='';
            if(filled($menus)){
                $array=[];
                foreach ($menus as $menu){
                    $menu->checked=($menu->getOriginal('auth')==0 || $role->id==1 || $menu_ids->contains($menu->id))?'checked':'';
                    $array[]=$menu;
                }
                $str="<tr data-tt-id='\$id' data-tt-parent-id='\$parent_id'>
                          <td>\$name</td>
                          <td><input type='checkbox' name='menu_ids[]' value='\$id' \$checked onclick='upDown($(this))' id='id-\$id' data-id='\$id' data-parent-id='\$parent_id'></td>
                      </tr>";

                $menu_tree=get_tree($array,$str,0,1,['','',''],'');
            }

            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($role)){
                $code='error';
                $msg='数据不存在';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='gov.error';
            }else{
                $role->menus=$menu_tree;

                $code='success';
                $msg='查询成功';
                $sdata=$role;
                $edata=new Role();
                $url=null;

                $view='gov.role.edit';
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
            /* ********** 表单验证 ********** */
            $model=new Role();
            $rules=[
                'name'=>'required|unique:role,name,'.$id.',id',
                'type'=>'required|boolean',
                'menu_ids'=>'required'
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'unique'=>':attribute 已存在',
                'boolean'=>'错误操作',
                'menu_ids.required'=>'选择权限',
            ];
            $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /* ********** 更新 ********** */
            DB::beginTransaction();
            try{
                /* ++++++++++ 锁定数据模型 ++++++++++ */
                $role=Role::withTrashed()->lockForUpdate()->find($id);
                if(blank($role)){
                    throw new \Exception('数据不存在',404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $role->fill($request->input());
                $role->editOther($request);
                $role->save();
                if(blank($role)){
                    throw new \Exception('修改失败',404404);
                }

                $menu_ids=Menu::withTrashed()
                    ->whereIn('id',$request->input('menu_ids'))
                    ->where('auth',1)
                    ->sharedLock()
                    ->pluck('id');

                Rolemenu::where('role_id',$id)->delete();

                if($role->id!=1 && filled($menu_ids)){
                    $values=[];
                    foreach($menu_ids as $menu_id){
                        $values[]=[
                            'role_id'=>$role->id,
                            'menu_id'=>$menu_id,
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s'),
                        ];
                    }
                    $ins_field=['role_id','menu_id','created_at','updated_at'];
                    $sqls=batch_update_or_insert_sql('role_menu',$ins_field,$values,$ins_field);
                    if(!$sqls){
                        throw new \Exception('保存失败',404404);
                    }
                    foreach ($sqls as $sql){
                        DB::statement($sql);
                    }
                }

                $code='success';
                $msg='保存成功';
                $sdata=$role;
                $edata=null;
                $url=route('g_role');

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'保存失败';
                $sdata=null;
                $edata=$role;
                $url=null;

                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }

}