<?php
/*
|--------------------------------------------------------------------------
| 项目-兑付补偿-补偿科目
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use App\Http\Model\Assets;
use App\Http\Model\Crowd;
use App\Http\Model\House;
use App\Http\Model\Household;
use App\Http\Model\Householddetail;
use App\Http\Model\Householdmembercrowd;
use App\Http\Model\Itemprogram;
use App\Http\Model\Itemreward;
use App\Http\Model\Itemsubject;
use App\Http\Model\Pay;
use App\Http\Model\Paybuilding;
use App\Http\Model\Paycrowd;
use App\Http\Model\Payhouse;
use App\Http\Model\Payobject;
use App\Http\Model\Paypublic;
use App\Http\Model\Paysubject;
use App\Http\Model\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaysubjectController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 添加补偿科目 ========== */
    public function add(Request $request){
        $pay_id=$request->input('pay_id');
        if(!$pay_id){
            $result=['code'=>'error','message'=>'错误操作','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }

        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
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
                /* ++++++++++ 被征收户 ++++++++++ */
                $household=Household::with(['itemland'=>function($query){
                    $query->with('adminunit')->select(['id','address','admin_unit_id']);
                },'itembuilding'=>function($query){
                    $query->select(['id','building']);
                },'state'=>function($query){
                    $query->select(['code','name']);
                }])
                    ->sharedLock()
                    ->select(['id','item_id','land_id','building_id','unit','floor','number','type','code'])
                    ->find($pay->household_id);
                /* ++++++++++ 被征收户-详情 ++++++++++ */
                $household_detail=Householddetail::with(['defbuildinguse'=>function($query){
                    $query->select(['id','name']);
                }])
                    ->sharedLock()
                    ->where([
                        ['item_id',$pay->item_id],
                        ['household_id',$pay->household_id],
                    ])
                    ->select(['item_id','household_id','has_assets','def_use','status'])
                    ->first();
                /* ++++++++++ 补偿科目 ++++++++++ */
                $item_subject_ids=Itemsubject::sharedLock()->where('item_id',$pay->item_id)->pluck('subject_id');
                $subjects=Subject::sharedLock()
                    ->whereIn('id',$item_subject_ids)
                    ->whereNotIn('id',[14,18])
                    ->where('main',0)
                    ->get();
                if(blank($subjects)){
                    throw new \Exception('没有可添加的补偿科目',404404);
                }

                $code='success';
                $msg='请求成功';
                $sdata=[
                    'item'=>$this->item,
                    'pay'=>$pay,
                    'household'=>$household,
                    'household_detail'=>$household_detail,
                    'subjects'=>$subjects,
                ];
                $edata=null;
                $url=null;

                $view='gov.paysubject.add';
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
        /* ********** 保存 ********** */
        else {
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'subject_id' => 'required',
                'calculate' => 'required',
                'amount' => 'required|numeric|min:0.01',
            ];
            $messages = [
                'required' => ':attribute 为必须项',
                'numeric' => ':attribute 格式错误',
                'min' => ':attribute 不能少于 :min',
            ];
            $model = new Paysubject();
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result = ['code' => 'error', 'message' => $validator->errors()->first(), 'sdata' => null, 'edata' => null, 'url' => null];
                return response()->json($result);
            }
            DB::beginTransaction();
            try{
                $count=Itemsubject::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['subject_id',$request->input('subject_id')],
                    ])
                    ->count();
                if(!$count){
                    throw new \Exception('当前项目没有该项补偿科目',404404);
                }
                /* ++++++++++ 兑付汇总 ++++++++++ */
                $pay=Pay::lockForUpdate()
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$pay_id],
                    ])
                    ->first();
                if(blank($pay)){
                    throw new \Exception('兑付数据不存在',404404);
                }

                $count=Paysubject::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['pay_id',$pay_id],
                        ['subject_id',$request->input('subject_id')],
                    ])
                    ->whereNotIn('subject_id',[17,18])
                    ->count();
                if($count){
                    throw new \Exception('当前被征收户已添加该项补偿科目',404404);
                }
                /* ++++++++++ 被征收户 ++++++++++ */
                $household=Household::sharedLock()
                    ->select(['id','item_id','land_id','building_id','unit','floor','number','type','code'])
                    ->find($pay->household_id);
                /* ++++++++++ 被征收户-详情 ++++++++++ */
                $household_detail=Householddetail::sharedLock()
                    ->where([
                        ['item_id',$pay->item_id],
                        ['household_id',$pay->household_id],
                    ])
                    ->select(['item_id','household_id','has_assets','def_use','status'])
                    ->first();
                /* ++++++++++ 正式方案 ++++++++++ */
                $program=Itemprogram::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['code','22'],
                    ])
                    ->first();
                if(blank($program)){
                    throw new \Exception('暂无通过审查的正式征收方案数据',404404);
                }

                /* ++++++++++ 合法面积、合法房屋补偿总额 ++++++++++ */
                $legal=Paybuilding::sharedLock()
                    ->where([
                        ['item_id',$pay->item_id],
                        ['pay_id',$pay->id],
                    ])
                    ->select([DB::raw('SUM(`real_outer`) AS `legal_area`,SUM(`amount`) AS `legal_total`')])
                    ->whereIn('code',['90','92','95'])
                    ->first();

                $pay_subject=$model;
                $pay_subject->fill($request->input());
                $pay_subject->addOther($request);
                $pay_subject->item_id=$this->item_id;
                $pay_subject->household_id=$pay->household_id;
                $pay_subject->land_id=$pay->land_id;
                $pay_subject->building_id=$pay->building_id;
                $pay_subject->pay_id=$pay->id;
                $pay_subject->pact_id=0;
                $pay_subject->total_id=0;
                $pay_subject->code='110';

                $subject_data=[];
                switch ($request->input('subject_id')){
                    /* ++++++++++ 搬迁补助 ++++++++++ */
                    case 9:
                        if($pay->getOriginal('move_way')==0){
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
                            $move_total=$legal->legal_area * $move_price * $move_times;
                            $move_total=$move_total>$program->move_base?$move_total:$program->move_base;

                            $pay_subject->calculate=number_format($legal->legal_area,2).' × '.number_format($move_price,2).' × '.$move_times.' = '.number_format($move_total,2);
                            $pay_subject->amount=$move_total;
                        }
                        else{
                            throw new \Exception('选择由政府协助搬迁的，不发放搬迁补助',404404);
                        }
                        break;

                    /* ++++++++++ 签约奖励（住宅） ++++++++++ */
                    case 11:
                        if(strtotime($program->item_end) < strtotime(date('Y-m-d'))){
                            throw new \Exception('已过项目征收期限，不能发放签约奖励',404404);
                        }
                        if($household_detail->def_use!=1){
                            throw new \Exception('被征收户的房屋不是住宅性质',404404);
                        }
                        /* ++++++++++ 签约奖励方案 ++++++++++ */
                        $item_reward=Itemreward::sharedLock()
                            ->where([
                                ['start_at','<=',date('Y-m-d')],
                                ['end_at','>=',date('Y-m-d')],
                            ])
                            ->first();
                        // 货币补偿
                        if($pay->getOriginal('repay_way')==0){
                            $reward_total=$legal->legal_area * ($item_reward->price+$program->reward_house);
                            $pay_subject->calculate=number_format($legal->legal_area,2).' × '.number_format(($item_reward->price+$program->reward_house),2).' = '.number_format($reward_total,2);
                        }
                        // 产权调换
                        else{
                            $reward_total=$legal->legal_area * $item_reward->price;
                            $pay_subject->calculate=number_format($legal->legal_area,2).' × '.number_format(($item_reward->price),2).' = '.number_format($reward_total,2);
                        }
                        $pay_subject->amount=$reward_total;
                        break;

                    /* ++++++++++ 签约奖励（非住宅） ++++++++++ */
                    case 12:
                        if(strtotime($program->item_end) < strtotime(date('Y-m-d'))){
                            throw new \Exception('已过项目征收期限，不能发放签约奖励',404404);
                        }
                        if($household_detail->def_use==1){
                            throw new \Exception('被征收户的房屋是住宅性质的',404404);
                        }
                        /* ++++++++++ 签约奖励方案 ++++++++++ */
                        $item_reward=Itemreward::sharedLock()
                            ->where([
                                ['start_at','<=',date('Y-m-d')],
                                ['end_at','>=',date('Y-m-d')],
                            ])
                            ->first();

                        // 货币补偿
                        if($pay->getOriginal('repay_way')==0){
                            $reward_total=($legal->legal_total) * ($item_reward->portion+$program->reward_other)/100;
                            $pay_subject->calculate=number_format(($legal->legal_total),2).' × '.($item_reward->portion+$program->reward_other).'% = '.number_format($reward_total,2);
                        }
                        // 产权调换
                        else{
                            $reward_total=($legal->legal_total) * ($item_reward->portion)/100;
                            $pay_subject->calculate=number_format(($legal->legal_total),2).' × '.($item_reward->portion).'% = '.number_format($reward_total,2);
                        }
                        $pay_subject->amount=$reward_total;
                        break;

                    /* ++++++++++ 临时安置费 ++++++++++ */
                    case 13:
                        if($pay->getOriginal('repay_way')==0){
                            throw new \Exception('选择货币补偿的不发放临时安置费',404404);
                        }
                        if($pay->getOriginal('transit_way')==1){
                            throw new \Exception('选择临时周转房过渡的不发放临时安置费',404404);
                        }
                        /* ++++++++++ 选择安置房源 ++++++++++ */
                        $resettle_house_ids=Payhouse::sharedLock()
                            ->where([
                                ['item_id',$pay->item_id],
                                ['household_id',$pay->household_id],
                            ])
                            ->pluck('house_id');
                        if(blank($resettle_house_ids)){
                            throw new \Exception('请先选择安置房源',404404);
                        }
                        /* ++++++++++ 现房数量 ++++++++++ */
                        $real_count=House::sharedLock()
                            ->whereIn('id',$resettle_house_ids)
                            ->where('is_real',1)
                            ->count();
                        /* ++++++++++ 临时安置时长 ++++++++++ */
                        $transit_times=$real_count?$program->transit_real:$program->transit_future;
                        $transit_end=date('Y-m',strtotime($program->item_end.' +'.$transit_times.' month'));
                        $now=date('Y-m');
                        if($now>=$transit_end){
                            throw new \Exception('当前时间已超过临时安置时限',404404);
                        }
                        $diff_time=date_diff(date_create($now),date_create($transit_end));
                        $transit_times = $diff_time->format('%m');
                        /* ++++++++++ 临时安置单价 ++++++++++ */
                        if($household_detail->def_use==1){
                            // 住宅
                            $transit_price=$program->transit_house;
                        } else{
                            // 非住宅
                            $transit_price=$program->transit_other;
                        }
                        $price=$legal->legal_area * $transit_price;
                        if($price>$program->transit_base){
                            $transit_total=$price * $transit_times;
                            $pay_subject->calculate=number_format($legal->legal_area,2).' × '.number_format($transit_price,2).' × '.$transit_times.' = '.number_format($transit_total,2);
                        }else{
                            $transit_total=$program->transit_base * $transit_times;
                            $pay_subject->calculate=number_format($program->transit_base,2).' × '.$transit_times.' = '.number_format($transit_total,2);
                        }
                        $pay_subject->amount=$transit_total;

                        if($transit_total){
                            /* ++++++++++ 临时安置费特殊人群优惠补助 ++++++++++ */
                            $member_crowd_ids=Householdmembercrowd::sharedLock()
                                ->where([
                                    ['item_id',$this->item_id],
                                    ['household_id',$pay->household_id],
                                ])
                                ->pluck('crowd_id','id');

                            $item_subject=Itemsubject::sharedLock()
                                ->where([
                                    ['item_id',$this->item_id],
                                    ['subject_id',14],
                                ])
                                ->first();
                            if(filled($member_crowd_ids) && filled($item_subject)) {
                                $crowds = Crowd::with(['itemcrowds' => function ($query) {
                                    $query->where('item_id', $this->item_id)->orderBy('rate', 'desc');
                                }])
                                    ->where('parent_id', 0)
                                    ->get();
                                $crowd_data = [];
                                $crowd_total = 0;
                                foreach ($crowds as $crowd) {
                                    foreach ($crowd->itemcrowds as $itemcrowd) {
                                        if ($member_crowd_id = $member_crowd_ids->search($itemcrowd->crowd_id)) {
                                            $crowd_data[] = [
                                                'item_id' => $this->item_id,
                                                'household_id' => $pay->household_id,
                                                'land_id' => $pay->land_id,
                                                'building_id' => $pay->building_id,
                                                'pay_id' => $pay->id,
                                                'item_subject_id' => $item_subject->id,
                                                'subject_id' => $item_subject->subject_id,
                                                'item_crowd_id' => $itemcrowd->id,
                                                'member_crowd_id' => $member_crowd_id,
                                                'crowd_cate_id' => $itemcrowd->crowd_cate_id,
                                                'crowd_id' => $itemcrowd->crowd_id,
                                                'transit' => $pay_subject->amount,
                                                'rate' => $itemcrowd->rate,
                                                'amount' => $itemcrowd->rate /100 * $pay_subject->amount,
                                                'created_at' => date('Y-m-d H:i:s'),
                                                'updated_at' => date('Y-m-d H:i:s'),
                                            ];
                                            $crowd_total += $itemcrowd->rate /100 * $pay_subject->amount;
                                            break;
                                        }
                                    }
                                }
                                $field = ['item_id', 'household_id', 'land_id', 'building_id', 'pay_id', 'item_subject_id', 'subject_id', 'item_crowd_id', 'member_crowd_id', 'crowd_cate_id', 'crowd_id', 'transit', 'rate', 'amount', 'created_at', 'updated_at'];
                                $sqls = batch_update_or_insert_sql('pay_crowd', $field, $crowd_data, 'updated_at');
                                if (!$sqls) {
                                    throw new \Exception('数据错误', 404404);
                                }
                                foreach ($sqls as $sql) {
                                    DB::statement($sql);
                                }

                                $subject_data=[
                                    'item_id'=>$pay->item_id,
                                    'household_id'=>$pay->household_id,
                                    'land_id'=>$pay->land_id,
                                    'building_id'=>$pay->building_id,
                                    'pay_id'=>$pay->id,
                                    'pact_id'=>0,
                                    'subject_id'=>$item_subject->subject_id,
                                    'total_id'=>0,
                                    'calculate'=>null,
                                    'amount'=>$crowd_total,
                                    'code'=>'110',
                                    'created_at'=>date('Y-m-d H:i:s'),
                                    'updated_at'=>date('Y-m-d H:i:s'),
                                ];
                            }
                        }

                        break;

                    /* ++++++++++ 按约搬迁奖励 ++++++++++ */
                    case 15:
                        $pay_subject->calculate=null;
                        $pay_subject->amount=$program->reward_move;
                        break;

                    /* ++++++++++ 房屋状况与登记相符的奖励 ++++++++++ */
                    case 16:
                        $reward_move=$legal->legal_area*$program->reward_real;
                        $pay_subject->calculate=number_format($legal->legal_area,2).' × '.number_format($program->reward_real,2).' = '.number_format($reward_move,2);
                        $pay_subject->amount=$reward_move;
                        break;

                    /* ++++++++++ 超期临时安置费 ++++++++++ */
                    case 17:
                        if($pay->getOriginal('repay_way')==0){
                            throw new \Exception('选择货币补偿的不发放临时安置费',404404);
                        }
                        if($pay->getOriginal('transit_way')==1){
                            throw new \Exception('选择临时周转房过渡的不发放临时安置费',404404);
                        }
                        /* ++++++++++ 选择安置房源 ++++++++++ */
                        $resettle_house_ids=Payhouse::sharedLock()
                            ->where([
                                ['item_id',$pay->item_id],
                                ['household_id',$pay->household_id],
                            ])
                            ->pluck('house_id');
                        if(blank($resettle_house_ids)){
                            throw new \Exception('请先选择安置房源',404404);
                        }
                        /* ++++++++++ 现房数量 ++++++++++ */
                        $real_count=House::sharedLock()
                            ->whereIn('id',$resettle_house_ids)
                            ->where('is_real',1)
                            ->count();
                        /* ++++++++++ 临时安置时长 ++++++++++ */
                        $transit_times=$real_count?$program->transit_real:$program->transit_future;
                        $transit_end=date('Y-m',strtotime($program->item_end.' +'.$transit_times.' month'));
                        $now=date('Y-m');
                        if($now<$transit_end){
                            throw new \Exception('未到临时安置时限，不能发放超期临时安置费',404404);
                        }

                        if($pay_subject->amount){
                            /* ++++++++++ 超期临时安置费特殊人群优惠补助 ++++++++++ */
                            $member_crowd_ids=Householdmembercrowd::sharedLock()
                                ->where([
                                    ['item_id',$this->item_id],
                                    ['household_id',$pay->household_id],
                                ])
                                ->pluck('crowd_id','id');

                            $item_subject=Itemsubject::sharedLock()
                                ->where([
                                    ['item_id',$this->item_id],
                                    ['subject_id',18],
                                ])
                                ->first();
                            if(filled($member_crowd_ids) && filled($item_subject)) {
                                $crowds = Crowd::with(['itemcrowds' => function ($query) {
                                    $query->where('item_id', $this->item_id)->orderBy('rate', 'desc');
                                }])
                                    ->where('parent_id', 0)
                                    ->get();
                                $crowd_data = [];
                                $crowd_total = 0;
                                foreach ($crowds as $crowd) {
                                    foreach ($crowd->itemcrowds as $itemcrowd) {
                                        if ($member_crowd_id = $member_crowd_ids->search($itemcrowd->crowd_id)) {
                                            $crowd_data[] = [
                                                'item_id' => $this->item_id,
                                                'household_id' => $pay->household_id,
                                                'land_id' => $pay->land_id,
                                                'building_id' => $pay->building_id,
                                                'pay_id' => $pay->id,
                                                'item_subject_id' => $item_subject->id,
                                                'subject_id' => $item_subject->subject_id,
                                                'item_crowd_id' => $itemcrowd->id,
                                                'member_crowd_id' => $member_crowd_id,
                                                'crowd_cate_id' => $itemcrowd->crowd_cate_id,
                                                'crowd_id' => $itemcrowd->crowd_id,
                                                'transit' => $pay_subject->amount,
                                                'rate' => $itemcrowd->rate,
                                                'amount' => $itemcrowd->rate /100 * $pay_subject->amount,
                                                'created_at' => date('Y-m-d H:i:s'),
                                                'updated_at' => date('Y-m-d H:i:s'),
                                            ];
                                            $crowd_total += $itemcrowd->rate /100 * $pay_subject->amount;
                                            break;
                                        }
                                    }
                                }
                                $field = ['item_id', 'household_id', 'land_id', 'building_id', 'pay_id', 'item_subject_id', 'subject_id', 'item_crowd_id', 'member_crowd_id', 'crowd_cate_id', 'crowd_id', 'transit', 'rate', 'amount', 'created_at', 'updated_at'];
                                $sqls = batch_update_or_insert_sql('pay_crowd', $field, $crowd_data, 'updated_at');
                                if (!$sqls) {
                                    throw new \Exception('数据错误', 404404);
                                }
                                foreach ($sqls as $sql) {
                                    DB::statement($sql);
                                }

                                $subject_data=[
                                    'item_id'=>$pay->item_id,
                                    'household_id'=>$pay->household_id,
                                    'land_id'=>$pay->land_id,
                                    'building_id'=>$pay->building_id,
                                    'pay_id'=>$pay->id,
                                    'pact_id'=>0,
                                    'subject_id'=>$item_subject->subject_id,
                                    'total_id'=>0,
                                    'calculate'=>null,
                                    'amount'=>$crowd_total,
                                    'code'=>'110',
                                    'created_at'=>date('Y-m-d H:i:s'),
                                    'updated_at'=>date('Y-m-d H:i:s'),
                                ];
                            }
                        }

                        break;
                }

                $pay_subject->save();
                if(blank($pay_subject)){
                    throw new \Exception('保存失败',404404);
                }
                if(filled($subject_data)){
                    Paysubject::insert($subject_data);
                }

                /* ++++++++++ 补偿总额 ++++++++++ */
                $subject_total=Paysubject::sharedLock()
                    ->where('pay_id',$pay->id)
                    ->sum('amount');
                $pay->total=$subject_total;
                $pay->save();

                $code='success';
                $msg='保存成功';
                $sdata=[
                    'item'=>$this->item,
                    'pay'=>$pay,
                    'pay_subject'=>$pay_subject,
                    'pay_subject_crowd'=>$subject_data,
                ];
                $edata=new Pay();
                $url=route('g_pay_info',['item'=>$pay->item_id,'id'=>$pay_id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'保存失败';
                $sdata=null;
                $edata=null;
                $url=null;

                DB::rollBack();
            }

            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }

    /* ========== 查看补偿科目详情 ========== */
    public function info(Request $request){
        $id=$request->input('id');
        DB::beginTransaction();
        try{
            if(!$id){
                throw new \Exception('错误操作',404404);
            }
            $pay_subject=Paysubject::with(['household'=>function($query){
                $query->select(['id','item_id','land_id','building_id','unit','floor','number','type','code']);
            },'subject'=>function($query){
                $query->select(['id','name']);
            },'itemsubject'=>function($query){
                $query->where('item_id',$this->item_id);
            },'state'])
                ->sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['id',$id],
                ])
                ->first();
            if(blank($pay_subject)){
                throw new \Exception('数据不存在',404404);
            }
            /* ++++++++++ 无明细的补偿科目 ++++++++++ */
            if(in_array($pay_subject->subject_id,[7,8,9,10,11,12,13,15,16,17])){
                $sdata=[
                    'item'=>$this->item,
                    'pay_subject'=>$pay_subject,
                ];
            }
            /* ++++++++++ 有明细的补偿科目 ++++++++++ */
            else{
                switch($pay_subject->subject_id){
                    // 合法房屋及附属物
                    case 1:
                        $pay_buildings=Paybuilding::with(['householdbuilding'=>function($query){
                            $query->select(['id','name']);
                        },'realuse','buildingstruct'])
                            ->sharedLock()
                            ->where([
                                ['item_id',$pay_subject->item_id],
                                ['household_id',$pay_subject->household_id],
                                ['pay_id',$pay_subject->pay_id],
                            ])
                            ->whereIn('code',['90'])
                            ->get();

                        $sdata=[
                            'item'=>$this->item,
                            'pay_subject'=>$pay_subject,
                            'pay_buildings'=>$pay_buildings,
                        ];
                        break;
                    // 合法临建
                    case 2:
                        $pay_buildings=Paybuilding::with(['householdbuilding'=>function($query){
                            $query->select(['id','name']);
                        },'realuse','buildingstruct'])
                            ->sharedLock()
                            ->where([
                                ['item_id',$pay_subject->item_id],
                                ['household_id',$pay_subject->household_id],
                                ['pay_id',$pay_subject->pay_id],
                            ])
                            ->whereIn('code',['92','95'])
                            ->get();

                        $sdata=[
                            'item'=>$this->item,
                            'pay_subject'=>$pay_subject,
                            'pay_buildings'=>$pay_buildings,
                        ];
                        break;
                    // 违建自行拆除补助
                    case 3:
                        $pay_buildings=Paybuilding::with(['householdbuilding'=>function($query){
                            $query->select(['id','name']);
                        },'realuse','buildingstruct'])
                            ->sharedLock()
                            ->where([
                                ['item_id',$pay_subject->item_id],
                                ['household_id',$pay_subject->household_id],
                                ['pay_id',$pay_subject->pay_id],
                            ])
                            ->whereIn('code',['94'])
                            ->get();

                        $sdata=[
                            'item'=>$this->item,
                            'pay_subject'=>$pay_subject,
                            'pay_buildings'=>$pay_buildings,
                        ];
                        break;
                    // 公共附属物
                    case 4:
                        $pay_publics=Paypublic::sharedLock()
                            ->where([
                                ['item_id',$pay_subject->item_id],
                                ['land_id',$pay_subject->land_id],
                            ])
                            ->get();

                        $sdata=[
                            'item'=>$this->item,
                            'pay_subject'=>$pay_subject,
                            'pay_publics'=>$pay_publics,
                        ];
                        break;
                    // 其他补偿事项
                    case 5:
                        $pay_objects=Payobject::sharedLock()
                            ->where([
                                ['item_id',$pay_subject->item_id],
                                ['household_id',$pay_subject->household_id],
                                ['pay_id',$pay_subject->pay_id],
                            ])
                            ->get();

                        $sdata=[
                            'item'=>$this->item,
                            'pay_subject'=>$pay_subject,
                            'pay_objects'=>$pay_objects,
                        ];
                        break;
                    // 固定资产
                    case 6:
                        $assets=Assets::sharedLock()
                            ->where([
                                ['item_id',$pay_subject->item_id],
                                ['household_id',$pay_subject->household_id],
                            ])
                            ->first();

                        $sdata=[
                            'item'=>$this->item,
                            'pay_subject'=>$pay_subject,
                            'assets'=>$assets,
                        ];
                        break;
                    // 临时安置费特殊人群优惠补助
                    case 14:
                    // 超期临时安置费特殊人群优惠补助
                    case 18:
                        $pay_crowds=Paycrowd::with(['crowdcate','crowd'])
                            ->sharedLock()
                            ->where([
                                ['item_id',$pay_subject->item_id],
                                ['household_id',$pay_subject->household_id],
                                ['pay_id',$pay_subject->pay_id],
                                ['subject_id',$pay_subject->subject_id],
                            ])
                            ->get();

                        $sdata=[
                            'item'=>$this->item,
                            'pay_subject'=>$pay_subject,
                            'pay_crowds'=>$pay_crowds,
                        ];
                        break;
                }
            }

            $code='success';
            $msg='请求成功';

            $edata=null;
            $url=null;

            $view='gov.paysubject.info';
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

    /* ========== 修改补偿科目 ========== */
    public function edit(Request $request){
        $id=$request->input('id');
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                if(!$id){
                    throw new \Exception('错误操作',404404);
                }
                $pay_subject=Paysubject::with(['subject','itemsubject'=>function($query){
                    $query->where('item_id',$this->item_id);
                }])
                    ->sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$id],
                    ])
                    ->first();
                if(blank($pay_subject)){
                    throw new \Exception('数据不存在',404404);
                }

                $code='success';
                $msg='请求成功';
                $sdata=[
                    'item'=>$this->item,
                    'pay_subject'=>$pay_subject,
                ];
                $edata=null;
                $url=null;

                $view='gov.paysubject.edit';
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
        /* ********** 保存 ********** */
        else{
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'calculate' => 'required',
                'amount' => 'required|numeric|min:0.01',
            ];
            $messages = [
                'required' => ':attribute 为必须项',
                'numeric' => ':attribute 格式错误',
                'min' => ':attribute 不能少于 :min',
            ];
            $model = new Paysubject();
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result = ['code' => 'error', 'message' => $validator->errors()->first(), 'sdata' => null, 'edata' => null, 'url' => null];
                return response()->json($result);
            }
            DB::beginTransaction();
            try{
                if(!$id){
                    throw new \Exception('错误操作',404404);
                }
                $pay_subject=Paysubject::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$id],
                    ])
                    ->first();
                if(blank($pay_subject)){
                    throw new \Exception('数据不存在',404404);
                }
                $pay_subject->fill($request->input());
                $pay_subject->save();

                $code='success';
                $msg='请求成功';
                $sdata=[
                    'item'=>$this->item,
                    'pay_subject'=>$pay_subject,
                ];
                $edata=null;
                $url=null;

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

    /* ========== 重新计算补偿 ========== */
    public function recal(Request $request){
        DB::beginTransaction();
        try{
            $pay_id=$request->input('pay_id');
            if(!$pay_id){
                throw new \Exception('错误操作',404404);
            }
            /* ++++++++++ 兑付汇总 ++++++++++ */
            $pay=Pay::lockForUpdate()
                ->where([
                    ['item_id',$this->item_id],
                    ['id',$pay_id],
                ])
                ->first();
            if(blank($pay)){
                throw new \Exception('兑付数据不存在',404404);
            }
            /* ++++++++++ 被征收户 ++++++++++ */
            $household=Household::sharedLock()
                ->select(['id','item_id','land_id','building_id','unit','floor','number','type','code'])
                ->find($pay->household_id);

            if(!in_array($household->code,['68','76'])){
                throw new \Exception('被征收户【'.$household->state->name.'】，不能重新计算补偿',404404);
            }

            $pay_subjects=Paysubject::lockForUpdate()
                ->where([
                    ['item_id',$pay->item_id],
                    ['household_id',$pay->household_id],
                    ['pay_id',$pay->id],
                ])
                ->whereIn('subject_id',[11,12,13])
                ->get();
            if(blank($pay_subjects)){
                throw new \Exception('没有补偿科目数据，请先添加',404404);
            }
            /* ++++++++++ 被征收户-详情 ++++++++++ */
            $household_detail=Householddetail::sharedLock()
                ->where([
                    ['item_id',$pay->item_id],
                    ['household_id',$pay->household_id],
                ])
                ->select(['item_id','household_id','has_assets','def_use','status'])
                ->first();
            /* ++++++++++ 正式方案 ++++++++++ */
            $program=Itemprogram::sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['code','22'],
                ])
                ->first();
            if(blank($program)){
                throw new \Exception('暂无通过审查的正式征收方案数据',404404);
            }
            /* ++++++++++ 合法面积、合法房屋补偿总额 ++++++++++ */
            $legal=Paybuilding::sharedLock()
                ->where([
                    ['item_id',$pay->item_id],
                    ['pay_id',$pay->id],
                ])
                ->select([DB::raw('SUM(`real_outer`) AS `legal_area`,SUM(`amount`) AS `legal_total`')])
                ->whereIn('code',['90','92','95'])
                ->first();

            $del_ids=[];
            $subject_data=[];
            foreach ($pay_subjects as $subject){
                switch ($subject->subject_id){
                    /* ++++++++++ 签约奖励（住宅） ++++++++++ */
                    case 11:
                        if(strtotime($program->item_end) < strtotime(date('Y-m-d')) || $household_detail->def_use!=1){
                            $del_ids[]=$subject->id;
                        }else{
                            /* ++++++++++ 签约奖励方案 ++++++++++ */
                            $item_reward=Itemreward::sharedLock()
                                ->where([
                                    ['start_at','<=',date('Y-m-d')],
                                    ['end_at','>=',date('Y-m-d')],
                                ])
                                ->first();
                            // 货币补偿
                            if($pay->getOriginal('repay_way')==0){
                                $reward_total=$legal->legal_area * ($item_reward->price+$program->reward_house);
                                $calculate=number_format($legal->legal_area,2).' × '.number_format(($item_reward->price+$program->reward_house),2).' = '.number_format($reward_total,2);
                            }
                            // 产权调换
                            else{
                                $reward_total=$legal->legal_area * $item_reward->price;
                                $calculate=number_format($legal->legal_area,2).' × '.number_format(($item_reward->price),2).' = '.number_format($reward_total,2);
                            }
                            $subject_data[]=[
                                'id'=>$subject->id,
                                'item_id'=>$subject->item_id,
                                'household_id'=>$subject->household_id,
                                'land_id'=>$subject->land_id,
                                'building_id'=>$subject->building_id,
                                'pay_id'=>$subject->pay_id,
                                'pact_id'=>0,
                                'subject_id'=>$subject->subject_id,
                                'total_id'=>0,
                                'calculate'=>$calculate,
                                'amount'=>$reward_total,
                                'code'=>'110',
                                'created_at'=>date('Y-m-d H:i:s'),
                                'updated_at'=>date('Y-m-d H:i:s'),
                            ];
                        }
                        break;

                    /* ++++++++++ 签约奖励（非住宅） ++++++++++ */
                    case 12:
                        if(strtotime($program->item_end) < strtotime(date('Y-m-d')) || $household_detail->def_use==1){
                            $del_ids[]=$subject->id;
                        }else{
                            /* ++++++++++ 签约奖励方案 ++++++++++ */
                            $item_reward=Itemreward::sharedLock()
                                ->where([
                                    ['start_at','<=',date('Y-m-d')],
                                    ['end_at','>=',date('Y-m-d')],
                                ])
                                ->first();

                            // 货币补偿
                            if($pay->getOriginal('repay_way')==0){
                                $reward_total=($legal->legal_total) * ($item_reward->portion+$program->reward_other)/100;
                                $calculate=number_format(($legal->legal_total),2).' × '.($item_reward->portion+$program->reward_other).'% = '.number_format($reward_total,2);
                            }
                            // 产权调换
                            else{
                                $reward_total=($legal->legal_total) * ($item_reward->portion)/100;
                                $calculate=number_format(($legal->legal_total),2).' × '.($item_reward->portion).'% = '.number_format($reward_total,2);
                            }
                            $subject_data[]=[
                                'id'=>$subject->id,
                                'item_id'=>$subject->item_id,
                                'household_id'=>$subject->household_id,
                                'land_id'=>$subject->land_id,
                                'building_id'=>$subject->building_id,
                                'pay_id'=>$subject->pay_id,
                                'pact_id'=>0,
                                'subject_id'=>$subject->subject_id,
                                'total_id'=>0,
                                'calculate'=>$calculate,
                                'amount'=>$reward_total,
                                'code'=>'110',
                                'created_at'=>date('Y-m-d H:i:s'),
                                'updated_at'=>date('Y-m-d H:i:s'),
                            ];
                        }
                        break;

                    /* ++++++++++ 临时安置费 ++++++++++ */
                    case 13:
                        $delete=false;
                        if($pay->getOriginal('repay_way')==0 || $pay->getOriginal('transit_way')==1){
                            $del_ids[]=$subject->id;
                            $delete=true;
                        }else{
                            /* ++++++++++ 选择安置房源 ++++++++++ */
                            $resettle_house_ids=Payhouse::sharedLock()
                                ->where([
                                    ['item_id',$pay->item_id],
                                    ['household_id',$pay->household_id],
                                ])
                                ->pluck('house_id');
                            if(blank($resettle_house_ids)){
                                $del_ids[]=$subject->id;
                                $delete=true;
                            }else{
                                /* ++++++++++ 现房数量 ++++++++++ */
                                $real_count=House::sharedLock()
                                    ->whereIn('id',$resettle_house_ids)
                                    ->where('is_real',1)
                                    ->count();
                                /* ++++++++++ 临时安置时长 ++++++++++ */
                                $transit_times=$real_count?$program->transit_real:$program->transit_future;
                                $transit_end=date('Y-m',strtotime($program->item_end.' +'.$transit_times.' month'));
                                $now=date('Y-m');
                                if($now>=$transit_end){
                                    $del_ids[]=$subject->id;
                                    $delete=true;
                                }else{
                                    $diff_time=date_diff(date_create($now),date_create($transit_end));
                                    $transit_times = $diff_time->format('%m');
                                    /* ++++++++++ 临时安置单价 ++++++++++ */
                                    if($household_detail->def_use==1){
                                        // 住宅
                                        $transit_price=$program->transit_house;
                                    } else{
                                        // 非住宅
                                        $transit_price=$program->transit_other;
                                    }
                                    $price=$legal->legal_area * $transit_price;
                                    if($price>$program->transit_base){
                                        $transit_total=$price * $transit_times;
                                        $calculate=number_format($legal->legal_area,2).' × '.number_format($transit_price,2).' × '.$transit_times.' = '.number_format($transit_total,2);
                                    }else{
                                        $transit_total=$program->transit_base * $transit_times;
                                        $calculate=number_format($program->transit_base,2).' × '.$transit_times.' = '.number_format($transit_total,2);
                                    }
                                    $subject_data[]=[
                                        'id'=>$subject->id,
                                        'item_id'=>$subject->item_id,
                                        'household_id'=>$subject->household_id,
                                        'land_id'=>$subject->land_id,
                                        'building_id'=>$subject->building_id,
                                        'pay_id'=>$subject->pay_id,
                                        'pact_id'=>0,
                                        'subject_id'=>$subject->subject_id,
                                        'total_id'=>0,
                                        'calculate'=>$calculate,
                                        'amount'=>$transit_total,
                                        'code'=>'110',
                                        'created_at'=>date('Y-m-d H:i:s'),
                                        'updated_at'=>date('Y-m-d H:i:s'),
                                    ];
                                    if($transit_total){
                                        /* ++++++++++ 临时安置费特殊人群优惠补助 ++++++++++ */
                                        $member_crowd_ids=Householdmembercrowd::sharedLock()
                                            ->where([
                                                ['item_id',$this->item_id],
                                                ['household_id',$pay->household_id],
                                            ])
                                            ->pluck('crowd_id','id');

                                        $item_subject=Itemsubject::sharedLock()
                                            ->where([
                                                ['item_id',$this->item_id],
                                                ['subject_id',14],
                                            ])
                                            ->first();
                                        if(filled($member_crowd_ids) && filled($item_subject)) {
                                            $crowds = Crowd::with(['itemcrowds' => function ($query) {
                                                $query->where('item_id', $this->item_id)->orderBy('rate', 'desc');
                                            }])
                                                ->where('parent_id', 0)
                                                ->get();
                                            $crowd_data = [];
                                            $crowd_total = 0;
                                            foreach ($crowds as $crowd) {
                                                foreach ($crowd->itemcrowds as $itemcrowd) {
                                                    if ($member_crowd_id = $member_crowd_ids->search($itemcrowd->crowd_id)) {
                                                        $crowd_data[] = [
                                                            'item_id' => $this->item_id,
                                                            'household_id' => $pay->household_id,
                                                            'land_id' => $pay->land_id,
                                                            'building_id' => $pay->building_id,
                                                            'pay_id' => $pay->id,
                                                            'item_subject_id' => $item_subject->id,
                                                            'subject_id' => $item_subject->subject_id,
                                                            'item_crowd_id' => $itemcrowd->id,
                                                            'member_crowd_id' => $member_crowd_id,
                                                            'crowd_cate_id' => $itemcrowd->crowd_cate_id,
                                                            'crowd_id' => $itemcrowd->crowd_id,
                                                            'transit' =>$transit_total,
                                                            'rate' => $itemcrowd->rate,
                                                            'amount' => $itemcrowd->rate /100 * $transit_total,
                                                            'created_at' => date('Y-m-d H:i:s'),
                                                            'updated_at' => date('Y-m-d H:i:s'),
                                                        ];
                                                        $crowd_total += $itemcrowd->rate /100 * $transit_total;
                                                        break;
                                                    }
                                                }
                                            }
                                            $field = ['item_id', 'household_id', 'land_id', 'building_id', 'pay_id', 'item_subject_id', 'subject_id', 'item_crowd_id', 'member_crowd_id', 'crowd_cate_id', 'crowd_id', 'transit', 'rate', 'amount', 'created_at', 'updated_at'];
                                            $sqls = batch_update_or_insert_sql('pay_crowd', $field, $crowd_data, 'updated_at');
                                            if (!$sqls) {
                                                throw new \Exception('数据错误', 404404);
                                            }
                                            // 删除原有数据
                                            Paycrowd::lockForUpdate()
                                                ->where([
                                                    ['item_id',$pay->item_id],
                                                    ['household_id',$pay->household_id],
                                                    ['pay_id',$pay->id],
                                                ])
                                                ->delete();

                                            foreach ($sqls as $sql) {
                                                DB::statement($sql);
                                            }

                                            $subject_data[]=[
                                                'item_id'=>$pay->item_id,
                                                'household_id'=>$pay->household_id,
                                                'land_id'=>$pay->land_id,
                                                'building_id'=>$pay->building_id,
                                                'pay_id'=>$pay->id,
                                                'pact_id'=>0,
                                                'subject_id'=>$item_subject->subject_id,
                                                'total_id'=>0,
                                                'calculate'=>null,
                                                'amount'=>$crowd_total,
                                                'code'=>'110',
                                                'created_at'=>date('Y-m-d H:i:s'),
                                                'updated_at'=>date('Y-m-d H:i:s'),
                                            ];
                                        }else{
                                            $delete=true;
                                        }
                                    }
                                    else{
                                        $delete=true;
                                    }
                                }
                            }
                        }
                        if($delete){
                            $pay_subject_id=Paysubject::lockForUpdate()
                                ->where([
                                    ['item_id',$pay->item_id],
                                    ['household_id',$pay->household_id],
                                    ['pay_id',$pay->id],
                                    ['subject_id',14],
                                ])
                                ->value('id');
                            if($pay_subject_id){
                                $del_ids[]=$pay_subject_id;
                                Paycrowd::lockForUpdate()
                                    ->where([
                                        ['item_id',$pay->item_id],
                                        ['household_id',$pay->household_id],
                                        ['pay_id',$pay->id],
                                    ])
                                    ->delete();
                            }
                        }
                        break;
                }
            }

            if(filled($subject_data)){
                $field=['id','item_id','household_id','land_id','building_id','pay_id','pact_id','subject_id','total_id','calculate','amount','code','created_at','updated_at'];
                $sqls=batch_update_or_insert_sql('pay_subject',$field,$subject_data,['calculate','amount','updated_at']);
                if(!$sqls){
                    throw new \Exception('数据错误',404404);
                }
                foreach($sqls as $sql){
                    DB::statement($sql);
                }
            }
            if(filled($del_ids)){
                Paysubject::lockForUpdate()->whereIn('id',$del_ids)->delete();
            }
            /* ++++++++++ 补偿总额 ++++++++++ */
            $subject_total=Paysubject::sharedLock()
                ->where('pay_id',$pay->id)
                ->sum('amount');
            $pay->total=$subject_total;
            $pay->save();


            $code='success';
            $msg='保存成功';
            $sdata=[
                'item'=>$this->item,
                'pay'=>$pay,
            ];
            $edata=new Pay();
            $url=route('g_pay_info',['item'=>$pay->item_id,'id'=>$pay_id]);

            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'保存失败';
            $sdata=null;
            $edata=null;
            $url=null;

            DB::rollBack();
        }

        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        return response()->json($result);

    }
}