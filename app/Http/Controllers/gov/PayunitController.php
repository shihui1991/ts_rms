<?php
/*
|--------------------------------------------------------------------------
| 项目- 项目实施-公房单位
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use App\Http\Model\Adminunit;
use App\Http\Model\Payunit;
use App\Http\Model\Payunitpact;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PayunitController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        DB::beginTransaction();
        try{
            $pay_units=Payunit::with('adminunit')
                ->sharedLock()
                ->where('item_id',$this->item_id)
                ->distinct()
                ->select(['unit_id',DB::raw('SUM(`amount`) AS `total`')])
                ->groupBy('unit_id')
                ->get();

            $code='success';
            $msg='获取成功';
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络错误';
        }
        $sdata=[
            'item'=>$this->item,
            'pay_units'=>$pay_units,
        ];
        $edata=null;
        $url=null;
        DB::commit();
        $result=['code'=>$code, 'message'=>$msg, 'sdata'=>$sdata, 'edata'=>$edata, 'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.payunit.index')->with($result);
        }
    }

    /* ========== 补偿详情 ========== */
    public function info(Request $request){
        $unit_id=$request->input('unit_id');
        DB::beginTransaction();
        try{
            if(!$unit_id){
                throw new \Exception('错误操作',404404);
            }
            /* ++++++++++ 公房单位 ++++++++++ */
            $admin_unit=Adminunit::sharedLock()->find($unit_id);
            if(blank($admin_unit)){
                throw new \Exception('数据不存在',404404);
            }
            /* ++++++++++ 公房单位 - 补偿总额 ++++++++++ */
            $total=Payunit::sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['unit_id',$unit_id]
                ])
                ->select(DB::raw('COUNT(*) AS `count`,SUM(`amount`) AS `total`'))
                ->fisrt();
            if(blank($total)){
                throw new \Exception('没有【'.$admin_unit->name.'】的补偿数据',404404);
            }
            /* ++++++++++ 公房单位 - 补偿协议 ++++++++++ */
            $unit_pacts=Payunitpact::with(['pactcate','state','payunits'])
                ->sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['unit_id',$unit_id],
                ])
                ->get();
            /* ++++++++++ 公房单位 - 补偿列表 ++++++++++ */
            $per_page=15;
            $page=$request->input('page',1);
            $pay_units=Payunit::with(['itemland'=>function($query){
                $query->select(['id','address']);
            },'household'=>function($query){
                $query->with(['itembuilding'=>function($query){
                    $query->select(['id','building']);
                }])
                    ->select(['id','item_id','land_id','building_id','unit','floor','number','type','code']);
            },'state'])
                ->where([
                    ['item_id',$this->item_id],
                    ['unit_id',$unit_id],
                ])
                ->sharedLock()
                ->offset($per_page*($page-1))
                ->limit($per_page)
                ->get();

            $pay_units=new LengthAwarePaginator($pay_units,$total->count,$per_page,$page);
            $pay_units->withPath(route('g_payunit_info',['item'=>$this->item_id,'unit_id'=>$unit_id]));

            $code='success';
            $msg='获取成功';
            $sdata=[
                'item'=>$this->item,
                'admin_unit'=>$admin_unit,
                'total'=>$total,
                'unit_pacts'=>$unit_pacts,
                'pay_units'=>$pay_units,
            ];
            $edata=null;
            $url=null;

            $view='gov.payunit.info';
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络错误';
            $sdata=null;
            $edata=null;
            $url=null;

            $view='gov.error';
        }

        DB::commit();
        $result=['code'=>$code, 'message'=>$msg, 'sdata'=>$sdata, 'edata'=>$edata, 'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view($view)->with($result);
        }
    }
}