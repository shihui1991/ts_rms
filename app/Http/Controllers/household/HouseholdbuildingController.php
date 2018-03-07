<?php
/*
|--------------------------------------------------------------------------
| 项目-社会风险评估
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers\household;

use App\Http\Model\Householdbuilding;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class  HouseholdbuildingController extends BaseController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    public function info(Request $request)
    {

        $id=$request->input('id');
        if(!$id){
            $result=['code'=>'error','message'=>'请先选择数据','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('household.error')->with($result);
            }
        }

        /* ********** 当前数据 ********** */
        DB::beginTransaction();
        $householdbuilding=Householdbuilding::with([
            'item'=>function($query){
                $query->select(['id','name']);
            },
            'itemland'=>function($query){
                $query->select(['id','address']);
            },
            'itembuilding'=>function($query){
                $query->select(['id','building']);
            },
            'buildingstruct'=>function($query){
                $query->select(['id','name']);
            },
            'buildinguse'=>function($query){
                $query->select(['id','name']);
            },
            'buildinguses'=>function($query){
                $query->select(['id','name']);
            }])
            ->sharedLock()
            ->find($id);
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($householdbuilding)){
            $code='warning';
            $msg='数据不存在';
            $sdata=null;
            $edata=null;
            $url=null;
        }else{
            $code='success';
            $msg='获取成功';
            $sdata=$householdbuilding;
            $edata=null;
            $url=null;

            $view='household.householdbuilding.info';
        }
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view($view)->with($result);
        }
    }
}