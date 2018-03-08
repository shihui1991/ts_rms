<?php
/*
|--------------------------------------------------------------------------
| 项目-征收方案
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;
use App\Http\Model\Itemprogram;
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

    /* ========== 添加 ========== */
    public function add(Request $request){
        $item_id=$this->item_id;

        $model=new Itemprogram();
        if($request->isMethod('get')){
            $sdata['item_id'] = $item_id;
            $sdata['codeStage']=Statecode::pluck('name','code');
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
                ->where('item_id',$item_id)
                ->first();
            if (filled($check)){
                $result=['code'=>'error','message'=>'征收方案不能重复添加','sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }

            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'name' => 'required',
                'content' => 'required'
            ];
            $messages = [
                'required' => ':attribute必须填写'
            ];
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
dump($request->input());
            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try {
                /* ++++++++++ 批量赋值 ++++++++++ */
                $model->fill($request->all());
                $model->addOther($request);
                $model->item_id=$this->item_id;
                $model->save();
                if (blank($model)) {
                    throw new \Exception('添加失败', 404404);
                }

                $code = 'success';
                $msg = '添加成功';
                $sdata = $model;
                $edata = null;
                $url = null;
                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '添加失败';
                $sdata = null;
                $edata = $model;
                $url = null;
                DB::rollBack();
            }
            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }

    /* ========== 详情 ========== */
    public function info(Request $request){

        $item_id=$this->item_id;

        /* ********** 查询条件 ********** */
        $where[] = ['item_id',$item_id];
        $infos['item_id'] = $item_id;

        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $model=Itemprogram::
                with(['item'=>function($query){
                    $query->select(['id','name']);
                },'state'=>function($query){
                $query->select(['code','name']);
            }])
                ->where($where)
                ->sharedLock()
                ->first();

            if(blank($model)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$model;
            $edata=$infos;
            $url=null;
        }catch(\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=$infos;
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
        $item_id=$this->item_id;

        $id=$request->input('id');
        if(!$id){
            $edata['item_id']=$item_id;
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
                'content' => 'required'
            ];
            $messages = [
                'required' => ':attribute必须填写'
            ];
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }

            /* ********** 更新 ********** */
            DB::beginTransaction();
            try{
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
                $url=route('g_itemprogram_info',['item'=>$this->item_id]);;

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