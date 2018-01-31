<?php
/*
|--------------------------------------------------------------------------
| 公产单位
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;
use App\Http\Model\Adminunit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminunitController extends BaseController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {

    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        $select=['id','name','address','phone','contact_man','contact_tel','infos','deleted_at'];

        /* ********** 查询条件 ********** */
        $where=[];
        /* ++++++++++ 名称 ++++++++++ */
        $name=trim($request->input('name'));
        if($name){
            $where[]=['name','like','%'.$name.'%'];
            $infos['name']=$name;
        }
        /* ++++++++++ 联系人 ++++++++++ */
        $contact_man=trim($request->input('contact_man'));
        if($contact_man){
            $where[]=['contact_man','like','%'.$contact_man.'%'];
            $infos['contact_man']=$contact_man;
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

        $model=new Adminunit();
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
            $adminunits=$model->where($where)->select($select)->orderBy($ordername,$orderby)->sharedLock()->paginate($displaynum);
            if(blank($adminunits)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $data=$adminunits;
        }catch (\Exception $exception){
            $adminunits=collect();
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=$adminunits;
        }
        DB::commit();

        /* ********** 结果 ********** */
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>$infos]);
    }

    /* ========== 添加 ========== */
    public function add(Request $request){
        $model=new Adminunit();
        /* ********** 保存 ********** */
        /* ++++++++++ 表单验证 ++++++++++ */
        $rules=[
            'name'=>'required|unique:admin_unit',
            'address'=>'required',
            'phone'=>'required',
            'contact_man'=>'required',
            'contact_tel'=>'required'
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
            $adminunit=$model;
            $adminunit->fill($request->input());
            $adminunit->addOther($request);
            $adminunit->save();
            if(blank($adminunit)){
                throw new \Exception('添加失败',404404);
            }

            $code='success';
            $msg='添加成功';
            $data=$adminunit;
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
        $adminunit=Adminunit::withTrashed()
            ->sharedLock()
            ->find($id);
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($adminunit)){
            $code='warning';
            $msg='数据不存在';
            $data=[];

        }else{
            $code='success';
            $msg='获取成功';
            $data=$adminunit;
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
        /* ********** 表单验证 ********** */
        $model=new Adminunit();
        $rules=[
            'name'=>'required|unique:admin_unit,name,'.$id.',id',
            'address'=>'required',
            'phone'=>'required',
            'contact_man'=>'required',
            'contact_tel'=>'required'
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
            $adminunit=Adminunit::withTrashed()
                ->lockForUpdate()
                ->find($id);
            if(blank($adminunit)){
                throw new \Exception('指定数据项不存在',404404);
            }
            /* ++++++++++ 处理其他数据 ++++++++++ */
            $adminunit->fill($request->input());
            $adminunit->setOther($request);
            $adminunit->save();
            if(blank($adminunit)){
                throw new \Exception('修改失败',404404);
            }

            $code='success';
            $msg='修改成功';
            $data=$adminunit;

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