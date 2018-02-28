<?php
/*
|--------------------------------------------------------------------------
| 项目-初步预算
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use App\Http\Model\Initbudget;
use App\Http\Model\Itemnotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InitbudgetController extends BaseitemController
{
    /* ========== 初始化 ========== */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 初步预算 ========== */
    public function index(Request $request){
        /* ********** 查询 ********** */
        DB::beginTransaction();
        $init_budget=Initbudget::sharedLock()->where('item_id',$this->item_id)->first();
        $item_notice=Itemnotice::sharedLock()
            ->where([
                ['item_id',$this->item_id],
                ['cate_id',2],
            ])
            ->first();

        DB::commit();

        /* ++++++++++ 结果 ++++++++++ */
        $result=[
            'code'=>'success',
            'message'=>'请求成功',
            'sdata'=>[
                'item'=>$this->item,
                'init_budget'=>$init_budget,
                'item_notice'=>$item_notice,
            ],
            'edata'=>null,
            'url'=>null];

        if($request->ajax()){
            return response()->json($result);
        }else{
            return view('gov.initbudget.index')->with($result);
        }
    }

}