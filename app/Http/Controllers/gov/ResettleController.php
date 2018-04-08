<?php
/*
|--------------------------------------------------------------------------
| 项目-产权调换
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use App\Http\Model\Household;
use App\Http\Model\Householdmember;
use App\Http\Model\Houseresettle;
use App\Http\Model\Houseresettlenotice;
use App\Http\Model\Pay;
use App\Http\Model\Payhouse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ResettleController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        $households=null;
        DB::beginTransaction();
        try{
            /* ++++++++++ 选择产权调换的被征收户 ++++++++++ */
            $household_ids=Pay::sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['repay_way',1],
                ])
                ->pluck('household_id');
            $total=$household_ids->count();
            if(!$total){
                throw new \Exception('暂无数据',404404);
            }

            $per_page=15;
            $page=$request->input('page',1);
            $households=Household::with(['itemland'=>function($query){
                $query->select(['id','address']);
            },'itembuilding'=>function($query){
                $query->select(['id','building']);
            },'state'=>function($query){
                $query->select(['code','name']);
            }])
                ->where('item_id',$this->item_id)
                ->whereIn('id',$household_ids)
                ->select(['id','item_id','land_id','building_id','unit','floor','number','type','code'])
                ->sharedLock()
                ->offset($per_page*($page-1))
                ->limit($per_page)
                ->orderBy('code','asc')
                ->get();

            $households=new LengthAwarePaginator($households,$total,$per_page,$page);
            $households->withPath(route('g_resettle',['item'=>$this->item_id]));

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
            return view('gov.resettle.index')->with($result);
        }
    }
    
    /* ========== 详情 ========== */
    public function info(Request $request){
        $id=$request->input('id');
        DB::beginTransaction();
        try{
            if(!$id){
                throw new \Exception('错误操作',404404);
            }
            /* ++++++++++ 被征收户 ++++++++++ */
            $household=Household::with(['itemland'=>function($query){
                $query->select(['id','address']);
            },'itembuilding'=>function($query){
                $query->select(['id','building']);
            },'state'=>function($query){
                $query->select(['code','name']);
            },'pay'=>function($query){
                $query->select(['id','item_id','household_id','repay_way','transit_way','move_way']);
            }])
                ->sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['id',$id],
                ])
                ->select(['id','item_id','land_id','building_id','unit','floor','number','type','code'])
                ->first();
            if(blank($household)){
                throw new \Exception('被征收户不存在',404404);
            }
            /* ++++++++++ 协议产权调换房 ++++++++++ */
            $pay_houses=Payhouse::with(['house'=>function($query){
                $query->with(['housecompany'=>function($query){
                    $query->select(['id','name']);
                },'housecommunity'=>function($query){
                    $query->select(['id','name','address']);
                },'layout'=>function($query){
                    $query->select(['id','name']);
                },'state'])
                    ->select(['id','company_id','community_id','layout_id','building','unit','floor','number','lift','is_real','code']);
            },'houseresettle'=>function($query) use ($id){
                $query->where([
                    ['item_id',$this->item_id],
                    ['household_id',$id],
                ])
                    ->select(['id','item_id','household_id','house_id']);
            }])
                ->sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['household_id',$id],
                ])
                ->get();
            /* ++++++++++ 产权调换记录 ++++++++++ */
            $house_resettles=Houseresettle::with(['house'=>function($query){
                $query->with(['housecompany'=>function($query){
                    $query->select(['id','name']);
                },'housecommunity'=>function($query){
                    $query->select(['id','name','address']);
                },'layout'=>function($query){
                    $query->select(['id','name']);
                },'state'])
                    ->select(['id','company_id','community_id','layout_id','building','unit','floor','number','area','lift','is_real','code']);
            },'notice'=>function($query) use ($id){
                $query->where([
                    ['item_id',$this->item_id],
                    ['household_id',$id],
                ])
                    ->select(['id','item_id','household_id','house_id'])
                    ->orderBy('serial','desc');
            }])
                ->sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['household_id',$id],
                ])
                ->orderBy('settle_at','asc')
                ->get();

            $code='success';
            $msg='获取成功';
            $sdata=[
                'item'=>$this->item,
                'household'=>$household,
                'pay_houses'=>$pay_houses,
                'house_resettles'=>$house_resettles,
            ];
            $edata=null;
            $url=null;

            $view='gov.resettle.info';
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

    /* ========== 开始安置 ========== */
    public function add(Request $request){
        $id=$request->input('id');
        $household_id=$request->input('household_id');
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                if(!$id || !$household_id){
                    throw new \Exception('错误操作',404404);
                }
                $pay_house=Payhouse::with(['house'=>function($query){
                    $query->with(['housecompany'=>function($query){
                        $query->select(['id','name']);
                    },'housecommunity'=>function($query){
                        $query->select(['id','name','address']);
                    },'layout'=>function($query){
                        $query->select(['id','name']);
                    },'state'])
                        ->select(['id','company_id','community_id','layout_id','building','unit','floor','number','area','lift','is_real','code']);
                },'houseresettle'=>function($query) use ($household_id){
                    $query->where([
                        ['item_id',$this->item_id],
                        ['household_id',$household_id],
                    ])
                        ->select(['id','item_id','household_id','house_id']);
                }])
                    ->sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$id],
                    ])
                    ->first();
                if(blank($pay_house)){
                    throw new \Exception('数据不存在',404404);
                }
                if($pay_house->houseresettle->id){
                    throw new \Exception('已做处理，请勿重复操作',404404);
                }

                $code='success';
                $msg='获取成功';
                $sdata=[
                    'item'=>$this->item,
                    'pay_house'=>$pay_house,
                ];
                $edata=null;
                $url=null;

                $view='gov.resettle.add';
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
        /* ++++++++++ 保存 ++++++++++ */
        else{
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'settle_at' => 'required|date_format:Y-m-d',
                'hold_at' => 'nullable|date_format:Y-m-d|after:settle_at',
            ];
            $messages = [
                'required' => ':attribute 为必须项',
                'date_format' => ':attribute 格式错误',
                'after' => ':attribute 必须在 :date 之后',
            ];
            $model=new Houseresettle();
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result = ['code' => 'error', 'message' => $validator->errors()->first(), 'sdata' => null, 'edata' => null, 'url' => null];
                return response()->json($result);
            }
            DB::beginTransaction();
            try{
                if(!$id || !$household_id){
                    throw new \Exception('错误操作',404404);
                }
                $pay_house=Payhouse::with(['houseresettle'=>function($query) use ($household_id){
                    $query->where([
                        ['item_id',$this->item_id],
                        ['household_id',$household_id],
                    ])
                        ->select(['id','item_id','household_id','house_id']);
                }])
                    ->sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$id],
                    ])
                    ->first();
                if(blank($pay_house)){
                    throw new \Exception('数据不存在',404404);
                }
                if($pay_house->houseresettle->id){
                    throw new \Exception('已做处理，请勿重复操作',404404);
                }
                /* ++++++++++ 赋值 ++++++++++ */
                $house_resettle=$model;
                $house_resettle->fill($request->input());
                $house_resettle->item_id=$this->item_id;
                $house_resettle->household_id=$pay_house->household_id;
                $house_resettle->land_id=$pay_house->land_id;
                $house_resettle->building_id=$pay_house->building_id;
                $house_resettle->pay_id=$pay_house->pay_id;
                $house_resettle->house_id=$pay_house->house_id;
                $house_resettle->save();
                if(blank($house_resettle)){
                    throw new \Exception('操作失败',404404);
                }

                $code='success';
                $msg='操作成功';
                $sdata=[
                    'item'=>$this->item,
                    'pay_house'=>$pay_house,
                    'house_resettle'=>$house_resettle,
                ];
                $edata=null;
                $url=null;

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'操作失败';
                $sdata=null;
                $edata=null;
                $url=null;

                DB::rollBack();
            }

            $result=['code'=>$code, 'message'=>$msg, 'sdata'=>$sdata, 'edata'=>$edata, 'url'=>$url];
            return response()->json($result);
        }
    }

    /* ========== 更新 ========== */
    public function edit(Request $request){
        $id=$request->input('id');
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                if(!$id){
                    throw new \Exception('错误操作',404404);
                }
                $house_resettle=Houseresettle::with(['house'=>function($query){
                    $query->with(['housecompany'=>function($query){
                        $query->select(['id','name']);
                    },'housecommunity'=>function($query){
                        $query->select(['id','name','address']);
                    },'layout'=>function($query){
                        $query->select(['id','name']);
                    },'state'])
                        ->select(['id','company_id','community_id','layout_id','building','unit','floor','number','area','lift','is_real','code']);
                }])
                    ->sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$id],
                    ])
                    ->first();
                if(blank($house_resettle)){
                    throw new \Exception('数据不存在',404404);
                }

                $code='success';
                $msg='获取成功';
                $sdata=[
                    'item'=>$this->item,
                    'house_resettle'=>$house_resettle,
                ];
                $edata=null;
                $url=null;

                $view='gov.resettle.edit';
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
        /* ++++++++++ 保存 ++++++++++ */
        else{
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'settle_at' => 'required|date_format:Y-m-d',
                'hold_at' => 'nullable|date_format:Y-m-d|after:settle_at',
                'end_at' => 'nullable|date_format:Y-m-d|after:settle_at',
            ];
            $messages = [
                'required' => ':attribute 为必须项',
                'date_format' => ':attribute 格式错误',
                'after' => ':attribute 必须在 :date 之后',
            ];
            $model=new Houseresettle();
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
                $house_resettle=Houseresettle::lockForUpdate()
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$id],
                    ])
                    ->first();
                if(blank($house_resettle)){
                    throw new \Exception('数据不存在',404404);
                }

                /* ++++++++++ 赋值 ++++++++++ */
                $house_resettle->fill($request->input());
                $house_resettle->save();
                if(blank($house_resettle)){
                    throw new \Exception('操作失败',404404);
                }

                $code='success';
                $msg='操作成功';
                $sdata=[
                    'item'=>$this->item,
                    'house_resettle'=>$house_resettle,
                ];
                $edata=null;
                $url=null;

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'操作失败';
                $sdata=null;
                $edata=null;
                $url=null;

                DB::rollBack();
            }

            $result=['code'=>$code, 'message'=>$msg, 'sdata'=>$sdata, 'edata'=>$edata, 'url'=>$url];
            return response()->json($result);
        }
    }

    /* ========== 添加入住通知 ========== */
    public function notice_add(Request $request){
        $house_resettle_id=$request->input('house_resettle');
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                if(!$house_resettle_id){
                    throw new \Exception('错误操作',404404);
                }
                $house_resettle=Houseresettle::with(['house'=>function($query){
                    $query->with(['housecompany'=>function($query){
                        $query->select(['id','name']);
                    },'housecommunity'=>function($query){
                        $query->select(['id','name','address']);
                    },'layout'=>function($query){
                        $query->select(['id','name']);
                    },'state'])
                        ->select(['id','company_id','community_id','layout_id','building','unit','floor','number','area','lift','is_real','code']);
                }])
                    ->sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$house_resettle_id],
                    ])
                    ->first();
                if(blank($house_resettle)){
                    throw new \Exception('数据不存在',404404);
                }

                $code='success';
                $msg='获取成功';
                $sdata=[
                    'item'=>$this->item,
                    'house_resettle'=>$house_resettle,
                ];
                $edata=null;
                $url=null;

                $view='gov.resettle.notice_add';
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
        /* ++++++++++ 保存 ++++++++++ */
        else{
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'act_at' => 'required|date_format:Y-m-d',
                'serial'=>['required','min:1',Rule::unique('house_resettle_notice')->where(function($query){
                    $query->where('item_id',$this->item_id);
                })]
            ];
            $messages = [
                'required' => ':attribute 为必须项',
                'min' => ':attribute 必须为正数',
                'unique' => ':attribute 已存在',
            ];
            $names=[
                'act_at'=>'办理日期',
                'serial'=>'序号',
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $names);
            if ($validator->fails()) {
                $result = ['code' => 'error', 'message' => $validator->errors()->first(), 'sdata' => null, 'edata' => null, 'url' => null];
                return response()->json($result);
            }
            DB::beginTransaction();
            try{
                if(!$house_resettle_id){
                    throw new \Exception('错误操作',404404);
                }
                $house_resettle=Houseresettle::with(['house'=>function($query){
                    $query->with(['housecompany'=>function($query){
                        $query->select(['id','name']);
                    },'housecommunity'=>function($query){
                        $query->select(['id','name','address']);
                    }])
                        ->select(['id','company_id','community_id','layout_id','building','unit','floor','number','area','lift','is_real','code']);
                }])
                    ->sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$house_resettle_id],
                    ])
                    ->first();
                if(blank($house_resettle)){
                    throw new \Exception('数据不存在',404404);
                }
                $member=Householdmember::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['household_id',$house_resettle->household_id],
                    ])
                    ->orderBy('holder','desc')
                    ->orderBy('portion','desc')
                    ->first();

                $resettle_notice=new Houseresettlenotice();
                $resettle_notice->item_id=$house_resettle->item_id;
                $resettle_notice->household_id=$house_resettle->household_id;
                $resettle_notice->member_id=0;
                $resettle_notice->land_id=$house_resettle->land_id;
                $resettle_notice->building_id=$house_resettle->building_id;
                $resettle_notice->pay_id=$house_resettle->pay_id;
                $resettle_notice->pact_id=0;
                $resettle_notice->company_id=$house_resettle->house->company_id;
                $resettle_notice->community_id=$house_resettle->house->community_id;
                $resettle_notice->house_id=$house_resettle->house_id;
                $resettle_notice->serial=$request->serial;
                $resettle_notice->content=response(view('gov.resettle.notice_cont')->with([
                    'item'=>$this->item,
                    'house_resettle'=>$house_resettle,
                    'member'=>$member,
                    'act_at'=>$request->act_at,
                    'serial'=>$request->serial,
                ]))->getContent();

                $resettle_notice->save();

                $code='success';
                $msg='操作成功';
                $sdata=[
                    'item'=>$this->item,
                    'resettle_notice'=>$resettle_notice,
                ];
                $edata=null;
                $url=route('g_resettle_info',['item'=>$this->item_id,'id'=>$house_resettle->household_id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'操作失败';
                $sdata=null;
                $edata=null;
                $url=null;

                DB::rollBack();
            }

            $result=['code'=>$code, 'message'=>$msg, 'sdata'=>$sdata, 'edata'=>$edata, 'url'=>$url];
            return response()->json($result);
        }
    }

    /* ========== 入住通知详情 ========== */
    public function notice_info(Request $request){
        $notice_id=$request->input('notice_id');
        DB::beginTransaction();
        try{
            if(!$notice_id){
                throw new \Exception('错误操作',404404);
            }
            $notice=Houseresettlenotice::sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['id',$notice_id],
                ])
                ->first();
            if(blank($notice)){
                throw new \Exception('数据不存在',404404);
            }
            $code='success';
            $msg='请求成功';
            $sdata=[
                'item'=>$this->item,
                'notice'=>$notice,
            ];
            $edata=null;
            $url=null;

            $view='gov.resettle.notice_info';
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
}