<?php
/*
|--------------------------------------------------------------------------
| 建筑用途类型
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;
use App\Http\Model\Buildinguse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BuildinguseController extends BaseauthController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        $select=['id','name','infos','deleted_at'];

        /* ********** 查询条件 ********** */
        $where=[];
        /* ++++++++++ 名称 ++++++++++ */
        $name=trim($request->input('name'));
        if($name){
            $where[]=['name','like','%'.$name.'%'];
            $infos['name']=$name;
        }
        /* ********** 排序 ********** */
        $ordername=$request->input('ordername');
        $ordername=$ordername?$ordername:'id';
        $infos['ordername']=$ordername;

        $orderby=$request->input('orderby');
        $orderby=$orderby?$orderby:'asc';
        $infos['orderby']=$orderby;
        /* ********** 每页条数 ********** */
        $displaynum=$request->input('displaynum');
        $displaynum=$displaynum?$displaynum:15;
        $infos['displaynum']=$displaynum;
        /* ********** 是否删除 ********** */
        $deleted=$request->input('deleted');

        $model=new Buildinguse();
        if(is_numeric($deleted) && in_array($deleted,[0,1])){
            $infos['deleted']=$deleted;
            if($deleted){
                $model=$model->onlyTrashed();
            }
        }else{
            $model=$model->withTrashed();
        }
        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $building_uses=$model->where($where)->select($select)->orderBy($ordername,$orderby)->sharedLock()->paginate($displaynum);
            if(blank($building_uses)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$building_uses;
            $edata=null;
            $url=null;
        }catch (\Exception $exception){
            $building_uses=collect();
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=$building_uses;
            $url=null;
        }
        DB::commit();
        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.buildinguse.index')->with($result);
        }
    }

    /* ========== 添加 ========== */
    public function add(Request $request){
        $model=new Buildinguse();
        if($request->isMethod('get')){
            $result=['code'=>'success','message'=>'请求成功','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.buildinguse.add')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else {
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'name' => 'required|unique:building_use'
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
                $building_use = $model;
                $building_use->fill($request->input());
                $building_use->addOther($request);
                $building_use->save();
                if (blank($building_use)) {
                    throw new \Exception('添加失败', 404404);
                }
                $code = 'success';
                $msg = '添加成功';
                $sdata = $building_use;
                $edata = null;
                $url = route('g_buildinguse');
                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '添加失败';
                $sdata = null;
                $edata = $building_use;
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
        $building_use=Buildinguse::withTrashed()
            ->sharedLock()
            ->find($id);
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($building_use)){
            $code='warning';
            $msg='数据不存在';
            $sdata=null;
            $edata=null;
            $url=null;

        }else{
            $code='success';
            $msg='获取成功';
            $sdata=$building_use;
            $edata=new Buildinguse();
            $url=null;

            $view='gov.buildinguse.info';
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
            $building_use=Buildinguse::withTrashed()
                ->sharedLock()
                ->find($id);
            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($building_use)){
                $code='warning';
                $msg='数据不存在';
                $sdata=null;
                $edata=null;
                $url=null;

            }else{
                $code='success';
                $msg='获取成功';
                $sdata=$building_use;
                $edata=new Buildinguse();
                $url=null;

                $view='gov.buildinguse.edit';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }else{
            /* ********** 表单验证 ********** */
            $model=new Buildinguse();
            $rules=[
                'name'=>'required|unique:building_use,name,'.$id.',id'
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'unique'=>':attribute 已存在'
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
                $building_use=Buildinguse::withTrashed()
                    ->lockForUpdate()
                    ->find($id);
                if(blank($building_use)){
                    throw new \Exception('指定数据项不存在',404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $building_use->fill($request->input());
                $building_use->editOther($request);
                $building_use->save();
                if(blank($building_use)){
                    throw new \Exception('修改失败',404404);
                }
                $code='success';
                $msg='修改成功';
                $sdata=$building_use;
                $edata=null;
                $url=route('g_buildinguse');

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=$building_use;
                $url=null;
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }
}