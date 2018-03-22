<?php
/*
|--------------------------------------------------------------------------
| 兑付--补偿科目
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\household;
use App\Http\Model\Paysubject;
use Illuminate\Http\Request;

class  PaysubjectController extends BaseController{
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
            $paysubject=Paysubject::sharedLock()
                ->find($id);
        }
}