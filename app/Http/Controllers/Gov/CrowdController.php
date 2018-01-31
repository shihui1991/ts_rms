<?php
/*
|--------------------------------------------------------------------------
| 特殊人群
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;
use App\Http\Model\Crowd;
use App\Http\Model\Crowdcate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CrowdController extends BaseController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {

    }

    /* ========== 特殊人群分类首页(一级分类) ========== */
    public function index(Request $request){
        $model=new Crowdcate();
        /* ********** 查询字段 ********** */
        $select=['id','name','infos','deleted_at'];
        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $crowd_cates=$model->select($select)->sharedLock()->get();
            if(blank($crowd_cates)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $data=$crowd_cates;
        }catch (\Exception $exception){
            $crowd_cates=collect();
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=$crowd_cates;
        }
        DB::commit();
        /* ********** 结果 ********** */
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'']);
    }

    /* ========== 特殊人群分类首页(二级分类) ========== */
    public function index_childs(Request $request){
        /* ********** 是否存在一级分类 ********** */
        $crowd_cate_id = $request->input('cate_id');
        if(blank($crowd_cate_id)){
            $code='error';
            $msg='请选择特殊人群分类';
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>'','edata'=>'']);
        }
        /* ********** 查询字段 ********** */
        $model=new Crowd();
        $select=['id','cate_id','name','infos','deleted_at'];
        $where[] = ['cate_id',$crowd_cate_id];
        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $crowd=$model->with([
                'crowdcate'=>function($qeury){
                    $qeury->withTrashed()->select(['id','name']);
                }])
                ->select($select)
                ->sharedLock()
                ->get();
            if(blank($crowd)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $data=$crowd;
        }catch (\Exception $exception){
            $crowd=collect();
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=$crowd;
        }
        DB::commit();
        /* ********** 结果 ********** */
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'']);
    }

    /* ========== 添加(特殊人群分类) ========== */
    public function add(Request $request){
        $model=new Crowdcate();
        /* ********** 保存 ********** */
        /* ++++++++++ 表单验证 ++++++++++ */
        $rules=[
            'name'=>'required|unique:crowd_cate'
        ];
        $messages=[
            'required'=>':attribute 为必须项',
            'unique'=>':attribute 已存在'
        ];
        $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
        if($validator->fails()){
            return response()->json(['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>'','edata'=>'']);
        }

        /* ++++++++++ 新增 ++++++++++ */
        DB::beginTransaction();
        try{
            /* ++++++++++ 批量赋值 ++++++++++ */
            $crowd=$model;
            $crowd->fill($request->input());
            $crowd->addOther($request);
            $crowd->save();
            if(blank($crowd)){
                throw new \Exception('添加失败',404404);
            }
            $code='success';
            $msg='添加成功';
            $data=$crowd;
            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'添加失败';
            $data=[];
            DB::rollBack();
        }
        /* ++++++++++ 结果 ++++++++++ */
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'']);
    }

    /* ========== 添加(特殊人群) ========== */
    public function add_childs(Request $request){
        /* ********** 是否存在一级分类 ********** */
        $crowd_cate_id = $request->input('cate_id');
        if(blank($crowd_cate_id)){
            $code='error';
            $msg='请选择特殊人群分类';
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>'','edata'=>'']);
        }
        /* ********** 保存 ********** */
        $model=new Crowd();
        /* ++++++++++ 表单验证 ++++++++++ */
        $rules=[
            'name'=>'required|unique:crowd'
        ];
        $messages=[
            'required'=>':attribute 为必须项',
            'unique'=>':attribute 已存在'
        ];
        $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
        if($validator->fails()){
            return response()->json(['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>'','edata'=>'']);
        }

        /* ++++++++++ 新增 ++++++++++ */
        DB::beginTransaction();
        try{
            /* ++++++++++ 批量赋值 ++++++++++ */
            $crowd=$model;
            $crowd->fill($request->input());
            $crowd->addOther($request);
            $crowd->save();
            if(blank($crowd)){
                throw new \Exception('添加失败',404404);
            }
            $code='success';
            $msg='添加成功';
            $data=$crowd;
            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'添加失败';
            $data=[];
            DB::rollBack();
        }
        /* ++++++++++ 结果 ++++++++++ */
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'']);
    }

    /* ========== 详情(特殊人群分类) ========== */
    public function info(Request $request){
        $id=$request->input('id');
        if(!$id){
            $code='warning';
            $msg='请选择一条数据';
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>'','edata'=>'']);
        }
        /* ********** 当前数据 ********** */
        DB::beginTransaction();
        $crowd=Crowdcate::withTrashed()
            ->sharedLock()
            ->find($id);
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($crowd)){
            $code='warning';
            $msg='数据不存在';
            $data=[];
        }else{
            $code='success';
            $msg='获取成功';
            $data=$crowd;
        }
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'']);
    }

    /* ========== 详情(特殊人群) ========== */
    public function info_childs(Request $request){
        $id=$request->input('id');
        if(!$id){
            $code='warning';
            $msg='请选择一条数据';
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>'','edata'=>'']);
        }
        /* ********** 当前数据 ********** */
        DB::beginTransaction();
        $crowd=Crowd::withTrashed()
            ->sharedLock()
            ->find($id);
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($crowd)){
            $code='warning';
            $msg='数据不存在';
            $data=[];
        }else{
            $code='success';
            $msg='获取成功';
            $data=$crowd;
        }
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'']);
    }

    /* ========== 修改(特殊人群分类) ========== */
    public function edit(Request $request){
        $id=$request->input('id');
        if(!$id){
            $code='warning';
            $msg='请选择一条数据';
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>'','edata'=>'']);
        }
        $model=new Crowdcate();
        /* ********** 表单验证 ********** */
        $rules=[
            'name'=>'required|unique:crowd_cate,name,'.$id.',id'
        ];
        $messages=[
            'required'=>':attribute 为必须项',
            'unique'=>':attribute 已存在'
        ];
        $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
        if($validator->fails()){
            return response()->json(['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>'','edata'=>'']);
        }
        /* ********** 更新 ********** */
        DB::beginTransaction();
        try{
            /* ++++++++++ 锁定数据模型 ++++++++++ */
            $crowd=Crowdcate::withTrashed()
                ->lockForUpdate()
                ->find($id);
            if(blank($crowd)){
                throw new \Exception('指定数据项不存在',404404);
            }
            /* ++++++++++ 处理其他数据 ++++++++++ */
            $crowd->fill($request->input());
            $crowd->setOther($request);
            $crowd->save();
            if(blank($crowd)){
                throw new \Exception('修改失败',404404);
            }
            $code='success';
            $msg='修改成功';
            $data=$crowd;

            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=[];
            DB::rollBack();
        }
        /* ********** 结果 ********** */
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'']);
    }

    /* ========== 修改(特殊人群) ========== */
    public function edit_childs(Request $request){
        $id=$request->input('id');
        if(!$id){
            $code='warning';
            $msg='请选择一条数据';
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>'','edata'=>'']);
        }
        $model=new Crowd();
        /* ********** 表单验证 ********** */
        $rules=[
            'name'=>'required|unique:crowd,name,'.$id.',id'
        ];
        $messages=[
            'required'=>':attribute 为必须项',
            'unique'=>':attribute 已存在'
        ];
        $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
        if($validator->fails()){
            return response()->json(['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>'','edata'=>'']);
        }
        /* ********** 更新 ********** */
        DB::beginTransaction();
        try{
            /* ++++++++++ 锁定数据模型 ++++++++++ */
            $crowd=Crowd::withTrashed()
                ->lockForUpdate()
                ->find($id);
            if(blank($crowd)){
                throw new \Exception('指定数据项不存在',404404);
            }
            /* ++++++++++ 处理其他数据 ++++++++++ */
            $crowd->fill($request->input());
            $crowd->setOther($request);
            $crowd->save();
            if(blank($crowd)){
                throw new \Exception('修改失败',404404);
            }
            $code='success';
            $msg='修改成功';
            $data=$crowd;

            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=[];
            DB::rollBack();
        }
        /* ********** 结果 ********** */
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'']);
    }


}