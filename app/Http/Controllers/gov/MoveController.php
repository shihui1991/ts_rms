<?php
/*
|--------------------------------------------------------------------------
| 项目-腾空搬迁
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use App\Http\Model\Household;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MoveController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        DB::beginTransaction();
        try{
            $total=Household::sharedLock()
                ->where('item_id',$this->item_id)
                ->whereIn('code',['70','77'])
                ->count();

            $per_page=15;
            $page=$request->input('page',1);
            $households=Household::with(['itemland'=>function($query){
                $query->select(['id','address']);
            },'itembuilding'=>function($query){
                $query->select(['id','building']);
            },'state'=>function($query){
                $query->select(['code','name']);
            }])
                ->where('item_id',$this->item_id)
                ->whereIn('code',['70','77'])
                ->select(['id','item_id','land_id','building_id','unit','floor','number','type','code'])
                ->sharedLock()
                ->offset($per_page*($page-1))
                ->limit($per_page)
                ->get();

            $households=new LengthAwarePaginator($households,$total,$per_page,$page);
            $households->withPath(route('g_pay',['item'=>$this->item_id]));

            $code='success';
            $msg='获取成功';
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络错误';
        }
        $sdata=[
            'item'=>$this->item,
            'households'=>$households,
        ];
        $edata=null;
        $url=null;
        DB::commit();
        $result=['code'=>$code, 'message'=>$msg, 'sdata'=>$sdata, 'edata'=>$edata, 'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.move.index')->with($result);
        }
    }

    /* ========== 已搬迁 ========== */
    public function edit(Request $request){
        $id=$request->input('id');
        DB::beginTransaction();
        try{
            if(!$id){
                throw new \Exception('错误操作',404404);
            }
            $household=Household::lockForUpdate()
                ->where([
                    ['item_id',$this->item_id],
                    ['id',$id],
                ])
                ->whereIn('code',['70','77'])
                ->first();
            if(blank($household)){
                throw new \Exception('数据错误',404404);
            }
            $household->code='72';
            $household->save();

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
        $result=['code'=>$code, 'message'=>$msg, 'sdata'=>$sdata, 'edata'=>$edata, 'url'=>$url];
        return response()->json($result);
    }
}