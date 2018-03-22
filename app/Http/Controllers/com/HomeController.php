<?php
/*
|--------------------------------------------------------------------------
| 首页
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\com;
use App\Http\Model\Worknotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HomeController extends BaseauthController
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
        $worknotices=Worknotice::with([
         'item'=>function($query){
            $query->select(['id','name']);
        },'schedule'=>function($query){
            $query->select(['id','name']);
        },'process'=>function($query){
            $query->select(['id','name']);
        }])
            ->where('user_id',session('com_user.user_id'))
            ->whereIn('code',['0','20'])
            ->sharedLock()
            ->get();

        $code='success';
        $msg='查询成功';
        $sdata=['worknotices'=>$worknotices];
        $edata=null;
        $url=null;

        DB::commit();

        /* ++++++++++ 结果 ++++++++++ */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view('com.home')->with($result);
        }
    }
}