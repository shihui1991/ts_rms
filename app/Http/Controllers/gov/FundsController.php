<?php
/*
|--------------------------------------------------------------------------
| 项目-资金管理
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use App\Http\Model\Adminunit;
use App\Http\Model\Bank;
use App\Http\Model\Funds;
use App\Http\Model\Fundscate;
use App\Http\Model\Fundstotal;
use App\Http\Model\Householdmember;
use App\Http\Model\Itemuser;
use App\Http\Model\Pact;
use App\Http\Model\Pay;
use App\Http\Model\Payhouse;
use App\Http\Model\Payunit;
use App\Http\Model\Payunitpact;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
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

    /* ========== 录入资金 ========== */
    public function add(Request $request){
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=2 || $item->process_id!=18 ||  $item->code!='1'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 检查操作权限 ++++++++++ */
                $count=Itemuser::sharedLock()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$item->schedule_id],
                        ['process_id',$item->process_id],
                        ['user_id',session('gov_user.user_id')],
                    ])
                    ->get();
                if(!$count){
                    throw new \Exception('您没有执行此操作的权限',404404);
                }

                $banks=Bank::sharedLock()->select('id','name')->get();

                $code='success';
                $msg='查询成功';
                $sdata=['item'=>$item,'banks'=>$banks];
                $edata=null;
                $url=null;

                $view='gov.funds.add';
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
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
                'amount'=>'required|numeric|min:0.01',
                'voucher'=>'required',
                'bank_id'=>'required',
                'account'=>'required',
                'name'=>'required',
                'entry_at'=>'required|date_format:Y-m-d H:i:s',
                'infos'=>'required',
                'picture'=>'required',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'date_format'=>':attribute 输入格式错误',
                'numeric'=>':attribute 输入格式错误',
                'min'=>':attribute 不能少于 :min',
            ];
            $model=new Funds();
            $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }

            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=2 || $item->process_id!=18 ||  $item->code!='1'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 检查操作权限 ++++++++++ */
                $count=Itemuser::sharedLock()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$item->schedule_id],
                        ['process_id',$item->process_id],
                        ['user_id',session('gov_user.user_id')],
                    ])
                    ->get();
                if(!$count){
                    throw new \Exception('您没有执行此操作的权限',404404);
                }
                /* ++++++++++ 批量赋值 ++++++++++ */
                $funds=$model;
                $funds->fill($request->input());
                $funds->addOther($request);
                $funds->item_id=$this->item_id;
                $funds->cate_id=1;
                $funds->save();
                if(blank($funds)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=$funds;
                $edata=null;
                $url=route('g_funds',['item'=>$this->item_id]);

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

    /* ========== 转账详情 ========== */
    public function info(Request $request){
        $id=$request->input('id');
        if(!$id){
            $result=['code'=>'error', 'message'=>'错误操作', 'sdata'=>null, 'edata'=>null, 'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else {
                return view('gov.error')->with($result);
            }
        }

        DB::beginTransaction();
        $funds=Funds::with(['fundscate'=>function($query){
            $query->select(['id','name']);
        },'bank'=>function($query){
            $query->select(['id','name']);
        }])
            ->sharedLock()
            ->find($id);

        DB::commit();
        if(filled($funds)){
            $code='success';
            $msg='获取成功';
            $sdata=['item'=>$this->item,'funds'=>$funds];
            $edata=null;
            $url=null;

            $view='gov.funds.info';
        }else{
            $code='error';
            $msg='数据不存在';
            $sdata=null;
            $edata=null;
            $url=null;

            $view='gov.error';
        }
        $result=['code'=>$code, 'message'=>$msg, 'sdata'=>$sdata, 'edata'=>$edata, 'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view($view)->with($result);
        }
    }

    /* ========== 被征收户 ========== */
    public function household(Request $request){
        DB::beginTransaction();
        try{
            $total=Pay::sharedLock()
                ->where('item_id',$this->item_id)
                ->count();

            $per_page=15;
            $page=$request->input('page',1);
            $pay_households=Pay::with(['itemland'=>function($query){
                $query->select(['id','address']);
            },'itembuilding'=>function($query){
                $query->select(['id','building']);
            },'household'=>function($query){
                $query->with('state')->select(['id','unit','floor','number','type','code']);
            }])
                ->where('item_id',$this->item_id)
                ->select(['id','item_id','land_id','building_id','household_id','total'])
                ->sharedLock()
                ->offset($per_page*($page-1))
                ->limit($per_page)
                ->get();

            $households=new LengthAwarePaginator($pay_households,$total,$per_page,$page);
            $households->withPath(route('g_funds_household',['item'=>$this->item_id]));

            $code='success';
            $msg='获取成功';
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络错误';
        }
        $sdata=[
            'item'=>$this->item,
            'households'=>$households,
        ];
        $edata=null;
        $url=null;
        DB::commit();
        $result=['code'=>$code, 'message'=>$msg, 'sdata'=>$sdata, 'edata'=>$edata, 'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.funds.household')->with($result);
        }
    }

    /* ========== 被征收户 - 补偿详情 ========== */
    public function household_info(Request $request){
        $pay_id=$request->input('pay_id');
        DB::beginTransaction();
        try{
            if(!$pay_id){
                throw new \Exception('错误操作',404404);
            }
            /* ++++++++++ 兑付 ++++++++++ */
            $pay_household=Pay::with(['itemland'=>function($query){
                $query->with('adminunit')->select(['id','address','admin_unit_id']);
            },'itembuilding'=>function($query){
                $query->select(['id','building']);
            },'household'=>function($query){
                $query->with('state')->select(['id','unit','floor','number','type','code']);
            }])
                ->where([
                    ['item_id',$this->item_id],
                    ['id',$pay_id],
                ])
                ->sharedLock()
                ->first();
            if(!$pay_household){
                throw new \Exception('数据不存在',404404);
            }
            /* ++++++++++ 协议 ++++++++++ */
            $pacts=Pact::with(['pactcate','state','paysubjects'=>function($query){
                $query->with('subject','state');
            }])
                ->sharedLock()
                ->where([
                    ['household_id',$pay_household->household_id],
                    ['pay_id',$pay_id],
                ])
                ->get();
            /* ++++++++++ 兑付单 ++++++++++ */
            $funds_totals=Fundstotal::with(['fundscate','state','funds'=>function($query){
                $query->with('bank');
            }])
                ->sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['type',0],
                    ['val_id',$pay_household->household_id],
                ])
                ->get();
            /* ++++++++++ 公房单位、承租人、产权人 ++++++++++ */
            $pay_unit=null;
            if($pay_household->household->getOriginal('type')){
                $pay_unit=Payunit::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['household_id',$pay_household->household_id],
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
                    ['household_id',$pay_household->household_id],
                    ['holder',$holder_type],
                ])
                ->orderBy('portion','desc')
                ->first();
            /* ++++++++++ 产权调换房 ++++++++++ */
            $pay_house_total=Payhouse::sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['household_id',$pay_household->household_id],
                ])
                ->sum('total');
            $code='success';
            $msg='获取成功';
            $sdata=[
                'item'=>$this->item,
                'pay_household'=>$pay_household,
                'pacts'=>$pacts,
                'funds_totals'=>$funds_totals,
                'pay_unit'=>$pay_unit,
                'holder'=>$holder,
                'pay_house_total'=>$pay_house_total,
            ];
            $edata=null;
            $url=null;

            $view='gov.funds.household_info';
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

    /* ========== 被征收户 - 兑付总单 ========== */
    public function pay_total(Request $request){
        $pact_id=$request->input('pact_id');
        DB::beginTransaction();
        try{
            if(!$pact_id){
                throw new \Exception('错误操作',404404);
            }
            /* ++++++++++ 协议 ++++++++++ */
            $pact=Pact::with(['household'=>function($query){
                $query->select(['id','type','code']);
            },'pay','paysubjects'])
                ->lockForUpdate()
                ->where([
                    ['item_id',$this->item_id],
                    ['id',$pact_id]
                ])
                ->first();
            if(!$pact){
                throw new \Exception('数据不存在',404404);
            }
            if($pact->getOriginal('status') !=1){
                throw new \Exception('当前协议没有生效',404404);
            }
            if($pact->code != '111'){
                throw new \Exception('当前协议正在处理中，请勿重复操作',404404);
            }
            /* ++++++++++ 协议兑付科目金额 ++++++++++ */
            $pact_total=$pact->paysubjects->sum('amount');
            /* ++++++++++ 协议类型 ++++++++++ */
            switch ($pact->cate_id){
                // 补偿协议
                case 1:
                    $funds_cate=3; // 默认为货币补偿款
                    /* ++++++++++ 公房 ++++++++++ */
                    if($pact->household->getOriginal('type')==1){
                        /* ++++++++++ 公房单位 ++++++++++ */
                        $pay_unit=Payunit::sharedLock()
                            ->where([
                                ['item_id',$this->item_id],
                                ['household_id',$pact->household_id],
                                ['pay_id',$pact->pay_id],
                            ])
                            ->first();
                        $pact_total -= $pay_unit->amount;
                    }
                    /* ++++++++++ 产权调换 ++++++++++ */
                    if($pact->pay->getOriginal('repay_way')==1){
                        /* ++++++++++ 产权调换房价 ++++++++++ */
                        $pay_house_total=Payhouse::sharedLock()
                            ->where([
                                ['item_id',$this->item_id],
                                ['household_id',$pact->household_id],
                            ])
                            ->sum('total');
                        $pact_total -= $pay_house_total;
                        if($pact_total<0){
                            $funds_cate=2; // 补偿款与产权调换房价之差额
                        }else{
                            $funds_cate=4; // 产权调换结余补偿款
                        }
                    }
                    break;
                // 补偿补充协议
                case 2:
                    $funds_cate=5; // 补充协议补偿金
                    break;
            }
            /* ++++++++++ 生成总单 ++++++++++ */
            $funds_total=new Fundstotal();
            $funds_total->item_id=$this->item_id;
            $funds_total->type=0;
            $funds_total->val_id=$pact->household_id;
            $funds_total->cate_id=$funds_cate;
            $funds_total->amount= - $pact_total;
            $funds_total->code='112';
            $funds_total->save();
            if(blank($funds_total)){
                throw new \Exception('操作失败',404404);
            }
            /* ++++++++++ 更新协议状态 ++++++++++ */
            $pact->code='112';
            $pact->save();
            /* ++++++++++ 更新补偿科目 ++++++++++ */
            $values=[];
            foreach($pact->paysubjects as $subject){
                $values[]=[
                    'id'=>$subject->id,
                    'total_id'=>$funds_total->id,
                    'code'=>'112',
                    'updated_at'=>date('Y-m-d H:i:s'),
                ];
            }
            $field=['id','total_id','code','updated_at'];
            $sqls=batch_update_or_insert_sql('pay_subject',$field,$values,$field);
            if(!$sqls){
                throw new \Exception('操作失败',404404);
            }
            foreach ($sqls as $sql){
                DB::statement($sql);
            }

            $code='success';
            $msg='获取成功';
            $sdata=[
                'item'=>$this->item,
                'pact'=>$pact,
                'funds_total'=>$funds_total,
            ];
            $edata=null;
            $url=route('g_funds_pay_total_funds',['item'=>$this->item_id,'total_id'=>$funds_total->id]);

            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络错误';
            $sdata=null;
            $edata=null;
            $url=null;

            DB::rollBack();
        }

        $result=['code'=>$code, 'message'=>$msg, 'sdata'=>$sdata, 'edata'=>$edata, 'url'=>$url];
        return response()->json($result);
    }

    /* ========== 兑付总单 - 支付 ========== */
    public function pay_total_funds(Request $request){
        $total_id=$request->input('total_id');
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                if(!$total_id){
                    throw new \Exception('错误操作',404404);
                }
                $funds_total=Fundstotal::with(['fundscate','state','funds'])
                    ->sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$total_id],
                    ])
                    ->first();
                if(blank($funds_total)){
                    throw new \Exception('数据不存在',404404);
                }
                $funds_amount=$funds_total->funds->sum('amount');
                if(abs($funds_amount)==abs($funds_total->amount)){
                    throw new \Exception('已支付完成，请勿重复操作',404404);
                }
                $banks=Bank::sharedLock()->select('id','name')->get();

                $code='success';
                $msg='获取成功';
                $sdata=[
                    'item'=>$this->item,
                    'funds_total'=>$funds_total,
                    'funds_amount'=>$funds_amount,
                    'banks'=>$banks,
                ];
                $edata=null;
                $url=null;

                $view='gov.funds.total';
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
        /* ++++++++++ 支付 ++++++++++ */
        else{
            DB::beginTransaction();
            try{
                if(!$total_id){
                    throw new \Exception('错误操作',404404);
                }
                $funds_total=Fundstotal::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$total_id],
                    ])
                    ->first();
                if(blank($funds_total)){
                    throw new \Exception('数据不存在',404404);
                }
                $funds_amount=Funds::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['total_id',$total_id],
                    ])
                    ->sum('amount');
                $last=abs($funds_total->amount)-abs($funds_amount);
                if($last==0){
                    throw new \Exception('已支付完成，请勿重复操作',404404);
                }
                /* ++++++++++ 表单验证 ++++++++++ */
                $rules=[
                    'amount'=>'required|numeric|between:0.01,'.$last,
                    'voucher'=>'required',
                    'bank_id'=>'required',
                    'account'=>'required',
                    'name'=>'required',
                    'entry_at'=>'required|date_format:Y-m-d H:i:s',
                    'infos'=>'required',
                    'picture'=>'required',
                ];
                $messages=[
                    'required'=>':attribute 为必须项',
                    'numeric'=>':attribute 格式错误',
                    'date_format'=>':attribute 输入格式错误',
                    'between'=>':attribute 必须在 :min 和 :max 之间',
                ];
                $model=new Funds();
                $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
                if($validator->fails()){
                    throw new \Exception($validator->errors()->first(),404404);
                }

                /* ++++++++++ 批量赋值 ++++++++++ */
                $funds=$model;
                $funds->fill($request->input());
                $funds->addOther($request);
                $funds->item_id=$this->item_id;
                $funds->cate_id=$funds_total->cate_id;
                $funds->total_id=$funds_total->id;
                if($funds_total<0){
                    $funds->amount = 0-$funds->amount;
                }
                $funds->save();
                if(blank($funds)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=$funds;
                $edata=null;
                $url=route('g_funds',['item'=>$this->item_id]);

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

    /* ========== 公房单位 ========== */
    public function unit(Request $request){
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
            return view('gov.funds.unit')->with($result);
        }
    }

    /* ========== 公房单位 - 补偿详情 ========== */
    public function unit_info(Request $request){
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
            /* ++++++++++ 公房单位 - 补偿详情 ++++++++++ */
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
            $per_page=15;
            $page=$request->input('page',1);
            $pay_units=Payunit::with(['household'=>function($query){
                $query->with(['itemland'=>function($query){
                    $query->select(['id','address']);
                },'itembuilding'=>function($query){
                    $query->select(['id','building']);
                },'state'])
                    ->select(['id','land_id','building_id','unit','floor','number','type','code']);
            },'state'])
                ->sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['unit_id',$unit_id]
                ])
                ->offset($per_page*($page-1))
                ->limit($per_page)
                ->get();
            $pay_units=new LengthAwarePaginator($pay_units,$total->count,$per_page,$page);
            $pay_units->withPath(route('g_funds_unit_info',['item'=>$this->item_id,'unit_id'=>$unit_id]));
            /* ++++++++++ 公房单位 - 补偿协议 ++++++++++ */
            $unit_pacts=Payunitpact::with(['pactcate','state','payunits'=>function($query){
                $query->with(['household'=>function($query){
                    $query->with(['itemland'=>function($query){
                        $query->select(['id','address']);
                    },'itembuilding'=>function($query){
                        $query->select(['id','building']);
                    },'state'])
                        ->select(['id','land_id','building_id','unit','floor','number','type','code']);
                },'state']);
            }])
                ->sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['unit_id',$unit_id],
                ])
                ->get();
            /* ++++++++++ 公房单位 - 兑付单 ++++++++++ */
            $funds_totals=Fundstotal::with(['fundscate','state','funds'=>function($query){
                $query->with('bank');
            }])
                ->sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['type',1],
                    ['val_id',$unit_id],
                ])
                ->get();

            $code='success';
            $msg='获取成功';
            $sdata=[
                'item'=>$this->item,
                'total'=>$total,
                'pay_units'=>$pay_units,
            ];
            $edata=null;
            $url=null;

            $view='gov.funds.unit_info';
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

    /* ========== 项目支出 ========== */
    public function out(Request $request){

    }
}