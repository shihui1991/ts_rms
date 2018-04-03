<?php
/*
|--------------------------------------------------------------------------
| 项目-补偿协议
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use App\Http\Model\Assets;
use App\Http\Model\Estate;
use App\Http\Model\Household;
use App\Http\Model\Householdbuilding;
use App\Http\Model\Householddetail;
use App\Http\Model\Householdmember;
use App\Http\Model\Item;
use App\Http\Model\Itemprogram;
use App\Http\Model\Itemreward;
use App\Http\Model\Itemuser;
use App\Http\Model\Pact;
use App\Http\Model\Pay;
use App\Http\Model\Paybuilding;
use App\Http\Model\Payhouse;
use App\Http\Model\Payobject;
use App\Http\Model\Paypublic;
use App\Http\Model\Paysubject;
use App\Http\Model\Payunit;
use App\Http\Model\Worknotice;
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

            $code='success';
            $msg='请求成功';
            $sdata=[
                'item'=>$this->item,
                'pay'=>$pay,
            ];
            $edata=null;
            $url=null;

            $view='gov.pact.index';
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

    /* ========== 添加补偿安置协议 ========== */
    public function add(Request $request){
        $pay_id=$request->input('pay_id');
        if($request->isMethod('get')){
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
                    throw new \Exception('兑付数据不存在',404404);
                }
                $pact=Pact::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['household_id',$pay->household_id],
                        ['pay_id',$pay->id],
                        ['cate_id',1],
                    ])
                    ->first();
                if(filled($pact)){
                    throw new \Exception('补偿安置协议已存在，请勿重复操作',404404);
                }
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查操作权限 ++++++++++ */
                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];

                $worknotice->code='2';
                $worknotice->save();
                if(blank($worknotice)){
                    throw new \Exception('操作失败',404404);
                }
                /* ++++++++++ 删除相同工作推送 ++++++++++ */
                Worknotice::lockForUpdate()
                    ->where([
                        ['item_id',$this->item_id],
                        ['schedule_id',$process->schedule_id],
                        ['process_id',$process->id],
                        ['menu_id',$process->menu_id],
                        ['code','0'],
                    ])
                    ->delete();
                /* ++++++++++ 被征收户 ++++++++++ */
                $household=Household::with(['itemland'=>function($query){
                    $query->with('adminunit')->select(['id','address']);
                },'itembuilding'=>function($query){
                    $query->with('buildingstruct')->select(['id','building']);
                },'state'=>function($query){
                    $query->select(['code','name']);
                }])
                    ->sharedLock()
                    ->find($pay->household_id);
                /* ++++++++++ 被征收户 - 详情 ++++++++++ */
                $household_detail=Householddetail::with(['defbuildinguse'=>function($query){
                    $query->select(['id','name']);
                },'realbuildinguse'=>function($query){
                    $query->select(['id','name']);
                }])
                    ->sharedLock()
                    ->where('household_id',$pay->household_id)
                    ->first();
                /* ++++++++++ 公房单位、承租人、产权人 ++++++++++ */
                if($household->getOriginal('type')){
                    $holder_type=2;
                }else{
                    $holder_type=1;
                }
                $holder=Householdmember::sharedLock()
                    ->select(['id','item_id','household_id','name','holder','portion','card_num'])
                    ->where([
                        ['item_id',$this->item_id],
                        ['household_id',$household->id],
                        ['holder',$holder_type],
                    ])
                    ->orderBy('portion','desc')
                    ->first();
                $household_total=Paysubject::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['pay_id',$pay_id],
                    ])
                    ->sum('total');

                $code='success';
                $msg='请求成功';
                $sdata=[
                    'item'=>$this->item,
                    'pay'=>$pay,
                    'household'=>$household,
                    'household_detail'=>$household_detail,
                    'household_total'=>$household_total,
                    'holder'=>$holder,
                ];
                $edata=null;
                $url=null;

                $view='gov.pact.first';
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
        /* ++++++++++ 生成协议 ++++++++++ */
        else{
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
                    throw new \Exception('兑付数据不存在',404404);
                }
                $pact=Pact::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['household_id',$pay->household_id],
                        ['pay_id',$pay->id],
                        ['cate_id',1],
                    ])
                    ->first();
                if(filled($pact)){
                    throw new \Exception('补偿安置协议已存在，请勿重复操作',404404);
                }
                /* ++++++++++ 检查操作权限 ++++++++++ */
                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];

                $worknotice->code='2';
                $worknotice->save();
                if(blank($worknotice)){
                    throw new \Exception('操作失败',404404);
                }
                /* ++++++++++ 删除相同工作推送 ++++++++++ */
                Worknotice::lockForUpdate()
                    ->where([
                        ['item_id',$this->item_id],
                        ['schedule_id',$process->schedule_id],
                        ['process_id',$process->id],
                        ['menu_id',$process->menu_id],
                        ['code','0'],
                    ])
                    ->delete();
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
                if($household->getOriginal('type')){
                    $holder_type=2;
                }else{
                    $holder_type=1;
                }
                $holder=Householdmember::sharedLock()
                    ->select(['id','item_id','household_id','name','holder','portion','card_num'])
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
                /* ++++++++++ 补偿科目 ++++++++++ */
                $pay_subjects=Paysubject::with(['subject','itemsubject'=>function($query){
                    $query->where('item_id',$this->item_id);
                }])
                    ->sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['pay_id',$pay_id],
                    ])
                    ->orderBy('subject_id','asc')
                    ->whereIn('subject_id',[1,2,3,4,5,6,7,8,9,10,11,12])
                    ->get();
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
                /* ++++++++++ 安置房 ++++++++++ */
                $pay_houses=null;
                if($pay->getOriginal('repay_way')==1){
                    $pay_houses=Payhouse::with(['house'=>function($query){
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
                /* ++++++++++ 合法面积、合法补偿总额 ++++++++++ */
                $legal_area=$register_buildings->sum('real_outer')+$legal_buildings->sum('real_outer');
                $legal_amount=$register_buildings->sum('amount')+$legal_buildings->sum('amount');
                $move_times=$pay->getOriginal('transit_way')==0?1:2; //货币过渡补助 1 次，临时周转补助 2 次
                switch ($household_detail->def_use){
                    case 1: // 住宅
                        $move_price=$program->move_house;
                        break;
                    case 2: // 商服
                        $move_price=$program->move_business;
                        break;
                    case 3: // 办公
                        $move_price=$program->move_office;
                        break;
                    case 4: // 生产加工
                        $move_price=$program->move_factory;
                        break;
                    default :
                        $move_price=0;
                }
                /* ++++++++++ 签约奖励方案 ++++++++++ */
                $item_reward=Itemreward::sharedLock()
                    ->where([
                        ['start_at','<=',date('Y-m-d')],
                        ['end_at','>=',date('Y-m-d')],
                    ])
                    ->first();
                $reward_price=0;
                $reward_rate=0;
                if(filled($item_reward)){
                    // 货币补偿
                    if($pay->getOriginal('repay_way')==0){
                        $reward_price=$item_reward->price+$program->reward_house;
                        $reward_rate= ($item_reward->portion+$program->reward_other)/100;
                    }
                    // 产权调换
                    else{
                        $reward_price=$item_reward->price;
                        $reward_rate= ($item_reward->portion)/100;
                    }
                }

                $datas=[
                    'item'=>$this->item,
                    'pay'=>$pay,
                    'household'=>$household,
                    'household_detail'=>$household_detail,
                    'real_area'=>$real_area,
                    'main_building'=>$main_building,
                    'holder'=>$holder,
                    'program'=>$program,
                    'pay_subjects'=>$pay_subjects,
                    'register_buildings'=>$register_buildings,
                    'legal_buildings'=>$legal_buildings,
                    'destroy_buildings'=>$destroy_buildings,
                    'public_buildings'=>$public_buildings,
                    'pay_objects'=>$pay_objects,
                    'pay_houses'=>$pay_houses,
                    'legal_area'=>$legal_area,
                    'legal_amount'=>$legal_amount,
                    'move_times'=>$move_times,
                    'move_price'=>$move_price,
                    'reward_price'=>$reward_price,
                    'reward_rate'=>$reward_rate,
                    'business_type'=>$request->input('business_type'),
                ];

                $pay_pact=response(view('gov.pact.pact_1')->with($datas))->getContent();// 补偿安置协议
                $pay_table=response(view('gov.pact.pay')->with($datas))->getContent(); // 兑付表
                /* ++++++++++ 房产评估报告 ++++++++++ */
                $estate_pic=Estate::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['household_id',$household->id],
                    ])
                    ->value('picture');
                /* ++++++++++ 资产评估报告 ++++++++++ */
                $assets_pic=null;
                if($household_detail->getOriginal('has_assets')){
                    $assets_pic=Assets::sharedLock()
                        ->where([
                            ['item_id',$this->item_id],
                            ['household_id',$household->id],
                        ])
                        ->value('picture');
                }

                $pact=new Pact();
                $pact->item_id=$pay->item_id;
                $pact->household_id=$pay->household_id;
                $pact->land_id=$pay->land_id;
                $pact->building_id=$pay->building_id;
                $pact->pay_id=$pay->id;
                $pact->cate_id=1;
                $pact->content=[
                    'pay_pact'=>$pay_pact,
                    'pay_table'=>$pay_table,
                    'estate_pic'=>$estate_pic,
                    'assets_pic'=>$assets_pic,
                ];
                $pact->code='170';
                $pact->status=0;
                $pact->save();

                $code='success';
                $msg='请求成功';
                $sdata=[
                    'item'=>$this->item,
                    'pay'=>$pay,
                    'household'=>$household,
                    'household_detail'=>$household_detail,
                    'holder'=>$holder,
                    'pact'=>$pact,
                ];
                $edata=null;
                $url=route('g_pay_info',['item'=>$this->item_id,'id'=>$pay_id]);

                DB::commit();
            }catch (\Exception $exception){dd($exception);
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络错误';
                $sdata=null;
                $edata=null;
                $url=null;

                DB::rollBack();
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }

    /* ========== 协议详情 ========== */
    public function info(Request $request){
        $pact_id=$request->input('pact_id');
        DB::beginTransaction();
        try{
            if(!$pact_id){
                throw new \Exception('错误操作',404404);
            }
            $pact=Pact::sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['id',$pact_id],
                ])
                ->first();
            if(blank($pact)){
                throw new \Exception('数据不存在',404404);
            }
            $code='success';
            $msg='请求成功';
            $sdata=[
                'item'=>$this->item,
                'pact'=>$pact,
            ];
            $edata=null;
            $url=null;

            $view='gov.pact.info';
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

    public function reset_pact(Request $request){
        $pact_id=$request->input('pact_id');
        DB::beginTransaction();
        try{
            if(!$pact_id){
                throw new \Exception('错误操作',404404);
            }
            $pact=Pact::sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['id',$pact_id],
                ])
                ->first();
            if(blank($pact)){
                throw new \Exception('数据不存在',404404);
            }
            if(!in_array($pact->code,['170','174'])){
                throw new \Exception('协议在【'.$pact->state->name.'】，不能修改',404404);
            }
            /* ++++++++++ 补偿安置协议 ++++++++++ */
            if($pact->cate_id==1){
                /* ++++++++++ 兑付汇总 ++++++++++ */
                $pay=Pay::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$pact->pay_id],
                    ])
                    ->first();
                if(blank($pay)){
                    throw new \Exception('兑付数据不存在',404404);
                }
                /* ++++++++++ 检查操作权限 ++++++++++ */
//                $count=Itemuser::sharedLock()
//                    ->where([
//                        ['item_id',$this->item_id],
//                        ['schedule_id',5],
//                        ['process_id',40],
//                        ['user_id',session('gov_user.user_id')],
//                    ])
//                    ->count();
//                if(!$count){
//                    throw new \Exception('您没有执行此操作的权限',404404);
//                }
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
                if($household->getOriginal('type')){
                    $holder_type=2;
                }else{
                    $holder_type=1;
                }
                $holder=Householdmember::sharedLock()
                    ->select(['id','item_id','household_id','name','holder','portion','card_num'])
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
                /* ++++++++++ 补偿科目 ++++++++++ */
                $pay_subjects=Paysubject::with(['subject','itemsubject'=>function($query){
                    $query->where('item_id',$this->item_id);
                }])
                    ->sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['pay_id',$pay->id],
                    ])
                    ->orderBy('subject_id','asc')
                    ->whereIn('subject_id',[1,2,3,4,5,6,7,8,9,10,11,12])
                    ->get();
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
                /* ++++++++++ 安置房 ++++++++++ */
                $pay_houses=null;
                if($pay->getOriginal('repay_way')==1){
                    $pay_houses=Payhouse::with(['house'=>function($query){
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
                /* ++++++++++ 合法面积、合法补偿总额 ++++++++++ */
                $legal_area=$register_buildings->sum('real_outer')+$legal_buildings->sum('real_outer');
                $legal_amount=$register_buildings->sum('amount')+$legal_buildings->sum('amount');
                $move_times=$pay->getOriginal('transit_way')==0?1:2; //货币过渡补助 1 次，临时周转补助 2 次
                switch ($household_detail->def_use){
                    case 1: // 住宅
                        $move_price=$program->move_house;
                        break;
                    case 2: // 商服
                        $move_price=$program->move_business;
                        break;
                    case 3: // 办公
                        $move_price=$program->move_office;
                        break;
                    case 4: // 生产加工
                        $move_price=$program->move_factory;
                        break;
                    default :
                        $move_price=0;
                }
                /* ++++++++++ 签约奖励方案 ++++++++++ */
                $item_reward=Itemreward::sharedLock()
                    ->where([
                        ['start_at','<=',date('Y-m-d')],
                        ['end_at','>=',date('Y-m-d')],
                    ])
                    ->first();
                $reward_price=0;
                $reward_rate=0;
                if(filled($item_reward)){
                    // 货币补偿
                    if($pay->getOriginal('repay_way')==0){
                        $reward_price=$item_reward->price+$program->reward_house;
                        $reward_rate= ($item_reward->portion+$program->reward_other)/100;
                    }
                    // 产权调换
                    else{
                        $reward_price=$item_reward->price;
                        $reward_rate= ($item_reward->portion)/100;
                    }
                }

                $datas=[
                    'item'=>$this->item,
                    'pay'=>$pay,
                    'household'=>$household,
                    'household_detail'=>$household_detail,
                    'real_area'=>$real_area,
                    'main_building'=>$main_building,
                    'holder'=>$holder,
                    'program'=>$program,
                    'pay_subjects'=>$pay_subjects,
                    'register_buildings'=>$register_buildings,
                    'legal_buildings'=>$legal_buildings,
                    'destroy_buildings'=>$destroy_buildings,
                    'public_buildings'=>$public_buildings,
                    'pay_objects'=>$pay_objects,
                    'pay_houses'=>$pay_houses,
                    'legal_area'=>$legal_area,
                    'legal_amount'=>$legal_amount,
                    'move_times'=>$move_times,
                    'move_price'=>$move_price,
                    'reward_price'=>$reward_price,
                    'reward_rate'=>$reward_rate,
                    'business_type'=>$request->input('business_type'),
                ];

                $pay_pact=response(view('gov.pact.pact_1')->with($datas))->getContent();// 补偿安置协议
                $pay_table=response(view('gov.pact.pay')->with($datas))->getContent(); // 兑付表
                /* ++++++++++ 房产评估报告 ++++++++++ */
                $estate_pic=Estate::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['household_id',$household->id],
                    ])
                    ->value('picture');
                /* ++++++++++ 资产评估报告 ++++++++++ */
                $assets_pic=null;
                if($household_detail->getOriginal('has_assets')){
                    $assets_pic=Assets::sharedLock()
                        ->where([
                            ['item_id',$this->item_id],
                            ['household_id',$household->id],
                        ])
                        ->value('picture');
                }
                $pact->content=[
                    'pay_pact'=>$pay_pact,
                    'pay_table'=>$pay_table,
                    'estate_pic'=>$estate_pic,
                    'assets_pic'=>$assets_pic,
                ];
                $pact->code='170';
                $pact->status=0;
                $pact->save();
            }

            $code='success';
            $msg='请求成功';
            $sdata=[
                'item'=>$this->item,
                'pact'=>$pact,
            ];
            $edata=null;
            $url=route('g_pay_info',['item'=>$this->item_id,'id'=>$pact->pay_id]);

            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络错误';
            $sdata=null;
            $edata=null;
            $url=null;

            DB::rollBack();
        }
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        return response()->json($result);
    }
}