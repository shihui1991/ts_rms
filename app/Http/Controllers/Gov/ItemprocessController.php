<?php
/*
|--------------------------------------------------------------------------
| 项目流程
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use App\Http\Model\Item;
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
                    $query->select(['id','name']);
                },'dept'=>function($query){
                    $query->select(['id','name']);
                },'role'=>function($query){
                    $query->select(['id','name']);
                },'user'=>function($query){
                    $query->select(['id','name']);
                }])
                    ->where('item_id',$this->item_id)
                    ->whereNotIn('code',['0','20'])
                    ->orderBy('updated_at','desc')
                    ->orderBy('id','desc');
            }])
                ->orderBy('sort','asc')
                ->sharedLock()
                ->get();
            if(blank($schedules)){
                throw new \Exception('没有符合条件的数据',404404);
            }

            $code='success';
            $msg='查询成功';
            $sdata=$schedules;
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
            /* ++++++++++ 流程设置 ++++++++++ */
            $process=Process::sharedLock()->where('menu_id',session('menu.cur_menu.id'))->first();
            /* ++++++++++ 是否有工作推送 ++++++++++ */
            $worknotice=Worknotice::sharedLock()
                ->where([
                    ['item_id',$item->id],
                    ['schedule_id',$process->schedule_id],
                    ['process_id',$process->id],
                    ['menu_id',$process->menu_id],
                    ['user_id',session('gov_user.user_id')],
                    ['code','0'],
                ])
                ->first();
            if(blank($worknotice)){
                throw new \Exception('您的没有执行此操作的权限',404404);
            }
            /* ++++++++++ 下级未完成数 ++++++++++ */
            $worknotice_subs=Worknotice::sharedLock()
                ->where([
                    ['item_id',$item->id],
                    ['schedule_id',$process->schedule_id],
                    ['process_id',$process->id],
                    ['menu_id',$process->menu_id],
                    ['parent_id',session('gov_user.role_id')],
                    ['code','0'],
                ])
                ->count();
            if($worknotice_subs){
                throw new \Exception('您的下级未完成此操作，您的操作暂时不能被执行',404404);
            }
            /* ++++++++++ 执行 ++++++++++ */
            $worknotice->code='2';
            $worknotice->save();
            if(blank($worknotice)){
                throw new \Exception('操作失败',404404);
            }
            /* ++++++++++ 同级完成数 ++++++++++ */
            $worknotice_sames=Worknotice::sharedLock()
                ->where([
                    ['item_id',$item->id],
                    ['schedule_id',$process->schedule_id],
                    ['process_id',$process->id],
                    ['menu_id',$process->menu_id],
                    ['parent_id',$worknotice->parent_id],
                    ['code','2'],
                ])
                ->count();
            /* ++++++++++ 同级完成数达到限制 ++++++++++ */
            if(($worknotice_sames)==$process->number){
                /* ++++++++++ 删除相同工作推送 ++++++++++ */
                Worknotice::query()->sharedLock()
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
                    ->select(['id','menu_id'])
                    ->find(3);
                $values=[];
                /* ++++++++++ 部门审查 工作提醒推送 ++++++++++ */
                foreach ($process->processusers as $user){
                    $values[]=[
                        'item_id'=>$item->id,
                        'schedule_id'=>1,
                        'process_id'=>3,
                        'menu_id'=>$process->menu_id,
                        'dept_id'=>$user->dept_id,
                        'parent_id'=>$user->role->parent_id,
                        'role_id'=>$user->role_id,
                        'user_id'=>$user->id,
                        'url'=>route('g_itemprocess_cdc',['item'=>$this->item->id]),
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
            /* ++++++++++ 同级完成数未达限制 ++++++++++ */
            else{
                $item->schedule_id=$worknotice->schedule_id;
                $item->process_id=$worknotice->process_id;
                $item->code='1';
            }
            $item->save();
            
            $code='success';
            $msg='操作成功';
            $sdata=null;
            $edata=null;
            $url=null;
            
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
}