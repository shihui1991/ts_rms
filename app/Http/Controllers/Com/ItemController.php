<?php
/*
|--------------------------------------------------------------------------
| 项目
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Com;


use App\Http\Model\Itemcompany;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ItemController extends BaseController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ++++++++++ 我的项目 ++++++++++ */
    public function index(Request $request){
        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $total=Itemcompany::where('company_id',session('com_user.company_id'))
                ->sharedLock()
                ->count(DB::raw('DISTINCT `item_id`'));
            $per_page=15;
            $page=$request->input('page',1);
            $items=Itemcompany::with(['item'=>function($query){
                $query->with(['itemadmins'=>function($query){
                    $query->select('name');
                },'state'=>function($query){
                    $query->select(['code','name']);
                },'schedule'=>function($query){
                    $query->select(['id','name']);
                },'process'=>function($query){
                    $query->select(['id','name']);
                }])->withCount('households');
            }])
                ->select(['item_id','company_id'])
                ->distinct()
                ->where('company_id',session('com_user.company_id'))
                ->offset($per_page*($page-1))
                ->limit($per_page)
                ->orderBy('item_id','asc')
                ->get();

            $items=new LengthAwarePaginator($items,$total,$per_page,$page);
            $items->withPath(route('c_item'));

            if(blank($items)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$items;
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

        /* ++++++++++ 结果 ++++++++++ */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view('com.item.index')->with($result);
        }
    }
}