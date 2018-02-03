<?php
/*
|--------------------------------------------------------------------------
| 评估机构
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;
use App\Http\Model\Company;
use App\Http\Model\Companyuser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CompanyController extends BaseController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {

    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        $select=['id','type','name','address','phone','fax','contact_man','contact_tel','logo','infos','user_id','state','deleted_at'];

        /* ********** 查询条件 ********** */
        $where=[];
        /* ++++++++++ 名称 ++++++++++ */
        $name=trim($request->input('name'));
        if($name){
            $where[]=['name','like','%'.$name.'%'];
            $infos['name']=$name;
        }
        /* ++++++++++ 类型 ++++++++++ */
        $type=trim($request->input('type'));
        if(is_numeric($type)&&in_array($type,['0','1'])){
            $where[]=['type',$type];
            $infos['type']=$type;
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

        $model=new Company();
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
            $companys=$model->where($where)->select($select)->orderBy($ordername,$orderby)->sharedLock()->paginate($displaynum);
            if(blank($companys)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $data=$companys;
        }catch (\Exception $exception){
            $companys=collect();
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=$companys;
        }
        DB::commit();

        /* ********** 结果 ********** */
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>$infos]);
    }

    /* ========== 添加 ========== */
    public function add(Request $request){
        $model=new Company();
        /* ********** 保存 ********** */
        /* ++++++++++ 表单验证 ++++++++++ */
        /*--- 评估机构 ---*/
        $rules=[
            'type'=>'required',
            'name'=>'required|unique:company',
            'address'=>'required',
            'phone'=>'required',
            'content'=>'required'
        ];
        $messages=[
            'required'=>':attribute 为必须项',
            'unique'=>':attribute 已存在'
        ];
        $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
        if($validator->fails()){
            return response()->json(['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>'','edata'=>'']);
        }
        /*--- 评估机构(操作员) ---*/
        $companyuser_model = new Companyuser();
        $rules1=[
            'username'=>'required|unique:company_user',
            'password'=>'required',
        ];
        $messages1=[
            'required'=>':attribute 为必须项',
            'unique'=>':attribute 已存在'
        ];
        $validator1 = Validator::make($request->all(),$rules1,$messages1,$companyuser_model->columns);
        if($validator1->fails()){
            return response()->json(['code'=>'error','message'=>$validator1->errors()->first(),'sdata'=>'','edata'=>'']);
        }

        /* ++++++++++ 新增 ++++++++++ */
        DB::beginTransaction();
        try{
            /* ++++++++++ 批量赋值 ++++++++++ */
            /*--- 评估机构 ---*/
            $company=$model;
            $company->fill($request->input());
            $company->user_id = 0;
            $company->state = 0;
            $company->save();
//            dump($company);
            if(blank($company)){
                throw  new \Exception('添加失败',404404);
            }
            /*--- 评估机构(操作员) ---*/
            $companyuser = $companyuser_model;
            $companyuser->username = $request->input('username');
            $companyuser->password = encrypt($request->input('password'));
            $companyuser->company_id = $company->id;
            $companyuser->secret = create_guid();
            $companyuser->save();
            if(blank($companyuser)){
                throw new \Exception('添加失败',404404);
            }
            /*--- 设置评估机构(操作员) ---*/
            $company->user_id = $companyuser->id;
            $company->save();
            if(blank($company)){
                throw new \Exception('添加失败',404404);
            }
            $code='success';
            $msg='添加成功';
            $data=$company;
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
        $company=Company::withTrashed()
            ->sharedLock()
            ->find($id);
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($company)){
            $code='warning';
            $msg='数据不存在';
            $data=[];

        }else{
            $code='success';
            $msg='获取成功';
            $data=$company;
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
        $model=new Company();
        /* ********** 表单验证 ********** */
        $rules=[
            'type'=>'required',
            'name'=>'required|unique:company,name,'.$id.',id',
            'address'=>'required',
            'phone'=>'required',
            'content'=>'required',
            'user_id'=>'required',
            'state'=>'required'
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
            $company=Company::withTrashed()
                ->lockForUpdate()
                ->find($id);
            if(blank($company)){
                throw new \Exception('指定数据项不存在',404404);
            }
            /* ++++++++++ 处理其他数据 ++++++++++ */
            $company->fill($request->input());
            $company->editOther($request);
            $company->save();
            if(blank($company)){
                throw  new \Exception('修改失败',404404);
            }

            $code='success';
            $msg='修改成功';
            $data=$company;

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