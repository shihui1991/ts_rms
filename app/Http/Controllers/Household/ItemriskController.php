<?php
/*
|--------------------------------------------------------------------------
| 项目-社会风险评估
|--------------------------------------------------------------------------
*/
namespace  App\Http\Controllers\Household;
use App\Http\Model\Itemrisk;

use App\Http\Model\Household;
use App\Http\Model\Layout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class  ItemriskController extends BaseController {
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    public function info(Request $request){

        $item_id=session('household_user.item_id');
        $household_id=session('household_user.user_id');
        /* ********** 当前数据 ********** */
        DB::beginTransaction();

        $itemrisk=Itemrisk::with(
            ['item'=>function($query){
                $query->select(['id','name']);
            },'building'=>function($query){
                $query->select(['id','building']);
            },'land'=>function($query){
                $query->select(['id','address']);
            }])
            ->where('household_id',$household_id)
            ->where('item_id',$item_id)
            ->sharedLock()
            ->first();
        DB::commit();

        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($itemrisk)){
            $code='warning';
            $msg='数据不存在';
            $sdata=null;
            $edata=null;
            $url=null;
        }else{
            $code='success';
            $msg='获取成功';
            $sdata=$itemrisk;
            $edata=null;
            $url=null;
        }
        $view='household.itemrisk.info';
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view($view)->with($result);
        }
    }

    /*社会稳定风险评估-添加页面*/
    public function add(Request $request){
        $item_id=session('household_user.item_id');
        $household_id=session('household_user.user_id');
        $land_id=session('household_user.land_id');
        $building_id=session('household_user.building_id');


        if($request->isMethod('get')){

            DB::beginTransaction();
            $itemrisk=Itemrisk::with(
                ['item'=>function($query){
                    $query->select(['id','name']);
                },'land'=>function($query){
                    $query->select(['id','address']);
                },'building'=>function($query){
                    $query->select(['id','building']);
                }])
                ->where('household_id',$household_id)
                ->where('item_id',$item_id)
                ->sharedLock()
                ->first();
            DB::commit();

            if (filled($itemrisk)){
                return response()->json(['code'=>'error','message'=>'社会稳定风险评估不允许重复添加!','sdata'=>null,'edata'=>null,'url'=>null]);
            }

            $model=Household::with(
                ['item'=>function($query){
                    $query->select(['id','name']);
                },'itemland'=>function($query){
                    $query->select(['id','address']);
                },'itembuilding'=>function($query){
                    $query->select(['id','building']);
                }])
                ->where('item_id',$item_id)
                ->sharedLock()
                ->first();
            $model->layout=Layout::pluck('name','id');
            $result=['code'=>'success','message'=>'请求成功','sdata'=>$model,'edata'=>new Itemrisk(),'url'=>null];

            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('household.itemrisk.add')->with($result);
            }
        }
        /*数据保存*/
        else{
            $model=new Itemrisk();
            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'agree'=>'required',
                'repay_way'=>'required',
                'layout_id' => 'required',
                'transit_way' => 'required',
                'move_way' => 'required',
                'move_fee' => 'required'
            ];
            $messages = [
                'required' => ':attribute必须填写'
            ];
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try{
                /* ++++++++++ 批量赋值 ++++++++++ */
                $itemrisk = $model;
                $itemrisk->fill($request->all());
                $itemrisk->addOther($request);
                $itemrisk->item_id=$item_id;
                $itemrisk->land_id=$land_id;
                $itemrisk->household_id=$household_id;
                $itemrisk->building_id=$building_id;

                $itemrisk->save();
                if (blank($itemrisk)) {
                    throw new \Exception('添加失败', 404404);
                }
                $code = 'success';
                $msg = '添加成功';
                $sdata = $itemrisk;
                $edata = null;
                $url = route('h_itemrisk_info',['item'=>$item_id]);
                DB::commit();
            }catch (\Exception $exception){
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '添加失败';
                $sdata = null;
                $edata = null;
                $url = null;
                DB::rollBack();
            }
            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }

    /*社会稳定风险评估-修改页面*/
    public function edit(Request $request){
        $id=$request->input('id');
        if(!$id){
            $result=['code'=>'error','message'=>'请先选择数据','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }
        if ($request->isMethod('get')) {
            /* ********** 当前数据 ********** */
            DB::beginTransaction();
            $data=Itemrisk::with(['item'=>function($query){
                $query->select(['id','name']);
            },'building'=>function($query){
                $query->select(['id','building']);
            },'land'=>function($query){
                $query->select(['id','address']);
            }])
                ->sharedLock()
                ->find($id);

            DB::commit();

            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($data)){
                $code='warning';
                $msg='数据不存在';
                $sdata=null;
                $edata=null;
                $url=null;
            }else{
                $code='success';
                $msg='获取成功';
                $sdata=$data;
                $edata=null;
                $url=null;
                $view='household.itemrisk.edit';
            }

            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>new Itemrisk(),'url'=>$url];
            dd($result);
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }else{
            DB::beginTransaction();
            $itemrisk=Itemrisk::with(
                ['item'=>function($query){
                    $query->select(['id','name']);
                },'building'=>function($query){
                    $query->select(['id','building']);
                },'land'=>function($query){
                    $query->select(['id','address']);
                }])
                ->lockForUpdate()
                ->find($id);
            $itemrisk->layout=Layout::pluck('name','id');

            DB::commit();
        }
    }
}