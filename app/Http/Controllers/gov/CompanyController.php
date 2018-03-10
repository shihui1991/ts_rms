<?php
/*
|--------------------------------------------------------------------------
| 评估机构
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;
use App\Http\Model\Company;
use App\Http\Model\Companyuser;
use App\Http\Model\Companyvaluer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CompanyController extends BaseauthController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        $select=['id','type','name','address','phone','fax','contact_man','contact_tel','logo','infos','user_id','code','deleted_at'];
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
            $companys=$model->where($where)->select($select)->orderBy($ordername,$orderby)->sharedLock()->get();
            $infos['typecount'] = Company::where($where)
                ->where('type',0)
                ->count();
            $infos['typecounts'] = Company::where($where)
                ->where('type',1)
                ->count();
            if(blank($companys)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata = $companys;
            $edata=$infos;
            $url=null;
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata = null;
            $edata = $infos;
            $url = null;
        }
        DB::commit();
        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.company.index')->with($result);
        }
    }

    /* ========== 添加 ========== */
    public function add(Request $request){
        $model=new Company();
        if($request->isMethod('get')){
            $sdata['type'] = $request->input('type');
            $result=['code'=>'success','message'=>'请求成功','sdata'=>$sdata,'edata'=>$model,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.company.add')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else {
            /* ++++++++++ 表单验证 ++++++++++ */
            /*--- 评估机构 ---*/
            $rules = [
                'type' => 'required',
                'name' => 'required|unique:company',
                'address' => 'required',
                'phone' => 'required',
                'content' => 'required'
            ];
            $messages = [
                'required' => ':attribute 为必须项',
                'unique' => ':attribute 已存在'
            ];
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /*--- 评估机构(操作员) ---*/
            $companyuser_model = new Companyuser();
            $rules1 = [
                'username'=>['required','alpha_num','between:4,20','unique:company_user'],
                'password' => 'required|min:6',
            ];
            $messages1 = [
                'required' => ':attribute 为必须项',
                'alpha_num'=>':attribute 须为字母或与数字组合',
                'between'=>':attribute 长度在 :min 到 :max 位之间',
                'unique'=>':attribute 已占用',
                'min'=>':attribute 长度至少 :min 位'
            ];
            $validator1 = Validator::make($request->all(), $rules1, $messages1, $companyuser_model->columns);
            if ($validator1->fails()) {
                $result=['code'=>'error','message'=>$validator1->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }

            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try {
                /* ++++++++++ 批量赋值 ++++++++++ */
                /*--- 评估机构 ---*/
                $company = $model;
                $company->fill($request->input());
                $company->user_id = 0;
                $company->code = 40;
                $company->save();
                if (blank($company)) {
                    throw  new \Exception('添加失败', 404404);
                }
                /*--- 评估机构(操作员) ---*/
                $companyuser = $companyuser_model;
                $companyuser->username = $request->input('username');
                $companyuser->password = encrypt($request->input('password'));
                $companyuser->company_id = $company->id;
                $companyuser->secret = $companyuser_model->get_secret();
                $companyuser->save();
                if (blank($companyuser)) {
                    throw new \Exception('添加失败', 404404);
                }
                /*--- 设置评估机构(操作员) ---*/
                $company->user_id = $companyuser->id;
                $company->save();
                if (blank($company)) {
                    throw new \Exception('添加失败', 404404);
                }
                $code = 'success';
                $msg = '添加成功';
                $sdata = $company;
                $edata = null;
                $url = route('g_company');
                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '添加失败';
                $sdata = null;
                $edata = $company;
                $url = null;
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
        /* ********** 当前数据 ********** */
        DB::beginTransaction();
        $company=Company::withTrashed()
            ->with(['companyuser'=>function($query){
                    $query->withTrashed()->select(['id','name','phone','username','action_at']);
            }])
            ->sharedLock()
            ->find($id);
        $data['companyusers']=Companyuser::with(['company'=>function($query){
                $query->withTrashed()->select(['id','name','user_id','type']);
            }])
            ->where('company_id',$id)
            ->sharedLock()
            ->get();
        $data['companyvaluers']=Companyvaluer::with(['company'=>function($query){
                $query->withTrashed()->select(['id','name','type']);
            }])
            ->where('company_id',$id)
            ->sharedLock()
            ->get();
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($company)){
            $code='warning';
            $msg='数据不存在';
            $sdata=null;
            $edata=$data;
            $url=null;

        }else{
            $code='success';
            $msg='获取成功';
            $sdata=$company;
            $edata=$data;
            $url=null;

            $view='gov.company.info';
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

        if ($request->isMethod('get')) {
            /* ********** 当前数据 ********** */
            DB::beginTransaction();
            $company=Company::withTrashed()
                ->with(['companyuser'=>function($query){
                    $query->withTrashed()->select(['id','name','phone','username','action_at']);
                }])
                ->sharedLock()
                ->find($id);
            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($company)){
                $code='warning';
                $msg='数据不存在';
                $sdata=null;
                $edata=null;
                $url=null;

            }else{
                $code='success';
                $msg='获取成功';
                $sdata=$company;
                $edata=new Company();
                $url=null;

                $view='gov.company.edit';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }else{
            $model=new Company();
            /* ********** 表单验证 ********** */
            $rules=[
                'type'=>'required',
                'name'=>'required|unique:company,name,'.$id.',id',
                'address'=>'required',
                'phone'=>'required',
                'content'=>'required'
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'unique'=>':attribute 已存在'
            ];
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
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
                $sdata=$company;
                $edata=null;
                $url=route('g_company');

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=$company;
                $url=null;
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }
}