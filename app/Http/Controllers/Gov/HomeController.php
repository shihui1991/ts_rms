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
}