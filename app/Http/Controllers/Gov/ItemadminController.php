<?php
/*
|--------------------------------------------------------------------------
| 项目负责人
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use App\Http\Model\Dept;
use App\Http\Model\Itemadmin;
use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemadminController extends BaseitemController
{
    /* ========== 初始化 ========== */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 项目负责人 ========== */
    public function index(Request $request){
        DB::beginTransaction();
        try{
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

            $depts=Dept::select(['id','name'])->sharedLock()->get();

            if(blank($itemadmins)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$itemadmins;
            $edata=$depts;
            $url=null;
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=$depts;
            $url=null;
        }
        DB::commit();

        /* ++++++++++ 结果 ++++++++++ */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view('gov.itemadmin.index')->with($result);
        }
    }

    /* ========== 添加负责人 ========== */
    public function add(Request $request){
        if($request->isMethod('get')){

        }
        /* ++++++++++ 结果 ++++++++++ */
        else{
            $user_id=$request->input('user_id');
            if(blank($user_id)){
                $result=['code'=>'error','message'=>'请先选择人员','sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            DB::beginTransaction();
            try{
                /* ++++++++++ 锁定数据模型 ++++++++++ */
                $where[]=['item_id',$this->item_id];
                $where[]=['user_id',$user_id];
                $itemadmin=Itemadmin::withTrashed()->where($where)->lockForUpdate()->first();
                if(blank($itemadmin)){
                    $user=User::select(['id','dept_id','role_id'])->sharedLock()->find($user_id);

                    $pre_data=[
                        'item_id'=>$this->item_id,
                        'dept_id'=>$user->dept_id,
                        'role_id'=>$user->role_id,
                        'user_id'=>$user->id,
                    ];
                    $itemadmin=Itemadmin::firstOrCreate($pre_data);
                }else{
                    if($itemadmin->trashed()){
                        $itemadmin->restore();
                    }
                }

                $code='success';
                $msg='保存成功';
                $sdata=$itemadmin;
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
            return response()->json($result);
        }
        DB::beginTransaction();
        try{
            /* ++++++++++ 锁定数据模型 ++++++++++ */
            $itemadmin=Itemadmin::lockForUpdate()->find($id);
            if(blank($itemadmin)){
                throw new \Exception('数据不存在',404404);
            }
            $where=[
                ['item_id',$itemadmin->item_id],
            ];
            $count=Itemadmin::where($where)->sharedLock()->count();
            if($count<=1){
                throw new \Exception('至少需要一名项目负责人',404404);
            }
            $itemadmin->delete();

            $code='success';
            $msg='保存成功';
            $sdata=$itemadmin;
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