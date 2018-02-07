<?php
/*
|--------------------------------------------------------------------------
| 土地权益状况
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;
use App\Http\Model\Landprop;
use App\Http\Model\Landsource;
use App\Http\Model\Landstate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LandstateController extends BaseController
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
        $source_id = $request->input('source_id');
        if(!$source_id){
            $result=['code'=>'error','message'=>'请先选择土地来源','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }

        /* ********** 查询条件 ********** */
        $where=[];
        $where[]=['prop_id',$prop_id];
        $where[]=['source_id',$source_id];
        $select=['id','prop_id','source_id','name','infos','deleted_at'];
        /* ********** 查询 ********** */
        $model=new Landstate();
        DB::beginTransaction();
        try{
            $landstates['prop_id'] =$prop_id;
            $landstates['landprop'] =Landprop::withTrashed()->select(['id','name'])->find($prop_id);
            $landstates['source_id'] =$source_id;
            $landstates['landsource'] =Landsource::withTrashed()->select(['id','name'])->find($source_id);
            $landstates['landstate']=$model->withTrashed()
                        ->with(['landprop'=>function($query){
                            $query->withTrashed()->select(['id','name']);
                        },
                        'landsource'=>function($query){
                            $query->withTrashed()->select(['id','name']);
                        }])
                        ->where($where)
                        ->select($select)
                        ->sharedLock()
                        ->get();
            if(blank($landstates)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$landstates;
            $edata=null;
            $url=null;
        }catch (\Exception $exception){
            $landstates=collect();
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=$landstates;
            $url=null;
        }
        DB::commit();

        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.landstate.index')->with($result);
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
            $edata['prop_id'] = $prop_id;
            $edata['source_id'] = $source_id;
            $result=['code'=>'success','message'=>'请求成功','sdata'=>null,'edata'=>$edata,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.landstate.add')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else {
            $model = new Landstate();
            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'prop_id' => 'required',
                'source_id' => 'required',
                'name' => 'required|unique:land_state'
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
                $landstate = $model;
                $landstate->fill($request->input());
                $landstate->addOther($request);
                $landstate->save();
                if (blank($landstate)) {
                    throw new \Exception('添加失败', 404404);
                }
                $code = 'success';
                $msg = '添加成功';
                $sdata = $landstate;
                $edata = null;
                $url = route('g_landstate',['prop_id'=>$prop_id,'source_id'=>$source_id]);
                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '添加失败';
                $sdata = null;
                $edata = $landstate;
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

            $view='gov.landstate.info';
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
            $model=new Landstate();
            /* ********** 表单验证 ********** */
            $rules=[
                'name'=>'required|unique:land_state,name,'.$id.',id'
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
                $landstate=Landstate::withTrashed()
                    ->lockForUpdate()
                    ->find($id);
                $prop_id = $landstate->prop_id;
                $source_id = $landstate->source_id;
                if(blank($landstate)){
                    throw new \Exception('指定数据项不存在',404404);
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
                $url=route('g_landstate',['prop_id'=>$prop_id,'source_id'=>$source_id]);

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