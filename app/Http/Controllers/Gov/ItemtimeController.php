<?php
/*
|--------------------------------------------------------------------------
| 项目-时间规划
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use App\Http\Model\Item;
use App\Http\Model\Itemtime;
use App\Http\Model\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemtimeController extends BaseController
{
    /* ========== 初始化 ========== */
    public function __construct()
    {

    }

    /* ========== 时间规划 ========== */
    public function index(Request $request){
        $item_id=1;
        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $itemtimes=Schedule::with(['itemtime'=>function($query) use ($item_id){
                $query->where('item_id',$item_id);
            }])
                ->orderBy('sort','asc')
                ->sharedLock()
                ->get();

            $itemcreate=Item::where('id',$item_id)->value('created_at');

            if(blank($itemtimes)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$itemtimes;
            $edata=['created_at'=>$itemcreate];
            $url=null;
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=null;
            $url=null;
        }
        DB::commit();

        /* ++++++++++ 结果 ++++++++++ */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view('gov.Itemtime.index')->with($result);
        }
    }

    /* ========== 修改规划 ========== */
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
        if($request->isMethod('get')){
            DB::beginTransaction();
            $itemtime=Itemtime::with(['schedule'=>function($query){
                $query->select(['id','name']);
            }])
                ->sharedLock()
                ->find($id);
            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($itemtime)){
                $code='error';
                $msg='数据不存在';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='gov.error';
            }else{
                $code='success';
                $msg='查询成功';
                $sdata=$itemtime;
                $edata=null;
                $url=null;

                $view='gov.itemtime.edit';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }
        /* ********** 保存 ********** */
        else{
            /* ********** 表单验证 ********** */
            $model=new Itemtime();
            $rules=[
                'start_at'=>'required|date',
                'end_at'=>'required|date|after:start_at'
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'date'=>':attribute 必须为日期',
                'after'=>':attribute 必须在 :date 之后',
            ];
            $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /* ********** 更新 ********** */
            DB::beginTransaction();
            try{
                /* ++++++++++ 锁定数据模型 ++++++++++ */
                $itemtime=Itemtime::lockForUpdate()->find($id);
                if(blank($itemtime)){
                    throw new \Exception('数据不存在',404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $itemtime->fill($request->input());
                $itemtime->editOther($request);
                $itemtime->save();
                if(blank($itemtime)){
                    throw new \Exception('修改失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=$itemtime;
                $edata=null;
                $url=route('g_itemtime');

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'保存失败';
                $sdata=null;
                $edata=$itemtime;
                $url=null;

                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }
}