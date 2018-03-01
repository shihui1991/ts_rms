<?php
/*
|--------------------------------------------------------------------------
| 项目-资金管理
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use App\Http\Model\Funds;
use App\Http\Model\Fundscate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FundsController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        DB::beginTransaction();

        $funds_details=Fundscate::with(['fundses'=>function($query){
            $query->with(['bank'=>function($query){
                $query->select(['id','name']);
            }])
                ->where('item_id',$this->item_id)
                ->orderBy('entry_at','asc');
        }])
            ->Select(['*',DB::raw('(SELECT SUM(`amount`) FROM `item_funds` WHERE `item_id`='.$this->item_id.' AND `item_funds`.`cate_id`=`a_item_funds_cate`.`id`) AS `total`')])
            ->sharedLock()
            ->get();

        DB::commit();

        /* ********** 结果 ********** */
        $result=[
            'code'=>'success',
            'message'=>'请求成功',
            'sdata'=>[
                'item'=>$this->item,
                'funds_details'=>$funds_details,
            ],
            'edata'=>null,
            'url'=>null];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.funds.index')->with($result);
        }
    }

    /* ========== 添加 ========== */
    public function add(Request $request){

    }

}