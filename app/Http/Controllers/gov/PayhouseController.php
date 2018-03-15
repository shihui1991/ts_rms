<?php
/*
|--------------------------------------------------------------------------
| 项目-产权调换房
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use App\Http\Model\House;
use App\Http\Model\Household;
use App\Http\Model\Householdmember;
use App\Http\Model\Itemctrl;
use App\Http\Model\Itemhouse;
use App\Http\Model\Itemhouserate;
use App\Http\Model\Itemprogram;
use App\Http\Model\Pay;
use App\Http\Model\Payhouse;
use App\Http\Model\Payreserve;
use App\Http\Model\Paysubject;
use App\Http\Model\Payunit;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PayhouseController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 开始选房 ========== */
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
                /* ++++++++++ 兑付 ++++++++++ */
                $pay=Pay::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$pay_id],
                    ])
                    ->first();
                if(blank($pay)){
                    throw new \Exception('错误操作',404404);
                }
                if($pay->getOriginal('repay_way')==0){
                    throw new \Exception('选择货币补偿的不能选择安置房',404404);
                }
                /* ++++++++++ 选房时间 ++++++++++ */
                $itemctrl=Itemctrl::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['cate_id',3],
                        ['start_at','<=',date('Y-m-d H:i:s')],
                        ['end_at','>=',date('Y-m-d H:i:s')],
                    ])
                    ->first();
                if(blank($itemctrl)){
                    throw new \Exception('还未到选房时间',404404);
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
                if(!in_array($household->code,['68','76'])){
                    throw new \Exception('被征收户【'.$household->state->name.'】，不能选房',404404);
                }
                $count=Payhouse::sharedLock()
                    ->where([
                        ['item_id',$pay->item_id],
                        ['household_id',$pay->household_id],
                    ])
                    ->count();
                if($count){
                    throw new \Exception('已有选房数据，请进入修改页面',404404);
                }
                /* ++++++++++ 公房单位、承租人、产权人 ++++++++++ */
                $pay_unit=null;
                if($household->getOriginal('type')){
                    $pay_unit=Payunit::sharedLock()
                        ->where([
                            ['item_id',$this->item_id],
                            ['household_id',$household->id],
                            ['pay_id',$pay_id],
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
                /* ++++++++++ 可调换安置房的补偿额 ++++++++++ */
                $resettle_total=Paysubject::sharedLock()
                    ->where([
                        ['item_id',$pay->item_id],
                        ['household_id',$pay->household_id],
                        ['pay_id',$pay->id],
                    ])
                    ->whereIn('subject_id',[1,2,4,11,12])
                    ->sum('amount');
                if($household->getOriginal('type')==1){ // 公房
                    $resettle_total -= $pay_unit->amount;
                }

                /* ++++++++++ 项目房源 ++++++++++ */
                $item_house_ids=Itemhouse::sharedLock()
                    ->where('item_id',$this->item_id)
                    ->pluck('house_id');

                $total=House::sharedLock()
                    ->whereIn('id',$item_house_ids)
                    ->where('code','151')
                    ->count();

                $per_page=15;
                $page=$request->input('page',1);
                $houses=House::with(['housecommunity','layout','houselayoutimg','itemhouseprice'=>function($query){
                    $query->where([
                        ['start_at','<=',$this->item->created_at],
                        ['end_at','>=',$this->item->created_at],
                    ]);
                }])
                    ->sharedLock()
                    ->whereIn('id',$item_house_ids)
                    ->where('code','151')
                    ->offset($per_page*($page-1))
                    ->limit($per_page)
                    ->get();
                $houses=new LengthAwarePaginator($houses,$total,$per_page,$page);
                $houses->withPath(route('g_payreserve_house',['item'=>$this->item_id,'pay_id'=>$pay_id]));

                $code='success';
                $msg='请求成功';
                $sdata=[
                    'item'=>$this->item,
                    'household'=>$household,
                    'pay_unit'=>$pay_unit,
                    'holder'=>$holder,
                    'pay'=>$pay,
                    'resettle_total'=>$resettle_total,
                    'houses'=>$houses,
                ];
                $edata=null;
                $url=null;

                $view='gov.payhouse.add';
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
        /* ++++++++++ 保存 ++++++++++ */
        else{
            DB::beginTransaction();
            try{
                /* ++++++++++ 兑付 ++++++++++ */
                $pay=Pay::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$pay_id],
                    ])
                    ->first();
                if(blank($pay)){
                    throw new \Exception('错误操作',404404);
                }
                if($pay->getOriginal('repay_way')==0){
                    throw new \Exception('选择货币补偿的不能选择安置房',404404);
                }

                $house_ids=$request->input('house_ids');
                $transits=$request->input('transits');
                if(blank($house_ids)){
                    throw new \Exception('请选择房源',404404);
                }
                if($house_ids==$transits){
                    throw new \Exception('请选择产权调换房源',404404);
                }

                /* ++++++++++ 临时周转房过渡 ++++++++++ */
                if($pay->getOriginal('transit_way')){
                    if(blank($transits)){
                        throw new \Exception('请选择临时周转房源',404404);
                    }
                    $house_ids=array_diff($house_ids,$transits);
                }
                /* ++++++++++ 货币过渡 ++++++++++ */
                else{
                    if(filled($transits)){
                        throw new \Exception('选择货币过渡则不能选择临时周转房',404404);
                    }
                }

                /* ++++++++++ 选房时间 ++++++++++ */
                $itemctrl=Itemctrl::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['cate_id',3],
                        ['start_at','<=',date('Y-m-d H:i:s')],
                        ['end_at','>=',date('Y-m-d H:i:s')],
                    ])
                    ->first();
                if(blank($itemctrl)){
                    throw new \Exception('还未到选房时间',404404);
                }
                /* ++++++++++ 被征收户 ++++++++++ */
                $household=Household::sharedLock()
                    ->select(['id','item_id','land_id','building_id','unit','floor','number','type','code'])
                    ->find($pay->household_id);
                if(!in_array($household->code,['68','76'])){
                    throw new \Exception('被征收户【'.$household->state->name.'】，不能选房',404404);
                }

                $count=Payhouse::sharedLock()
                    ->where([
                        ['item_id',$pay->item_id],
                        ['household_id',$pay->household_id],
                    ])
                    ->count();
                if($count){
                    throw new \Exception('已有选房数据，请进入修改页面',404404);
                }

                /* ++++++++++ 产权调换房 ++++++++++ */
                $houses=House::with(['itemhouseprice'=>function($query){
                    $query->where([
                        ['start_at','<=',$this->item->created_at],
                        ['end_at','>=',$this->item->created_at],
                    ]);
                }])
                    ->sharedLock()
                    ->whereIn('id',$house_ids)
                    ->where('code','151')
                    ->orderBy('area','desc')
                    ->get();
                if(blank($houses)){
                    throw new \Exception('当前选择的房源已被占用',404404);
                }
                $houses=$houses->sortByDesc(function($house,$key){
                    return $house->itemhouseprice->price;
                });
                $house_rates=Itemhouserate::sharedLock()->where('item_id',$this->item_id)->orderBy('start_area','asc')->get();

                /* ++++++++++ 可调换安置房的补偿额 ++++++++++ */
                $resettle_total=Paysubject::sharedLock()
                    ->where([
                        ['item_id',$pay->item_id],
                        ['household_id',$pay->household_id],
                        ['pay_id',$pay->id],
                    ])
                    ->whereIn('subject_id',[1,2,4,11,12])
                    ->sum('amount');
                if($household->getOriginal('type')==1){ // 公房
                    $pay_unit=Payunit::sharedLock()
                        ->where([
                            ['item_id',$this->item_id],
                            ['household_id',$household->id],
                            ['pay_id',$pay_id],
                        ])
                        ->first();
                    $resettle_total -= $pay_unit->amount;
                }

                $last_total=$resettle_total; // 产权调换后结余补偿款
                $plus_area=0; // 上浮累计面积
                $house_data=[];
                $plus_data=[];
                $resettles=[];
                foreach($houses as $house){
                    $house_amount=$house->area * $house->itemhouseprice->price; // 房屋安置优惠价值
                    $plus_toal=0;

                    $last_total -= $house_amount; // 结余补偿款
                    // 可完全优惠
                    if($last_total>=0){

                    }
                    // 不能完全优惠
                    else{
                        // 原补偿款结余为正
                        if(($last_total+$house_amount)>=0){
                            $def_area=($last_total+$house_amount)/$house->itemhouseprice->price; // 补偿款可完全优惠面积
                            $last_area=$house->area-$def_area; // 房屋面积与补偿款可完全优惠面积之差：上浮面积
                        }else{
                            // 上浮累计面积 超过限制
                            if($plus_area>=30){
                                break;
                            }
                            $last_area=$house->area;
                        }
                        // 优惠上浮
                        foreach($house_rates as $rate){
                            // 在上浮优惠区间
                            if($rate->end_area !=0 && $rate->rate !=0){
                                // 上浮累计面积不在当前区间
                                if($plus_area>$rate->end_area){
                                    continue;
                                }
                                // 上浮累计面积加上浮面积 在当前区间
                                if(($plus_area+$last_area) <= $rate->end_area){
                                    $plus_area += $last_area;
                                    $amount=$last_area * $house->itemhouseprice->price * $rate->rate;
                                    $plus_toal += $amount;

                                    $plus_data[]=[
                                        'item_id'=>$pay->item_id,
                                        'household_id'=>$pay->household_id,
                                        'land_id'=>$pay->land_id,
                                        'building_id'=>$pay->building_id,
                                        'house_id'=>$house->id,
                                        'start'=>$rate->start_area,
                                        'end'=>$rate->end_area,
                                        'area'=>$last_area,
                                        'market'=>$house->itemhouseprice->market,
                                        'price'=>$house->itemhouseprice->price,
                                        'rate'=>$rate->rate,
                                        'agio'=>$house->itemhouseprice->market - $house->itemhouseprice->price,
                                        'amount'=>$amount,
                                        'created_at'=>date('Y-m-d H:i:s'),
                                        'updated_at'=>date('Y-m-d H:i:s'),
                                    ];
                                    break;
                                }
                                // 上浮累计面积加上浮面积 超出当前区间
                                else{
                                    $up_area=$rate->end_area - $plus_area;
                                    $amount=$up_area * $house->itemhouseprice->price * $rate->rate;
                                    $plus_area += $up_area;
                                    $last_area -= $up_area;
                                    $plus_toal += $amount;

                                    $plus_data[]=[
                                        'item_id'=>$pay->item_id,
                                        'household_id'=>$pay->household_id,
                                        'land_id'=>$pay->land_id,
                                        'building_id'=>$pay->building_id,
                                        'house_id'=>$house->id,
                                        'start'=>$rate->start_area,
                                        'end'=>$rate->end_area,
                                        'area'=>$up_area,
                                        'market'=>$house->itemhouseprice->market,
                                        'price'=>$house->itemhouseprice->price,
                                        'rate'=>$rate->rate,
                                        'agio'=>$house->itemhouseprice->market - $house->itemhouseprice->price,
                                        'amount'=>$amount,
                                        'created_at'=>date('Y-m-d H:i:s'),
                                        'updated_at'=>date('Y-m-d H:i:s'),
                                    ];
                                }
                            }
                            // 超过上浮优惠区间
                            else{
                                $plus_area += $last_area;
                                $amount = ($house->itemhouseprice->market - $house->itemhouseprice->price) * $last_area ;
                                $plus_toal += $amount;

                                $plus_data[]=[
                                    'item_id'=>$pay->item_id,
                                    'household_id'=>$pay->household_id,
                                    'land_id'=>$pay->land_id,
                                    'building_id'=>$pay->building_id,
                                    'house_id'=>$house->id,
                                    'start'=>$rate->start_area,
                                    'end'=>$rate->end_area,
                                    'area'=>$last_area,
                                    'market'=>$house->itemhouseprice->market,
                                    'price'=>$house->itemhouseprice->price,
                                    'rate'=>$rate->rate,
                                    'agio'=>$house->itemhouseprice->market - $house->itemhouseprice->price,
                                    'amount'=>$amount,
                                    'created_at'=>date('Y-m-d H:i:s'),
                                    'updated_at'=>date('Y-m-d H:i:s'),
                                ];
                                break;
                            }
                        }

                        // 上浮累计面积 超过限制
                        if($plus_area>=30){
                            break;
                        }
                    }
                    $resettles[]=$house->id;
                    $house_data[]=[
                        'item_id'=>$pay->item_id,
                        'household_id'=>$pay->household_id,
                        'land_id'=>$pay->land_id,
                        'building_id'=>$pay->building_id,
                        'house_id'=>$house->id,
                        'area'=>$house->area,
                        'market'=>$house->itemhouseprice->market,
                        'price'=>$house->itemhouseprice->price,
                        'amount'=>$house_amount,
                        'amount_plus'=>$plus_toal,
                        'total'=>$house_amount + $plus_toal,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ];
                }

                $field=['item_id','household_id','land_id','building_id','house_id','area','market','price','amount','amount_plus','total','created_at','updated_at'];
                $sqls=batch_update_or_insert_sql('pay_house',$field,$house_data,'updated_at');
                if(!$sqls){
                    throw new \Exception('保存失败',404404);
                }
                foreach ($sqls as $sql){
                    DB::statement($sql);
                }
                // 产权调换房 上浮
                if(filled($plus_data)){
                    $field=['item_id','household_id','land_id','building_id','house_id','start','end','area','market','price','rate','agio','amount','created_at','updated_at'];
                    $sqls=batch_update_or_insert_sql('pay_house_plus',$field,$plus_data,'updated_at');
                    if(!$sqls){
                        throw new \Exception('保存失败',404404);
                    }
                    foreach ($sqls as $sql){
                        DB::statement($sql);
                    }
                }

                /* ++++++++++ 临时周转房 ++++++++++ */
                if($pay->getOriginal('transit_way')){
                    $transit_data=[];
                    foreach($transits as $house_id){
                        $transit_data[]=[
                            'item_id'=>$pay->item_id,
                            'household_id'=>$pay->household_id,
                            'land_id'=>$pay->land_id,
                            'building_id'=>$pay->building_id,
                            'pay_id'=>$pay->id,
                            'pact_id'=>0,
                            'house_id'=>$house_id,
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s'),
                        ];
                    }
                    $field=['item_id','household_id','land_id','building_id','pay_id','pact_id','house_id','created_at','updated_at'];
                    $sqls=batch_update_or_insert_sql('pay_transit',$field,$transit_data,'updated_at');
                    if(!$sqls){
                        throw new \Exception('保存失败',404404);
                    }
                    foreach ($sqls as $sql){
                        DB::statement($sql);
                    }
                }
                $fails=array_diff($house_ids,$resettles);

                $code='success';
                $msg='保存成功';
                $sdata=[
                    'resettles'=>$resettles,
                ];
                $edata=filled($fails)?$fails:null;
                $url=route('g_pay_info',['item'=>$this->item_id,'id'=>$pay->id]);

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

    /* ========== 选房计算 ========== */
    public function calculate(Request $request){
        DB::beginTransaction();
        try{
            $pay_id=$request->input('pay_id');
            if(!$pay_id){
                throw new \Exception('错误操作',404404);
            }
            /* ++++++++++ 兑付 ++++++++++ */
            $pay=Pay::sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['id',$pay_id],
                ])
                ->first();
            if(blank($pay)){
                throw new \Exception('错误操作',404404);
            }
            if($pay->getOriginal('repay_way')==0){
                throw new \Exception('选择货币补偿的不能选择安置房',404404);
            }
            $house_ids=$request->input('house_ids');
            $transits=$request->input('transits');
            if(blank($house_ids)){
                throw new \Exception('请选择房源',404404);
            }
            if($house_ids==$transits){
                throw new \Exception('请选择产权调换房源',404404);
            }

            /* ++++++++++ 临时周转房过渡 ++++++++++ */
            if($pay->getOriginal('transit_way')){
                if(blank($transits)){
                    throw new \Exception('请选择临时周转房源',404404);
                }
                $house_ids=array_diff($house_ids,$transits);
            }
            /* ++++++++++ 货币过渡 ++++++++++ */
            else{
                if(filled($transits)){
                    throw new \Exception('选择货币过渡则不能选择临时周转房',404404);
                }
            }

            /* ++++++++++ 选房时间 ++++++++++ */
            $itemctrl=Itemctrl::sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['cate_id',3],
                    ['start_at','<=',date('Y-m-d H:i:s')],
                    ['end_at','>=',date('Y-m-d H:i:s')],
                ])
                ->first();
            if(blank($itemctrl)){
                throw new \Exception('还未到选房时间',404404);
            }
            /* ++++++++++ 被征收户 ++++++++++ */
            $household=Household::sharedLock()
                ->select(['id','item_id','land_id','building_id','unit','floor','number','type','code'])
                ->find($pay->household_id);
            if(!in_array($household->code,['68','76'])){
                throw new \Exception('被征收户【'.$household->state->name.'】，不能选房',404404);
            }

            $count=Payhouse::sharedLock()
                ->where([
                    ['item_id',$pay->item_id],
                    ['household_id',$pay->household_id],
                ])
                ->count();
            if($count){
                throw new \Exception('已有选房数据，请进入修改页面',404404);
            }

            /* ++++++++++ 产权调换房 ++++++++++ */
            $houses=House::with(['housecommunity','layout','itemhouseprice'=>function($query){
                $query->where([
                    ['start_at','<=',$this->item->created_at],
                    ['end_at','>=',$this->item->created_at],
                ]);
            }])
                ->sharedLock()
                ->whereIn('id',$house_ids)
                ->where('code','151')
                ->orderBy('area','desc')
                ->get();
            if(blank($houses)){
                throw new \Exception('当前选择的房源已被占用',404404);
            }
            $houses=$houses->sortByDesc(function($house,$key){
                return $house->itemhouseprice->price;
            });
            $house_rates=Itemhouserate::sharedLock()->where('item_id',$this->item_id)->orderBy('start_area','asc')->get();

            $total=$pay->total;
            /* ++++++++++ 可调换安置房的补偿额 ++++++++++ */
            $resettle_total=Paysubject::sharedLock()
                ->where([
                    ['item_id',$pay->item_id],
                    ['household_id',$pay->household_id],
                    ['pay_id',$pay->id],
                ])
                ->whereIn('subject_id',[1,2,4,11,12])
                ->sum('amount');
            if($household->getOriginal('type')==1){ // 公房
                $pay_unit=Payunit::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['household_id',$household->id],
                        ['pay_id',$pay_id],
                    ])
                    ->first();
                $total -= $pay_unit->amount;
                $resettle_total -= $pay_unit->amount;
            }

            $end_total=$total;
            $last_total=$resettle_total; // 产权调换后结余补偿款
            $plus_area=0; // 上浮累计面积
            $resettles=[];
            $resettle_ids=[];
            foreach($houses as $house){
                $house_amount=$house->area * $house->itemhouseprice->price; // 房屋安置优惠价值
                $plus_toal=0;
                $plus_data=[];

                $last_total -= $house_amount; // 结余补偿款
                // 可完全优惠
                if($last_total>=0){

                }
                // 不能完全优惠
                else{
                    // 原补偿款结余为正
                    if(($last_total+$house_amount)>=0){
                        $def_area=($last_total+$house_amount)/$house->itemhouseprice->price; // 补偿款可完全优惠面积
                        $last_area=$house->area-$def_area; // 房屋面积与补偿款可完全优惠面积之差：上浮面积
                    }else{
                        // 上浮累计面积 超过限制
                        if($plus_area>=30){
                            break;
                        }
                        $last_area=$house->area;
                    }
                    // 优惠上浮
                    foreach($house_rates as $rate){
                        // 在上浮优惠区间
                        if($rate->end_area !=0 && $rate->rate !=0){
                            // 上浮累计面积不在当前区间
                            if($plus_area>$rate->end_area){
                                continue;
                            }
                            // 上浮累计面积加上浮面积 在当前区间
                            if(($plus_area+$last_area) <= $rate->end_area){
                                $plus_area += $last_area;
                                $amount=$last_area * $house->itemhouseprice->price * $rate->rate;
                                $plus_toal += $amount;

                                $plus_data[]=[
                                    'start'=>$rate->start_area,
                                    'end'=>$rate->end_area,
                                    'area'=>$last_area,
                                    'market'=>$house->itemhouseprice->market,
                                    'price'=>$house->itemhouseprice->price,
                                    'rate'=>$rate->rate,
                                    'agio'=>$house->itemhouseprice->market - $house->itemhouseprice->price,
                                    'amount'=>$amount,
                                ];
                                break;
                            }
                            // 上浮累计面积加上浮面积 超出当前区间
                            else{
                                $up_area=$rate->end_area - $plus_area;
                                $amount=$up_area * $house->itemhouseprice->price * $rate->rate;
                                $plus_area += $up_area;
                                $last_area -= $up_area;
                                $plus_toal += $amount;

                                $plus_data[]=[
                                    'start'=>$rate->start_area,
                                    'end'=>$rate->end_area,
                                    'area'=>$up_area,
                                    'market'=>$house->itemhouseprice->market,
                                    'price'=>$house->itemhouseprice->price,
                                    'rate'=>$rate->rate,
                                    'agio'=>$house->itemhouseprice->market - $house->itemhouseprice->price,
                                    'amount'=>$amount,
                                ];
                            }
                        }
                        // 超过上浮优惠区间
                        else{
                            $plus_area += $last_area;
                            $amount = ($house->itemhouseprice->market - $house->itemhouseprice->price) * $last_area ;
                            $plus_toal += $amount;

                            $plus_data[]=[
                                'start'=>$rate->start_area,
                                'end'=>$rate->end_area,
                                'area'=>$last_area,
                                'market'=>$house->itemhouseprice->market,
                                'price'=>$house->itemhouseprice->price,
                                'rate'=>$rate->rate,
                                'agio'=>$house->itemhouseprice->market - $house->itemhouseprice->price,
                                'amount'=>$amount,
                            ];
                            break;
                        }
                    }

                    // 上浮累计面积 超过限制
                    if($plus_area>=30){
                        break;
                    }
                }
                $house->amount=$house_amount;
                $house->amount_plus=$plus_toal;
                $house->total=$house_amount + $plus_toal;
                $house->housepluses=$plus_data;
                $resettles[]=$house;
                $resettle_ids[]=$house->id;

                $end_total -= $house->total;
            }

            $fails=array_diff($house_ids,$resettle_ids);

            $code='success';
            $msg='计算成功';
            $sdata=[
                'resettles'=>$resettles,
                'resettle_total'=>$resettle_total,
                'last_total'=>$end_total,
                'plus_area'=>$plus_area,
            ];
            $edata=$fails;
            $url=null;
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'计算失败';
            $sdata=null;
            $edata=null;
            $url=null;
        }
        DB::commit();

        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        return response()->json($result);
    }
}