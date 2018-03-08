<?php
/*
|--------------------------------------------------------------------------
| 项目-项目房源
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers\household;

use App\Http\Model\Itemhouse;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class ItemhouseController extends BaseController{

    protected $item_id;

    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request){
        $this->item_id=session('household_user.item_id');
        /* ********** 查询条件 ********** */
        $where=[];
        $where[] = ['item_id', $this->item_id];
        $infos['item_id'] =  $this->item_id;
        $select=['item_id','house_id','type','created_at'];
        /* ********** 排序 ********** */
        $ordername=$request->input('ordername');
        $ordername=$ordername?$ordername:'created_at';
        $infos['ordername']=$ordername;

        $orderby=$request->input('orderby');
        $orderby=$orderby?$orderby:'asc';
        $infos['orderby']=$orderby;
        /* ********** 每页条数 ********** */
        $displaynum=$request->input('displaynum');
        $displaynum=$displaynum?$displaynum:15;
        $infos['displaynum']=$displaynum;
        /* ********** 查询 ********** */
        $model=new Itemhouse();
        DB::beginTransaction();
        try{
            $itemhouses=$model
                ->with(['item'=>function($query){
                    $query->select(['id','name']);
                },
                    'house'=>function($query){
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
                ->where($where)
                ->select($select)
                ->orderBy($ordername,$orderby)
                ->sharedLock()
                ->paginate($displaynum);
            if(blank($itemhouses)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$itemhouses;
            $edata=$infos;
            $url=null;
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=$infos;
            $url=null;
        }
        DB::commit();

        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('household.itemhouse.index')->with($result);
        }
    }

}