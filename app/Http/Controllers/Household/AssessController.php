<?php
/*
|--------------------------------------------------------------------------
| 项目-项目房源
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers\household;

use App\Http\Model\Assess;
use App\Http\Model\Assets;
use App\Http\Model\Estate;
use App\Http\Model\Item;
use App\Http\Model\Household;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class AssessController extends BaseController{

    protected $item_id;

    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    public function info(Request $request){
        $this->item_id=session('household_user.item_id');
        $household_id=session('household_user.user_id');

        /* ********** 查询条件 ********** */
        $where=[];
        $where[] = ['item_id', $this->item_id];
        $where[] = ['household_id', $household_id];


        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            /*项目信息*/
            $item=Item::sharedLock()->find($this->item_id);
            if(blank($item)){
                throw new \Exception('项目不存在',404404);
            }

            /* ++++++++++ 被征收户 ++++++++++ */
            $household=Household::sharedLock()
                ->select(['id','item_id','land_id','building_id','unit','floor','number','type','state'])
                ->find($household_id);
            if(blank($item)){
                throw new \Exception('被征户不存在',404404);
            }

            $assess=Assess::sharedLock()
                    ->where([
                        ['item_id', $this->item_id],
                        ['household_id', $household_id],
                        ['state', 6],
                    ])
                    ->first();

            if(blank($assess)){
                throw new \Exception('评估汇总不存在',404404);
            }

            $estate=Estate::with(['company'=>function($query){
                $query->select(['id','name']);
            }])
                ->sharedLock()
                ->where([['assess_id',$assess->id]])
                ->first();

            $assets=Assets::with(['company'=>function($query){
                $query->select(['id','name']);
            }])
                ->sharedLock()
                ->where([['assess_id',$assess->id]])
                ->first();

            $code='success';
            $msg='查询成功';
            $sdata=[
                'item'=>$item,
                'household'=>$household,
                'assess'=>$assess,
                'assets'=>$assets,
                'estate'=>$estate,
            ];
            $edata=null;
            $url=null;
            $view='household.assess.info';
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=null;
            $url=null;
            $view='household.error';
        }
        DB::commit();

        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view($view)->with($result);
        }
    }

}