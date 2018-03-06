<?php
/*
|--------------------------------------------------------------------------
| 项目-排队选房
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use App\Http\Model\Itemctrl;
use App\Http\Model\Payreserve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PayreserveController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 排队选房 ========== */
    public function index(Request $request){
        DB::beginTransaction();

        try{
            $itemctrl=Itemctrl::sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['cate_id',3],
                    ['start_at','<=',date('Y-m-d H:i:s')],
                    ['end_at','>=',date('Y-m-d H:i:s')],
                ])
                ->first();
            if(blank($itemctrl)){
                throw new \Exception('还未到排队选房时间',404404);
            }
            $reserves=Payreserve::with(['household'=>function($query){
                $query->with(['itemland'=>function($query){
                    $query->select(['id','address']);
                },'itembuilding'=>function($query){
                    $query->select(['id','building']);
                },'pay'])
                    ->select(['id','item_id','land_id','building_id','unit','floor','number','type','state']);
            }])
                ->sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['control_id',$itemctrl->id],
                    ['state',0],
                ])
                ->orderBy('number','asc')
                ->paginate();

            $code='success';
            $msg='请求成功';
        }catch (\Exception $exception){
            $itemctrl=null;
            $reserves=null;

            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络错误';
        }
        DB::commit();

        $sdata=[
            'item'=>$this->item,
            'itemctrl'=>$itemctrl,
            'reserves'=>$reserves,
        ];
        $edata=null;
        $url=null;

        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view('gov.payreserve.index')->with($result);
        }
    }

    /* ========== 开始选房 ========== */
    public function house(Request $request){

    }
}