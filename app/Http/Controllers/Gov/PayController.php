<?php
/*
|--------------------------------------------------------------------------
| 项目-兑付补偿
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use App\Http\Model\Assess;
use App\Http\Model\Assets;
use App\Http\Model\Estate;
use App\Http\Model\Estatebuilding;
use App\Http\Model\Household;
use App\Http\Model\Householddetail;
use App\Http\Model\Householdobject;
use App\Http\Model\Pay;
use App\Http\Model\Paybuilding;
use App\Http\Model\Payobject;
use App\Http\Model\Paypublic;
use App\Http\Model\Paysubject;
use App\Http\Model\Payunit;
use App\Http\Model\Publicdetail;
use Illuminate\Http\Request;
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

        $households=Household::with(['itemland'=>function($query){
            $query->select(['id','address']);
        },'itembuilding'=>function($query){
            $query->select(['id','building']);
        },'pay'])
            ->where('item_id',$this->item_id)
            ->select(['id','item_id','land_id','building_id','unit','floor','number','type','state'])
            ->sharedLock()
            ->paginate();

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

    /* ========== 生成兑付 ========== */
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
                    throw new \Exception('该被征收户已存在兑付数据',404404);
                }
                $household=Household::sharedLock()
                    ->select(['id','item_id','land_id','building_id','unit','floor','number','type','state'])
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
                    ->select(['id','item_id','land_id','building_id','unit','floor','number','type','state'])
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$household_id],
                    ]);
                if(blank($household)){
                    throw new \Exception('被征收户不存在',404404);
                }
                $household_detail=Householddetail::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['household_id',$household_id],
                    ])
                    ->select(['item_id','household_id','has_assets','agree','repay_way'])
                    ->first();
                /* ++++++++++ 评估汇总 ++++++++++ */
                $assess=Assess::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['household_id',$household_id],
                        ['state',6],
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
                        ['state',6],
                    ])
                    ->select(['id','item_id','household_id','assess_id','state'])
                    ->first();
                if(blank($assess)){
                    throw new \Exception('暂无有效的房产评估数据',404404);
                }
                $estatebuildings=Estatebuilding::with(['householdbuilding'=>function($query){
                    $query->select(['id','register','state','dispute']);
                }])
                    ->where([
                        ['item_id',$this->item_id],
                        ['household_id',$household_id],
                        ['assess_id',$assess->id],
                        ['estate_id',$estate->id],
                    ])
                    ->sharedLock()
                    ->get();

                if($household_detail->getOriginal('has_assets')){
                    $assets=Assets::sharedLock()
                        ->where([
                            ['item_id',$this->item_id],
                            ['household_id',$household_id],
                            ['assess_id',$assess->id],
                            ['state',6],
                        ])
                        ->select(['id','item_id','household_id','assess_id','state'])
                        ->first();
                    if(blank($assets)){
                        throw new \Exception('暂无有效的资产评估数据',404404);
                    }
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
                $register_total=0;
                $legal_total=0;
                $destroy_total=0;
                foreach($estatebuildings as $building){
                    if(in_array($building->householdbuilding->getOriginal('state'),[1,3])){
                        throw new \Exception('存在合法性争议的房屋',404404);
                    }
                    if(in_array($building->householdbuilding->getOriginal('dispute'),[1,2,4])){
                        throw new \Exception('存在面积争议的房屋',404404);
                    }
                    switch ($building->householdbuilding->getOriginal('state')){
                        case 2:
                            $price=$building->price;
                            $amount=$building->amount;
                            $legal_total +=$amount;
                            break;
                        case 4:
                            $price=$building->householdbuilding->buildingdeal->price;
                            $amount=$building->householdbuilding->buildingdeal->amount;
                            $destroy_total +=$amount;
                            break;
                        case 5:
                            $price=$building->price;
                            $amount=$building->amount;
                            $legal_total +=$amount;
                            break;
                        default:
                            $price=$building->price;
                            $amount=$building->amount;
                            $register_total +=$amount;

                    }
                    $building_data[]=[
                        'item_id'=>$this->item_id,
                        'household_id'=>$household_id,
                        'land_id'=>$household->land_id,
                        'building_id'=>$household->building_id,
                        'assess_id'=>$assess->id,
                        'estate_id'=>$estate->id,
                        'household_building_id'=>$building->household_building_id,
                        'pay_id'=>$pay->id,
                        'register'=>$building->householdbuilding->getOriginal('register'),
                        'state'=>$building->householdbuilding->getOriginal('state'),
                        'real_outer'=>$building->real_outer,
                        'real_use'=>$building->real_use,
                        'struct_id'=>$building->struct_id,
                        'direct'=>$building->direct,
                        'floor'=>$building->floor,
                        'price'=>$price,
                        'amount'=>$amount,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ];
                }
                $field=['item_id','household_id','land_id','building_id','assess_id','estate_id','household_building_id','pay_id','register','state','real_outer','real_use','struct_id','direct','floor','price','amount','created_at','updated_at'];
                $sqls=batch_update_or_insert_sql('pay_building',$field,$building_data,$field);
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
                        'state'=>0,
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
                        'state'=>0,
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
                        'state'=>0,
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
                        'subject_id'=>17,
                        'total_id'=>0,
                        'calculate'=>null,
                        'amount'=>$assess->assets,
                        'state'=>0,
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
                if($pay_public->public_count){
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
                        $sqls=batch_update_or_insert_sql('pay_public',$field,$public_data,$field);
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
                        'state'=>0,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ];
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
                if(filled($household_objects)){
                    $object_data=[];
                    $object_total=0;
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
                    $sqls=batch_update_or_insert_sql('pay_object',$field,$object_data,$field);
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
                            'state'=>0,
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s'),
                        ];
                    }
                }

                /* ++++++++++ 固定补偿科目 ++++++++++ */
                $field=['item_id','household_id','land_id','building_id','pay_id','pact_id','subject_id','total_id','calculate','amount','state','created_at','updated_at'];
                $sqls=batch_update_or_insert_sql('pay_subject',$field,$subject_data,$field);
                if(!$sqls){
                    throw new \Exception('数据错误',404404);
                }
                foreach($sqls as $sql){
                    DB::statement($sql);
                }
                /* ++++++++++ 公产单位补偿 ++++++++++ */
                if($household->getOriginal('type')){
                    $pay_unit=new Payunit();
                    $pay_unit->item_id=$this->item_id;
                    $pay_unit->household_id=$household_id;
                    $pay_unit->land_id=$household->land_id;
                    $pay_unit->unit_id=$household->itemland->admin_unit_id;
                    $pay_unit->pay_id=$pay->id;
                    $pay_unit->pact_id=0;
                    $pay_unit->total_id=0;
                    $pay_unit->calculate=number_format($register_total+$legal_total+$public_total,2).' × 20% = '.number_format(($register_total+$legal_total+$public_total)*0.2,2);
                    $pay_unit->amount=($register_total+$legal_total+$public_total)*0.2;
                    $pay_unit->state=0;
                    $pay_unit->save();
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
            $household=Household::sharedLock()
                ->select(['id','item_id','land_id','building_id','unit','floor','number','type','state'])
                ->find($pay->household_id);
            /* ++++++++++ 补偿科目 ++++++++++ */
            $subjects=Paysubject::with('subject')
                ->sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['pay_id',$pay_id],
                ])
                ->get();
            /* ++++++++++ 公产单位、承租人 ++++++++++ */
            $pay_unit=null;
            $holder=null;
            if($household->getOriginal('type')){
                $pay_unit=Payunit::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['household_id',$household->id],
                        ['pay_id',$pay_id],
                    ])
                    ->first();
                $holder=Household::sharedLock()
                    ->select(['id','item_id','household_id','name','holder'])
                    ->where([
                        ['item_id',$this->item_id],
                        ['household_id',$household->id],
                        ['holder',2],
                    ])
                    ->first();
            }
            /* ++++++++++ 房屋建筑 ++++++++++ */
            $buildings=Paybuilding::with(['realuse'=>function($query){
                $query->select(['id','name']);
            },'buildingstruct'=>function($query){
                $query->select(['id','name']);
            }])
                ->sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['household_id',$household->id],
                    ['pay_id',$pay_id],
                ])
                ->orderBy('register','desc')
                ->orderBy('state','asc')
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