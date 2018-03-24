<?php
/*
|--------------------------------------------------------------------------
| 控制台
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\household;
use App\Http\Model\Menu;
use App\Http\Model\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends BaseController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request){

        DB::beginTransaction();
        /* ++++++++++ 通知公告 ++++++++++ */
        $news=News::with(['newscate'=>function($query){
            $query->select(['id','name','infos']);
        },'state'=>function($query){
            $query->select(['code','name']);
        }])
            ->where('code',22)
            ->sharedLock()
            ->orderBy('is_top','desc')
            ->orderBy('release_at','asc')
            ->get();

        /* ********** 结果 ********** */
        $result=[
            'code'=>'success',
            'message'=>'请求成功',
            'sdata'=>$news,
            'edata'=>null,
            'url'=>null];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('household.home')->with($result);
        }

    }

}
