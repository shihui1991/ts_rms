<?php
/*
|--------------------------------------------------------------------------
| 项目-临时周转
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use App\Http\Model\Household;
use App\Http\Model\Housetransit;
use App\Http\Model\Pay;
use App\Http\Model\Paytransit;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransitController extends BaseitemController
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
            /* ++++++++++ 选择临时周转的被征收户 ++++++++++ */
            $household_ids=Pay::sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['repay_way',1],
                    ['transit_way',1],
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
            $households->withPath(route('g_transit',['item'=>$this->item_id]));

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
            return view('gov.transit.index')->with($result);
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
            /* ++++++++++ 协议临时周转房 ++++++++++ */
            $pay_transits=Paytransit::with(['pact'=>function($query){
                $query->with(['pactcate','state'])->select(['id','cate_id','code','status']);
            },'house'=>function($query){
                $query->with(['housecompany'=>function($query){
                    $query->select(['id','name']);
                },'housecommunity'=>function($query){
                    $query->select(['id','name','address']);
                },'layout'=>function($query){
                    $query->select(['id','name']);
                },'state'])
                    ->select(['id','company_id','community_id','layout_id','building','unit','floor','number','area','lift','code']);
            },'housetransit'=>function($query) use ($id){
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
                    ['pact_id','<>',0],
                ])
                ->get();
            /* ++++++++++ 临时周转记录 ++++++++++ */
            $house_transits=Housetransit::with(['house'=>function($query){
                $query->with(['housecompany'=>function($query){
                    $query->select(['id','name']);
                },'housecommunity'=>function($query){
                    $query->select(['id','name','address']);
                },'layout'=>function($query){
                    $query->select(['id','name']);
                },'state'])
                    ->select(['id','company_id','community_id','layout_id','building','unit','floor','number','area','lift','code']);
            }])
                ->sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['household_id',$id],
                ])
                ->orderBy('start_at','asc')
                ->get();

            $code='success';
            $msg='获取成功';
            $sdata=[
                'item'=>$this->item,
                'household'=>$household,
                'pay_transits'=>$pay_transits,
                'house_transits'=>$house_transits,
            ];
            $edata=null;
            $url=null;

            $view='gov.transit.info';
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

    /* ========== 开始过渡 ========== */
    public function add(Request $request){
        $id=$request->input('id');
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                if(!$id){
                    throw new \Exception('错误操作',404404);
                }
                $pay_transit=Paytransit::with(['pact'=>function($query){
                    $query->select(['id','cate_id','code','status']);
                },'house'=>function($query){
                    $query->with(['housecompany'=>function($query){
                        $query->select(['id','name']);
                    },'housecommunity'=>function($query){
                        $query->select(['id','name','address']);
                    },'layout'=>function($query){
                        $query->select(['id','name']);
                    },'state'])
                        ->select(['id','company_id','community_id','layout_id','building','unit','floor','number','area','lift','code']);
                },'housetransit'=>function($query) use ($id){
                    $query->where([
                        ['item_id',$this->item_id],
                        ['household_id',$id],
                    ])
                        ->select(['id','item_id','household_id','house_id']);
                }])
                    ->sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$id],
                        ['pact_id','<>',0],
                    ])
                    ->first();
                if(filled($pay_transit)){
                    throw new \Exception('数据不存在',404404);
                }
                if($pay_transit->pact->getOriginal('status') != 1){
                    throw new \Exception('协议没有生效，不能操作',404404);
                }
                if(filled($pay_transit->housetransit)){
                    throw new \Exception('已做处理，请勿重复操作',404404);
                }

                $code='success';
                $msg='获取成功';
                $sdata=[
                    'item'=>$this->item,
                    'pay_transit'=>$pay_transit,
                ];
                $edata=null;
                $url=null;

                $view='gov.transit.add';
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
                'start_at' => 'required|date_format:Y-m-d',
                'exp_end' => 'required|date_format:Y-m-d|after:start_at',
            ];
            $messages = [
                'required' => ':attribute 为必须项',
                'date_format' => ':attribute 格式错误',
                'after' => ':attribute 必须在 :date 之后',
            ];
            $model=new Housetransit();
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
                $pay_transit=Paytransit::with(['pact'=>function($query){
                    $query->select(['id','cate_id','code','status']);
                },'housetransit'=>function($query) use ($id){
                    $query->where([
                        ['item_id',$this->item_id],
                        ['household_id',$id],
                    ])
                        ->select(['id','item_id','household_id','house_id']);
                }])
                    ->sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$id],
                        ['pact_id','<>',0],
                    ])
                    ->first();
                if(filled($pay_transit)){
                    throw new \Exception('数据不存在',404404);
                }
                if($pay_transit->pact->getOriginal('status') != 1){
                    throw new \Exception('协议没有生效，不能操作',404404);
                }
                if(filled($pay_transit->housetransit)){
                    throw new \Exception('已做处理，请勿重复操作',404404);
                }
                /* ++++++++++ 赋值 ++++++++++ */
                $house_transit=$model;
                $house_transit->fill($request->input());
                $house_transit->item_id=$this->item_id;
                $house_transit->household_id=$pay_transit->household_id;
                $house_transit->land_id=$pay_transit->land_id;
                $house_transit->building_id=$pay_transit->building_id;
                $house_transit->pay_id=$pay_transit->pay_id;
                $house_transit->pact_id=$pay_transit->pact_id;
                $house_transit->house_id=$pay_transit->house_id;
                $house_transit->save();
                if(blank($house_transit)){
                    throw new \Exception('操作失败',404404);
                }

                $code='success';
                $msg='操作成功';
                $sdata=[
                    'item'=>$this->item,
                    'pay_transit'=>$pay_transit,
                    'house_transit'=>$house_transit,
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

    /* ========== 结束过渡 ========== */
    public function edit(Request $request){
        $id=$request->input('id');
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                if(!$id){
                    throw new \Exception('错误操作',404404);
                }
                $house_transit=Housetransit::with(['house'=>function($query){
                    $query->with(['housecompany'=>function($query){
                        $query->select(['id','name']);
                    },'housecommunity'=>function($query){
                        $query->select(['id','name','address']);
                    },'layout'=>function($query){
                        $query->select(['id','name']);
                    },'state'])
                        ->select(['id','company_id','community_id','layout_id','building','unit','floor','number','area','lift','code']);
                }])
                    ->sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$id],
                    ])
                    ->first();
                if(filled($house_transit)){
                    throw new \Exception('数据不存在',404404);
                }

                $code='success';
                $msg='获取成功';
                $sdata=[
                    'item'=>$this->item,
                    'house_transit'=>$house_transit,
                ];
                $edata=null;
                $url=null;

                $view='gov.transit.edit';
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
                'start_at' => 'required|date_format:Y-m-d',
                'exp_end' => 'required|date_format:Y-m-d|after:start_at',
                'end_at' => 'required|date_format:Y-m-d|after:start_at',
            ];
            $messages = [
                'required' => ':attribute 为必须项',
                'date_format' => ':attribute 格式错误',
                'after' => ':attribute 必须在 :date 之后',
            ];
            $model=new Housetransit();
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
                $house_transit=Housetransit::lockForUpdate()
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$id],
                    ])
                    ->first();
                if(filled($house_transit)){
                    throw new \Exception('数据不存在',404404);
                }

                /* ++++++++++ 赋值 ++++++++++ */
                $house_transit->fill($request->input());
                $house_transit->save();
                if(blank($house_transit)){
                    throw new \Exception('操作失败',404404);
                }

                $code='success';
                $msg='操作成功';
                $sdata=[
                    'item'=>$this->item,
                    'house_transit'=>$house_transit,
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
}