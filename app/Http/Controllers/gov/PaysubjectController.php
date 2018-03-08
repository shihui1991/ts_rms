<?php
/*
|--------------------------------------------------------------------------
| 项目-兑付补偿-补偿科目
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use App\Http\Model\Crowd;
use App\Http\Model\Household;
use App\Http\Model\Householdmembercrowd;
use App\Http\Model\Itemsubject;
use App\Http\Model\Pay;
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
                $household=Household::sharedLock()
                    ->select(['id','item_id','land_id','building_id','unit','floor','number','type','state'])
                    ->find($pay->household_id);

                $item_subject_ids=Itemsubject::sharedLock()->where('item_id',$pay->item_id)->pluck('subject_id');
                $subjects=Subject::sharedLock()
                    ->whereIn('id',$item_subject_ids)
                    ->whereNotIn('id',[1,2,3,4,5,13,17])
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
                    'subjects'=>$subjects,
                ];
                $edata=new Pay();
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
                'amount' => 'required|min:1',
            ];
            $messages = [
                'required' => ':attribute 为必须项',
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
                    ->count();
                if($count){
                    throw new \Exception('当前被征收户已添加该项补偿科目',404404);
                }
                $pay_subject=$model;
                $pay_subject->fill($request->input());
                $pay_subject->item_id=$this->item_id;
                $pay_subject->household_id=$pay->household_id;
                $pay_subject->land_id=$pay->land_id;
                $pay_subject->building_id=$pay->building_id;
                $pay_subject->pay_id=$pay->id;
                $pay_subject->pact_id=0;
                $pay_subject->total_id=0;
                $pay_subject->state=0;
                $pay_subject->save();
                if(blank($pay_subject)){
                    throw new \Exception('保存失败',404404);
                }
                /* ++++++++++ 临时安置费特殊人群优惠补助 ++++++++++ */
                $pay_subject_crowd=null;
                if($pay_subject->subject_id==12){
                    $member_crowd_ids=Householdmembercrowd::sharedLock()
                        ->where([
                            ['item_id',$this->item_id],
                            ['household_id',$pay->household_id],
                        ])
                        ->pluck('crowd_id','id');

                    $item_subject=Itemsubject::sharedLock()
                        ->where([
                            ['item_id',$this->item_id],
                            ['subject_id',13],
                        ])
                        ->first();
                    if(filled($member_crowd_ids) && filled($item_subject)){
                        $crowds=Crowd::with(['itemcrowds'=>function($query){
                            $query->where('item_id',$this->item_id)->orderBy('rate','desc');
                        }])
                            ->where('parent_id',0)
                            ->get();
                        $crowd_data=[];
                        $crowd_total=0;
                        foreach($crowds as $crowd){
                            foreach($crowd->itemcrowds as $itemcrowd){
                                if($member_crowd_id=$member_crowd_ids->search($itemcrowd->crowd_id)){
                                    $crowd_data[]=[
                                        'item_id'=>$this->item_id,
                                        'household_id'=>$pay->household_id,
                                        'land_id'=>$pay->land_id,
                                        'building_id'=>$pay->building_id,
                                        'pay_id'=>$pay->id,
                                        'item_subject_id'=>$item_subject->id,
                                        'subject_id'=>$item_subject->subject_id,
                                        'item_crowd_id'=>$itemcrowd->id,
                                        'member_crowd_id'=>$member_crowd_id,
                                        'crowd_cate_id'=>$itemcrowd->crowd_cate_id,
                                        'crowd_id'=>$itemcrowd->crowd_id,
                                        'transit'=>$pay_subject->amount,
                                        'rate'=>$itemcrowd->rate,
                                        'amount'=>$itemcrowd->rate*$pay_subject->amount,
                                        'created_at'=>date('Y-m-d H:i:s'),
                                        'updated_at'=>date('Y-m-d H:i:s'),
                                    ];
                                    $crowd_total += $itemcrowd->rate*$pay_subject->amount;
                                    break;
                                }
                            }
                        }
                        $field=['item_id','household_id','land_id','building_id','pay_id','item_subject_id','subject_id','item_crowd_id','member_crowd_id','crowd_cate_id','crowd_id','transit','rate','amount','created_at','updated_at'];
                        $sqls=batch_update_or_insert_sql('pay_crowd',$field,$crowd_data,'updated_at');
                        if(!$sqls){
                            throw new \Exception('数据错误',404404);
                        }
                        foreach($sqls as $sql){
                            DB::statement($sql);
                        }
                        $pay_subject_crowd=new Paysubject();
                        $pay_subject_crowd->item_id=$this->item_id;
                        $pay_subject_crowd->household_id=$pay->household_id;
                        $pay_subject_crowd->land_id=$pay->land_id;
                        $pay_subject_crowd->building_id=$pay->building_id;
                        $pay_subject_crowd->pay_id=$pay->id;
                        $pay_subject_crowd->pact_id=0;
                        $pay_subject_crowd->subject_id=$item_subject->subject_id;
                        $pay_subject_crowd->total_id=0;
                        $pay_subject_crowd->calculate=null;
                        $pay_subject_crowd->amount=$crowd_total;
                        $pay_subject_crowd->state=0;
                        $pay_subject_crowd->save();
                        if(blank($pay_subject_crowd)){
                            throw new \Exception('保存失败',404404);
                        }
                    }
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
                    'pay_subject_crowd'=>$pay_subject_crowd,
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