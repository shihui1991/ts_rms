<?php
/*
|--------------------------------------------------------------------------
| 首页
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use App\Http\Model\Schedule;
use App\Http\Model\Worknotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HomeController extends BaseController
{
    /* ========== 初始化 ========== */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        DB::beginTransaction();

        /* ++++++++++ 工作提醒 ++++++++++ */
        $worknotices=Worknotice::with(['item'=>function($query){
            $query->select(['id','name']);
        },'schedule'=>function($query){
            $query->select(['id','name']);
        },'process'=>function($query){
            $query->select(['id','name']);
        }])
            ->where('user_id',session('gov_user.user_id'))
            ->whereIn('code',['0','20'])
            ->sharedLock()
            ->get();
        /* ++++++++++ 项目进度 ++++++++++ */
        $schedules=Schedule::sharedLock()->select(['id','name','sort'])->orderBy('sort','asc')->get();

        $code='success';
        $msg='查询成功';
        $sdata=['worknotices'=>$worknotices,'schedules'=>$schedules];
        $edata=null;
        $url=null;

        DB::commit();

        /* ++++++++++ 结果 ++++++++++ */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view('gov.home')->with($result);
        }
    }

    /* ========== 工作提醒详情 ========== */
    public function infos(Request $request){
        DB::beginTransaction();
        try{
            $id=$request->input('id');
            if(!$id){
                throw new \Exception('错误操作',404404);
            }
            /* ++++++++++ 工作详情 ++++++++++ */
            $worknotice=Worknotice::with(['item'=>function($query){
                $query->select(['id','name']);
            },'schedule'=>function($query){
                $query->select(['id','name']);
            },'process'=>function($query){
                $query->select(['id','name']);
            },'menu'=>function($query){
                $query->select(['id','name']);
            },'dept'=>function($query){
                $query->select(['id','name']);
            },'role'=>function($query){
                $query->select(['id','name']);
            },'user'=>function($query){
                $query->select(['id','name']);
            },'state'=>function($query){
                $query->select(['code','name']);
            }])
                ->sharedLock()
                ->find($id);

            if(blank($worknotice)){
                throw new \Exception('数据不存在',404404);
            }

            $code='success';
            $msg='查询成功';
            $sdata=$worknotice;
            $edata=null;
            $url=null;

            $view='gov.infos';
        }catch (\Exception $exception){
            $code='error';
            $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '网络错误';
            $sdata=null;
            $edata=null;
            $url=null;

            $view='gov.error';
        }
        DB::commit();
        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view($view)->with($result);
        }
    }
}