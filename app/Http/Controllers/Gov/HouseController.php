<?php
/*
|--------------------------------------------------------------------------
| 房源
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use App\Http\Model\House;
use App\Http\Model\Housemanageprice;
use App\Http\Model\Houseprice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class HouseController extends BaseController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {

    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        $select=['id','building','unit','floor','number','area','total_floor','lift'
            ,'is_real','is_buy','is_transit','is_public','state','deleted_at'];

        /* ********** 查询条件 ********** */
        $where=[];
        /* ********** 排序 ********** */
        $ordername=$request->input('ordername');
        $ordername=$ordername?$ordername:'id';
        $infos['ordername']=$ordername;

        $orderby=$request->input('orderby');
        $orderby=$orderby?$orderby:'asc';
        $infos['orderby']=$orderby;
        /* ********** 每页条数 ********** */
        $displaynum=$request->input('displaynum');
        $displaynum=$displaynum?$displaynum:15;
        $infos['displaynum']=$displaynum;
        /* ********** 是否删除 ********** */
        $deleted=$request->input('deleted');

        $model=new House();
        if(is_numeric($deleted) && in_array($deleted,[0,1])){
            $infos['deleted']=$deleted;
            if($deleted){
                $model=$model->onlyTrashed();
            }
        }else{
            $model=$model->withTrashed();
        }
        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $houses=$model->with(
                ['housecommunity'=> function ($query) {
                    $query->select('id', 'name');
                },
                'layout'=> function ($query) {
                    $query->select('id', 'name');
                },
                'houselayoutimg'=> function ($query) {
                    $query->select('id', 'name','picture');
                }])
                ->where($where)
                ->select($select)
                ->orderBy($ordername,$orderby)
                ->sharedLock()
                ->paginate($displaynum);
            if(blank($houses)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $data=$houses;
        }catch (\Exception $exception){
            $houses=collect();
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=$houses;
        }
        DB::commit();

        /* ********** 结果 ********** */
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>$infos]);
    }

    /* ========== 添加 ========== */
    public function add(Request $request){
        /* ********** 保存 ********** */
        /* ++++++++++ 表单验证 ++++++++++ */
        /*----- 房源 -----*/
        $model=new House();
        $rules=[
            'community_id'=>'required',
            'layout_id'=>'required',
            'layout_img_id'=>'required',
            'building'=>'required',
            'unit'=>'required',
            'floor'=>'required',
            'number'=>'required',
            'area'=>'required',
            'total_floor'=>'required',
            'lift'=>'required',
            'is_real'=>'required',
            'is_buy'=>'required',
            'is_transit'=>'required',
            'is_public'=>'required',
            'state'=>'required'
        ];
        $messages=[
            'required'=>':attribute 为必须项'
        ];
        $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
        if($validator->fails()){
            return response()->json(['code'=>'error','message'=>$validator->errors(),'sdata'=>'','edata'=>'']);
        }
        /*----- 房源-评估单价 -----*/
        $houseprice_model = new Houseprice();
        $rules1 = [
            'start_at'=>'required',
            'end_at'=>'required',
            'market'=>'required',
            'price'=>'required'
        ];
        $messages1=[
            'required'=>':attribute 为必须项'
        ];
        $validator1 = Validator::make($request->all(),$rules1,$messages1,$houseprice_model->columns);
        if($validator1->fails()){
            return response()->json(['code'=>'error','message'=>$validator1->errors(),'sdata'=>'','edata'=>'']);
        }
        /*----- 房源-购置管理费单价 -----*/
        $housemanageprice_model = new Housemanageprice();
        $rules2 = [
            'start_at'=>'required',
            'end_at'=>'required',
            'manage_price'=>'required'
        ];
        $messages2=[
            'required'=>':attribute 为必须项'
        ];
        $validator2 = Validator::make($request->all(),$rules2,$messages2,$housemanageprice_model->columns);
        if($validator2->fails()){
            return response()->json(['code'=>'error','message'=>$validator2->errors(),'sdata'=>'','edata'=>'']);
        }


        /* ++++++++++ 新增 ++++++++++ */
        DB::beginTransaction();
        try{
            /* ++++++++++ 批量赋值 ++++++++++ */
            /*----- 房源添加 -----*/
            $house=$model;
            $house->fill($request->input());
            $house->setOther($request);
            $house_rs = $house->save();
            if(blank($house_rs)){
                throw  new \Exception('添加失败',404404);
            }
            /*----- 房源-评估单价添加 -----*/
            $houseprice=$houseprice_model;
            $houseprice->fill([
                'house_id'=>$house->id,
                'start_at'=>$request->input('start_at'),
                'end_at'=>$request->input('end_at'),
                'market'=>$request->input('market'),
                'price'=>$request->input('price')
                ]);
            $houseprice_rs = $houseprice->save();
            if(blank($houseprice_rs)){
                throw  new \Exception('添加失败',404404);
            }
            /*----- 房源-购置管理费单价添加 -----*/
            $housemanageprice=$housemanageprice_model;
            $housemanageprice->fill([
                'house_id'=>$house->id,
                'start_at'=>$request->input('start_at'),
                'end_at'=>$request->input('end_at'),
                'manage_price'=>$request->input('manage_price')
            ]);
            $housemanageprice_rs = $housemanageprice->save();
            if(blank($housemanageprice_rs)){
                throw  new \Exception('添加失败',404404);
            }

            $code='success';
            $msg='添加成功';
            $data=$house;
            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'添加失败';
            $data=[];
            DB::rollBack();
        }
        /* ++++++++++ 结果 ++++++++++ */
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'']);
    }

    /* ========== 详情 ========== */
    public function info(Request $request){
        $id=$request->input('id');
        if(!$id){
            $code='warning';
            $msg='请选择一条数据';
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>'','edata'=>'']);
        }
        /* ********** 当前数据 ********** */
        DB::beginTransaction();
        $house=House::withTrashed()
            ->with(
                ['housecommunity'=> function ($query) {
                    $query->select('id', 'name');
                },
                    'layout'=> function ($query) {
                        $query->select('id', 'name');
                    },
                    'houselayoutimg'=> function ($query) {
                        $query->select('id', 'name','picture');
                    }])
            ->sharedLock()
            ->find($id);
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($house)){
            $code='warning';
            $msg='数据不存在';
            $data=[];

        }else{
            $code='success';
            $msg='获取成功';
            $data=$house;
        }
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'']);
    }

    /* ========== 修改 ========== */
    public function edit(Request $request){
        $id=$request->input('id');
        if(!$id){
            $code='warning';
            $msg='请选择一条数据';
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>'','edata'=>'']);
        }
        $model=new House();
        /* ********** 表单验证 ********** */
        $rules=[
            'community_id'=>'required',
            'layout_id'=>'required',
            'layout_img_id'=>'required',
            'building'=>'required',
            'unit'=>'required',
            'floor'=>'required',
            'number'=>'required',
            'area'=>'required',
            'total_floor'=>'required',
            'lift'=>'required',
            'is_real'=>'required',
            'is_buy'=>'required',
            'is_transit'=>'required',
            'is_public'=>'required',
            'state'=>'required'
        ];
        $messages=[
            'required'=>':attribute 为必须项'
        ];
        $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
        if($validator->fails()){
            return response()->json(['code'=>'error','message'=>$validator->errors(),'sdata'=>'','edata'=>'']);
        }
        /* ********** 更新 ********** */
        DB::beginTransaction();
        try{
            /* ++++++++++ 锁定数据模型 ++++++++++ */
            $house=House::withTrashed()
                ->lockForUpdate()
                ->find($id);
            if(blank($house)){
                throw new \Exception('指定数据项不存在',404404);
            }
            /* ++++++++++ 处理其他数据 ++++++++++ */
            $house->fill($request->input());
            $house->setOther($request);
            $house->save();

            $code='success';
            $msg='修改成功';
            $data=$house;

            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=[];
            DB::rollBack();
        }
        /* ********** 结果 ********** */
        return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'']);
    }
}