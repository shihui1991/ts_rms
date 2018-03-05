<?php
/*
|--------------------------------------------------------------------------
| 项目-兑付补偿
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use App\Http\Model\Assess;
use App\Http\Model\Estatebuilding;
use App\Http\Model\Household;
use App\Http\Model\Householddetail;
use App\Http\Model\Pay;
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
            ->get();

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
                    ->find($household_id);
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
                    ->find($household_id);
                if(blank($household)){
                    throw new \Exception('被征收户不存在',404404);
                }
                $household_detail=Householddetail::query()->sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['household_id',$household_id],
                    ])
                    ->select(['item_id','household_id','has_assets','agree','repay_way'])
                    ->first();

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
}