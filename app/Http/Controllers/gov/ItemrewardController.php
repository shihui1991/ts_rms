<?php
/*
|--------------------------------------------------------------------------
| 项目-产权调换房的签约奖励
|--------------------------------------------------------------------------
*/
namespace  App\Http\Controllers\gov;

use App\Http\Model\Itemreward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;

class ItemrewardController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 详情页 ========== */
    public function index(Request $request){
        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $item_rewards=Itemreward::sharedLock()
                ->where('item_id',$this->item_id)
                ->orderBy('start_at','asc')
                ->get();
            if(blank($item_rewards)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';

        }catch(\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';

        }
        $sdata=[
            'item'=>$this->item,
            'item_rewards'=>$item_rewards,
        ];
        $edata=null;
        $url=null;
        DB::commit();
        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];

        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.itemreward.index')->with($result);
        }
    }

    /* ========== 添加页 ========== */
    public function add(Request $request){
        if($request->isMethod('get')){
            $result=['code'=>'success','message'=>'请求成功','sdata'=>['item'=>$this->item],'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.itemreward.add')->with($result);
            }
        }
        /* ********** 保存 ********** */
        else{
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules=[
                'start_at'=>'required|date',
                'end_at'=>'required|date|after:start_at',
                'price'=>'required|numeric|min:0',
                'portion'=>'required|numeric|between:0,100',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'date'=>':attribute 必须为日期',
                'after'=>':attribute 必须在 :date 之后',
                'min'=>':attribute 不能小于 :min',
                'numeric'=>':attribute 必须为数值',
                'between'=>':attribute 必须在 :min 和 :max 之间',
            ];
            $model=new Itemreward();
            $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }

            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try{
                /* ++++++++++ 批量赋值 ++++++++++ */
                $item_reward=$model;
                $item_reward->fill($request->all());
                $item_reward->addOther($request);
                $item_reward->item_id=$this->item_id;
                $item_reward->save();
                if (blank($item_reward)) {
                    throw new \Exception('添加失败', 404404);
                }
                $code = 'success';
                $msg = '添加成功';
                $sdata = $model;
                $edata = null;
                $url = route('g_itemreward',['item'=>$this->item_id]);
                DB::commit();
            }catch (\Exception $exception){
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

    /* ========== 修改页 ========== */
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
            try{
                $item_reward=Itemreward::sharedLock()->where('item_id',$this->item_id)->where('id',$id)->first();
                if(blank($item_reward)){
                    throw new \Exception('数据不存在',404404);
                }
                $code='success';
                $msg='请求成功';
                $sdata=[
                    'item'=>$this->item,
                    'item_reward'=>$item_reward,
                ];
                $edata=null;
                $url=null;

                $view='gov.itemreward.edit';
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
        }else{
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules=[
                'start_at'=>'required|date',
                'end_at'=>'required|date|after:start_at',
                'price'=>'required|numeric|min:0',
                'portion'=>'required|numeric|between:0,100',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'date'=>':attribute 必须为日期',
                'after'=>':attribute 必须在 :date 之后',
                'min'=>':attribute 不能小于 :min',
                'numeric'=>':attribute 必须为数值',
                'between'=>':attribute 必须在 :min 和 :max 之间',
            ];

            $model=new Itemreward();
            $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /* ********** 更新 ********** */
            DB::beginTransaction();
            try{
                /* ++++++++++ 锁定数据模型 ++++++++++ */
                $item_reward=Itemreward::lockForUpdate()->where('item_id',$this->item_id)->where('id',$id)->first();
                if(blank($item_reward)){
                    throw new \Exception('指定数据项不存在',404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $item_reward->fill($request->all());
                $item_reward->editOther($request);
                $item_reward->save();
                if(blank($item_reward)){
                    throw new \Exception('修改失败',404404);
                }
                $code='success';
                $msg='修改成功';
                $sdata=[
                    'item'=>$this->item,
                    'item_reward'=>$item_reward,
                ];
                $edata=null;
                $url=route('g_itemreward',['item'=>$this->item_id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=null;
                $url=null;
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }

}