<?php
/*
|--------------------------------------------------------------------------
| 兑付--安置房备选
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\household;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Model\Payhousebak;

class PayhousebakController extends BaseController{

    /*选定的安置房缓存表*/
    public function index(Request $request){
        $household_id=session('household_user.user_id');
        $item_id=session('household_user.item_id');
        DB::beginTransaction();
        try{
            $payhousebak=Payhousebak::with(['house'=>function($query){
                    $query->with([
                        'housecommunity'=> function ($query) {
                            $query->select(['id','name']);
                        },
                        'layout'=> function ($query) {
                            $query->select(['id','name']);
                        },
                        'housecompany'=> function ($query) {
                            $query->select(['id','name']);
                        }]);
                }])
                ->where([
                ['household_id',$household_id],
                ['item_id',$item_id]
            ])
                ->sharedLock()
                ->get();
            if (blank($payhousebak)){
                throw new \Exception('暂未选择房源', 404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$payhousebak;
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
            return view('household.payhousebak.index')->with($result);
        }
    }

    /*添加安置房*/
    public function add(Request $request){
        $household_id=session('household_user.user_id');
        $item_id=session('household_user.item_id');
        DB::beginTransaction();
        try{
            $payhousebak=Payhousebak::where([
                ['household_id',$household_id],
                ['item_id',$item_id],
                ['house_id',$request->input('house_id')]
            ])
                ->sharedLock()
                ->first();
            if (filled($payhousebak)){
                throw new \Exception('已选择过该房源', 404404);
            }
            $payhousebak=new Payhousebak();
//            $payhousebak->fill($request->all());

            $payhousebak->item_id=$item_id;
            $payhousebak->house_id=$request->input('house_id');
            $payhousebak->household_id=$household_id;
            $payhousebak->land_id=session('household_user.land_id');
            $payhousebak->building_id=session('household_user.building_id');
            $payhousebak->save();
            if (blank($payhousebak)) {
                throw new \Exception('该房源不存在', 404404);
            }
            $code = 'success';
            $msg = '选房成功';
            $sdata = $payhousebak;
            $edata = null;
            $url = route('h_payhousebak');
            DB::commit();
        }catch (\Exception $exception){
            $code = 'error';
            $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '网络异常';
            $sdata = null;
            $edata = null;
            $url = null;
            DB::rollBack();
        }
        /* ********** 结果 ********** */
        $result = ['code' => $code, 'message' => $msg, 'sdata' => $sdata, 'edata' => $edata, 'url' => $url];
        return response()->json($result);
    }

    /*房源详情*/
    public function info(Request $request){
        $id=$request->input('id');
        if(!$id){
            $result=['code'=>'error','message'=>'请先选择数据','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('household.error')->with($result);
            }
        }
        DB::beginTransaction();
        $house=House::sharedLock()
            ->find($id);
        /* ********** 查询 ********** */
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($house)){
            $code='warning';
            $msg='数据不存在';
            $sdata=null;
            $edata=null;
            $url=null;
        }else{
            $code='success';
            $msg='获取成功';
            $sdata=$house;
            $edata=null;
            $url=null;

            $view='household.payhousebak.info';
        }
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view($view)->with($result);
        }
    }
}