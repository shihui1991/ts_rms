<?php
/*
|--------------------------------------------------------------------------
| 项目流程
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use App\Http\Model\Item;
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

    /* ========== 项目审查 - 提交部门审查 ========== */
    public function check_to_dept_check(Request $request){
        DB::beginTransaction();
        try{
            $item=Item::query()->select(['id','code'])->lockForUpdate()->find($this->item_id);
            if(blank($item)){
                throw new \Exception('项目不存在',404404);
            }
            /* ++++++++++ 检查项目状态 ++++++++++ */
            /* ********** 状态代码为数字 ********** */
            if(is_numeric($item->code)){
                if($item->code=='0'){
                    throw new \Exception('当前项目已作【不予受理】处理，不能提交审查',404404);
                }else{
                    $item->code='1-1-2';
                    $item->save();
                }
            }
            /* ********** 状态代码为字符串 ********** */
            else{
                if($item->code=='1-1-2'){
                    throw new \Exception('当前项目已【提交部门审查】，请勿重复操作',404404);
                }else{
                    throw new \Exception('当前项目处于【'.$item->state->name.'】，不能进行当前操作',404404);
                }
            }
            
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