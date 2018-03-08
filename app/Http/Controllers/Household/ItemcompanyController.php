<?php
/*
|--------------------------------------------------------------------------
| 入围机构
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Household;

use App\Http\Model\Itemcompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class ItemcompanyController extends BaseController{

    protected $item_id;

    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request){
        $this->item_id=session('household_user.item_id');
        DB::beginTransaction();
        try{
            $item_companys=Itemcompany::with(['company'=>function($query){
                $query->select();
            }])
                ->withCount(['companyvotes'=>function($query){
                $query->where('item_id',$this->item_id);
                }])
                ->where('item_id',$this->item_id)
                ->orderBy('companyvotes_count','desc')
                ->sharedLock()
                ->get();
            if(blank($item_companys)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$item_companys;
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
        $result=[
            'code'=>$code,
            'message'=>$msg,
            'sdata'=>$sdata,
            'edata'=>null,
            'url'=>null];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('household.itemcompany.index')->with($result);
        }
    }
}