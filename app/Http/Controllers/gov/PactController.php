<?php
/*
|--------------------------------------------------------------------------
| 项目-补偿协议
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use App\Http\Model\Household;
use App\Http\Model\Householdbuilding;
use App\Http\Model\Householddetail;
use App\Http\Model\Householdmember;
use App\Http\Model\Itemprogram;
use App\Http\Model\Pay;
use App\Http\Model\Paybuilding;
use App\Http\Model\Payhouse;
use App\Http\Model\Payobject;
use App\Http\Model\Paypublic;
use App\Http\Model\Paysubject;
use App\Http\Model\Payunit;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PactController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 协议 ========== */
    public function index(Request $request){
        $pay_id=$request->input('id');
        DB::beginTransaction();
        try{
            if(!$pay_id){
                throw new \Exception('错误操作',404404);
            }
            /* ++++++++++ 兑付汇总 ++++++++++ */
            $pay=Pay::sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['id',$pay_id],
                ])
                ->first();
            if(blank($pay)){
                throw new \Exception('错误操作',404404);
            }

            switch ($request->input('cate')){
                // 补偿安置协议
                case 1:

                    /* ++++++++++ 被征收户 ++++++++++ */
                    $household=Household::with(['itemland'=>function($query){
                        $query->with('adminunit')->select(['id','address']);
                    },'itembuilding'=>function($query){
                        $query->with('buildingstruct')->select(['id','building']);
                    },'state'=>function($query){
                        $query->select(['code','name']);
                    }])
                        ->sharedLock()
                        ->select(['id','item_id','land_id','building_id','unit','floor','number','type','code'])
                        ->find($pay->household_id);
                    /* ++++++++++ 被征收户 - 详情 ++++++++++ */
                    $household_detail=Householddetail::with(['defbuildinguse'=>function($query){
                        $query->select(['id','name']);
                    },'realbuildinguse'=>function($query){
                        $query->select(['id','name']);
                    }])
                        ->sharedLock()
                        ->select(['id','household_id','status','register','reg_outer','def_use','real_use','has_assets','business'])
                        ->where('household_id',$pay->household_id)
                        ->first();
                    /* ++++++++++ 被征收户 - 实测面积 ++++++++++ */
                    $real_area=Householdbuilding::sharedLock()
                        ->where([
                            ['item_id',$this->item_id],
                            ['household_id',$household->id],
                        ])
                        ->sum('real_outer');
                    /* ++++++++++ 主体建筑 ++++++++++ */
                    $main_building=Householdbuilding::sharedLock()
                        ->where([
                            ['item_id',$this->item_id],
                            ['household_id',$household->id],
                        ])
                        ->whereIn('def_use',[1,2,3,4])
                        ->orderBy('code','asc')
                        ->orderBy('real_outer','desc')
                        ->first();
                    /* ++++++++++ 公房单位、承租人、产权人 ++++++++++ */
                    $pay_unit=null;
                    if($household->getOriginal('type')){
                        $pay_unit=Payunit::sharedLock()
                            ->where([
                                ['item_id',$this->item_id],
                                ['household_id',$household->id],
                                ['pay_id',$pay->id],
                            ])
                            ->first();

                        $holder_type=2;
                    }else{
                        $holder_type=1;
                    }
                    $holder=Householdmember::sharedLock()
                        ->select(['id','item_id','household_id','name','holder','portion'])
                        ->where([
                            ['item_id',$this->item_id],
                            ['household_id',$household->id],
                            ['holder',$holder_type],
                        ])
                        ->orderBy('portion','desc')
                        ->first();
                    /* ++++++++++ 正式方案 ++++++++++ */
                    $program=Itemprogram::sharedLock()
                        ->where([
                            ['item_id',$this->item_id],
                            ['code','22'],
                        ])
                        ->first();
                    /* ++++++++++ 合法房屋及附属物 ++++++++++ */
                    $register_buildings=Paybuilding::with(['realuse','buildingstruct','householdbuilding'])
                        ->sharedLock()
                        ->where([
                            ['item_id',$this->item_id],
                            ['household_id',$household->id],
                            ['pay_id',$pay->id],
                        ])
                        ->whereIn('code',['90'])
                        ->get();
                    /* ++++++++++ 合法临建 ++++++++++ */
                    $legal_buildings=Paybuilding::with(['realuse','buildingstruct','householdbuilding'])
                        ->sharedLock()
                        ->where([
                            ['item_id',$this->item_id],
                            ['household_id',$household->id],
                            ['pay_id',$pay->id],
                        ])
                        ->whereIn('code',['92','95'])
                        ->get();
                    /* ++++++++++ 自行拆除补助 ++++++++++ */
                    $destroy_buildings=Paybuilding::with(['realuse','buildingstruct','householdbuilding'])
                        ->sharedLock()
                        ->where([
                            ['item_id',$this->item_id],
                            ['household_id',$household->id],
                            ['pay_id',$pay->id],
                        ])
                        ->whereIn('code',['94'])
                        ->get();
                    /* ++++++++++ 公共附属物 ++++++++++ */
                    $public_buildings=Paypublic::sharedLock()
                        ->where([
                            ['item_id',$this->item_id],
                            ['land_id',$household->land_id],
                        ])
                        ->get();
                    /* ++++++++++ 其他补偿事项 ++++++++++ */
                    $pay_objects=Payobject::sharedLock()
                        ->where([
                            ['item_id',$this->item_id],
                            ['household_id',$household->id],
                        ])
                        ->get();
                    /* ++++++++++ 固定资产 ++++++++++ */
                    $assets=Paysubject::sharedLock()
                        ->where([
                            ['item_id',$this->item_id],
                            ['household_id',$household->id],
                            ['pay_id',$pay->id],
                            ['subject_id',6],
                        ])
                        ->first();
                    /* ++++++++++ 装修补偿 ++++++++++ */
                    $decoration=Paysubject::sharedLock()
                        ->where([
                            ['item_id',$this->item_id],
                            ['household_id',$household->id],
                            ['pay_id',$pay->id],
                            ['subject_id',7],
                        ])
                        ->first();
                    /* ++++++++++ 停产停业损失补偿 ++++++++++ */
                    $business=Paysubject::sharedLock()
                        ->where([
                            ['item_id',$this->item_id],
                            ['household_id',$household->id],
                            ['pay_id',$pay->id],
                            ['subject_id',8],
                        ])
                        ->first();
                    /* ++++++++++ 搬迁补助 ++++++++++ */
                    $move=Paysubject::with(['itemsubject'=>function($query){
                        $query->where('item_id',$this->item_id);
                    }])
                        ->sharedLock()
                        ->where([
                            ['item_id',$this->item_id],
                            ['household_id',$household->id],
                            ['pay_id',$pay->id],
                            ['subject_id',9],
                        ])
                        ->first();
                    /* ++++++++++ 设备拆移补助 ++++++++++ */
                    $device=Paysubject::sharedLock()
                        ->where([
                            ['item_id',$this->item_id],
                            ['household_id',$household->id],
                            ['pay_id',$pay->id],
                            ['subject_id',10],
                        ])
                        ->first();
                    /* ++++++++++ 签约奖励 ++++++++++ */
                    $sign_reward=Paysubject::with(['itemsubject'=>function($query){
                        $query->where('item_id',$this->item_id);
                    }])
                        ->sharedLock()
                        ->where([
                            ['item_id',$this->item_id],
                            ['household_id',$household->id],
                            ['pay_id',$pay->id],
                        ])
                        ->whereIn('subject_id',[11,12])
                        ->first();


                    /* ++++++++++ 安置房 ++++++++++ */
                    $payhouses=null;
                    if($pay->getOriginal('repay_way')==1){
                        $payhouses=Payhouse::with(['house'=>function($query){
                            $query->with(['housecommunity','layout','houselayoutimg']);
                        },'housepluses'=>function($query) use ($household){
                            $query->where([
                                ['item_id',$household->item_id],
                                ['household_id',$household->id],
                            ]);
                        }])
                            ->where([
                                ['item_id',$household->item_id],
                                ['household_id',$household->id],
                            ])
                            ->sharedLock()
                            ->get();
                    }

                    $datas=[
                        'item'=>$this->item,
                        'pay'=>$pay,
                        'household'=>$household,
                        'household_detail'=>$household_detail,
                        'real_area'=>$real_area,
                        'main_building'=>$main_building,
                        'pay_unit'=>$pay_unit,
                        'holder'=>$holder,
                        'program'=>$program,
                        'register_buildings'=>$register_buildings,
                        'legal_buildings'=>$legal_buildings,
                        'destroy_buildings'=>$destroy_buildings,
                        'public_buildings'=>$public_buildings,
                        'pay_objects'=>$pay_objects,
                        'assets'=>$assets,
                        'decoration'=>$decoration,
                        'business'=>$business,
                        'move'=>$move,
                        'device'=>$device,
                        'sign_reward'=>$sign_reward,
                        'payhouses'=>$payhouses,
                    ];

                    $pact_content=$this->first($datas);
                    $pact_pay=$this->pay($datas);

                    break;
            }


            $code='success';
            $msg='请求成功';
            $sdata=[
                'item'=>$this->item,
                'pay'=>$pay,
            ];
            $edata=null;
            $url=null;

            $view='gov.pay.info';
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络错误';
            $sdata=null;
            $edata=null;
            $url=null;

            $view='gov.error';
        }
        DB::commit();
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view($view)->with($result);
        }
    }

    /* ========== 补偿安置协议 ========== */
    public function first($datas){
        return view('gov.pact.pact_1')->with($datas);
    }

    /* ========== 补偿安置协议 - 兑付表 ========== */
    public function pay($datas){
        return view('gov.pact.pay')->with($datas);
    }
}