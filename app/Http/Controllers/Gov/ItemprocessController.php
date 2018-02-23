<?php
/*
|--------------------------------------------------------------------------
| 项目流程
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use App\Http\Model\Item;
use App\Http\Model\Schedule;
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
                    ->orderBy('created_at','desc')
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
            return view('gov.process.index')->with($result);
        }
    }

    /* ========== 项目审查 - 提交部门审查 ========== */
    public function check_to_dept_check(Request $request){
        DB::beginTransaction();
        try{
            $item=Item::select(['id','schedule_id','process_id','code'])
                ->lockForUpdate()
                ->find($this->item_id);

            if(blank($item)){
                throw new \Exception('项目不存在',404404);
            }
            /* ++++++++++ 检查项目状态 ++++++++++ */
            if($item->schedule_id!=1 || $item->process_id!=1 || $item->code != '0'){
                throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
            }
            $item->code='2';
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