<?php
/*
|--------------------------------------------------------------------------
| 项目流程
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\System;

use App\Http\Model\Process;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcessController extends BaseController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {

    }

    /* ++++++++++ 首页 ++++++++++ */
    public function index(Request $request){
        $model=new Process();
        $select = ['id','name','sort','infos'];
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
        $ordername=$ordername?$ordername:'sort';
        $infos['ordername']=$ordername;

        $orderby=$request->input('orderby');
        $orderby=$orderby?$orderby:'asc';
        $infos['orderby']=$orderby;
        /* ********** 每页条数 ********** */
        $nums=[15,30,50,100,200];
        $infos['nums']=$nums;
        $displaynum=$request->input('displaynum');
        $displaynum=$displaynum?$displaynum:15;
        $infos['displaynum']=$displaynum;

        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $processs=$model->where($where)->select($select)->orderBy($ordername,$orderby)->sharedLock()->paginate($displaynum);
            if(blank($processs)){
                throw new \Exception('没有符合条件的数据',404404);
            }

            $error=1;
            $code='error';
            $msg='查询成功';
            $data=$processs;
            $url='';
        }catch (\Exception $exception){
            $processs=collect();

            $error=1;
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=$processs;
            $url='';
        }
        DB::commit();
        $infos['processs']=$processs;
        $infos[$code]=$msg;

        /* ********** 结果 ********** */
        if($request->ajax()){
            return response()->json(['error'=>$error,'code'=>$code,'message'=>$msg,'data'=>$data,'url'=>$url]);
        }else{
            return view('system.process.all',$infos);
        }
    }

    /* ========== 添加 ========== */
    public function add(Request $request,$id=0){
        $model=new Process();
        /* ********** 保存 ********** */
        if($request->isMethod('post')){
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules=[
                'name'=>'required|unique:a_process',
                'sort'=>'required'
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'unique'=>':attribute 已存在'
            ];

            $this->validate($request,$rules,$messages,$model->columns);

            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try{
                /* ++++++++++ 批量赋值 ++++++++++ */
                $process=$model;
                $process->fill($request->input());
                $process->setOther($request);
                $process->save();

                $error=0;
                $code='success';
                $msg='添加成功';
                $data=$process;
                $url='';
                DB::commit();
            }catch (\Exception $exception){
                $error=1;
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'添加失败';
                $data=[];
                $url='';
                DB::rollBack();
            }
            /* ++++++++++ 结果 ++++++++++ */
            if($request->ajax()){
                return response()->json(['error'=>$error,'code'=>$code,'message'=>$msg,'data'=>$data,'url'=>$url]);
            }else{
                return redirect()->back()->withInput()->with($code,$msg);
            }
        }
        /* ********** 视图 ********** */
        else{
            /* ++++++++++ 当前上级 ++++++++++ */
            $parent=['id'=>$id,'name'=>''];
            if($id){
                DB::beginTransaction();
                $parent['name']=process::withTrashed()->where('id',$id)->sharedLock()->value('name');
                DB::commit();
            }
            $infos['parent']=$parent;

            /* ++++++++++ 输出视图 ++++++++++ */
            return view('system.process.add',$infos);
        }
    }

    /* ========== 详情 ========== */
    public function info(Request $request,$id){

        /* ********** 当前数据 ********** */
        DB::beginTransaction();
        $process=Process::withTrashed()
            ->sharedLock()
            ->find($id);

        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($process)){
            $error=1;
            $code='warning';
            $msg='数据不存在';
            $data=[];
            $url='';
        }else{
            $error=0;
            $code='success';
            $msg='获取成功';
            $data=$process;
            $url='';
        }
        $infos=[
            'error'=>$error,
            'code'=>$code,
            'msg'=>$msg,
            'data'=>$data,
            'url'=>$url,
        ];

        /* ********** 输出视图 ********** */
        return view('system.process.info',$infos);
    }


    /* ========== 修改 ========== */
    public function edit(Request $request,$id){
        $model=new Process();
        if($request->isMethod('post')){
            /* ********** 表单验证 ********** */
            $rules=[
                'name'=>'required|unique:a_process',
                'sort'=>'required'
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'unique'=>':attribute 已存在'
            ];
            $this->validate($request,$rules,$messages,$model->columns);

            /* ********** 更新 ********** */
            DB::beginTransaction();
            try{
                /* ++++++++++ 锁定数据模型 ++++++++++ */
                $process=Process::withTrashed()
                    ->lockForUpdate()
                    ->find($id);

                if(blank($process)){
                    throw new \Exception('指定数据项不存在',404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $process->fill($request->input());
                $process->setOther($request);
                $process->save();

                $error=0;
                $code='success';
                $msg='修改成功';
                $data=$process;
                $url='';
                DB::commit();
            }catch (\Exception $exception){
                $error=1;
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $data=[];
                $url='';
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            if($request->ajax()){
                return response()->json(['error'=>$error,'code'=>$code,'message'=>$msg,'data'=>$data,'url'=>$url]);
            }else{
                return redirect()->back()->withInput()->with($code,$msg);
            }
        }else{
            /* ********** 当前数据 ********** */
            DB::beginTransaction();
            $process=Process::withTrashed()
                ->sharedLock()
                ->find($id);

            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($process)){
                $error=1;
                $code='warning';
                $msg='数据不存在';
                $data=[];
                $url='';
            }else{
                $error=0;
                $code='success';
                $msg='获取成功';
                $data=$process;
                $url='';
            }
            $infos=[
                'error'=>$error,
                'code'=>$code,
                'msg'=>$msg,
                'data'=>$data,
                'url'=>$url,
            ];

            /* ********** 输出视图 ********** */
            return view('system.process.edit',$infos);
        }

    }

    /* ========== 删除 ========== */
    public function delete(Request $request){
        /* ********** 验证选择数据项 ********** */
        $ids=$request->input('ids');
        if(!$ids){
            $error=1;
            $code='warning';
            $msg='至少选择一项';
            $data=[];
            $url='';
            if($request->ajax()){
                return response()->json(['error'=>$error,'code'=>$code,'message'=>$msg,'data'=>$data,'url'=>$url]);
            }else{
                return redirect()->back()->withInput()->with($code,$msg);
            }
        }
        /* ********** 删除 ********** */
        DB::beginTransaction();
        try{
            /* ++++++++++ 锁定数据 ++++++++++ */
            $processs=Process::select(['id'])->whereIn('id',$ids)->lockForUpdate()->get();
            if(blank($processs)){
                throw new \Exception('没有可删除数据');
            }
            $success_ids=[];
            $fail_ids=[];
            foreach ($processs as $process){
                if($process->process_count){
                    $fail_ids[]=$process->id;
                }else{
                    $success_ids[]=$process->id;
                }
            }
            if(blank($success_ids)){
                throw new \Exception('存在子级，禁止删除');
            }
            /* ++++++++++ 批量删除 ++++++++++ */
            Process::whereIn('id',$success_ids)->delete();

            $error=0;
            if(blank($fail_ids)){
                $code='success';
                $msg='全部删除成功';
            }else{
                $code='warning';
                $msg='部分存在子级，禁止删除';
            }
            $data=$success_ids;
            $url='';
            DB::commit();
        }catch (\Exception $exception){
            $error=1;
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=[];
            $url='';
            DB::rollBack();
        }
        /* ********** 结果 ********** */
        if($request->ajax()){
            return response()->json(['error'=>$error,'code'=>$code,'message'=>$msg,'data'=>$data,'url'=>$url]);
        }else{
            return redirect()->back()->withInput()->with($code,$msg);
        }
    }


    /* ========== 恢复 ========== */
    public function restore(Request $request){
        /* ********** 验证选择数据项 ********** */
        $ids=$request->input('ids');
        if(!$ids){
            $error=1;
            $code='warning';
            $msg='至少选择一项';
            $data=[];
            $url='';
            if($request->ajax()){
                return response()->json(['error'=>$error,'code'=>$code,'message'=>$msg,'data'=>$data,'url'=>$url]);
            }else{
                return redirect()->back()->withInput()->with($code,$msg);
            }
        }
        /* ********** 恢复 ********** */
        DB::beginTransaction();
        try{
            /* ++++++++++ 锁定数据 ++++++++++ */
            $process_ids=Process::onlyTrashed()->whereIn('id',$ids)->lockForUpdate()->pluck('id');
            if(blank($process_ids)){
                throw new \Exception('没有可恢复的数据');
            }
            /* ++++++++++ 批量恢复 ++++++++++ */
            Process::whereIn('id',$process_ids)->restore();

            $error=0;
            $code='success';
            $msg='恢复成功';
            $data=$process_ids;
            $url='';
            DB::commit();
        }catch (\Exception $exception){
            $error=1;
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=[];
            $url='';
            DB::rollBack();
        }
        /* ********** 结果 ********** */
        if($request->ajax()){
            return response()->json(['error'=>$error,'code'=>$code,'message'=>$msg,'data'=>$data,'url'=>$url]);
        }else{
            return redirect()->back()->withInput()->with($code,$msg);
        }
    }


    /* ========== 销毁 ========== */
    public function destroy(Request $request){
        /* ********** 验证选择数据项 ********** */
        $ids=$request->input('ids');
        if(!$ids){
            $error=1;
            $code='warning';
            $msg='至少选择一项';
            $data=[];
            $url='';
            if($request->ajax()){
                return response()->json(['error'=>$error,'code'=>$code,'message'=>$msg,'data'=>$data,'url'=>$url]);
            }else{
                return redirect()->back()->withInput()->with($code,$msg);
            }
        }
        /* ********** 销毁 ********** */
        DB::beginTransaction();
        try{
            /* ++++++++++ 锁定数据 ++++++++++ */
            $process_ids=Process::onlyTrashed()->whereIn('id',$ids)->lockForUpdate()->pluck('id');
            if(blank($process_ids)){
                throw new \Exception('只能销毁已删除的数据');
            }
            /* ++++++++++ 批量销毁 ++++++++++ */
            Process::whereIn('id',$process_ids)->forceDelete();

            $error=0;
            $code='success';
            $msg='销毁成功';
            $data=$process_ids;
            $url='';
            DB::commit();
        }catch (\Exception $exception){
            $error=1;
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=[];
            $url='';
            DB::rollBack();
        }
        /* ********** 结果 ********** */
        if($request->ajax()){
            return response()->json(['error'=>$error,'code'=>$code,'message'=>$msg,'data'=>$data,'url'=>$url]);
        }else{
            return redirect()->back()->withInput()->with($code,$msg);
        }
    }
}