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
use Illuminate\Support\Facades\Validator;

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
                ->select(['id','parent_id','level','name','admin','deleted_at'])
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

            $code='success';
            $msg='查询成功';
            $data=$roles;
        }catch (\Exception $exception){
            $roles=collect();
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=$roles;
        }
        DB::commit();
        $infos['roles']=$roles;

        /* ++++++++++ 结果 ++++++++++ */
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'']);
    }

    /* ========== 全列表 ========== */
    public function all(Request $request){
        $select=['id','parent_id','level','name','admin','deleted_at'];

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
            $code='error';
            $msg='查询成功';
            $data=$roles;
        }catch (\Exception $exception){
            $roles=collect();
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=$roles;
        }
        DB::commit();

        /* ********** 结果 ********** */
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>$infos]);
    }

    /* ========== 添加(查询上级角色) ========== */
    public function select_parent(Request $request){
        $parent_id = $request->input('id');
        if($parent_id){
            DB::beginTransaction();
            $parent['name']=Role::withTrashed()->where('id',$parent_id)->sharedLock()->value('name');
            DB::commit();
            $code = 'success';
            $msg = '查询上级角色成功';
            $data = $parent;
        }else{
            $code = 'error';
            $msg = '暂无上级角色信息';
            $data = [];
        }
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'']);
    }

    /* ========== 添加 ========== */
    public function add(Request $request,$id=0){
        $model=new Role();
        /* ********** 保存 ********** */
        /* ++++++++++ 表单验证 ++++++++++ */
        $rules=[
            'parent_id'=>['required','regex:/^[0-9]+$/'],
            'name'=>'required|unique:role',
            'admin'=>'required',
            'level'=>'required'
        ];
        $messages=[
            'required'=>':attribute 为必须项',
            'parent_id.regex'=>'选择正确的上级菜单',
            'unique'=>':attribute 已存在'
        ];
        $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
        if($validator->fails()){
            return response()->json(['code'=>'error','message'=>$validator->errors(),'sdata'=>'','edata'=>'']);
        }

        /* ++++++++++ 新增 ++++++++++ */
        DB::beginTransaction();
        try{
            /* ++++++++++ 批量赋值 ++++++++++ */
            $role=$model;
            $role->fill($request->input());
            $role->setOther($request);
            $role->save();

            $code='success';
            $msg='添加成功';
            $data=$role;
            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'添加失败';
            $data=[];
            DB::rollBack();
        }
        /* ++++++++++ 结果 ++++++++++ */
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'']);
    }

    /* ========== 详情 ========== */
    public function info(Request $request){
        $id=$request->input('id');
        if(!$id){
            $code='warning';
            $msg='请选择一条数据';
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>'','edata'=>'']);
        }
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
            $code='warning';
            $msg='数据不存在';
            $data=[];
        }else{
            $code='success';
            $msg='获取成功';
            $data=$role;
        }

        /* ********** 结果 ********** */
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'']);
    }

    /* ========== 修改 ========== */
    public function edit(Request $request){
        $id=$request->input('id');
        if(!$id){
            $code='warning';
            $msg='请选择一条数据';
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>'','edata'=>'']);
        }
        $model=new Role();
        /* ********** 表单验证 ********** */
        $rules=[
            'parent_id'=>['required','regex:/^[0-9]+$/'],
            'name'=>'required|unique:role',
            'admin'=>'required',
            'level'=>'required'
        ];
        $messages=[
            'required'=>':attribute 为必须项',
            'parent_id.regex'=>'选择正确的上级菜单',
            'unique'=>':attribute 已存在'
        ];
        $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
        if($validator->fails()){
            return response()->json(['code'=>'error','message'=>$validator->errors(),'sdata'=>'','edata'=>'']);
        }

        /* ********** 更新 ********** */
        DB::beginTransaction();
        try{
            if($request->input('parent_id')){
                throw new \Exception('禁止修改上级角色',404404);
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

            $code='success';
            $msg='修改成功';
            $data=$role;
            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=[];
            DB::rollBack();
        }
        /* ********** 结果 ********** */
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'']);
    }

    /* ========== 删除 ========== */
    public function delete(Request $request){
        /* ********** 验证选择数据项 ********** */
        $ids=$request->input('ids');
        if(!$ids){
            $code='warning';
            $msg='至少选择一项';
            $data=[];
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'']);
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

            if(blank($fail_ids)){
                $code='success';
                $msg='全部删除成功';
            }else{
                $code='warning';
                $msg='部分存在子级，禁止删除';
            }
            $data=$success_ids;
            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=[];
            DB::rollBack();
        }
        /* ********** 结果 ********** */
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'']);
    }

    /* ========== 恢复 ========== */
    public function restore(Request $request){
        /* ********** 验证选择数据项 ********** */
        $ids=$request->input('ids');
        if(!$ids){
            $code='warning';
            $msg='至少选择一项';
            $data=[];
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'']);
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

            $code='success';
            $msg='恢复成功';
            $data=$role_ids;
            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=[];
            DB::rollBack();
        }
        /* ********** 结果 ********** */
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'']);
    }

    /* ========== 销毁 ========== */
    public function destroy(Request $request){
        /* ********** 验证选择数据项 ********** */
        $ids=$request->input('ids');
        if(!$ids){
            $code='warning';
            $msg='至少选择一项';
            $data=[];
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'']);
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

            $code='success';
            $msg='销毁成功';
            $data=$role_ids;
            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=[];
            DB::rollBack();
        }
        /* ********** 结果 ********** */
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'']);
    }
}