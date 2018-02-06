<?php
/*
|--------------------------------------------------------------------------
| 项目
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;
use App\Http\Model\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemController extends BaseController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {

    }

    /* ========== 我的项目 ========== */
    public function index(Request $request){

    }


    /* ========== 所有项目 ========== */
    public function all(Request $request){
        $select=['id','name','place','map','infos','code','created_at','updated_at','deleted_at'];
        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $items=Item::select($select)
                ->sharedLock()
                ->paginate();

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
            return view('gov.item.all')->with($result);
        }
    }


    public function add(Request $request){



        return view('gov.item.add');
    }
}