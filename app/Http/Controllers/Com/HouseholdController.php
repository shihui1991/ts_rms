<?php
/*
|--------------------------------------------------------------------------
| 入户摸底
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Com;
use App\Http\Model\Companyhousehold;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HouseholdController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ++++++++++ 获取入户摸底资料 ++++++++++ */
    public function index(Request $request)
    {
       $item_id = $this->item_id;
        /* ********** 每页条数 ********** */
        $displaynum=$request->input('displaynum');
        $displaynum=$displaynum?$displaynum:15;
        $infos['displaynum']=$displaynum;

        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $households = Companyhousehold::with([
                'household'=>function($querys){
                    $querys->with([
                        'itemland'=>function($query){
                            $query->select(['id','address']);
                        },
                        'itembuilding'=>function($query){
                            $query->select(['id','building']);
                        },
                        'householddetail'=>function($query){
                            $query->select(['id','household_id','dispute']);
                        }]);
                }])
                ->where('company_id',session('com_user.company_id'))
                ->where('item_id',$item_id)
                ->paginate($displaynum);
            if(blank($households)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$households;
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
            return view('com.household.index')->with($result);
        }
    }
}