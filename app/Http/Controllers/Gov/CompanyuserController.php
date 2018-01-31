<?php
/*
|--------------------------------------------------------------------------
| 评估机构-操作员
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;
use App\Http\Model\Companyuser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CompanyuserController extends BaseController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {

    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        $select=['id','company_id','name','phone','username','action_at','deleted_at'];

        /* ********** 查询条件 ********** */
        $where=[];
        /* ++++++++++ 名称 ++++++++++ */
        $name=trim($request->input('name'));
        if($name){
            $where[]=['name','like','%'.$name.'%'];
            $infos['name']=$name;
        }
        /* ++++++++++ 电话 ++++++++++ */
        $phone=trim($request->input('phone'));
        if($phone){
            $where[]=['phone',$phone];
            $infos['phone']=$phone;
        }
        /* ********** 排序 ********** */
        $ordername=$request->input('ordername');
        $ordername=$ordername?$ordername:'id';
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

        $model=new Companyuser();
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
            $companyusers=$model
                ->with(['company'=>function($query){
                    $query->withTrashed()->select(['id','name']);
                }])
                ->where($where)
                ->select($select)
                ->orderBy($ordername,$orderby)
                ->sharedLock()
                ->paginate($displaynum);
            if(blank($companyusers)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $data=$companyusers;
        }catch (\Exception $exception){
            $companyusers=collect();
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=$companyusers;
        }
        DB::commit();

        /* ********** 结果 ********** */
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>$infos]);
    }

    /* ========== 添加 ========== */
    public function add(Request $request){
        $model=new Companyuser();
        /* ********** 保存 ********** */
        /* ++++++++++ 表单验证 ++++++++++ */
        $rules=[
            'company_id'=>'required',
            'username'=>'required|unique:company_user',
            'password'=>'required'
        ];
        $messages=[
            'required'=>':attribute 为必须项',
            'unique'=>':attribute 已存在'
        ];
        $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
        if($validator->fails()){
            return response()->json(['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>'','edata'=>'']);
        }

        /* ++++++++++ 新增 ++++++++++ */
        DB::beginTransaction();
        try{
            /* ++++++++++ 批量赋值 ++++++++++ */
            /*--- 评估机构 ---*/
            $companyuser=$model;
            $companyuser->fill($request->input());
            $companyuser->addOther($request);
            $companyuser->save();
            if(blank($companyuser)){
                throw new \Exception('添加失败',404404);
            }

            $code='success';
            $msg='添加成功';
            $data=$companyuser;
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
        $companyuser=Companyuser::withTrashed()
            ->with(['company'=>function($query){
                $query->withTrashed()->select(['id','name']);
            }])
            ->sharedLock()
            ->find($id);
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($companyuser)){
            $code='warning';
            $msg='数据不存在';
            $data=[];

        }else{
            $code='success';
            $msg='获取成功';
            $data=$companyuser;
        }
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
        $model=new Companyuser();
        /* ********** 表单验证 ********** */
        $rules=[
            'company_id'=>'required',
            'username'=>'required|unique:company_user,name,'.$id.',id',
            'password'=>'required'
        ];
        $messages=[
            'required'=>':attribute 为必须项',
            'unique'=>':attribute 已存在'
        ];
        $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
        if($validator->fails()){
            return response()->json(['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>'','edata'=>'']);
        }
        /* ********** 更新 ********** */
        DB::beginTransaction();
        try{
            /* ++++++++++ 锁定数据模型 ++++++++++ */
            $companyuser=Companyuser::withTrashed()
                ->lockForUpdate()
                ->find($id);
            if(blank($companyuser)){
                throw new \Exception('指定数据项不存在',404404);
            }
            /* ++++++++++ 处理其他数据 ++++++++++ */
            $companyuser->fill($request->input());
            $companyuser->setOther($request);
            $companyuser->save();
            if(blank($companyuser)){
                throw new \Exception('修改失败',404404);
            }

            $code='success';
            $msg='修改成功';
            $data=$companyuser;

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