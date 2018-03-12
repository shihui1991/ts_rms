<?php
/*
|--------------------------------------------------------------------------
| 项目-兑付补偿
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use App\Http\Model\Assess;
use App\Http\Model\Assets;
use App\Http\Model\Estate;
use App\Http\Model\Estatebuilding;
use App\Http\Model\Household;
use App\Http\Model\Householddetail;
use App\Http\Model\Householdmember;
use App\Http\Model\Householdobject;
use App\Http\Model\Itemprogram;
use App\Http\Model\Pay;
use App\Http\Model\Paybuilding;
use App\Http\Model\Payobject;
use App\Http\Model\Paypublic;
use App\Http\Model\Paysubject;
use App\Http\Model\Payunit;
use App\Http\Model\Publicdetail;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PayController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        DB::beginTransaction();

        $total=Household::sharedLock()
            ->where('item_id',$this->item_id)
            ->count();

        $per_page=15;
        $page=$request->input('page',1);
        $households=Household::with(['itemland'=>function($query){
            $query->select(['id','address']);
        },'itembuilding'=>function($query){
            $query->select(['id','building']);
        },'state'=>function($query){
            $query->select(['code','name']);
        },'pay'])
            ->where('item_id',$this->item_id)
            ->select(['id','item_id','land_id','building_id','unit','floor','number','type','code'])
            ->sharedLock()
            ->offset($per_page*($page-1))
            ->limit($per_page)
            ->get();

        $households=new LengthAwarePaginator($households,$total,$per_page,$page);
        $households->withPath(route('g_pay',['item'=>$this->item_id]));

        DB::commit();

        /* ********** 结果 ********** */
        $result=[
            'code'=>'success',
            'message'=>'请求成功',
            'sdata'=>[
                'item'=>$this->item,
                'households'=>$households,
            ],
            'edata'=>null,
            'url'=>null];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.pay.index')->with($result);
        }
    }

    /* ========== 补偿决定 ========== */
    public function add(Request $request){
        $household_id=$request->input('household_id');
        if(!$household_id){
            $result=['code'=>'error','message'=>'请选择被征收户','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                $pay_id=Pay::sharedLock()->where([['item_id',$this->item_id],['household_id',$household_id]])->value('id');
                if($pay_id){
                    throw new \Exception('该被征收户已存在补偿数据',404404);
                }
                $household=Household::with(['itemland'=>function($query){
                    $query->with('adminunit')->select(['id','address','admin_unit_id']);
                },'itembuilding'=>function($query){
                    $query->select(['id','building']);
                },'state'=>function($query){
                    $query->select(['code','name']);
                }])
                    ->sharedLock()
                    ->select(['id','item_id','land_id','building_id','unit','floor','number','type','code'])
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$household_id],
                    ])
                    ->first();
                if(blank($household)){
                    throw new \Exception('被征收户不存在',404404);
                }

                $code='success';
                $msg='请求成功';
                $sdata=[
                    'item'=>$this->item,
                    'household'=>$household,
                ];
                $edata=new Pay();
                $url=null;

                $view='gov.pay.add';
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
            $rules=[
                'repay_way'=>'required|boolean',
                'transit_way'=>'required|boolean',
                'move_way'=>'required|boolean',
                'picture'=>'required',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'boolean'=>'请选择 :attribute 的正确选项',
            ];
            $model=new Pay();
            $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }

            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try{
                $pay_id=Pay::sharedLock()->where([['item_id',$this->item_id],['household_id',$household_id]])->value('id');
                if($pay_id){
                    throw new \Exception('该被征收户已存在兑付数据',404404);
                }
                $household=Household::lockForUpdate()
                    ->select(['id','item_id','land_id','building_id','unit','floor','number','type','code'])
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$household_id],
                    ]);
                if(blank($household)){
                    throw new \Exception('被征收户不存在',404404);
                }
                if($household->code<'63'){
                    throw new \Exception('被征收户还未完成确权确户',404404);
                }
                $household_detail=Householddetail::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['household_id',$household_id],
                    ])
                    ->select(['item_id','household_id','has_assets','area_dispute','repay_way','def_use'])
                    ->first();
                if($household_detail->getOriginal('area_dispute')==0){
                    throw new \Exception('被征收户存在面积争议',404404);
                }
                /* ++++++++++ 评估汇总 ++++++++++ */
                $assess=Assess::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['household_id',$household_id],
                        ['code','136'],
                    ])
                    ->first();
                if(blank($assess)){
                    throw new \Exception('暂无有效的评估数据',404404);
                }
                /* ++++++++++ 房产评估 ++++++++++ */
                $estate=Estate::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['household_id',$household_id],
                        ['assess_id',$assess->id],
                        ['code','136'],
                    ])
                    ->select(['id','item_id','household_id','assess_id','code'])
                    ->first();
                if(blank($assess)){
                    throw new \Exception('暂无有效的房产评估数据',404404);
                }
                $estatebuildings=Estatebuilding::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['household_id',$household_id],
                        ['assess_id',$assess->id],
                        ['estate_id',$estate->id],
                    ])
                    ->get();

                if($household_detail->getOriginal('has_assets')){
                    $assets=Assets::sharedLock()
                        ->where([
                            ['item_id',$this->item_id],
                            ['household_id',$household_id],
                            ['assess_id',$assess->id],
                            ['code','136'],
                        ])
                        ->select(['id','item_id','household_id','assess_id','code'])
                        ->first();
                    if(blank($assets)){
                        throw new \Exception('暂无有效的资产评估数据',404404);
                    }
                }
                /* ++++++++++ 正式方案 ++++++++++ */
                $program=Itemprogram::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['code','22'],
                    ])
                    ->select(['id','item_id','code','item_end','portion_holder'])
                    ->first();
                if(blank($program)){
                    throw new \Exception('暂无通过审查的正式征收方案数据',404404);
                }
                if(strtotime($program->item_end) > strtotime(date('Y-m-d'))){
                    throw new \Exception('项目征收期限未到，不能下达行政征收决定',404404);
                }
                
                /* ++++++++++ 批量赋值 ++++++++++ */
                $pay=$model;
                $pay->fill($request->input());
                $pay->addOther($request);
                $pay->item_id=$this->item_id;
                $pay->household_id=$household_id;
                $pay->land_id=$household->land_id;
                $pay->building_id=$household->building_id;
                $pay->total=0;
                $pay->save();
                if(blank($pay)){
                    throw new \Exception('保存失败',404404);
                }
                $subject_data=[];
                /* ++++++++++ 合法房屋及附属物、合法临建、违建自行拆除补助 ++++++++++ */
                $building_data=[];
                $register_total=0;  // 合法房屋及附属物 评估总额
                $legal_total=0; // 合法临建 评估总额
                $destroy_total=0; // 违建自行拆除补助 评估总额
                $legal_area=0; // 合法面积
                foreach($estatebuildings as $building){
                    if(in_array($building->code,['91','93'])){
                        throw new \Exception('存在合法性争议的房屋',404404);
                    }

                    switch ($building->code){
                        case '92':
                            $price=$building->price;
                            $amount=$building->amount;
                            $legal_total +=$amount;
                            $legal_area += $building->real_outer;
                            break;
                        case '94':
                            $price=$building->householdbuilding->buildingdeal->price;
                            $amount=$building->householdbuilding->buildingdeal->amount;
                            $destroy_total +=$amount;
                            break;
                        case '95':
                            $price=$building->price;
                            $amount=$building->amount;
                            $legal_total +=$amount;
                            $legal_area += $building->real_outer;
                            break;
                        default:
                            $price=$building->price;
                            $amount=$building->amount;
                            $register_total +=$amount;
                            $legal_area += $building->real_outer;
                    }
                    $building_data[]=[
                        'item_id'=>$this->item_id,
                        'household_id'=>$household_id,
                        'land_id'=>$household->land_id,
                        'building_id'=>$household->building_id,
                        'assess_id'=>$assess->id,
                        'estate_id'=>$estate->id,
                        'household_building_id'=>$building->household_building_id,
                        'estate_building_id'=>$building->id,
                        'pay_id'=>$pay->id,
                        'code'=>$building->code,
                        'real_outer'=>$building->real_outer,
                        'real_use'=>$building->real_use,
                        'struct_id'=>$building->struct_id,
                        'layout_id'=>$building->layout_id,
                        'direct'=>$building->direct,
                        'floor'=>$building->floor,
                        'price'=>$price,
                        'amount'=>$amount,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ];
                }
                $field=['item_id','household_id','land_id','building_id','assess_id','estate_id','household_building_id','estate_building_id','pay_id','code','real_outer','real_use','struct_id','layout_id','direct','floor','price','amount','created_at','updated_at'];
                $sqls=batch_update_or_insert_sql('pay_building',$field,$building_data,'updated_at');
                if(!$sqls){
                    throw new \Exception('数据错误',404404);
                }
                foreach($sqls as $sql){
                    DB::statement($sql);
                }
                /* ++++++++++ 合法房屋及附属物 ++++++++++ */
                if($register_total){
                    $subject_data[]=[
                        'item_id'=>$this->item_id,
                        'household_id'=>$household_id,
                        'land_id'=>$household->land_id,
                        'building_id'=>$household->building_id,
                        'pay_id'=>$pay->id,
                        'pact_id'=>0,
                        'subject_id'=>1,
                        'total_id'=>0,
                        'calculate'=>null,
                        'amount'=>$register_total,
                        'code'=>'110',
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ];
                }
                /* ++++++++++ 合法临建 ++++++++++ */
                if($legal_total){
                    $subject_data[]=[
                        'item_id'=>$this->item_id,
                        'household_id'=>$household_id,
                        'land_id'=>$household->land_id,
                        'building_id'=>$household->building_id,
                        'pay_id'=>$pay->id,
                        'pact_id'=>0,
                        'subject_id'=>2,
                        'total_id'=>0,
                        'calculate'=>null,
                        'amount'=>$legal_total,
                        'code'=>'110',
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ];
                }
                /* ++++++++++ 违建自行拆除补助 ++++++++++ */
                if($destroy_total){
                    $subject_data[]=[
                        'item_id'=>$this->item_id,
                        'household_id'=>$household_id,
                        'land_id'=>$household->land_id,
                        'building_id'=>$household->building_id,
                        'pay_id'=>$pay->id,
                        'pact_id'=>0,
                        'subject_id'=>3,
                        'total_id'=>0,
                        'calculate'=>null,
                        'amount'=>$destroy_total,
                        'code'=>'110',
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ];
                }
                /* ++++++++++ 固定资产 ++++++++++ */
                if($household_detail->getOriginal('has_assets')){
                    $subject_data[]=[
                        'item_id'=>$this->item_id,
                        'household_id'=>$household_id,
                        'land_id'=>$household->land_id,
                        'building_id'=>$household->building_id,
                        'pay_id'=>$pay->id,
                        'pact_id'=>0,
                        'subject_id'=>6,
                        'total_id'=>0,
                        'calculate'=>null,
                        'amount'=>$assess->assets,
                        'code'=>'110',
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ];
                }

                /* ++++++++++ 公共附属物 ++++++++++ */
                $public_total=0;
                $pay_public=Paypublic::sharedLock()
                    ->select(DB::raw('count(*) as `public_count`,sum(`avg`) as `public_total`'))
                    ->where([
                        ['item_id',$this->item_id],
                        ['land_id',$household->land_id],
                    ])
                    ->first();
                if(filled($pay_public) && $pay_public->public_count){
                    $public_total=$pay_public->public_total;
                }else{
                    $public_details=Publicdetail::with(['itempublic'=>function($query){
                        $query->select(['id','item_id','land_id','building_id','name','num_unit','number']);
                    }])
                        ->sharedLock()
                        ->where([
                            ['item_id',$this->item_id],
                            ['land_id',$household->land_id],
                        ])
                        ->get();
                    if(filled($public_details)){
                        /* ++++++++++ 地块户数 ++++++++++ */
                        $land_num=Household::sharedLock()
                            ->where([
                                ['item_id',$this->item_id],
                                ['land_id',$household->land_id],
                            ])
                            ->count();
                        /* ++++++++++ 楼栋户数 ++++++++++ */
                        $building_num=Household::sharedLock()
                            ->where([
                                ['item_id',$this->item_id],
                                ['land_id',$household->land_id],
                                ['building_id',$household->building_id],
                            ])
                            ->count();
                        $public_data=[];
                        foreach($public_details as $public){
                            $household_num=$public->building_id?$building_num:$land_num;
                            $avg=$public->amount/$household_num;
                            $public_total += $avg;

                            $public_data[]=[
                                'item_id'=>$this->item_id,
                                'land_id'=>$public->land_id,
                                'building_id'=>$public->building_id,
                                'item_public_id'=>$public->item_public_id,
                                'com_public_id'=>$public->com_public_id,
                                'com_pub_detail_id'=>$public->id,
                                'name'=>$public->itempublic->name,
                                'num_unit'=>$public->itempublic->num_unit,
                                'number'=>$public->itempublic->number,
                                'price'=>$public->price,
                                'amount'=>$public->amount,
                                'household'=>$household_num,
                                'avg'=>$avg,
                                'created_at'=>date('Y-m-d H:i:s'),
                                'updated_at'=>date('Y-m-d H:i:s'),
                            ];
                        }
                        $field=['item_id','land_id','building_id','item_public_id','com_public_id','com_pub_detail_id','name','num_unit','number','price','amount','household','avg','created_at','updated_at'];
                        $sqls=batch_update_or_insert_sql('pay_public',$field,$public_data,'updated_at');
                        if(!$sqls){
                            throw new \Exception('数据错误',404404);
                        }
                        foreach($sqls as $sql){
                            DB::statement($sql);
                        }
                    }
                }
                if($public_total){
                    $subject_data[]=[
                        'item_id'=>$this->item_id,
                        'household_id'=>$household_id,
                        'land_id'=>$household->land_id,
                        'building_id'=>$household->building_id,
                        'pay_id'=>$pay->id,
                        'pact_id'=>0,
                        'subject_id'=>4,
                        'total_id'=>0,
                        'calculate'=>null,
                        'amount'=>$public_total,
                        'code'=>'110',
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ];
                }
                /* ++++++++++ 公房单位补偿 ++++++++++ */
                if($household->getOriginal('type')){
                    $pay_unit=new Payunit();
                    $pay_unit->item_id=$this->item_id;
                    $pay_unit->household_id=$household_id;
                    $pay_unit->land_id=$household->land_id;
                    $pay_unit->unit_id=$household->itemland->admin_unit_id;
                    $pay_unit->pay_id=$pay->id;
                    $pay_unit->pact_id=0;
                    $pay_unit->total_id=0;
                    $pay_unit->calculate=number_format($register_total+$legal_total+$public_total,2).' × '.$program->portion_holder.'% = '.number_format(($register_total+$legal_total+$public_total)*($program->portion_holder/100),2);
                    $pay_unit->amount=($register_total+$legal_total+$public_total)*($program->portion_holder/100);
                    $pay_unit->code='110';
                    $pay_unit->save();
                }

                /* ++++++++++ 其他补偿事项 ++++++++++ */
                $household_objects=Householdobject::with(['itemobject'=>function($query){
                    $query->where('item_id',$this->item_id);
                },'object'])
                    ->sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['household_id',$household_id],
                    ])
                    ->get();

                $object_total=0;
                if(filled($household_objects)){
                    $object_data=[];
                    foreach($household_objects as $object){
                        $amount=$object->number*$object->itemobject->price;
                        $object_total +=$amount;

                        $object_data[]=[
                            'item_id'=>$this->item_id,
                            'household_id'=>$household_id,
                            'land_id'=>$household->land_id,
                            'building_id'=>$household->building_id,
                            'household_obj_id'=>$object->id,
                            'item_object_id'=>$object->itemobject->id,
                            'object_id'=>$object->object_id,
                            'pay_id'=>$pay->id,
                            'name'=>$object->object->name,
                            'num_unit'=>$object->object->num_unit,
                            'number'=>$object->number,
                            'price'=>$object->itemobject->price,
                            'amount'=>$amount,
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s'),
                        ];
                    }
                    $field=['item_id','household_id','land_id','building_id','household_obj_id','item_object_id','object_id','pay_id','name','num_unit','number','price','amount','created_at','updated_at'];
                    $sqls=batch_update_or_insert_sql('pay_object',$field,$object_data,'updated_at');
                    if(!$sqls){
                        throw new \Exception('数据错误',404404);
                    }
                    foreach($sqls as $sql){
                        DB::statement($sql);
                    }

                    if($object_total){
                        $subject_data[]=[
                            'item_id'=>$this->item_id,
                            'household_id'=>$household_id,
                            'land_id'=>$household->land_id,
                            'building_id'=>$household->building_id,
                            'pay_id'=>$pay->id,
                            'pact_id'=>0,
                            'subject_id'=>5,
                            'total_id'=>0,
                            'calculate'=>null,
                            'amount'=>$object_total,
                            'code'=>'110',
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s'),
                        ];
                    }
                }

                /* ++++++++++ 补偿科目 ++++++++++ */
                $field=['item_id','household_id','land_id','building_id','pay_id','pact_id','subject_id','total_id','calculate','amount','code','created_at','updated_at'];
                $sqls=batch_update_or_insert_sql('pay_subject',$field,$subject_data,'updated_at');
                if(!$sqls){
                    throw new \Exception('数据错误',404404);
                }
                foreach($sqls as $sql){
                    DB::statement($sql);
                }

                $pay->total=$register_total+$legal_total+$destroy_total+$public_total+$object_total+$assess->assets;
                $pay->save();

                $code='success';
                $msg='保存成功';
                $sdata=$pay;
                $edata=null;
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
            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }

    /* ========== 兑付详情 ========== */
    public function info(Request $request){
        $pay_id=$request->input('id');
        DB::beginTransaction();
        try{
            if(!$pay_id){
                throw new \Exception('请选择兑付数据',404404);
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
            /* ++++++++++ 被征收户 ++++++++++ */
            $household=Household::with(['itemland'=>function($query){
                $query->with('adminunit')->select(['id','address']);
            },'itembuilding'=>function($query){
                $query->select(['id','building']);
            },'state'=>function($query){
                $query->select(['code','name']);
            }])
                ->sharedLock()
                ->select(['id','item_id','land_id','building_id','unit','floor','number','type','code'])
                ->find($pay->household_id);
            $household_detail=Householddetail::with(['defbuildinguse'=>function($query){
                $query->select(['id','name']);
            },'realbuildinguse'=>function($query){
                $query->select(['id','name']);
            }])
                ->sharedLock()
                ->select(['id','household_id','status','register','reg_outer','def_use','real_use','has_assets'])
                ->where('household_id',$pay->household_id)
                ->first();
            /* ++++++++++ 补偿科目 ++++++++++ */
            $subjects=Paysubject::with(['subject','state'=>function($query){
                $query->select(['code','name']);
            }])
                ->sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['pay_id',$pay_id],
                ])
                ->get();
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
            /* ++++++++++ 房屋建筑 ++++++++++ */
            $buildings=Paybuilding::with(['realuse'=>function($query){
                $query->select(['id','name']);
            },'buildingstruct'=>function($query){
                $query->select(['id','name']);
            },'state'=>function($query){
                $query->select(['code','name']);
            }])
                ->sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['household_id',$household->id],
                    ['pay_id',$pay_id],
                ])
                ->orderBy('register','desc')
                ->orderBy('code','asc')
                ->orderBy('real_use','asc')
                ->get();
            /* ++++++++++ 公共附属物 ++++++++++ */
            $publics=Paypublic::sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['land_id',$household->land_id],
                ])
                ->orderBy('land_id','asc')
                ->orderBy('building_id','asc')
                ->get();
            /* ++++++++++ 其他补偿事项 ++++++++++ */
            $objects=Payobject::sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['household_id',$household->id],
                    ['pay_id',$pay_id],
                ])
                ->get();

            $code='success';
            $msg='请求成功';
            $sdata=[
                'item'=>$this->item,
                'pay'=>$pay,
                'household'=>$household,
                'household_detail'=>$household_detail,
                'subjects'=>$subjects,
                'pay_unit'=>$pay_unit,
                'holder'=>$holder,
                'buildings'=>$buildings,
                'publics'=>$publics,
                'objects'=>$objects,
            ];
            $edata=new Pay();
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

    /* ========== 修改兑付方式 ========== */
    public function edit(Request $request){
        $pay_id=$request->input('id');
        if(!$pay_id){
            $result=['code'=>'error','message'=>'请选择兑付数据','sdata'=>null,'edata'=>null,'url'=>null];
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
                $household=Household::sharedLock()
                    ->select(['id','item_id','land_id','building_id','unit','floor','number','type','code'])
                    ->find($pay->household_id);
                if(!in_array($household->code,['69','75'])){
                    throw new \Exception('被征收户【'.$household->state->name.'】，不能修改',404404);
                }
                $code='success';
                $msg='请求成功';
                $sdata=[
                    'item'=>$this->item,
                    'pay'=>$pay,
                ];
                $edata=new Pay();
                $url=null;

                $view='gov.pay.edit';
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
                'repay_way' => 'required|boolean',
                'transit_way' => 'required|boolean',
                'move_way' => 'required|boolean',
            ];
            $messages = [
                'required' => ':attribute 为必须项',
                'boolean' => '请选择 :attribute 的正确选项',
            ];
            $model = new Pay();
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result = ['code' => 'error', 'message' => $validator->errors()->first(), 'sdata' => null, 'edata' => null, 'url' => null];
                return response()->json($result);
            }
            DB::beginTransaction();
            try{
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
                $pay->fill($request->input());
                $pay->save();
                if(blank($pay)){
                    throw new \Exception('保存失败',404404);
                }

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
}