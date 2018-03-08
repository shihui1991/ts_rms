<?php
/*
|--------------------------------------------------------------------------
| 项目-排队选房
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use App\Http\Model\House;
use App\Http\Model\Itemctrl;
use App\Http\Model\Itemhouse;
use App\Http\Model\Payreserve;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PayreserveController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 排队选房 ========== */
    public function index(Request $request){
        DB::beginTransaction();

        try{
            $itemctrl=Itemctrl::sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['cate_id',3],
                    ['start_at','<=',date('Y-m-d H:i:s')],
                    ['end_at','>=',date('Y-m-d H:i:s')],
                ])
                ->first();
            if(blank($itemctrl)){
                throw new \Exception('还未到排队选房时间',404404);
            }

            $total=Payreserve::sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['control_id',$itemctrl->id],
                    ['state',0],
                ])
                ->count();

            $per_page=15;
            $page=$request->input('page',1);
            $reserves=Payreserve::with(['household'=>function($query){
                $query->with(['itemland'=>function($query){
                    $query->select(['id','address']);
                },'itembuilding'=>function($query){
                    $query->select(['id','building']);
                },'pay'])
                    ->select(['id','item_id','land_id','building_id','unit','floor','number','type','state']);
            }])
                ->sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['control_id',$itemctrl->id],
                    ['state',0],
                ])
                ->offset($per_page*($page-1))
                ->limit($per_page)
                ->orderBy('number','asc')
                ->get();

            $reserves=new LengthAwarePaginator($reserves,$total,$per_page,$page);
            $reserves->withPath(route('g_payreserve',['item'=>$this->item_id]));

            $code='success';
            $msg='请求成功';
        }catch (\Exception $exception){
            $itemctrl=null;
            $reserves=null;

            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络错误';
        }
        DB::commit();

        $sdata=[
            'item'=>$this->item,
            'itemctrl'=>$itemctrl,
            'reserves'=>$reserves,
        ];
        $edata=null;
        $url=null;

        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view('gov.payreserve.index')->with($result);
        }
    }

    /* ========== 开始选房 ========== */
    public function house(Request $request){
        $reserve_id=$request->input('reserve_id');
        if(!$reserve_id){
            $result=['code'=>'error','message'=>'错误操作','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }

        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                $reserve=Payreserve::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$reserve_id],
                    ])
                    ->first();
                if(blank($reserve)){
                    throw new \Exception('错误操作',404404);
                }
                if($reserve->getOriginal('state')==1){
                    throw new \Exception('当前被征收户已经选房了，请进入修改页面操作',404404);
                }
                if($reserve->getOriginal('state')==2){
                    throw new \Exception('当前被征收户未在限定时间内来选房，预约失效',404404);
                }
                $item_house_ids=Itemhouse::sharedLock()
                    ->where('item_id',$this->item_id)
                    ->pluck('house_id');

                $total=House::sharedLock()
                    ->whereIn('id',$item_house_ids)
                    ->where('state',1)
                    ->count();

                $per_page=15;
                $page=$request->input('page',1);
                $houses=House::with(['housecommunity','layout','houselayoutimg','itemhouseprice'=>function($query){
                    $query->where([
                        ['start_at','<=',$this->item->created_at],
                        ['end_at','>=',$this->item->created_at],
                    ]);
                }])
                    ->sharedLock()
                    ->whereIn('id',$item_house_ids)
                    ->where('state',1)
                    ->offset($per_page*($page-1))
                    ->limit($per_page)
                    ->get();
                $houses=new LengthAwarePaginator($houses,$total,$per_page,$page);
                $houses->withPath(route('g_payreserve_house',['item'=>$this->item_id,'reserve_id'=>$reserve_id]));

                $code='success';
                $msg='请求成功';
                $sdata=[
                    'item'=>$this->item,
                    'reserve'=>$reserve,
                    'houses'=>$houses,
                ];
                $edata=null;
                $url=null;

                $view='gov.payreserve.house';
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
        /* ++++++++++ 保存 ++++++++++ */
        else{

        }
    }
}