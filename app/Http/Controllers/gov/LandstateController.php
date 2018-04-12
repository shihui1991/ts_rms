<?php
/*
|--------------------------------------------------------------------------
| 土地权益状况
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;
use App\Http\Model\Landprop;
use App\Http\Model\Landsource;
use App\Http\Model\Landstate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LandstateController extends BaseauthController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 添加 ========== */
    public function add(Request $request){
        $source_id = $request->input('source_id');
        if(!$source_id){
            $result=['code'=>'error','message'=>'请先选择土地来源','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }

        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                $landsource=Landsource::with('landprop')->sharedLock()->find($source_id);
                if(blank($landsource)){
                    throw new \Exception('土地来源不存在',404404);
                }

                $code = 'success';
                $msg = '请求成功';
                $sdata = $landsource;
                $edata = null;
                $url =null;

                $view='gov.landstate.add';
            }catch (\Exception $exception){
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '网络错误';
                $sdata = null;
                $edata = null;
                $url =null;

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
        /* ++++++++++ 保存 ++++++++++ */
        else {
            $model = new Landstate();
            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'name' => ['required',Rule::unique('land_state')->where(function ($query) use ($source_id){
                    $query->where('source_id',$source_id);
                })]
            ];
            $messages = [
                'required' => ':attribute 为必须项',
                'unique' => ':attribute 已存在'
            ];
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }

            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try {
                $landsource=Landsource::sharedLock()->find($source_id);
                if(blank($landsource)){
                    throw new \Exception('数据错误', 404404);
                }
                /* ++++++++++ 批量赋值 ++++++++++ */
                $landstate = $model;
                $landstate->fill($request->input());
                $landstate->addOther($request);
                $landstate->prop_id=$landsource->prop_id;
                $landstate->save();
                if (blank($landstate)) {
                    throw new \Exception('添加失败', 404404);
                }
                $code = 'success';
                $msg = '添加成功';
                $sdata = $landstate;
                $edata = null;
                $url = route('g_landprop');
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
            $landstate=Landstate::withTrashed()
                ->with(['landprop'=>function($query){
                    $query->withTrashed()->select(['id','name']);
                },
                    'landsource'=>function($query){
                        $query->withTrashed()->select(['id','name']);
                    }])
                ->sharedLock()
                ->find($id);
            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($landstate)){
                $code='warning';
                $msg='数据不存在';
                $sdata=null;
                $edata=null;
                $url=null;
            }else{
                $code='success';
                $msg='获取成功';
                $sdata=$landstate;
                $edata=new Landstate();
                $url=null;

                $view='gov.landstate.edit';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }else{
            /* ********** 更新 ********** */
            DB::beginTransaction();
            try{
                /* ++++++++++ 锁定数据模型 ++++++++++ */
                $landstate=Landstate::withTrashed()
                    ->lockForUpdate()
                    ->find($id);
                if(blank($landstate)){
                    throw new \Exception('指定数据项不存在',404404);
                }
                $source_id=$landstate->source_id;
                /* ********** 表单验证 ********** */
                $rules=[
                    'name' => ['required',Rule::unique('land_state')->where(function ($query) use ($id,$source_id){
                        $query->where('source_id',$source_id)->where('id','<>',$id);
                    })]
                ];
                $messages=[
                    'required'=>':attribute 为必须项',
                    'unique'=>':attribute 已存在'
                ];
                $validator = Validator::make($request->all(), $rules, $messages, $landstate->columns);
                if ($validator->fails()) {
                    throw new \Exception($validator->errors()->first(),404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $landstate->fill($request->input());
                $landstate->editOther($request);
                $landstate->save();
                if(blank($landstate)){
                    throw new \Exception('修改失败',404404);
                }
                $code='success';
                $msg='修改成功';
                $sdata=$landstate;
                $edata=null;
                $url=route('g_landprop');

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=$landstate;
                $url=null;
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }
}