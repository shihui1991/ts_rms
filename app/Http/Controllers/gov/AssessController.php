<?php
/*
|--------------------------------------------------------------------------
| 项目-评估报告
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use App\Http\Model\Assess;
use App\Http\Model\Assets;
use App\Http\Model\Estate;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AssessController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        $assess=null;
        DB::beginTransaction();
        try{
            $total=Assess::sharedLock()
                ->where('item_id',$this->item_id)
                ->count();

            $per_page=15;
            $page=$request->input('page',1);
            $assesses=Assess::with(['itemland'=>function($query){
                $query->select(['id','address']);
            },'itembuilding'=>function($query){
                $query->select(['id','building']);
            },'household'=>function($query){
                $query->select(['id','unit','floor','number','type']);
            },'state'])
                ->sharedLock()
                ->where('item_id',$this->item_id)
                ->offset($per_page*($page-1))
                ->limit($per_page)
                ->get();
            
            $assesses=new LengthAwarePaginator($assesses,$total,$per_page,$page);
            $assesses->withPath(route('g_assess',['item'=>$this->item_id]));

            $code='success';
            $msg='获取成功';
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络错误';
        }
        $sdata=[
            'item'=>$this->item,
            'assesses'=>$assesses,
        ];
        $edata=null;
        $url=null;
        DB::commit();
        $result=['code'=>$code, 'message'=>$msg, 'sdata'=>$sdata, 'edata'=>$edata, 'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.assess.index')->with($result);
        }
    }

    /* ========== 详情 ========== */
    public function info(Request $request){
        $id=$request->input('id');
        DB::beginTransaction();
        try{
            if(!$id){
                throw new \Exception('错误操作',404404);
            }
            /* ********** 评估汇总 ********** */
            $assess=Assess::with(['itemland'=>function($query){
                $query->select(['id','address']);
            },'itembuilding'=>function($query){
                $query->select(['id','building']);
            },'household'=>function($query){
                $query->with(['householddetail'=>function($query){
                    $query->select(['id','household_id','status','register','has_assets']);
                }])
                    ->select(['id','unit','floor','number','type']);
            },'state'])
                ->sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['id',$id],
                ])
                ->first();
            if(blank($assess)){
                throw new \Exception('数据不存在',404404);
            }
            /* ********** 房产评估 ********** */
            $estate=Estate::with(['estatebuildings'=>function($query){
                $query->with(['realbuildinguse','buildingstruct','state']);
            },'company'=>function($query){
                $query->select(['id','name']);
            },'state'])
                ->sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['assess_id',$assess->id],
                ])
                ->first();
            $assets=null;
            if($assess->household->householddetail->getOriginal('has_assets')==1){
                $assets=Assets::with(['company'=>function($query){
                    $query->select(['id','name']);
                },'state'])->sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['assess_id',$assess->id],
                    ])
                    ->first();
            }

            $code='success';
            $msg='获取成功';
            $sdata=[
                'item'=>$this->item,
                'assess'=>$assess,
                'estate'=>$estate,
                'assets'=>$assets,
            ];
            $edata=null;
            $url=null;

            $view='gov.assess.info';
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络错误';
            $sdata=null;
            $edata=null;
            $url=null;

            $view='gov.error';
        }

        DB::commit();
        $result=['code'=>$code, 'message'=>$msg, 'sdata'=>$sdata, 'edata'=>$edata, 'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view($view)->with($result);
        }
    }
}