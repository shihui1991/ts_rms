<?php
/*
|--------------------------------------------------------------------------
| 项目-时间规划
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use App\Http\Model\Item;
use App\Http\Model\Itemtime;
use App\Http\Model\Process;
use App\Http\Model\Schedule;
use App\Http\Model\Worknotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemtimeController extends BaseitemController
{
    /* ========== 初始化 ========== */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 时间规划 ========== */
    public function index(Request $request){
        /* ********** 查询 ********** */
        DB::beginTransaction();
        $itemtimes=Schedule::with(['itemtime'=>function($query){
            $query->where('item_id',$this->item_id);
        }])
            ->orderBy('sort','asc')
            ->sharedLock()
            ->get();

        DB::commit();

        /* ++++++++++ 结果 ++++++++++ */
        $result=['code'=>'success','message'=>'请求成功','sdata'=>['itemtimes'=>$itemtimes,'item'=>$this->item],'edata'=>null,'url'=>null];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view('gov.itemtime.index')->with($result);
        }
    }

    /* ========== 添加时间规划 ========== */
    public function add(Request $request){
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
//                $result=$this->checkNotice();
//                $process=$result['process'];
//                $worknotice=$result['worknotice'];

                $count=Itemtime::where('item_id',$this->item_id)->count();
                if($count){
                    throw new \Exception('项目时间规划已添加',404404);
                }
                /* ++++++++++ 获取全部进度 ++++++++++ */
                $schedules=Schedule::select(['id','name','sort'])
                    ->orderBy('sort','asc')
                    ->sharedLock()
                    ->get();
                if(blank($schedules)){
                    throw new \Exception('数据错误',404404);
                }

                $code='success';
                $msg='查询成功';
                $sdata=['schedules'=>$schedules,'item'=>$this->item];
                $edata=null;
                $url=null;

                $view='gov.itemtime.add';
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络错误';
                $sdata=null;
                $edata=null;
                $url=null;

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
        /* ********** 保存 ********** */
        else{
            DB::beginTransaction();
            try{
//                $result=$this->checkNotice();
//                $process=$result['process'];
//                $worknotice=$result['worknotice'];
//
//                $worknotice->code='1';
//                $worknotice->save();

                $count=Itemtime::where('item_id',$this->item_id)->count();
                if($count){
                    throw new \Exception('项目时间规划已添加',404404);
                }
                $values=[];
                $schedules=Schedule::sharedLock()->select(['id','name','sort'])->orderBy('sort','asc')->get();
                if(blank($schedules)){
                    throw new \Exception('数据错误',404404);
                }
                $datas=$request->input('data');
                foreach($schedules as $schedule){
                    if(!is_array($datas) || !isset($datas[$schedule->id]) || !isset($datas[$schedule->id]['start_at']) || !isset($datas[$schedule->id]['end_at'])){
                        throw new \Exception('时间数据必须填写',404404);
                    }
                    if(blank($datas[$schedule->id]['start_at'])){
                        throw new \Exception('请输入【'.$schedule->name.'】的起始时间',404404);
                    }
                    if(blank($datas[$schedule->id]['end_at'])){
                        throw new \Exception('请输入【'.$schedule->name.'】的结束时间',404404);
                    }
                    if($datas[$schedule->id]['start_at']>=$datas[$schedule->id]['end_at']){
                        throw new \Exception('【'.$schedule->name.'】的结束时间必须大于起始时间',404404);
                    }
                    $values[]=[
                        'item_id'=>$this->item_id,
                        'schedule_id'=>$schedule->id,
                        'start_at'=>$datas[$schedule->id]['start_at'],
                        'end_at'=>$datas[$schedule->id]['end_at'],
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ];
                }
                $field=['item_id','schedule_id','start_at','end_at','created_at','updated_at'];
                $sqls=batch_update_or_insert_sql('item_time',$field,$values,'updated_at');
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
                $url=route('g_itemtime',['item'=>$this->item_id]);

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

    /* ========== 修改规划 ========== */
    public function edit(Request $request){
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
//                $this->checkNotice();

                $itemtimes=Itemtime::with(['schedule'=>function($query){
                    $query->select(['id','name']);
                }])
                    ->sharedLock()
                    ->where('item_id',$this->item_id)
                    ->get();
                if(blank($itemtimes)){
                    throw new \Exception('项目时间规划还未添加',404404);
                }

                $code='success';
                $msg='查询成功';
                $sdata=['itemtimes'=>$itemtimes,'item'=>$this->item];
                $edata=null;
                $url=null;

                $view='gov.itemtime.edit';
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'保存失败';
                $sdata=null;
                $edata=null;
                $url=null;

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
        /* ********** 保存 ********** */
        else {
            DB::beginTransaction();
            try {
//                $result = $this->checkNotice();
//                $process = $result['process'];
//                $worknotice = $result['worknotice'];

                $values = [];
                $schedules = Schedule::sharedLock()->select(['id', 'name', 'sort'])->orderBy('sort', 'asc')->get();
                if (blank($schedules)) {
                    throw new \Exception('数据错误', 404404);
                }
                $datas = $request->input('data');
                foreach ($schedules as $schedule) {
                    if (!is_array($datas) || !isset($datas[$schedule->id]) || !isset($datas[$schedule->id]['start_at']) || !isset($datas[$schedule->id]['end_at'])|| !isset($datas[$schedule->id]['id'])) {
                        throw new \Exception('时间数据必须填写', 404404);
                    }
                    if (blank($datas[$schedule->id]['start_at'])) {
                        throw new \Exception('请输入【' . $schedule->name . '】的起始时间', 404404);
                    }
                    if (blank($datas[$schedule->id]['end_at'])) {
                        throw new \Exception('请输入【' . $schedule->name . '】的结束时间', 404404);
                    }
                    if ($datas[$schedule->id]['start_at'] >= $datas[$schedule->id]['end_at']) {
                        throw new \Exception('【' . $schedule->name . '】的结束时间必须大于起始时间', 404404);
                    }
                    $values[] = [
                        'id' => $datas[$schedule->id]['id'],
                        'item_id' => $this->item_id,
                        'schedule_id' => $schedule->id,
                        'start_at' => $datas[$schedule->id]['start_at'],
                        'end_at' => $datas[$schedule->id]['end_at'],
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                }
                $int_field = ['id','item_id', 'schedule_id', 'start_at', 'end_at', 'updated_at'];
                $upd_field = ['start_at', 'end_at', 'updated_at'];
                $sqls = batch_update_sql('item_time', $int_field, $values, $upd_field,'id');
                if (!$sqls) {
                    throw new \Exception('数据错误', 404404);
                }
                foreach ($sqls as $sql) {
                    DB::statement($sql);
                }

//                $worknotice->code='1';
//                $worknotice->save();

                $code = 'success';
                $msg = '修改成功';
                $sdata = null;
                $edata = null;
                $url = route('g_itemtime', ['item' => $this->item_id]);

                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '修改失败';
                $sdata = null;
                $edata = null;
                $url = null;

                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result = ['code' => $code, 'message' => $msg, 'sdata' => $sdata, 'edata' => $edata, 'url' => $url];
            return response()->json($result);
        }
    }

    /* ========== 检查是否存在工作推送 ========== */
    public function checkNotice(){
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
            ->whereIn('code',['0','1'])
            ->first();
        if(blank($worknotice)){
            throw new \Exception('您没有执行此操作的权限',404404);
        }

        return ['process'=>$process,'worknotice'=>$worknotice];
    }
}