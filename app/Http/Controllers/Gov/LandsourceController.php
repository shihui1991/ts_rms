<?php
/*
|--------------------------------------------------------------------------
| 土地来源
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;
use App\Http\Model\Landprop;
use App\Http\Model\Landsource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LandsourceController extends BaseController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {

    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        $prop_id = $request->input('prop_id');
        if(!$prop_id){
            $result=['code'=>'error','message'=>'请先选择土地性质','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }

        /* ********** 查询条件 ********** */
        $select=['id','prop_id','name','infos','deleted_at'];

        /* ********** 查询 ********** */
        $model=new Landsource();
        DB::beginTransaction();
        try{
            $landsources['prop_id'] =$prop_id;
            $landsources['landprop'] =Landprop::withTrashed()->select(['id','name'])->find($prop_id);
            $landsources['landsource']=$model
                ->with(['landprop'=>function($query){
                    $query->withTrashed()->select(['id','name']);
                }])
                ->where('prop_id',$prop_id)
                ->select($select)
                ->sharedLock()
                ->get();
            if(blank($landsources)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$landsources;
            $edata=null;
            $url=null;
        }catch (\Exception $exception){
            $landsources=collect();
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=$landsources;
            $url=null;
        }
        DB::commit();

        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.landsource.index')->with($result);
        }
    }

    /* ========== 添加 ========== */
    public function add(Request $request){
        $prop_id = $request->input('prop_id');
        if(!$prop_id){
            $result=['code'=>'error','message'=>'请先选择土地性质','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }

        if($request->isMethod('get')){
            $edata['prop_id'] = $prop_id;
            $result=['code'=>'success','message'=>'请求成功','sdata'=>null,'edata'=>$edata,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.landsource.add')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else {
            $model = new Landsource();
            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'prop_id' => 'required',
                'name' => 'required|unique:land_source'
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
                /* ++++++++++ 批量赋值 ++++++++++ */
                $landsource = $model;
                $landsource->fill($request->input());
                $landsource->addOther($request);
                $landsource->save();

                $code = 'success';
                $msg = '添加成功';
                $sdata = $landsource;
                $edata = null;
                $url = route('g_landsource',['prop_id'=>$prop_id]);
                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '添加失败';
                $sdata = null;
                $edata = $landsource;
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
        $id=$request->input('id');
        if(!$id){
            $result=['code'=>'error','message'=>'请先选择数据','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }
        /* ********** 当前数据 ********** */
        DB::beginTransaction();
        $landsource=Landsource::withTrashed()
            ->with(['landprop'=>function($query){
                    $query->withTrashed()->select(['id','name']);
                }])
            ->sharedLock()
            ->find($id);
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($landsource)){
            $code='warning';
            $msg='数据不存在';
            $sdata=null;
            $edata=null;
            $url=null;
        }else{
            $code='success';
            $msg='获取成功';
            $sdata=$landsource;
            $edata=new Landsource();
            $url=null;

            $view='gov.landsource.info';
        }
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view($view)->with($result);
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
            $landsource=Landsource::withTrashed()
                ->with(['landprop'=>function($query){
                    $query->withTrashed()->select(['id','name']);
                }])
                ->sharedLock()
                ->find($id);
            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($landsource)){
                $code='warning';
                $msg='数据不存在';
                $sdata=null;
                $edata=null;
                $url=null;
            }else{
                $code='success';
                $msg='获取成功';
                $sdata=$landsource;
                $edata=new Landsource();
                $url=null;

                $view='gov.landsource.edit';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }else{
            $model=new Landsource();
            /* ********** 表单验证 ********** */
            $rules=[
                'name'=>'required|unique:land_source,name,'.$id.',id'
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'unique'=>':attribute 已存在'
            ];
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result = ['code' => 'error', 'message' => $validator->errors()->first(), 'sdata' => null, 'edata' => null, 'url' => null];
                return response()->json($result);
            }
            /* ********** 更新 ********** */
            DB::beginTransaction();
            try{
                /* ++++++++++ 锁定数据模型 ++++++++++ */
                $landsource=Landsource::withTrashed()
                    ->lockForUpdate()
                    ->find($id);
                $prop_id = $landsource->prop_id;
                if(blank($landsource)){
                    throw new \Exception('指定数据项不存在',404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $landsource->fill($request->input());
                $landsource->editOther($request);
                $landsource->save();
                if(blank($landsource)){
                    throw new \Exception('修改失败',404404);
                }
                $code='success';
                $msg='修改成功';
                $sdata=$landsource;
                $edata=null;
                $url=route('g_landsource',['prop_id'=>$prop_id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=$landsource;
                $url=null;
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }
}