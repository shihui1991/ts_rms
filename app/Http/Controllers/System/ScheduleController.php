<?php
/*
|--------------------------------------------------------------------------
| 项目进度
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\System;
use App\Http\Model\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ScheduleController extends BaseController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {

    }

    /* ++++++++++ 首页 ++++++++++ */
    public function index(Request $request){
        $model=new Schedule();
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
            $schedules=$model
                ->with(['process'=>function($query){
                    $query->where('parent_id','0')->select(['id','schedule_id','type','menu_id','parent_id','name']);
                }])
                ->sharedLock()
                ->get();
            if(blank($schedules)){
                throw new \Exception('没有符合条件的数据',404404);
            }

            $code='error';
            $msg='查询成功';
            $data=$schedules;
            $url='';
        }catch (\Exception $exception){
            $schedules=collect();
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=$schedules;
            $url='';
        }
        DB::commit();
        $infos['schedules']=$schedules;
        $infos[$code]=$msg;

        /* ********** 结果 ********** */
        if($request->ajax()){
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
        }else{
            return view('system.schedule.index',$infos);
        }
    }

    /* ========== 添加 ========== */
    public function add(Request $request,$id=0){
        $model=new Schedule();
        /* ********** 保存 ********** */
        if($request->isMethod('post')){
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules=[
                'name'=>'required|unique:a_schedule',
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
                $schedule=$model;
                $schedule->fill($request->input());
                $schedule->addOther($request);
                $schedule->save();
                if(blank($schedule)){
                    throw new \Exception('添加失败',404404);
                }
                $code='success';
                $msg='添加成功';
                $data=$schedule;
                $url='';
                DB::commit();
            }catch (\Exception $exception){

                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'添加失败';
                $data=[];
                $url='';
                DB::rollBack();
            }
            /* ++++++++++ 结果 ++++++++++ */
            if($request->ajax()){
                return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
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
                $parent['name']=schedule::withTrashed()->where('id',$id)->sharedLock()->value('name');
                DB::commit();
            }
            $infos['parent']=$parent;

            /* ++++++++++ 输出视图 ++++++++++ */
            return view('system.schedule.add',$infos);
        }
    }

    /* ========== 详情 ========== */
    public function info(Request $request){
        $id=$request->input('id');
        if(!$id){
            $code='warning';
            $msg='请选择一条数据';
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>'','edata'=>'']);
        }
        /* ********** 当前数据 ********** */
        DB::beginTransaction();
        $schedule=Schedule::withTrashed()
            ->sharedLock()
            ->find($id);

        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($schedule)){
            $code='warning';
            $msg='数据不存在';
            $data=[];
            $url='';
        }else{
            $code='success';
            $msg='获取成功';
            $data=$schedule;
            $url='';
        }
        $infos=[
            'code'=>$code,
            'msg'=>$msg,
            'sdata'=>$data,'edata'=>'',
            'url'=>$url,
        ];

        /* ********** 输出视图 ********** */
        return view('system.schedule.info',$infos);
    }

    /* ========== 修改 ========== */
    public function edit(Request $request){
        $id=$request->input('id');
        if(!$id){
            $code='warning';
            $msg='请选择一条数据';
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>'','edata'=>'']);
        }

        $model=new Schedule();
        if($request->isMethod('post')){
            /* ********** 表单验证 ********** */
            $rules=[
                'name'=>'required|unique:a_schedule,name,'.$id.',id',
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
                $schedule=Schedule::withTrashed()
                    ->lockForUpdate()
                    ->find($id);
                if(blank($schedule)){
                    throw new \Exception('指定数据项不存在',404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $schedule->fill($request->input());
                $schedule->editOther($request);
                $schedule->save();
                if(blank($schedule)){
                    throw new \Exception('修改失败',404404);
                }
                $code='success';
                $msg='修改成功';
                $data=$schedule;
                $url='';
                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $data=[];
                $url='';
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            if($request->ajax()){
                return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
            }else{
                return redirect()->back()->withInput()->with($code,$msg);
            }
        }else{
            /* ********** 当前数据 ********** */
            DB::beginTransaction();
            $schedule=Schedule::withTrashed()
                ->sharedLock()
                ->find($id);
            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($schedule)){
                $code='warning';
                $msg='数据不存在';
                $data=[];
                $url='';
            }else{
                $code='success';
                $msg='获取成功';
                $data=$schedule;
                $url='';
            }
            $infos=[
                'code'=>$code,
                'msg'=>$msg,
                'sdata'=>$data,'edata'=>'',
                'url'=>$url,
            ];
            /* ********** 输出视图 ********** */
            return view('system.schedule.edit',$infos);
        }

    }

    /* ========== 删除 ========== */
    public function delete(Request $request){
        /* ********** 验证选择数据项 ********** */
        $ids=$request->input('ids');
        if(!$ids){

            $code='warning';
            $msg='至少选择一项';
            $data=[];
            $url='';
            if($request->ajax()){
                return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
            }else{
                return redirect()->back()->withInput()->with($code,$msg);
            }
        }
        /* ********** 删除 ********** */
        DB::beginTransaction();
        try{
            /* ++++++++++ 锁定数据 ++++++++++ */
            $schedules=Schedule::select(['id'])->withCount('process')->whereIn('id',$ids)->lockForUpdate()->get();
            if(blank($schedules)){
                throw new \Exception('没有可删除数据');
            }
            $success_ids=[];
            $fail_ids=[];
            foreach ($schedules as $schedule){
                if($schedule->process_count){
                    $fail_ids[]=$schedule->id;
                }else{
                    $success_ids[]=$schedule->id;
                }
            }
            if(blank($success_ids)){
                throw new \Exception('存在子级，禁止删除');
            }
            /* ++++++++++ 批量删除 ++++++++++ */
            Schedule::whereIn('id',$success_ids)->delete();


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

            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=[];
            $url='';
            DB::rollBack();
        }
        /* ********** 结果 ********** */
        if($request->ajax()){
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
        }else{
            return redirect()->back()->withInput()->with($code,$msg);
        }
    }

    /* ========== 恢复 ========== */
    public function restore(Request $request){
        /* ********** 验证选择数据项 ********** */
        $ids=$request->input('ids');
        if(!$ids){

            $code='warning';
            $msg='至少选择一项';
            $data=[];
            $url='';
            if($request->ajax()){
                return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
            }else{
                return redirect()->back()->withInput()->with($code,$msg);
            }
        }
        /* ********** 恢复 ********** */
        DB::beginTransaction();
        try{
            /* ++++++++++ 锁定数据 ++++++++++ */
            $schedule_ids=Schedule::onlyTrashed()->whereIn('id',$ids)->lockForUpdate()->pluck('id');
            if(blank($schedule_ids)){
                throw new \Exception('没有可恢复的数据');
            }
            /* ++++++++++ 批量恢复 ++++++++++ */
            Schedule::whereIn('id',$schedule_ids)->restore();


            $code='success';
            $msg='恢复成功';
            $data=$schedule_ids;
            $url='';
            DB::commit();
        }catch (\Exception $exception){

            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=[];
            $url='';
            DB::rollBack();
        }
        /* ********** 结果 ********** */
        if($request->ajax()){
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
        }else{
            return redirect()->back()->withInput()->with($code,$msg);
        }
    }

    /* ========== 销毁 ========== */
    public function destroy(Request $request){
        /* ********** 验证选择数据项 ********** */
        $ids=$request->input('ids');
        if(!$ids){

            $code='warning';
            $msg='至少选择一项';
            $data=[];
            $url='';
            if($request->ajax()){
                return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
            }else{
                return redirect()->back()->withInput()->with($code,$msg);
            }
        }
        /* ********** 销毁 ********** */
        DB::beginTransaction();
        try{
            /* ++++++++++ 锁定数据 ++++++++++ */
            $schedule_ids=Schedule::onlyTrashed()->whereIn('id',$ids)->lockForUpdate()->pluck('id');
            if(blank($schedule_ids)){
                throw new \Exception('只能销毁已删除的数据');
            }
            /* ++++++++++ 批量销毁 ++++++++++ */
            Schedule::whereIn('id',$schedule_ids)->forceDelete();


            $code='success';
            $msg='销毁成功';
            $data=$schedule_ids;
            $url='';
            DB::commit();
        }catch (\Exception $exception){

            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=[];
            $url='';
            DB::rollBack();
        }
        /* ********** 结果 ********** */
        if($request->ajax()){
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
        }else{
            return redirect()->back()->withInput()->with($code,$msg);
        }
    }
}