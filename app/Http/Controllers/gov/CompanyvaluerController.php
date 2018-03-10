<?php
/*
|--------------------------------------------------------------------------
| 评估机构-评估师
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;
use App\Http\Model\Company;
use App\Http\Model\Companyvaluer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CompanyvaluerController extends BaseauthController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        $select=['id','company_id','name','phone','register','valid_at','deleted_at'];

        /* ********** 查询条件 ********** */
        $where=[];
        /* ++++++++++ 评估机构 ++++++++++ */
        $company_id = $request->input('company_id');
        $where[] = ['company_id',$company_id];
        $infos['company_id'] = $company_id;
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
        /* ********** 是否删除 ********** */
        $deleted=$request->input('deleted');

        $model=new Companyvaluer();
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
            $companyvaluers=$model
                ->with(['company'=>function($query){
                    $query->withTrashed()->select(['id','name','type']);
                }])
                ->where($where)
                ->select($select)
                ->orderBy($ordername,$orderby)
                ->sharedLock()
                ->get();
            if(blank($companyvaluers)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$companyvaluers;;
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

        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.companyvaluer.index')->with($result);
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
        $companyvaluer=Companyvaluer::withTrashed()
            ->with(['company'=>function($query){
                $query->withTrashed()->select(['id','name','type']);
            }])
            ->sharedLock()
            ->find($id);
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($companyvaluer)){
            $code='warning';
            $msg='数据不存在';
            $sdata=null;
            $edata=null;
            $url=null;
        }else{
            $code='success';
            $msg='获取成功';
            $sdata=$companyvaluer;
            $edata=new Companyvaluer();
            $url=null;

            $view='gov.companyvaluer.info';
        }
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view($view)->with($result);
        }
    }

}