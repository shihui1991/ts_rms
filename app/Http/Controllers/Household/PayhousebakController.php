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
    public function add(Request $request){
        $household_id=session('household_user.user_id');
        $item_id=session('household_user.item_id');
        DB::beginTransaction();
        try{
            $payhousebak=Payhousebak::where([
                ['household_id',$household_id],
                ['item_id',$item_id],
            ])
                ->sharedLock()
                ->first();
//            if (filled($payhousebak)){
//                throw new \Exception('一户只能选择一处安置房', 404404);
//            }
            $payhousebak=new Payhousebak();
//            $payhousebak->fill($request->all());

            $payhousebak->item_id=$item_id;
            $payhousebak->house_id=$request->input('house_id');
            $payhousebak->household_id=$household_id;
            $payhousebak->land_id=session('household_user.land_id');
            $payhousebak->building_id=session('household_user.building_id');
            $payhousebak->save();
            if (blank($payhousebak)) {
                throw new \Exception('投票失败', 404404);
            }
            $code = 'success';
            $msg = '选房成功';
            $sdata = $payhousebak;
            $edata = null;
            $url = route('h_itemhousebak');
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
}