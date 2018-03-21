<?php
/*
|--------------------------------------------------------------------------
| 项目-征收方案
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;
use App\Http\Model\Itemcrowd;
use App\Http\Model\Itemhouserate;
use App\Http\Model\Itemobject;
use App\Http\Model\Itemprogram;
use App\Http\Model\Itemreward;
use App\Http\Model\Itemsubject;
use App\Http\Model\Itemuser;
use Illuminate\Http\Request;
use App\Http\Model\Statecode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ItemprogramController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        DB::beginTransaction();
        try{
            $program=Itemprogram::sharedLock()
                ->where('item_id',$this->item_id)
                ->first();
            $subjects=Itemsubject::with(['subject'=>function($query){
                $query->select(['id','name']);
            }])
                ->sharedLock()
                ->where('item_id',$this->item_id)
                ->get();
            $crowds=Itemcrowd::with(['cate'=>function($query){
                $query->select(['id','name']);
            },'crowd'=>function($query){
                $query->select(['id','name']);
            }])
                ->sharedLock()
                ->where('item_id',$this->item_id)
                ->get();
            $house_rates=Itemhouserate::sharedLock()
                ->where('item_id',$this->item_id)
                ->orderBy('start_area','asc')
                ->get();
            $objects=Itemobject::with(['object'=>function($query){
                $query->select(['id','name','num_unit']);
            }])
                ->sharedLock()
                ->where('item_id',$this->item_id)
                ->get();
            $rewards=Itemreward::sharedLock()
                ->where('item_id',$this->item_id)
                ->orderBy('start_at','asc')
                ->get();

            $code='success';
            $msg='查询成功';

        }catch(\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';

        }
        $sdata=[
            'item_id'=>$this->item_id,
            'item'=>$this->item,
            'program'=>$program,
            'subjects'=>$subjects,
            'crowds'=>$crowds,
            'house_rates'=>$house_rates,
            'objects'=>$objects,
            'rewards'=>$rewards,
        ];
        $edata=null;
        $url=null;
        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];

        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.itemprogram.index')->with($result);
        }
    }

    /* ========== 添加 ========== */
    public function add(Request $request){

        $model=new Itemprogram();
        if($request->isMethod('get')){
            $sdata['item_id'] = $this->item_id;
            $result=['code'=>'success','message'=>'请求成功','sdata'=>$sdata,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.itemprogram.add')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else {
            $check=$model
                ->where('item_id',$this->item_id)
                ->first();
            if (filled($check)){
                $result=['code'=>'error','message'=>'征收方案不能重复添加','sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }

            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'name' => 'required',
                'content' => 'required',
                'portion_holder' => 'required|numeric|between:0,100',
                'portion_renter' => 'required|numeric|between:0,100',
                'move_base' => 'required | numeric',
                'move_house' => 'required | numeric',
                'move_office' => 'required | numeric',
                'move_business' => 'required | numeric',
                'move_factory' => 'required | numeric',
                'transit_base' => 'required | numeric',
                'transit_house' => 'required | numeric',
                'transit_other' => 'required | numeric',
                'transit_real' => 'required | numeric',
                'transit_future' => 'required | numeric',
                'reward_house' => 'required | numeric',
                'reward_other' => 'required|numeric|between:0,100',
                'reward_real' => 'required | numeric',
                'reward_move' => 'required | numeric',
                'item_end' => 'required | date',
            ];
            $messages = [
                'required' => ':attribute必须填写',
                'numeric'=>':attribute必须为数字',
                'between'=>':attribute不能小于:min并且不能大于:max',
                'date'=>':attribute必须为日期'
            ];
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try {
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->process_id!=35 || $item->code != '22'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 检查操作权限 ++++++++++ */
                $count=Itemuser::sharedLock()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$item->schedule_id],
                        ['process_id',36],
                        ['user_id',session('gov_user.user_id')],
                    ])
                    ->get();
                if(!$count){
                    throw new \Exception('您没有执行此操作的权限',404404);
                }
                $item->process_id=36;
                $item->code='1';
                $item->save();
                /* ++++++++++ 批量赋值 ++++++++++ */
                $model->fill($request->all());
                $model->addOther($request);
                $model->item_id=$this->item_id;
                $model->code=20;
                $model->save();
                if (blank($model)) {
                    throw new \Exception('添加失败', 404404);
                }

                $code = 'success';
                $msg = '添加成功';
                $sdata = $model;
                $edata = null;
                $url=route('g_itemprogram_info',['item'=>$this->item_id]);
                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '添加失败';
                $sdata = null;
                $edata = null;
                $url = null;
                DB::rollBack();
            }
            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }

    /* ========== 详情 ========== */
    public function info(Request $request){

        /* ********** 查询条件 ********** */
        $where[] = ['item_id',$this->item_id];


        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $model=Itemprogram::
                with(['state'=>function($query){
                $query->select(['code','name']);
            }])
                ->where($where)
                ->sharedLock()
                ->first();

            if(blank($model)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $model->item_id=$this->item_id;
            $code='success';
            $msg='查询成功';
            $sdata=$model;
            $edata=null;
            $url=null;
        }catch(\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=['item_id'=>$this->item_id];
            $url=null;
        }

        DB::commit();

        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];

        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.itemprogram.info')->with($result);
        }
    }

    /* ========== 修改 ========== */
    public function edit(Request $request){

        $id=$request->input('id');
        if(!$id){
            $result=['code'=>'error','message'=>'请先选择数据','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }
        if ($request->isMethod('get')) {
            /* ********** 当前数据 ********** */
            DB::beginTransaction();
            $itemprogram=Itemprogram::sharedLock()->find($id);
            $itemprogram->codeStage=Statecode::pluck('name','code');
            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($itemprogram)){
                $code='warning';
                $msg='数据不存在';
                $sdata=null;
                $edata=null;
                $url=null;

            }else{
                $itemprogram->item_id=$this->item_id;
                $code='success';
                $msg='获取成功';
                $sdata=$itemprogram;
                $edata=null;
                $url=null;

                $view='gov.itemprogram.edit';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }else{
            $model=new Itemprogram();
            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'name' => 'required',
                'content' => 'required',
                'portion_holder' => 'required|numeric|between:0,100',
                'portion_renter' => 'required|numeric|between:0,100',
                'move_base' => 'required | numeric',
                'move_house' => 'required | numeric',
                'move_office' => 'required | numeric',
                'move_business' => 'required | numeric',
                'move_factory' => 'required | numeric',
                'transit_base' => 'required | numeric',
                'transit_house' => 'required | numeric',
                'transit_other' => 'required | numeric',
                'transit_real' => 'required | numeric',
                'transit_future' => 'required | numeric',
                'reward_house' => 'required | numeric',
                'reward_other' => 'required|numeric|between:0,100',
                'reward_real' => 'required | numeric',
                'reward_move' => 'required | numeric',
                'item_end' => 'required | date'
            ];
            $messages = [
                'required' => ':attribute必须填写',
                'numeric'=>':attribute必须为数字',
                'between'=>':attribute不能小于:min并且不能大于:max',
                'date'=>':attribute必须为日期'
            ];
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }

            /* ********** 更新 ********** */
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if(!in_array($item->process_id,['36','37']) || ($item->process_id =='36' && $item->code!='1') || ($item->process_id =='37' && $item->code!='23')){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 检查操作权限 ++++++++++ */
                $count=Itemuser::sharedLock()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$item->schedule_id],
                        ['process_id',36],
                        ['user_id',session('gov_user.user_id')],
                    ])
                    ->get();
                if(!$count){
                    throw new \Exception('您没有执行此操作的权限',404404);
                }
                $item->process_id=36;
                $item->code='1';
                $item->save();
                /* ++++++++++ 锁定数据模型 ++++++++++ */
                $itemprogram=$model::lockForUpdate()->find($id);
                if(blank($itemprogram)){
                    throw new \Exception('指定数据项不存在',404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $itemprogram->fill($request->all());
                $itemprogram->editOther($request);
                $itemprogram->save();
                if(blank($itemprogram)){
                    throw new \Exception('修改失败',404404);
                }
                $code='success';
                $msg='修改成功';
                $sdata=$itemprogram;
                $edata=null;
                $url=route('g_itemprogram_info',['item'=>$this->item_id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=$itemprogram;
                $url=null;
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }
}