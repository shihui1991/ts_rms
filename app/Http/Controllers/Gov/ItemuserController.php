<?php
/*
|--------------------------------------------------------------------------
| 项目人员
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use App\Http\Model\Dept;
use App\Http\Model\Itemuser;
use App\Http\Model\Process;
use App\Http\Model\Schedule;
use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemuserController extends BaseController
{
    /* ========== 初始化 ========== */
    public function __construct()
    {

    }

    /* ========== 项目人员 ========== */
    public function index(Request $request){
        $item_id=1;

        /* ********** 查询 ********** */
        DB::beginTransaction();

        $itemusers=Itemuser::with(['schedule'=>function($query){
            $query->select(['id','name']);
        },'processes'=>function($query) use ($item_id){
            $query->with(['process'=>function($query){
                $query->select(['id','name']);
            },'depts'=>function($query) use ($item_id){
                $query->with(['dept'=>function($query){
                    $query->select(['id','name']);
                },'users'=>function($query) use ($item_id){
                    $query->with(['user'=>function($query){
                        $query->select(['id','name']);
                    }])
                        ->where('item_id',$item_id)
                        ->select(['item_id','schedule_id','process_id','dept_id','user_id'])
                        ->distinct();
                }])
                    ->where('item_id',$item_id)
                    ->select(['item_id','schedule_id','process_id','dept_id'])
                    ->distinct();
            }])
                ->where('item_id',$item_id)
                ->select(['item_id','schedule_id','process_id'])
                ->distinct();
        }])
            ->select(['item_id','schedule_id'])
            ->distinct()
            ->sharedLock()
            ->get();

        DB::commit();

        if(blank($itemusers)){
            $code='error';
            $msg='还未配置项目人员';
            $sdata=null;
            $edata=null;
            $url=null;
        }else{
            $code='success';
            $msg='查询成功';
            $sdata=$itemusers;
            $edata=null;
            $url=null;
        }

        /* ++++++++++ 结果 ++++++++++ */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view('gov.itemuser.index')->with($result);
        }
    }

    /* ========== 配置项目人员 ========== */
    public function add(Request $request){
        $item_id=1;
        if($request->isMethod('get')){
            DB::beginTransaction();
            $processes=Schedule::with(['processes'=>function($query){
                $query->select(['id','schedule_id','name','sort'])->orderBy('sort','asc');
            }])
                ->select(['id','name','sort'])
                ->orderBy('sort','asc')
                ->sharedLock()
                ->get();

            $depts=Dept::select(['id','name'])->sharedLock()->get();
            DB::commit();

            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($processes)){
                $code='error';
                $msg='数据错误';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='gov.error';
            }else{
                $code='success';
                $msg='查询成功';
                $sdata=$processes;
                $edata=$depts;
                $url=null;

                $view='gov.itemuser.add';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else{
            /* ++++++++++ 验证 ++++++++++ */
            $itemusers=$request->input('itemusers');
            $user_ids=$request->input('user_ids');
            if(blank($itemusers)){
                $result=['code'=>'error','message'=>'请为项目流程添加人员','sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }

            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try{
                $processes=Process::select(['id','schedule_id','name','menu_id','sort'])
                    ->orderBy('schedule_id','asc')
                    ->orderBy('sort','asc')
                    ->sharedLock()
                    ->get();

                $users=User::select(['id','dept_id','role_id'])->whereIn('id',$user_ids)->sharedLock()->get();

                if(blank($processes) || blank($users)){
                    throw new \Exception('数据异常',404404);
                }

                $data=[];
                foreach ($processes as $process){
                    if(!isset($itemusers[$process->id])){
                        throw new \Exception('请为项目流程【'.$process->name.'】添加人员',404404);
                        break;
                    }
                    if(blank($itemusers[$process->id])){
                        throw new \Exception('请为项目流程【'.$process->name.'】添加人员',404404);
                        break;
                    }
                    $pre_data=[];
                    foreach ($users as $user){
                        if(in_array($user->id,$itemusers[$process->id])){
                            $pre_data=[
                                'item_id'=>$item_id,
                                'schedule_id'=>$process->schedule_id,
                                'process_id'=>$process->id,
                                'menu_id'=>$process->menu_id,
                                'dept_id'=>$user->dept_id,
                                'role_id'=>$user->role_id,
                                'user_id'=>$user->id,
                                'created_at'=>date('Y-m-d H:i:s'),
                                'updated_at'=>date('Y-m-d H:i:s'),
                            ];
                            $data[]=$pre_data;
                        }
                    }
                    if(blank($pre_data)){
                        throw new \Exception('请为项目流程【'.$process->name.'】添加人员',404404);
                        break;
                    }
                }

                /* ++++++++++ 批量添加 ++++++++++ */
                $field=['item_id','schedule_id','process_id','menu_id','dept_id','role_id', 'user_id','created_at','updated_at'];
                $sqls=batch_update_or_insert_sql('item_user',$field,$data,$field);
                if(!$sqls){
                    throw new \Exception('数据错误',404404);
                }
                foreach ($sqls as $sql){
                    DB::statement($sql);
                }

                $code='success';
                $msg='保存成功';
                $sdata=null;
                $edata=null;
                $url=route('g_itemuser');

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'保存失败';
                $sdata=null;
                $edata=null;
                $url=null;

                DB::rollBack();
            }
            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }

    /* ========== 调整项目人员 ========== */
    public function edit(Request $request){
        $item_id=1;
        $process_id=$request->input('process_id');
        if(!$process_id){
            $result=['code'=>'error','message'=>'请先选择数据','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }
        if($request->isMethod('get')){
            $where[]=['item_id',$item_id];
            $where[]=['process_id',$process_id];
            DB::beginTransaction();
            $process=Process::with(['schedule'=>function($query){
                $query->select(['id','name']);
            }])
                ->select(['id','schedule_id','name'])
                ->sharedLock()
                ->find($process_id);

            $depts=Dept::select(['id','name'])->sharedLock()->get();

            $itemusers=Itemuser::with(['dept'=>function($query){
                $query->select(['id','name']);
            },'role'=>function($query){
                $query->select(['id','name']);
            },'user'=>function($query){
                $query->select(['id','name']);
            }])
                ->where($where)
                ->sharedLock()
                ->get();
            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($itemusers)){
                $code='error';
                $msg='数据不存在';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='gov.error';
            }else{
                $code='success';
                $msg='查询成功';
                $sdata=$itemusers;
                $edata=['depts'=>$depts,'process'=>$process];
                $url=null;

                $view='gov.itemuser.edit';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else{
            $user_id=$request->input('user_id');
            if(blank($user_id)){
                $result=['code'=>'error','message'=>'请先选择项目人员','sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            DB::beginTransaction();
            try{
                /* ++++++++++ 锁定数据模型 ++++++++++ */
                $where[]=['item_id',$item_id];
                $where[]=['process_id',$process_id];
                $where[]=['user_id',$user_id];
                $itemuser=Itemuser::withTrashed()->where($where)->lockForUpdate()->first();
                if(blank($itemuser)){
                    $process=Process::select(['id','schedule_id','name','menu_id','sort'])
                        ->sharedLock()
                        ->find($process_id);
                    $user=User::select(['id','dept_id','role_id'])->sharedLock()->find($user_id);

                    $pre_data=[
                        'item_id'=>$item_id,
                        'schedule_id'=>$process->schedule_id,
                        'process_id'=>$process->id,
                        'menu_id'=>$process->menu_id,
                        'dept_id'=>$user->dept_id,
                        'role_id'=>$user->role_id,
                        'user_id'=>$user->id,
                    ];
                    $itemuser=Itemuser::firstOrCreate($pre_data);
                }else{
                    if($itemuser->trashed()){
                        $itemuser->restore();
                    }
                }

                $code='success';
                $msg='保存成功';
                $sdata=$itemuser;
                $edata=null;
                $url=null;

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'保存失败';
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

    /* ========== 删除项目人员 ========== */
    public function del(Request $request){
        $id=$request->input('id');
        if(!$id){
            $result=['code'=>'error','message'=>'请先选择数据','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }
        DB::beginTransaction();
        try{
            /* ++++++++++ 锁定数据模型 ++++++++++ */
            $itemuser=Itemuser::lockForUpdate()->find($id);
            if(blank($itemuser)){
                throw new \Exception('数据不存在',404404);
            }
            $where=[
                ['item_id',$itemuser->item_id],
                ['process_id',$itemuser->process_id],
            ];
            $count=Itemuser::where($where)->sharedLock()->count();
            if($count<=1){
                throw new \Exception('每个流程至少需要一名工作人员',404404);
            }
            $itemuser->delete();

            $code='success';
            $msg='保存成功';
            $sdata=$itemuser;
            $edata=null;
            $url=null;

            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'保存失败';
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