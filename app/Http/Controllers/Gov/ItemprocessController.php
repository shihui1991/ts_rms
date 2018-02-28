<?php
/*
|--------------------------------------------------------------------------
| 项目流程
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use App\Http\Model\Filecate;
use App\Http\Model\Filetable;
use App\Http\Model\Item;
use App\Http\Model\Itemadmin;
use App\Http\Model\Itemnotice;
use App\Http\Model\Itemtime;
use App\Http\Model\Itemuser;
use App\Http\Model\Process;
use App\Http\Model\Schedule;
use App\Http\Model\Worknotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemprocessController extends BaseitemController
{
    /* ========== 初始化 ========== */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 项目进度 ========== */
    public function index(Request $request){
        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $schedules=Schedule::with(['worknotices'=>function($query){
                $query->with(['process'=>function($query){
                    $query->select(['id','name','type']);
                },'dept'=>function($query){
                    $query->select(['id','name']);
                },'role'=>function($query){
                    $query->select(['id','name']);
                },'user'=>function($query){
                    $query->select(['id','name']);
                },'state'=>function($query){
                    $query->select(['code','name']);
                }])
                    ->where('item_id',$this->item_id)
                    ->whereNotIn('code',['0','20'])
                    ->orderBy('updated_at','desc')
                    ->orderBy('id','desc');
            }])
                ->orderBy('sort','asc')
                ->sharedLock()
                ->get();

            /* ++++++++++ 工作提醒 ++++++++++ */
            $worknotices=Worknotice::with(['process'=>function($query){
                $query->select(['id','name']);
            }])
                ->where('item_id',$this->item_id)
                ->where('user_id',session('gov_user.user_id'))
                ->whereIn('code',['0','20'])
                ->sharedLock()
                ->get();
            if(blank($schedules)){
                throw new \Exception('没有符合条件的数据',404404);
            }

            $code='success';
            $msg='查询成功';
            $sdata=['schedules'=>$schedules,'worknotices'=>$worknotices];
            $edata=null;
            $url=null;
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=null;
            $url=null;
        }
        DB::commit();

        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.itemprocess.index')->with($result);
        }
    }

    /* ========== 项目审查 - 提交部门审查 ========== */
    public function check_to_dept_check(Request $request){
        DB::beginTransaction();
        try{
            $item=$this->item;

            if(blank($item)){
                throw new \Exception('项目不存在',404404);
            }
            /* ++++++++++ 检查项目状态 ++++++++++ */
            if($item->schedule_id==1 && $item->process_id==2){
                throw new \Exception('当前项目已【'.$item->process->name.'】，不能重复操作',404404);
            }
            if($item->schedule_id!=1 || !in_array($item->process_id,[1,4]) || $item->code != '2'){
                throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
            }
            $result=$this->hasNotice();
            $process=$result['process'];
            $worknotice=$result['worknotice'];
            /* ++++++++++ 执行 ++++++++++ */
            $worknotice->code='2';
            $worknotice->save();
            if(blank($worknotice)){
                throw new \Exception('操作失败',404404);
            }
            /* ++++++++++ 删除相同工作推送 ++++++++++ */
            Worknotice::lockForUpdate()
                ->where([
                    ['item_id',$item->id],
                    ['schedule_id',$process->schedule_id],
                    ['process_id',$process->id],
                    ['menu_id',$process->menu_id],
                    ['code','0'],
                ])
                ->delete();

            /* ++++++++++ 部门审查 可操作人员 ++++++++++ */
            $process=Process::with(['processusers'=>function($query){
                $query->with('role');
            }])
                ->select(['id','schedule_id','menu_id'])
                ->find(3);
            $values=[];
            /* ++++++++++ 部门审查 工作提醒推送 ++++++++++ */
            foreach ($process->processusers as $user){
                $values[]=[
                    'item_id'=>$item->id,
                    'schedule_id'=>$process->schedule_id,
                    'process_id'=>$process->id,
                    'menu_id'=>$process->menu_id,
                    'dept_id'=>$user->dept_id,
                    'parent_id'=>$user->role->parent_id,
                    'role_id'=>$user->role_id,
                    'user_id'=>$user->id,
                    'url'=>route('g_itemprocess_cdc',['item'=>$this->item->id]),
                    'code'=>'20',
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                ];
            }

            $field=['item_id','schedule_id','process_id','menu_id','dept_id','parent_id','role_id','user_id','url','code','created_at','updated_at'];
            $sqls=batch_update_or_insert_sql('item_work_notice',$field,$values,'updated_at');
            if(!$sqls){
                throw new \Exception('操作失败',404404);
            }
            foreach ($sqls as $sql){
                DB::statement($sql);
            }

            $item->schedule_id=$worknotice->schedule_id;
            $item->process_id=$worknotice->process_id;
            $item->code=$worknotice->code;
            $item->save();
            
            $code='success';
            $msg='操作成功';
            $sdata=null;
            $edata=null;
            $url=route('g_itemprocess',['item'=>$this->item->id]);
            
            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'操作失败';
            $sdata=null;
            $edata=null;
            $url=null;
            
            DB::rollBack();
        }

        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if(request()->ajax()){
            return response()->json($result);
        }else{
            return view('gov.error')->with($result);
        }
    }

    /* ========== 项目审查 - 部门审查 ========== */
    public function check_dept_check(Request $request){
        if($request->isMethod('get')){
            /* ********** 查询 ********** */
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=1 || !in_array($item->process_id,[2,3])){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                if($item->process_id==2 && $item->code=='1'){
                    throw new \Exception('当前项目未完成【'.$item->process->name.'】，不能进行当前操作',404404);
                }
                if($item->process_id==3 && $item->code=='22'){
                    throw new \Exception('当前项目已完成【'.$item->process->name.'】，不能重复操作',404404);
                }
                if($item->process_id==3 && $item->code=='23'){
                    throw new \Exception('当前项目【'.$item->process->name.' - '.$item->state->name.'】，不能进行当前操作',404404);
                }

                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];

                /* ++++++++++ 更新项目状态 ++++++++++ */
                $item->schedule_id=$worknotice->schedule_id;
                $item->process_id=$worknotice->process_id;
                $item->code='21';
                $item->save();

                $file_table_id=Filetable::where('name','item')->sharedLock()->value('id');
                $file_cates=Filecate::where('file_table_id',$file_table_id)->sharedLock()->pluck('name','filename');

                $worknotices=Worknotice::with(['process'=>function($query){
                    $query->select(['id','name','type']);
                },'dept'=>function($query){
                    $query->select(['id','name']);
                },'role'=>function($query){
                    $query->select(['id','name']);
                },'user'=>function($query){
                    $query->select(['id','name']);
                },'state'=>function($query){
                    $query->select(['code','name']);
                }])
                    ->where('item_id',$this->item_id)
                    ->where('schedule_id',$process->schedule_id)
                    ->whereNotIn('code',['0','20'])
                    ->orderBy('updated_at','desc')
                    ->orderBy('id','desc')
                    ->sharedLock()
                    ->get();

                $code='success';
                $msg='查询成功';
                $sdata=['item'=>$item,'file_cates'=>$file_cates,'worknotices'=>$worknotices];
                $edata=null;
                $url=null;

                $view='gov.itemprocess.check.dept_check';
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='gov.error';
            }
            DB::commit();

            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }
        /* ********** 审查结果 ********** */
        else{
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=1 || !in_array($item->process_id,[2,3])){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                if($item->process_id==2 && $item->code=='1'){
                    throw new \Exception('当前项目未完成【'.$item->process->name.'】，不能进行当前操作',404404);
                }
                if($item->process_id==3 && $item->code=='22'){
                    throw new \Exception('当前项目已完成【'.$item->process->name.'】，不能重复操作',404404);
                }
                if($item->process_id==3 && $item->code=='23'){
                    throw new \Exception('当前项目【'.$item->process->name.' - '.$item->state->name.'】，不能进行当前操作',404404);
                }

                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];

                /* ++++++++++ 表单验证 ++++++++++ */
                $rules=[
                    'code'=>'required|in:22,23',
                    'infos'=>'required',
                ];
                $messages=[
                    'code.required'=>'请选择审查结果',
                    'code.in'=>'请选择正确的审查结果',
                    'infos.required'=>'请填写审查意见',
                ];
                $validator = Validator::make($request->all(),$rules,$messages);
                if($validator->fails()){
                    throw new \Exception($validator->errors()->first(),404404);
                }
                $code=$request->input('code');

                /* ++++++++++ 执行 ++++++++++ */
                $worknotice->fill($request->input());
                $worknotice->code=$code;
                $worknotice->save();
                if(blank($worknotice)){
                    throw new \Exception('操作失败',404404);
                }
                /* ++++++++++ 审查通过 ++++++++++ */
                if($code=='22'){
                    /* ++++++++++ 同级完成数 ++++++++++ */
                    $worknotice_sames=Worknotice::sharedLock()
                        ->where([
                            ['item_id',$item->id],
                            ['schedule_id',$process->schedule_id],
                            ['process_id',$process->id],
                            ['menu_id',$process->menu_id],
                            ['parent_id',$worknotice->parent_id],
                            ['code','22'],
                        ])
                        ->count();
                    /* ++++++++++ 同级完成数达到限制 ++++++++++ */
                    if($worknotice_sames==$process->number){
                        /* ++++++++++ 删除同级工作推送 ++++++++++ */
                        Worknotice::lockForUpdate()
                            ->where([
                                ['item_id',$item->id],
                                ['schedule_id',$process->schedule_id],
                                ['process_id',$process->id],
                                ['menu_id',$process->menu_id],
                                ['parent_id',$worknotice->parent_id],
                                ['code','20'],
                            ])
                            ->delete();

                        /* ++++++++++ 是否存在上级 ++++++++++ */
                        $worknotice_par=Worknotice::sharedLock()
                            ->where([
                                ['item_id',$item->id],
                                ['schedule_id',$process->schedule_id],
                                ['process_id',$process->id],
                                ['menu_id',$process->menu_id],
                                ['role_id',$worknotice->parent_id],
                                ['code','20'],
                            ])
                            ->count();
                        /* ++++++++++ 存在上级 ++++++++++ */
                        if($worknotice_par){
                            $item->schedule_id=$worknotice->schedule_id;
                            $item->process_id=$worknotice->process_id;
                            $item->code='21';
                        }else{
                            /* ++++++++++ 提交区政府审查 可操作人员 ++++++++++ */
                            $process=Process::with(['processusers'=>function($query){
                                $query->with('role');
                            }])
                                ->select(['id','schedule_id','menu_id'])
                                ->find(6);
                            $values=[];
                            /* ++++++++++ 提交区政府审查 工作提醒推送 ++++++++++ */
                            foreach ($process->processusers as $user){
                                $values[]=[
                                    'item_id'=>$item->id,
                                    'schedule_id'=>$process->schedule_id,
                                    'process_id'=>$process->id,
                                    'menu_id'=>$process->menu_id,
                                    'dept_id'=>$user->dept_id,
                                    'parent_id'=>$user->role->parent_id,
                                    'role_id'=>$user->role_id,
                                    'user_id'=>$user->id,
                                    'url'=>route('g_iteminfo_info',['item'=>$this->item->id]),
                                    'code'=>'0',
                                    'created_at'=>date('Y-m-d H:i:s'),
                                    'updated_at'=>date('Y-m-d H:i:s'),
                                ];
                            }

                            $field=['item_id','schedule_id','process_id','menu_id','dept_id','parent_id','role_id','user_id','url','code','created_at','updated_at'];
                            $sqls=batch_update_or_insert_sql('item_work_notice',$field,$values,'updated_at');
                            if(!$sqls){
                                throw new \Exception('操作失败',404404);
                            }
                            foreach ($sqls as $sql){
                                DB::statement($sql);
                            }

                            $item->schedule_id=$worknotice->schedule_id;
                            $item->process_id=$worknotice->process_id;
                            $item->code=$worknotice->code;
                        }
                    }
                    /* ++++++++++ 同级完成数未达限制 ++++++++++ */
                    else{
                        $item->schedule_id=$worknotice->schedule_id;
                        $item->process_id=$worknotice->process_id;
                        $item->code='21';
                    }
                }
                /* ++++++++++ 审查驳回 ++++++++++ */
                else{
                    /* ++++++++++ 删除相同工作推送 ++++++++++ */
                    Worknotice::lockForUpdate()
                        ->where([
                            ['item_id',$item->id],
                            ['schedule_id',$process->schedule_id],
                            ['process_id',$process->id],
                            ['menu_id',$process->menu_id],
                            ['code','20'],
                        ])
                        ->delete();

                    /* ++++++++++ 审查驳回处理 可操作人员 ++++++++++ */
                    $process=Process::with(['processusers'=>function($query){
                        $query->with('role');
                    }])
                        ->select(['id','schedule_id','menu_id'])
                        ->find(5);
                    $values=[];
                    /* ++++++++++ 审查驳回处理 工作提醒推送 ++++++++++ */
                    foreach ($process->processusers as $user){
                        $values[]=[
                            'item_id'=>$item->id,
                            'schedule_id'=>$process->schedule_id,
                            'process_id'=>$process->id,
                            'menu_id'=>$process->menu_id,
                            'dept_id'=>$user->dept_id,
                            'parent_id'=>$user->role->parent_id,
                            'role_id'=>$user->role_id,
                            'user_id'=>$user->id,
                            'url'=>route('g_itemprocess_crb',['item'=>$this->item->id]),
                            'code'=>'0',
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s'),
                        ];
                    }

                    $field=['item_id','schedule_id','process_id','menu_id','dept_id','parent_id','role_id','user_id','url','code','created_at','updated_at'];
                    $sqls=batch_update_or_insert_sql('item_work_notice',$field,$values,'updated_at');
                    if(!$sqls){
                        throw new \Exception('操作失败',404404);
                    }
                    foreach ($sqls as $sql){
                        DB::statement($sql);
                    }

                    $item->schedule_id=$worknotice->schedule_id;
                    $item->process_id=$worknotice->process_id;
                    $item->code=$worknotice->code;
                }

                $item->save();

                $code='success';
                $msg='操作成功';
                $sdata=null;
                $edata=null;
                $url=route('g_itemprocess',['item'=>$this->item->id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
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

    /* ========== 项目审查 - 审查驳回处理 ========== */
    public function check_roll_back(Request $request){
        if($request->isMethod('get')){
            /* ********** 查询 ********** */
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=1 || !in_array($item->process_id,[3,7,5])){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                if((in_array($item->process_id,[3,7]) && $item->code!='23') || ($item->process_id==5 && $item->code=='2')){
                    throw new \Exception('当前项目处于【'.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }

                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];

                /* ++++++++++ 更新项目状态 ++++++++++ */
                $item->schedule_id=$worknotice->schedule_id;
                $item->process_id=$worknotice->process_id;
                $item->code='1';
                $item->save();

                $worknotices=Worknotice::with(['process'=>function($query){
                    $query->select(['id','name','type']);
                },'dept'=>function($query){
                    $query->select(['id','name']);
                },'role'=>function($query){
                    $query->select(['id','name']);
                },'user'=>function($query){
                    $query->select(['id','name']);
                },'state'=>function($query){
                    $query->select(['code','name']);
                }])
                    ->where('item_id',$this->item_id)
                    ->where('schedule_id',$process->schedule_id)
                    ->whereNotIn('code',['0','20'])
                    ->orderBy('updated_at','desc')
                    ->orderBy('id','desc')
                    ->sharedLock()
                    ->get();

                $code='success';
                $msg='查询成功';
                $sdata=['item'=>$item,'worknotices'=>$worknotices];
                $edata=null;
                $url=null;

                $view='gov.itemprocess.check.roll_back';
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='gov.error';
            }
            DB::commit();

            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }
        /* ++++++++++ 处理结果 ++++++++++ */
        else{
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=1 || !in_array($item->process_id,[3,7,5])){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                if((in_array($item->process_id,[3,7]) && $item->code!='23') || ($item->process_id==5 && $item->code=='2')){
                    throw new \Exception('当前项目处于【'.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }

                $way=$request->input('way');
                if(blank($way) || !in_array($way,[0,1])){
                    throw new \Exception('请选择审查驳回处理方式',404404);
                }

                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];
                /* ++++++++++ 更新操作 ++++++++++ */
                $worknotice->code='2';
                $worknotice->save();
                if(blank($worknotice)){
                    throw new \Exception('操作失败',404404);
                }
                /* ++++++++++ 删除相同工作推送 ++++++++++ */
                Worknotice::lockForUpdate()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$process->schedule_id],
                        ['process_id',$process->id],
                        ['menu_id',$process->menu_id],
                        ['code','0'],
                    ])
                    ->delete();

                $values=[];
                /* ++++++++++ 处理方式 不予受理 ++++++++++ */
                if($way){
                    /* ++++++++++ 不予受理 可操作人员 ++++++++++ */
                    $process=Process::with(['processusers'=>function($query){
                        $query->with('role');
                    }])
                        ->select(['id','schedule_id','menu_id'])
                        ->find(15);
                    /* ++++++++++ 不予受理 工作提醒推送 ++++++++++ */
                    foreach ($process->processusers as $user){
                        $values[]=[
                            'item_id'=>$item->id,
                            'schedule_id'=>$process->schedule_id,
                            'process_id'=>$process->id,
                            'menu_id'=>$process->menu_id,
                            'dept_id'=>$user->dept_id,
                            'parent_id'=>$user->role->parent_id,
                            'role_id'=>$user->role_id,
                            'user_id'=>$user->id,
                            'url'=>route('g_itemprocess_stop',['item'=>$this->item->id]),
                            'code'=>'0',
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s'),
                        ];
                    }
                }
                /* ++++++++++ 处理方式 重新提交审查资料 ++++++++++ */
                else{
                    /* ++++++++++ 重新提交审查资料 可操作人员 ++++++++++ */
                    $process=Process::with(['processusers'=>function($query){
                        $query->with('role');
                    }])
                        ->select(['id','schedule_id','menu_id'])
                        ->find(4);
                    /* ++++++++++ 重新提交审查资料 工作提醒推送 ++++++++++ */
                    foreach ($process->processusers as $user){
                        $values[]=[
                            'item_id'=>$item->id,
                            'schedule_id'=>$process->schedule_id,
                            'process_id'=>$process->id,
                            'menu_id'=>$process->menu_id,
                            'dept_id'=>$user->dept_id,
                            'parent_id'=>$user->role->parent_id,
                            'role_id'=>$user->role_id,
                            'user_id'=>$user->id,
                            'url'=>route('g_itemprocess_retry',['item'=>$this->item->id]),
                            'code'=>'0',
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s'),
                        ];
                    }
                }

                $field=['item_id','schedule_id','process_id','menu_id','dept_id','parent_id','role_id','user_id','url','code','created_at','updated_at'];
                $sqls=batch_update_or_insert_sql('item_work_notice',$field,$values,'updated_at');
                if(!$sqls){
                    throw new \Exception('操作失败',404404);
                }
                foreach ($sqls as $sql){
                    DB::statement($sql);
                }

                /* ++++++++++ 更新项目状态 ++++++++++ */
                $item->schedule_id=$worknotice->schedule_id;
                $item->process_id=$worknotice->process_id;
                $item->code=$worknotice->code;
                $item->save();

                $code='success';
                $msg='操作成功';
                $sdata=null;
                $edata=null;
                $url=route('g_itemprocess',['item'=>$this->item->id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
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

    /* ========== 项目审查 - 重新提交审查资料 ========== */
    public function check_iteminfo_retry(Request $request){
        if($request->isMethod('get')){
            /* ********** 查询 ********** */
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=1 || !in_array($item->process_id,[4,5])){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                if(($item->process_id==5 && $item->code=='1') || ($item->process_id==4 && $item->code=='2')){
                    throw new \Exception('当前项目处于【'.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }

                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];

                $file_table_id=Filetable::where('name','item')->sharedLock()->value('id');
                $file_cates=Filecate::where('file_table_id',$file_table_id)->sharedLock()->get();

                /* ++++++++++ 更新项目状态 ++++++++++ */
                $item->schedule_id=$worknotice->schedule_id;
                $item->process_id=$worknotice->process_id;
                $item->code='1';
                $item->save();

                $worknotices=Worknotice::with(['process'=>function($query){
                    $query->select(['id','name','type']);
                },'dept'=>function($query){
                    $query->select(['id','name']);
                },'role'=>function($query){
                    $query->select(['id','name']);
                },'user'=>function($query){
                    $query->select(['id','name']);
                },'state'=>function($query){
                    $query->select(['code','name']);
                }])
                    ->where('item_id',$this->item_id)
                    ->where('schedule_id',$process->schedule_id)
                    ->whereNotIn('code',['0','20'])
                    ->orderBy('updated_at','desc')
                    ->orderBy('id','desc')
                    ->sharedLock()
                    ->get();

                $code='success';
                $msg='查询成功';
                $sdata=['item'=>$item,'file_cates'=>$file_cates,'worknotices'=>$worknotices];
                $edata=null;
                $url=null;

                $view='gov.itemprocess.check.iteminfo_retry';
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='gov.error';
            }
            DB::commit();

            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }
        /* ++++++++++ 处理结果 ++++++++++ */
        else{
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=1 || !in_array($item->process_id,[4,5])){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                if(($item->process_id==5 && $item->code=='1') || ($item->process_id==4 && $item->code=='2')){
                        throw new \Exception('当前项目处于【'.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }

                $model=new Item();
                /* ++++++++++ 表单验证 ++++++++++ */
                $rules=[
                    'name'=>'required|unique:item,name,'.$this->item_id.',id',
                    'place'=>'required',
                    'map'=>'required'
                ];
                $messages=[
                    'required'=>':attribute 为必须项',
                    'unique'=>':attribute 已存在',
                ];
                $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
                if($validator->fails()){
                    throw new \Exception($validator->errors()->first(),404404);
                }

                $file_table_id=Filetable::where('name','item')->sharedLock()->value('id');
                $file_cates=Filecate::where('file_table_id',$file_table_id)->sharedLock()->get();
                $rules=[];
                $messages=[];
                foreach ($file_cates as $file_cate){
                    $name='picture.'.$file_cate->filename;
                    $rules[$name]='required';
                    $messages[$name.'.required']='必须上传【'.$file_cate->name.'】';
                }
                $validator = Validator::make($request->all(),$rules,$messages);
                if($validator->fails()){
                    throw new \Exception($validator->errors()->first(),404404);
                }

                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];
                /* ++++++++++ 更新操作 ++++++++++ */
                $worknotice->code='2';
                $worknotice->save();
                if(blank($worknotice)){
                    throw new \Exception('操作失败',404404);
                }

                /* ++++++++++ 删除相同工作推送 ++++++++++ */
                Worknotice::lockForUpdate()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$process->schedule_id],
                        ['process_id',$process->id],
                        ['menu_id',$process->menu_id],
                        ['code','0'],
                    ])
                    ->delete();

                $values=[];
                /* ++++++++++ 提交部门审查 可操作人员 ++++++++++ */
                $process=Process::with(['processusers'=>function($query){
                    $query->with('role');
                }])
                    ->select(['id','schedule_id','menu_id'])
                    ->find(2);
                /* ++++++++++ 提交部门审查 工作提醒推送 ++++++++++ */
                foreach ($process->processusers as $user){
                    $values[]=[
                        'item_id'=>$item->id,
                        'schedule_id'=>$process->schedule_id,
                        'process_id'=>$process->id,
                        'menu_id'=>$process->menu_id,
                        'dept_id'=>$user->dept_id,
                        'parent_id'=>$user->role->parent_id,
                        'role_id'=>$user->role_id,
                        'user_id'=>$user->id,
                        'url'=>route('g_iteminfo_info',['item'=>$this->item->id]),
                        'code'=>'0',
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ];
                }

                $field=['item_id','schedule_id','process_id','menu_id','dept_id','parent_id','role_id','user_id','url','code','created_at','updated_at'];
                $sqls=batch_update_or_insert_sql('item_work_notice',$field,$values,'updated_at');
                if(!$sqls){
                    throw new \Exception('操作失败',404404);
                }
                foreach ($sqls as $sql){
                    DB::statement($sql);
                }

                $item->fill($request->input());
                /* ++++++++++ 更新项目状态 ++++++++++ */
                $item->schedule_id=$worknotice->schedule_id;
                $item->process_id=$worknotice->process_id;
                $item->code=$worknotice->code;
                $item->save();
                if(blank($item)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='操作成功';
                $sdata=null;
                $edata=null;
                $url=route('g_itemprocess',['item'=>$this->item->id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
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

    /* ========== 项目审查 - 不予受理 ========== */
    public function check_item_stop(Request $request){
        if($request->isMethod('get')){
            /* ********** 查询 ********** */
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=1 || !in_array($item->process_id,[5,15])){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                if(($item->process_id==5 && $item->code=='1') || ($item->process_id==15 && $item->code=='2')){
                    throw new \Exception('当前项目处于【'.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }

                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];

                /* ++++++++++ 更新项目状态 ++++++++++ */
                $item->schedule_id=$worknotice->schedule_id;
                $item->process_id=$worknotice->process_id;
                $item->code='1';
                $item->save();

                $worknotices=Worknotice::with(['process'=>function($query){
                    $query->select(['id','name','type']);
                },'dept'=>function($query){
                    $query->select(['id','name']);
                },'role'=>function($query){
                    $query->select(['id','name']);
                },'user'=>function($query){
                    $query->select(['id','name']);
                },'state'=>function($query){
                    $query->select(['code','name']);
                }])
                    ->where('item_id',$this->item_id)
                    ->where('schedule_id',$process->schedule_id)
                    ->whereNotIn('code',['0','20'])
                    ->orderBy('updated_at','desc')
                    ->orderBy('id','desc')
                    ->sharedLock()
                    ->get();

                $code='success';
                $msg='查询成功';
                $sdata=['item'=>$item,'worknotices'=>$worknotices];
                $edata=null;
                $url=null;

                $view='gov.itemprocess.check.item_stop';
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='gov.error';
            }
            DB::commit();

            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }
        /* ++++++++++ 处理结果 ++++++++++ */
        else{
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=1 || !in_array($item->process_id,[5,15])){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                if(($item->process_id==5 && $item->code=='1') || ($item->process_id==15 && $item->code=='2')){
                    throw new \Exception('当前项目处于【'.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }

                $model=new Itemnotice();
                /* ++++++++++ 表单验证 ++++++++++ */
                $rules=[
                    'infos'=>'required',
                    'picture'=>'required'
                ];
                $messages=[
                    'required'=>':attribute 为必须项',
                ];
                $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
                if($validator->fails()){
                    throw new \Exception($validator->errors()->first(),404404);
                }

                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];
                /* ++++++++++ 更新操作 ++++++++++ */
                $worknotice->code='2';
                $worknotice->save();
                if(blank($worknotice)){
                    throw new \Exception('操作失败',404404);
                }

                /* ++++++++++ 删除相同工作推送 ++++++++++ */
                Worknotice::lockForUpdate()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$process->schedule_id],
                        ['process_id',$process->id],
                        ['menu_id',$process->menu_id],
                        ['code','0'],
                    ])
                    ->delete();

                /* ++++++++++ 保存 ++++++++++ */
                $itemnotice=$model;
                $itemnotice->fill($request->input());
                $itemnotice->item_id=$this->item_id;
                $itemnotice->cate_id=1;
                $itemnotice->save();
                if(blank($itemnotice)){
                    throw new \Exception('保存失败',404404);
                }

                /* ++++++++++ 更新项目状态 ++++++++++ */
                $item->schedule_id=$worknotice->schedule_id;
                $item->process_id=$worknotice->process_id;
                $item->code=$worknotice->code;
                $item->save();
                if(blank($item)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='操作成功';
                $sdata=null;
                $edata=null;
                $url=route('g_itemprocess',['item'=>$this->item->id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
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

    /* ========== 项目审查 - 提交区政府审查 ========== */
    public function check_to_gov_check(Request $request){
        DB::beginTransaction();
        try{
            $item=$this->item;

            if(blank($item)){
                throw new \Exception('项目不存在',404404);
            }
            /* ++++++++++ 检查项目状态 ++++++++++ */
            if($item->schedule_id==1 && $item->process_id==6){
                throw new \Exception('当前项目已【'.$item->process->name.'】，不能重复操作',404404);
            }
            if($item->schedule_id!=1 || $item->process_id!=3 || $item->code != '22'){
                throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
            }
            $result=$this->hasNotice();
            $process=$result['process'];
            $worknotice=$result['worknotice'];
            /* ++++++++++ 执行 ++++++++++ */
            $worknotice->code='2';
            $worknotice->save();
            if(blank($worknotice)){
                throw new \Exception('操作失败',404404);
            }
            /* ++++++++++ 删除相同工作推送 ++++++++++ */
            Worknotice::lockForUpdate()
                ->where([
                    ['item_id',$item->id],
                    ['schedule_id',$process->schedule_id],
                    ['process_id',$process->id],
                    ['menu_id',$process->menu_id],
                    ['code','0'],
                ])
                ->delete();

            /* ++++++++++ 区政府审查 可操作人员 ++++++++++ */
            $process=Process::with(['processusers'=>function($query){
                $query->with('role');
            }])
                ->select(['id','schedule_id','menu_id'])
                ->find(7);
            $values=[];
            /* ++++++++++ 区政府审查 工作提醒推送 ++++++++++ */
            foreach ($process->processusers as $user){
                $values[]=[
                    'item_id'=>$item->id,
                    'schedule_id'=>$process->schedule_id,
                    'process_id'=>$process->id,
                    'menu_id'=>$process->menu_id,
                    'dept_id'=>$user->dept_id,
                    'parent_id'=>$user->role->parent_id,
                    'role_id'=>$user->role_id,
                    'user_id'=>$user->id,
                    'url'=>route('g_itemprocess_cgc',['item'=>$this->item->id]),
                    'code'=>'20',
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                ];
            }

            $field=['item_id','schedule_id','process_id','menu_id','dept_id','parent_id','role_id','user_id','url','code','created_at','updated_at'];
            $sqls=batch_update_or_insert_sql('item_work_notice',$field,$values,'updated_at');
            if(!$sqls){
                throw new \Exception('操作失败',404404);
            }
            foreach ($sqls as $sql){
                DB::statement($sql);
            }

            $item->schedule_id=$worknotice->schedule_id;
            $item->process_id=$worknotice->process_id;
            $item->code=$worknotice->code;
            $item->save();

            $code='success';
            $msg='操作成功';
            $sdata=null;
            $edata=null;
            $url=route('g_itemprocess',['item'=>$this->item->id]);

            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'操作失败';
            $sdata=null;
            $edata=null;
            $url=null;

            DB::rollBack();
        }

        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        return response()->json($result);
    }

    /* ========== 项目审查 - 区政府审查 ========== */
    public function check_gov_check(Request $request){
        if($request->isMethod('get')){
            /* ********** 查询 ********** */
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=1 || !in_array($item->process_id,[6,7])){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                if($item->process_id==7 && $item->code=='22'){
                    throw new \Exception('当前项目已完成【'.$item->process->name.'】，不能重复操作',404404);
                }
                if($item->process_id==7 && $item->code=='23'){
                    throw new \Exception('当前项目【'.$item->process->name.' - '.$item->state->name.'】，不能进行当前操作',404404);
                }

                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];

                /* ++++++++++ 更新项目状态 ++++++++++ */
                $item->schedule_id=$worknotice->schedule_id;
                $item->process_id=$worknotice->process_id;
                $item->code='21';
                $item->save();

                $file_table_id=Filetable::where('name','item')->sharedLock()->value('id');
                $file_cates=Filecate::where('file_table_id',$file_table_id)->sharedLock()->pluck('name','filename');

                $worknotices=Worknotice::with(['process'=>function($query){
                    $query->select(['id','name','type']);
                },'dept'=>function($query){
                    $query->select(['id','name']);
                },'role'=>function($query){
                    $query->select(['id','name']);
                },'user'=>function($query){
                    $query->select(['id','name']);
                },'state'=>function($query){
                    $query->select(['code','name']);
                }])
                    ->where('item_id',$this->item_id)
                    ->where('schedule_id',$process->schedule_id)
                    ->whereNotIn('code',['0','20'])
                    ->orderBy('updated_at','desc')
                    ->orderBy('id','desc')
                    ->sharedLock()
                    ->get();

                $code='success';
                $msg='查询成功';
                $sdata=['item'=>$item,'file_cates'=>$file_cates,'worknotices'=>$worknotices];
                $edata=null;
                $url=null;

                $view='gov.itemprocess.check.gov_check';
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='gov.error';
            }
            DB::commit();

            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }
        /* ********** 审查结果 ********** */
        else{
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=1 || !in_array($item->process_id,[6,7])){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                if($item->process_id==7 && $item->code=='22'){
                    throw new \Exception('当前项目已完成【'.$item->process->name.'】，不能重复操作',404404);
                }
                if($item->process_id==7 && $item->code=='23'){
                    throw new \Exception('当前项目【'.$item->process->name.' - '.$item->state->name.'】，不能进行当前操作',404404);
                }

                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];

                /* ++++++++++ 表单验证 ++++++++++ */
                $rules=[
                    'code'=>'required|in:22,23',
                    'infos'=>'required',
                ];
                $messages=[
                    'code.required'=>'请选择审查结果',
                    'code.in'=>'请选择正确的审查结果',
                    'infos.required'=>'请填写审查意见',
                ];
                $validator = Validator::make($request->all(),$rules,$messages);
                if($validator->fails()){
                    throw new \Exception($validator->errors()->first(),404404);
                }
                $code=$request->input('code');

                /* ++++++++++ 执行 ++++++++++ */
                $worknotice->fill($request->input());
                $worknotice->code=$code;
                $worknotice->save();
                if(blank($worknotice)){
                    throw new \Exception('操作失败',404404);
                }

                /* ++++++++++ 删除相同工作推送 ++++++++++ */
                Worknotice::lockForUpdate()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$process->schedule_id],
                        ['process_id',$process->id],
                        ['menu_id',$process->menu_id],
                        ['code','20'],
                    ])
                    ->delete();
                $values=[];
                /* ++++++++++ 审查通过 ++++++++++ */
                if($code=='22'){
                    /* ++++++++++ 开启项目启动配置 可操作人员 ++++++++++ */
                    $process=Process::with(['processusers'=>function($query){
                        $query->with('role');
                    }])
                        ->select(['id','schedule_id','menu_id'])
                        ->find(8);
                    $values=[];
                    /* ++++++++++ 开启项目启动配置 工作提醒推送 ++++++++++ */
                    foreach ($process->processusers as $user){
                        $values[]=[
                            'item_id'=>$item->id,
                            'schedule_id'=>$process->schedule_id,
                            'process_id'=>$process->id,
                            'menu_id'=>$process->menu_id,
                            'dept_id'=>$user->dept_id,
                            'parent_id'=>$user->role->parent_id,
                            'role_id'=>$user->role_id,
                            'user_id'=>$user->id,
                            'url'=>route('g_itemprocess_css',['item'=>$this->item->id]),
                            'code'=>'0',
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s'),
                        ];
                    }
                }
                /* ++++++++++ 审查驳回 ++++++++++ */
                else{
                    /* ++++++++++ 审查驳回处理 可操作人员 ++++++++++ */
                    $process=Process::with(['processusers'=>function($query){
                        $query->with('role');
                    }])
                        ->select(['id','schedule_id','menu_id'])
                        ->find(5);
                    /* ++++++++++ 审查驳回处理 工作提醒推送 ++++++++++ */
                    foreach ($process->processusers as $user){
                        $values[]=[
                            'item_id'=>$item->id,
                            'schedule_id'=>$process->schedule_id,
                            'process_id'=>$process->id,
                            'menu_id'=>$process->menu_id,
                            'dept_id'=>$user->dept_id,
                            'parent_id'=>$user->role->parent_id,
                            'role_id'=>$user->role_id,
                            'user_id'=>$user->id,
                            'url'=>route('g_itemprocess_crb',['item'=>$this->item->id]),
                            'code'=>'0',
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s'),
                        ];
                    }
                }
                $field=['item_id','schedule_id','process_id','menu_id','dept_id','parent_id','role_id','user_id','url','code','created_at','updated_at'];
                $sqls=batch_update_or_insert_sql('item_work_notice',$field,$values,'updated_at');
                if(!$sqls){
                    throw new \Exception('操作失败',404404);
                }
                foreach ($sqls as $sql){
                    DB::statement($sql);
                }

                $item->schedule_id=$worknotice->schedule_id;
                $item->process_id=$worknotice->process_id;
                $item->code=$worknotice->code;
                $item->save();

                $code='success';
                $msg='操作成功';
                $sdata=null;
                $edata=null;
                $url=route('g_itemprocess',['item'=>$this->item->id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
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

    /* ========== 项目审查 - 开启项目启动配置 ========== */
    public function check_start_set(Request $request){
        if($request->isMethod('get')){
            /* ********** 查询 ********** */
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=1 || $item->process_id!=7 ||  $item->code!='22'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }

                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];

                $worknotices=Worknotice::with(['process'=>function($query){
                    $query->select(['id','name','type']);
                },'dept'=>function($query){
                    $query->select(['id','name']);
                },'role'=>function($query){
                    $query->select(['id','name']);
                },'user'=>function($query){
                    $query->select(['id','name']);
                },'state'=>function($query){
                    $query->select(['code','name']);
                }])
                    ->where('item_id',$this->item_id)
                    ->where('schedule_id',$process->schedule_id)
                    ->whereNotIn('code',['0','20'])
                    ->orderBy('updated_at','desc')
                    ->orderBy('id','desc')
                    ->sharedLock()
                    ->get();

                $code='success';
                $msg='查询成功';
                $sdata=['item'=>$item,'worknotices'=>$worknotices];
                $edata=null;
                $url=null;

                $view='gov.itemprocess.check.start_set';
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='gov.error';
            }
            DB::commit();

            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }
        /* ********** 审查结果 ********** */
        else{
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=1 || $item->process_id!=7 ||  $item->code!='22'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }

                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];

                $worknotice->code='1';
                $worknotice->save();
                if(blank($worknotice)){
                    throw new \Exception('操作失败',404404);
                }

                /* ++++++++++ 删除相同工作推送 ++++++++++ */
                Worknotice::lockForUpdate()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$process->schedule_id],
                        ['process_id',$process->id],
                        ['menu_id',$process->menu_id],
                        ['code','0'],
                    ])
                    ->delete();

                /* ++++++++++ 项目启动配置 可操作人员 ++++++++++ */
                $processes=Process::with(['processusers'=>function($query){
                    $query->with('role');
                }])
                    ->select(['id','schedule_id','menu_id'])
                    ->where('parent_id',8)
                    ->get();
                /* ++++++++++ 项目启动配置 工作提醒推送 ++++++++++ */
                $values=[];
                foreach($processes as $process){
                    switch ($process->id){
                        case 9:
                            $url=route('g_itemuser',['item'=>$this->item->id]);
                            break;
                        case 10:
                            $url=route('g_itemtime',['item'=>$this->item->id]);
                            break;
                        case 16:
                            $url=route('g_itemadmin',['item'=>$this->item->id]);
                            break;
                    }
                    foreach ($process->processusers as $user){
                        $values[]=[
                            'item_id'=>$item->id,
                            'schedule_id'=>$process->schedule_id,
                            'process_id'=>$process->id,
                            'menu_id'=>$process->menu_id,
                            'dept_id'=>$user->dept_id,
                            'parent_id'=>$user->role->parent_id,
                            'role_id'=>$user->role_id,
                            'user_id'=>$user->id,
                            'url'=>$url,
                            'code'=>'0',
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s'),
                        ];
                    }
                }

                $field=['item_id','schedule_id','process_id','menu_id','dept_id','parent_id','role_id','user_id','url','code','created_at','updated_at'];
                $sqls=batch_update_or_insert_sql('item_work_notice',$field,$values,'updated_at');
                if(!$sqls){
                    throw new \Exception('操作失败',404404);
                }
                foreach ($sqls as $sql){
                    DB::statement($sql);
                }

                $item->schedule_id=$worknotice->schedule_id;
                $item->process_id=$worknotice->process_id;
                $item->code=$worknotice->code;
                $item->save();

                $code='success';
                $msg='操作成功';
                $sdata=null;
                $edata=null;
                $url=route('g_itemprocess',['item'=>$this->item->id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
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

    /* ========== 项目审查 - 配置项目负责人 ========== */
    public function check_set_itemadmin(Request $request){
        DB::beginTransaction();
        try{
            $item=$this->item;

            if(blank($item)){
                throw new \Exception('项目不存在',404404);
            }
            /* ++++++++++ 检查项目状态 ++++++++++ */
            if($item->schedule_id!=1 || $item->process_id!=8 ||  $item->code!='1'){
                throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
            }
            /* ++++++++++ 流程设置 ++++++++++ */
            $process=Process::sharedLock()->find(16);
            /* ++++++++++ 是否有工作推送 ++++++++++ */
            $worknotice=Worknotice::lockForUpdate()
                ->where([
                    ['item_id',$this->item->id],
                    ['schedule_id',$process->schedule_id],
                    ['process_id',$process->id],
                    ['menu_id',$process->menu_id],
                    ['user_id',session('gov_user.user_id')],
                ])
                ->whereIn('code',['1'])
                ->first();
            if(blank($worknotice)){
                throw new \Exception('您没有执行此操作的权限',404404);
            }
            $count=Itemadmin::sharedLock()->where('item_id',$this->item->id)->count();
            if(!$count){
                throw new \Exception('项目负责人还未配置，不能提交',404404);
            }
            $worknotice->code='2';
            $worknotice->save();

            if(blank($worknotice)){
                throw new \Exception('操作失败',404404);
            }
            /* ++++++++++ 删除相同工作推送 ++++++++++ */
            Worknotice::lockForUpdate()
                ->where([
                    ['item_id',$item->id],
                    ['schedule_id',$process->schedule_id],
                    ['process_id',$process->id],
                    ['menu_id',$process->menu_id],
                ])
                ->whereIn('code',['0','1'])
                ->delete();

            /* ++++++++++ 配置项目人员 完成数 ++++++++++ */
            $count_user=Worknotice::sharedLock()
                ->where([
                    ['item_id',$item->id],
                    ['schedule_id',$process->schedule_id],
                    ['process_id',9],
                    ['code','2'],
                ])
                ->count();
            /* ++++++++++ 配置项目时间规划 完成数 ++++++++++ */
            $count_time=Worknotice::sharedLock()
                ->where([
                    ['item_id',$item->id],
                    ['schedule_id',$process->schedule_id],
                    ['process_id',10],
                    ['code','2'],
                ])
                ->count();

            if($count_user && $count_time){
                /* ++++++++++ 项目配置提交审查 可操作人员 ++++++++++ */
                $process=Process::with(['processusers'=>function($query){
                    $query->with('role');
                }])
                    ->select(['id','schedule_id','menu_id'])
                    ->find(11);
                $values=[];
                /* ++++++++++ 项目配置提交审查 工作提醒推送 ++++++++++ */
                foreach ($process->processusers as $user){
                    $values[]=[
                        'item_id'=>$item->id,
                        'schedule_id'=>$process->schedule_id,
                        'process_id'=>$process->id,
                        'menu_id'=>$process->menu_id,
                        'dept_id'=>$user->dept_id,
                        'parent_id'=>$user->role->parent_id,
                        'role_id'=>$user->role_id,
                        'user_id'=>$user->id,
                        'url'=>route('g_itemprocess_cs2c',['item'=>$this->item->id]),
                        'code'=>'0',
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ];
                }

                $field=['item_id','schedule_id','process_id','menu_id','dept_id','parent_id','role_id','user_id','url','code','created_at','updated_at'];
                $sqls=batch_update_or_insert_sql('item_work_notice',$field,$values,'updated_at');
                if(!$sqls){
                    throw new \Exception('操作失败',404404);
                }
                foreach ($sqls as $sql){
                    DB::statement($sql);
                }

                $item->schedule_id=$worknotice->schedule_id;
                $item->process_id=8;
                $item->code='2';
                $item->save();
            }

            $code='success';
            $msg='操作成功';
            $sdata=null;
            $edata=null;
            $url=route('g_itemprocess',['item'=>$this->item->id]);

            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'操作失败';
            $sdata=null;
            $edata=null;
            $url=null;

            DB::rollBack();
        }

        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        return response()->json($result);
    }

    /* ========== 项目审查 - 配置项目人员 ========== */
    public function check_set_itemuser(Request $request){
        DB::beginTransaction();
        try{
            $item=$this->item;

            if(blank($item)){
                throw new \Exception('项目不存在',404404);
            }
            /* ++++++++++ 检查项目状态 ++++++++++ */
            if($item->schedule_id!=1 || $item->process_id!=8 ||  $item->code!='1'){
                throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
            }
            /* ++++++++++ 流程设置 ++++++++++ */
            $process=Process::sharedLock()->find(9);
            /* ++++++++++ 是否有工作推送 ++++++++++ */
            $worknotice=Worknotice::lockForUpdate()
                ->where([
                    ['item_id',$this->item->id],
                    ['schedule_id',$process->schedule_id],
                    ['process_id',$process->id],
                    ['menu_id',$process->menu_id],
                    ['user_id',session('gov_user.user_id')],
                ])
                ->whereIn('code',['1'])
                ->first();
            if(blank($worknotice)){
                throw new \Exception('您没有执行此操作的权限',404404);
            }
            $count=Itemuser::sharedLock()->where('item_id',$this->item->id)->count();
            if(!$count){
                throw new \Exception('项目人员还未配置，不能提交',404404);
            }
            $worknotice->code='2';
            $worknotice->save();

            if(blank($worknotice)){
                throw new \Exception('操作失败',404404);
            }
            /* ++++++++++ 删除相同工作推送 ++++++++++ */
            Worknotice::lockForUpdate()
                ->where([
                    ['item_id',$item->id],
                    ['schedule_id',$process->schedule_id],
                    ['process_id',$process->id],
                    ['menu_id',$process->menu_id],
                ])
                ->whereIn('code',['0','1'])
                ->delete();

            /* ++++++++++ 配置项目负责人 完成数 ++++++++++ */
            $count_admin=Worknotice::sharedLock()
                ->where([
                    ['item_id',$item->id],
                    ['schedule_id',$process->schedule_id],
                    ['process_id',16],
                    ['code','2'],
                ])
                ->count();
            /* ++++++++++ 配置项目时间规划 完成数 ++++++++++ */
            $count_time=Worknotice::sharedLock()
                ->where([
                    ['item_id',$item->id],
                    ['schedule_id',$process->schedule_id],
                    ['process_id',10],
                    ['code','2'],
                ])
                ->count();

            if($count_admin && $count_time){
                /* ++++++++++ 项目配置提交审查 可操作人员 ++++++++++ */
                $process=Process::with(['processusers'=>function($query){
                    $query->with('role');
                }])
                    ->select(['id','schedule_id','menu_id'])
                    ->find(11);
                $values=[];
                /* ++++++++++ 项目配置提交审查 工作提醒推送 ++++++++++ */
                foreach ($process->processusers as $user){
                    $values[]=[
                        'item_id'=>$item->id,
                        'schedule_id'=>$process->schedule_id,
                        'process_id'=>$process->id,
                        'menu_id'=>$process->menu_id,
                        'dept_id'=>$user->dept_id,
                        'parent_id'=>$user->role->parent_id,
                        'role_id'=>$user->role_id,
                        'user_id'=>$user->id,
                        'url'=>route('g_itemprocess_cs2c',['item'=>$this->item->id]),
                        'code'=>'0',
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ];
                }

                $field=['item_id','schedule_id','process_id','menu_id','dept_id','parent_id','role_id','user_id','url','code','created_at','updated_at'];
                $sqls=batch_update_or_insert_sql('item_work_notice',$field,$values,'updated_at');
                if(!$sqls){
                    throw new \Exception('操作失败',404404);
                }
                foreach ($sqls as $sql){
                    DB::statement($sql);
                }

                $item->schedule_id=$worknotice->schedule_id;
                $item->process_id=8;
                $item->code='2';
                $item->save();
            }

            $code='success';
            $msg='操作成功';
            $sdata=null;
            $edata=null;
            $url=route('g_itemprocess',['item'=>$this->item->id]);

            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'操作失败';
            $sdata=null;
            $edata=null;
            $url=null;

            DB::rollBack();
        }

        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        return response()->json($result);
    }

    /* ========== 项目审查 - 配置项目时间规划 ========== */
    public function check_set_itemtime(Request $request){
        DB::beginTransaction();
        try{
            $item=$this->item;

            if(blank($item)){
                throw new \Exception('项目不存在',404404);
            }
            /* ++++++++++ 检查项目状态 ++++++++++ */
            if($item->schedule_id!=1 || $item->process_id!=8 ||  $item->code!='1'){
                throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
            }
            /* ++++++++++ 流程设置 ++++++++++ */
            $process=Process::sharedLock()->find(10);
            /* ++++++++++ 是否有工作推送 ++++++++++ */
            $worknotice=Worknotice::lockForUpdate()
                ->where([
                    ['item_id',$this->item->id],
                    ['schedule_id',$process->schedule_id],
                    ['process_id',$process->id],
                    ['menu_id',$process->menu_id],
                    ['user_id',session('gov_user.user_id')],
                ])
                ->whereIn('code',['1'])
                ->first();
            if(blank($worknotice)){
                throw new \Exception('您没有执行此操作的权限',404404);
            }
            $count=Itemtime::sharedLock()->where('item_id',$this->item->id)->count();
            if(!$count){
                throw new \Exception('项目时间规划还未配置，不能提交',404404);
            }
            $worknotice->code='2';
            $worknotice->save();

            if(blank($worknotice)){
                throw new \Exception('操作失败',404404);
            }
            /* ++++++++++ 删除相同工作推送 ++++++++++ */
            Worknotice::lockForUpdate()
                ->where([
                    ['item_id',$item->id],
                    ['schedule_id',$process->schedule_id],
                    ['process_id',$process->id],
                    ['menu_id',$process->menu_id],
                ])
                ->whereIn('code',['0','1'])
                ->delete();

            /* ++++++++++ 配置项目人员 完成数 ++++++++++ */
            $count_user=Worknotice::sharedLock()
                ->where([
                    ['item_id',$item->id],
                    ['schedule_id',$process->schedule_id],
                    ['process_id',9],
                    ['code','2'],
                ])
                ->count();
            /* ++++++++++ 配置项目负责人 完成数 ++++++++++ */
            $count_admin=Worknotice::sharedLock()
                ->where([
                    ['item_id',$item->id],
                    ['schedule_id',$process->schedule_id],
                    ['process_id',16],
                    ['code','2'],
                ])
                ->count();

            if($count_user && $count_admin){
                /* ++++++++++ 项目配置提交审查 可操作人员 ++++++++++ */
                $process=Process::with(['processusers'=>function($query){
                    $query->with('role');
                }])
                    ->select(['id','schedule_id','menu_id'])
                    ->find(11);
                $values=[];
                /* ++++++++++ 项目配置提交审查 工作提醒推送 ++++++++++ */
                foreach ($process->processusers as $user){
                    $values[]=[
                        'item_id'=>$item->id,
                        'schedule_id'=>$process->schedule_id,
                        'process_id'=>$process->id,
                        'menu_id'=>$process->menu_id,
                        'dept_id'=>$user->dept_id,
                        'parent_id'=>$user->role->parent_id,
                        'role_id'=>$user->role_id,
                        'user_id'=>$user->id,
                        'url'=>route('g_itemprocess_cs2c',['item'=>$this->item->id]),
                        'code'=>'0',
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ];
                }

                $field=['item_id','schedule_id','process_id','menu_id','dept_id','parent_id','role_id','user_id','url','code','created_at','updated_at'];
                $sqls=batch_update_or_insert_sql('item_work_notice',$field,$values,'updated_at');
                if(!$sqls){
                    throw new \Exception('操作失败',404404);
                }
                foreach ($sqls as $sql){
                    DB::statement($sql);
                }

                $item->schedule_id=$worknotice->schedule_id;
                $item->process_id=8;
                $item->code='2';
                $item->save();
            }

            $code='success';
            $msg='操作成功';
            $sdata=null;
            $edata=null;
            $url=route('g_itemprocess',['item'=>$this->item->id]);

            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'操作失败';
            $sdata=null;
            $edata=null;
            $url=null;

            DB::rollBack();
        }

        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        return response()->json($result);
    }

    /* ========== 项目审查 - 项目配置提交审查 ========== */
    public function check_set_to_check(Request $request){
        if($request->isMethod('get')){
            /* ********** 查询 ********** */
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=1 || $item->process_id!=8 ||  $item->code!='2'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }

                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];

                $worknotices=Worknotice::with(['process'=>function($query){
                    $query->select(['id','name','type']);
                },'dept'=>function($query){
                    $query->select(['id','name']);
                },'role'=>function($query){
                    $query->select(['id','name']);
                },'user'=>function($query){
                    $query->select(['id','name']);
                },'state'=>function($query){
                    $query->select(['code','name']);
                }])
                    ->where('item_id',$this->item_id)
                    ->where('schedule_id',$process->schedule_id)
                    ->whereNotIn('code',['0','20'])
                    ->orderBy('updated_at','desc')
                    ->orderBy('id','desc')
                    ->sharedLock()
                    ->get();

                $code='success';
                $msg='查询成功';
                $sdata=['item'=>$item,'worknotices'=>$worknotices];
                $edata=null;
                $url=null;

                $view='gov.itemprocess.check.set_to_check';
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='gov.error';
            }
            DB::commit();

            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }
        /* ********** 审查结果 ********** */
        else{
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=1 || $item->process_id!=8 ||  $item->code!='2'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }

                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];

                $worknotice->code='2';
                $worknotice->save();
                if(blank($worknotice)){
                    throw new \Exception('操作失败',404404);
                }

                /* ++++++++++ 删除相同工作推送 ++++++++++ */
                Worknotice::lockForUpdate()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$process->schedule_id],
                        ['process_id',$process->id],
                        ['menu_id',$process->menu_id],
                        ['code','0'],
                    ])
                    ->delete();

                /* ++++++++++ 项目配置审查 可操作人员 ++++++++++ */
                $process=Process::with(['processusers'=>function($query){
                    $query->with('role');
                }])
                    ->select(['id','schedule_id','menu_id'])
                    ->find(12);
                $values=[];
                /* ++++++++++ 项目配置审查 工作提醒推送 ++++++++++ */
                foreach ($process->processusers as $user){
                    $values[]=[
                        'item_id'=>$item->id,
                        'schedule_id'=>$process->schedule_id,
                        'process_id'=>$process->id,
                        'menu_id'=>$process->menu_id,
                        'dept_id'=>$user->dept_id,
                        'parent_id'=>$user->role->parent_id,
                        'role_id'=>$user->role_id,
                        'user_id'=>$user->id,
                        'url'=>route('g_itemprocess_csc',['item'=>$this->item->id]),
                        'code'=>'20',
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ];
                }

                $field=['item_id','schedule_id','process_id','menu_id','dept_id','parent_id','role_id','user_id','url','code','created_at','updated_at'];
                $sqls=batch_update_or_insert_sql('item_work_notice',$field,$values,'updated_at');
                if(!$sqls){
                    throw new \Exception('操作失败',404404);
                }
                foreach ($sqls as $sql){
                    DB::statement($sql);
                }

                $item->schedule_id=$worknotice->schedule_id;
                $item->process_id=$worknotice->process_id;
                $item->code=$worknotice->code;
                $item->save();

                $code='success';
                $msg='操作成功';
                $sdata=null;
                $edata=null;
                $url=route('g_itemprocess',['item'=>$this->item->id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
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

    /* ========== 项目审查 - 项目配置审查 ========== */
    public function check_set_check(Request $request){
        if($request->isMethod('get')){
            /* ********** 查询 ********** */
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=1 || !in_array($item->process_id,[11,12])){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                if($item->process_id==12 && $item->code=='22'){
                    throw new \Exception('当前项目已完成【'.$item->process->name.'】，不能重复操作',404404);
                }
                if(($item->process_id==12 && $item->code=='23') || ($item->process_id==11 && $item->code!='2')){
                    throw new \Exception('当前项目【'.$item->process->name.' - '.$item->state->name.'】，不能进行当前操作',404404);
                }

                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];

                /* ++++++++++ 更新项目状态 ++++++++++ */
                $item->schedule_id=$worknotice->schedule_id;
                $item->process_id=$worknotice->process_id;
                $item->code='21';
                $item->save();

                /* ++++++++++ 工作日志 ++++++++++ */
                $worknotices=Worknotice::with(['process'=>function($query){
                    $query->select(['id','name','type']);
                },'dept'=>function($query){
                    $query->select(['id','name']);
                },'role'=>function($query){
                    $query->select(['id','name']);
                },'user'=>function($query){
                    $query->select(['id','name']);
                },'state'=>function($query){
                    $query->select(['code','name']);
                }])
                    ->where('item_id',$this->item_id)
                    ->where('schedule_id',$process->schedule_id)
                    ->whereNotIn('code',['0','20'])
                    ->orderBy('updated_at','desc')
                    ->orderBy('id','desc')
                    ->sharedLock()
                    ->get();
                /* ++++++++++ 项目人员 ++++++++++ */
                $itemusers=Itemuser::with(['user'=>function($query){
                    $query->select(['id','name']);
                },'dept'=>function($query){
                    $query->select(['id','name']);
                },'role'=>function($query){
                    $query->select(['id','name']);
                }])
                    ->sharedLock()
                    ->get();
                /* ++++++++++ 项目负责人 ++++++++++ */
                $itemadmins=Itemadmin::with(['dept'=>function($query){
                    $query->select(['id','name']);
                },'role'=>function($query){
                    $query->select(['id','name']);
                },'user'=>function($query){
                    $query->select(['id','name']);
                }])
                    ->where('item_id',$this->item_id)
                    ->sharedLock()
                    ->get();
                /* ++++++++++ 项目时间规划 ++++++++++ */
                $itemtimes=Schedule::with(['itemtime'=>function($query){
                    $query->where('item_id',$this->item_id);
                },'processes'=>function($query){
                    $query->select(['id','schedule_id','name'])->orderBy('sort','asc');
                }])
                    ->orderBy('sort','asc')
                    ->sharedLock()
                    ->get();

                $code='success';
                $msg='查询成功';
                $sdata=['item'=>$item,'worknotices'=>$worknotices,'itemusers'=>$itemusers,'itemadmins'=>$itemadmins,'itemtimes'=>$itemtimes];
                $edata=null;
                $url=null;

                $view='gov.itemprocess.check.set_check';
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='gov.error';
            }
            DB::commit();

            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }
        /* ********** 审查结果 ********** */
        else{
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=1 || !in_array($item->process_id,[11,12])){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                if($item->process_id==12 && $item->code=='22'){
                    throw new \Exception('当前项目已完成【'.$item->process->name.'】，不能重复操作',404404);
                }
                if(($item->process_id==12 && $item->code=='23') || ($item->process_id==11 && $item->code!='2')){
                    throw new \Exception('当前项目【'.$item->process->name.' - '.$item->state->name.'】，不能进行当前操作',404404);
                }

                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];

                /* ++++++++++ 表单验证 ++++++++++ */
                $rules=[
                    'code'=>'required|in:22,23',
                    'infos'=>'required',
                ];
                $messages=[
                    'code.required'=>'请选择审查结果',
                    'code.in'=>'请选择正确的审查结果',
                    'infos.required'=>'请填写审查意见',
                ];
                $validator = Validator::make($request->all(),$rules,$messages);
                if($validator->fails()){
                    throw new \Exception($validator->errors()->first(),404404);
                }
                $code=$request->input('code');

                /* ++++++++++ 执行 ++++++++++ */
                $worknotice->fill($request->input());
                $worknotice->code=$code;
                $worknotice->save();
                if(blank($worknotice)){
                    throw new \Exception('操作失败',404404);
                }
                /* ++++++++++ 审查通过 ++++++++++ */
                if($code=='22'){
                    /* ++++++++++ 同级完成数 ++++++++++ */
                    $worknotice_sames=Worknotice::sharedLock()
                        ->where([
                            ['item_id',$item->id],
                            ['schedule_id',$process->schedule_id],
                            ['process_id',$process->id],
                            ['menu_id',$process->menu_id],
                            ['parent_id',$worknotice->parent_id],
                            ['code','22'],
                        ])
                        ->count();
                    /* ++++++++++ 同级完成数达到限制 ++++++++++ */
                    if($worknotice_sames==$process->number){
                        /* ++++++++++ 删除同级工作推送 ++++++++++ */
                        Worknotice::lockForUpdate()
                            ->where([
                                ['item_id',$item->id],
                                ['schedule_id',$process->schedule_id],
                                ['process_id',$process->id],
                                ['menu_id',$process->menu_id],
                                ['parent_id',$worknotice->parent_id],
                                ['code','20'],
                            ])
                            ->delete();

                        /* ++++++++++ 是否存在上级 ++++++++++ */
                        $worknotice_par=Worknotice::sharedLock()
                            ->where([
                                ['item_id',$item->id],
                                ['schedule_id',$process->schedule_id],
                                ['process_id',$process->id],
                                ['menu_id',$process->menu_id],
                                ['role_id',$worknotice->parent_id],
                                ['code','20'],
                            ])
                            ->count();
                        /* ++++++++++ 存在上级 ++++++++++ */
                        if($worknotice_par){
                            $item->schedule_id=$worknotice->schedule_id;
                            $item->process_id=$worknotice->process_id;
                            $item->code='21';
                        }else{
                            /* ++++++++++ 项目启动 可操作人员 ++++++++++ */
                            $process=Process::with(['processusers'=>function($query){
                                $query->with('role');
                            }])
                                ->select(['id','schedule_id','menu_id'])
                                ->find(13);
                            $values=[];
                            /* ++++++++++ 项目启动 工作提醒推送 ++++++++++ */
                            foreach ($process->processusers as $user){
                                $values[]=[
                                    'item_id'=>$item->id,
                                    'schedule_id'=>$process->schedule_id,
                                    'process_id'=>$process->id,
                                    'menu_id'=>$process->menu_id,
                                    'dept_id'=>$user->dept_id,
                                    'parent_id'=>$user->role->parent_id,
                                    'role_id'=>$user->role_id,
                                    'user_id'=>$user->id,
                                    'url'=>route('g_itemprocess_cis',['item'=>$this->item->id]),
                                    'code'=>'0',
                                    'created_at'=>date('Y-m-d H:i:s'),
                                    'updated_at'=>date('Y-m-d H:i:s'),
                                ];
                            }

                            $field=['item_id','schedule_id','process_id','menu_id','dept_id','parent_id','role_id','user_id','url','code','created_at','updated_at'];
                            $sqls=batch_update_or_insert_sql('item_work_notice',$field,$values,'updated_at');
                            if(!$sqls){
                                throw new \Exception('操作失败',404404);
                            }
                            foreach ($sqls as $sql){
                                DB::statement($sql);
                            }

                            $item->schedule_id=$worknotice->schedule_id;
                            $item->process_id=$worknotice->process_id;
                            $item->code=$worknotice->code;
                        }
                    }
                    /* ++++++++++ 同级完成数未达限制 ++++++++++ */
                    else{
                        $item->schedule_id=$worknotice->schedule_id;
                        $item->process_id=$worknotice->process_id;
                        $item->code='21';
                    }
                }
                /* ++++++++++ 审查驳回 ++++++++++ */
                else{
                    /* ++++++++++ 删除相同工作推送 ++++++++++ */
                    Worknotice::lockForUpdate()
                        ->where([
                            ['item_id',$item->id],
                            ['schedule_id',$process->schedule_id],
                            ['process_id',$process->id],
                            ['menu_id',$process->menu_id],
                            ['code','20'],
                        ])
                        ->delete();

                    /* ++++++++++ 项目启动配置 可操作人员 ++++++++++ */
                    $processes=Process::with(['processusers'=>function($query){
                        $query->with('role');
                    }])
                        ->select(['id','schedule_id','menu_id'])
                        ->where('parent_id',8)
                        ->get();
                    /* ++++++++++ 项目启动配置 工作提醒推送 ++++++++++ */
                    $values=[];
                    foreach($processes as $process){
                        switch ($process->id){
                            case 9:
                                $url=route('g_itemuser',['item'=>$this->item->id]);
                                break;
                            case 10:
                                $url=route('g_itemtime',['item'=>$this->item->id]);
                                break;
                            case 16:
                                $url=route('g_itemadmin',['item'=>$this->item->id]);
                                break;
                        }
                        foreach ($process->processusers as $user){
                            $values[]=[
                                'item_id'=>$item->id,
                                'schedule_id'=>$process->schedule_id,
                                'process_id'=>$process->id,
                                'menu_id'=>$process->menu_id,
                                'dept_id'=>$user->dept_id,
                                'parent_id'=>$user->role->parent_id,
                                'role_id'=>$user->role_id,
                                'user_id'=>$user->id,
                                'url'=>$url,
                                'code'=>'0',
                                'created_at'=>date('Y-m-d H:i:s'),
                                'updated_at'=>date('Y-m-d H:i:s'),
                            ];
                        }
                    }

                    $field=['item_id','schedule_id','process_id','menu_id','dept_id','parent_id','role_id','user_id','url','code','created_at','updated_at'];
                    $sqls=batch_update_or_insert_sql('item_work_notice',$field,$values,'updated_at');
                    if(!$sqls){
                        throw new \Exception('操作失败',404404);
                    }
                    foreach ($sqls as $sql){
                        DB::statement($sql);
                    }

                    $item->schedule_id=$worknotice->schedule_id;
                    $item->process_id=8;
                    $item->code='1';
                }

                $item->save();

                $code='success';
                $msg='操作成功';
                $sdata=null;
                $edata=null;
                $url=route('g_itemprocess',['item'=>$this->item->id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
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

    /* ========== 项目审查 - 项目启动 ========== */
    public function check_item_start(Request $request){
        if($request->isMethod('get')){
            /* ********** 查询 ********** */
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=1 || $item->process_id!=12 ||  $item->code!='22'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }

                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];

                $worknotices=Worknotice::with(['process'=>function($query){
                    $query->select(['id','name','type']);
                },'dept'=>function($query){
                    $query->select(['id','name']);
                },'role'=>function($query){
                    $query->select(['id','name']);
                },'user'=>function($query){
                    $query->select(['id','name']);
                },'state'=>function($query){
                    $query->select(['code','name']);
                }])
                    ->where('item_id',$this->item_id)
                    ->where('schedule_id',$process->schedule_id)
                    ->whereNotIn('code',['0','20'])
                    ->orderBy('updated_at','desc')
                    ->orderBy('id','desc')
                    ->sharedLock()
                    ->get();

                $code='success';
                $msg='查询成功';
                $sdata=['item'=>$item,'worknotices'=>$worknotices];
                $edata=null;
                $url=null;

                $view='gov.itemprocess.check.item_start';
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='gov.error';
            }
            DB::commit();

            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }
        /* ********** 审查结果 ********** */
        else{
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=1 || $item->process_id!=12 ||  $item->code!='22'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }

                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];

                $worknotice->code='2';
                $worknotice->save();
                if(blank($worknotice)){
                    throw new \Exception('操作失败',404404);
                }

                /* ++++++++++ 删除相同工作推送 ++++++++++ */
                Worknotice::lockForUpdate()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$process->schedule_id],
                        ['process_id',$process->id],
                        ['menu_id',$process->menu_id],
                        ['code','0'],
                    ])
                    ->delete();

                /* ++++++++++ 项目初步预算 可操作人员 ++++++++++ */
                $itemusers=Itemuser::with(['role'=>function($query){
                    $query->select(['id','parent_id']);
                }])
                    ->where('process_id',14)
                    ->get();
                $values=[];
                /* ++++++++++ 项目初步预算 工作提醒推送 ++++++++++ */
                foreach ($itemusers as $user){
                    $values[]=[
                        'item_id'=>$user->item_id,
                        'schedule_id'=>$user->schedule_id,
                        'process_id'=>$user->process_id,
                        'menu_id'=>$user->menu_id,
                        'dept_id'=>$user->dept_id,
                        'parent_id'=>$user->role->parent_id,
                        'role_id'=>$user->role_id,
                        'user_id'=>$user->user_id,
                        'url'=>route('g_itemprocess_csc',['item'=>$this->item->id]),
                        'code'=>'0',
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ];
                }

                $field=['item_id','schedule_id','process_id','menu_id','dept_id','parent_id','role_id','user_id','url','code','created_at','updated_at'];
                $sqls=batch_update_or_insert_sql('item_work_notice',$field,$values,'updated_at');
                if(!$sqls){
                    throw new \Exception('操作失败',404404);
                }
                foreach ($sqls as $sql){
                    DB::statement($sql);
                }

                $item->schedule_id=$worknotice->schedule_id;
                $item->process_id=$worknotice->process_id;
                $item->code=$worknotice->code;
                $item->save();

                $code='success';
                $msg='操作成功';
                $sdata=null;
                $edata=null;
                $url=route('g_itemprocess',['item'=>$this->item->id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
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
}