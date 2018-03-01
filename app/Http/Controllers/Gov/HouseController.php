<?php
/*
|--------------------------------------------------------------------------
| 房源
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;
use App\Http\Model\House;
use App\Http\Model\Housecommunity;
use App\Http\Model\Housecompany;
use App\Http\Model\Housemanageprice;
use App\Http\Model\Houseprice;
use App\Http\Model\Layout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HouseController extends BaseauthController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        $select=['id','company_id','community_id','layout_id','layout_img_id',
            'building','unit','floor','number','area','total_floor','lift',
            'is_real','is_buy','is_transit','is_public','state','delive_at','deleted_at'];

        /* ********** 查询条件 ********** */
        $where=[];
        /* ********** 社区 ********** */
        $community_id = $request->input('community_id');
        if(is_numeric($community_id)){
            $where[] = ['community_id',$community_id];
            $infos['community_id']=$community_id;
        }
        /* ********** 户型 ********** */
        $layout_id = $request->input('layout_id');
        if(is_numeric($layout_id)){
            $where[] = ['layout_id',$layout_id];
            $infos['layout_id']=$layout_id;
        }
        /* ********** 状态 ********** */
        $state = $request->input('state');
        if(is_numeric($state)){
            $where[] = ['state',$state];
            $infos['state']=$state;
        }
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
            $houses=$model->select($select)
                ->with(['housecommunity'=> function ($query) {
                    $query->withTrashed()->select(['id','name']);
                },
                'layout'=> function ($query) {
                    $query->withTrashed()->select(['id','name']);
                },
                'housecompany'=> function ($query) {
                    $query->withTrashed()->select(['id','name']);
                }])
                ->where($where)
                ->orderBy($ordername,$orderby)
                ->sharedLock()
                ->paginate($displaynum);
            if(blank($houses)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$houses;
            $edata=null;
            $url=null;
        }catch (\Exception $exception){
            $houses=collect();
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=$houses;
            $url=null;
        }
        DB::commit();

        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.house.index')->with($result);
        }
    }

    /* ========== 添加 ========== */
    public function add(Request $request){
        $model = new House();
        if($request->isMethod('get')){
            $sdata['housecompany'] = Housecompany::withTrashed()->select(['id','name'])->get();
            $sdata['layout'] = Layout::withTrashed()->select(['id','name'])->get();
            $result=['code'=>'success','message'=>'请求成功','sdata'=>$sdata,'edata'=>$model,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.house.add')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else {
            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            /*----- 房源 -----*/
            $rules = [
                'company_id' => 'required',
                'community_id' => 'required',
                'layout_id' => 'required',
                'layout_img_id' => 'required',
                'building' => 'required',
                'unit' => 'required',
                'floor' => 'required',
                'number' => 'required',
                'area' => 'required',
                'total_floor' => 'required',
                'lift' => 'required',
                'is_real' => 'required',
                'is_buy' => 'required',
                'is_transit' => 'required',
                'is_public' => 'required',
                'delive_at'=>'required_if:is_buy,1',
            ];
            $messages = [
                'required' => ':attribute 为必须项',
                'delive_at.required_if' => '购置房源必须填写交付日期',
            ];
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /*----- 房源-评估单价 -----*/
            $houseprice_model = new Houseprice();
            $rules1 = [
                'start_at' => 'required',
                'end_at' => 'required',
                'market' => 'required',
                'price' => 'required',
            ];
            $messages1 = [
                'required' => ':attribute 为必须项'
            ];
            $validator1 = Validator::make($request->input('houseprice'), $rules1, $messages1, $houseprice_model->columns);
            if ($validator1->fails()) {
                $result=['code'=>'error','message'=>$validator1->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /*----- 房源-购置管理费单价 -----*/
            $housemanageprice_model = new Housemanageprice();
            $rules2 = [
                'start_at' => 'required',
                'end_at' => 'required',
                'manage_price' => 'required'
            ];
            $messages2 = [
                'required' => ':attribute 为必须项'
            ];
            $validator2 = Validator::make($request->all(), $rules2, $messages2, $housemanageprice_model->columns);
            if ($validator2->fails()) {
                $result=['code'=>'error','message'=>$validator2->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }


            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try {
                /* ++++++++++ 批量赋值 ++++++++++ */
                /*----- 房源添加 -----*/
                $house = $model;
                $house->fill($request->input());
                $house->addOther($request);
                $house->state=0;
                $house_rs = $house->save();
                if (blank($house_rs)) {
                    throw  new \Exception('添加失败', 404404);
                }
                /*----- 房源-评估单价添加 -----*/
                $houseprice = $houseprice_model;
                $houseprice->fill($request->input('houseprice'));
                $houseprice->house_id = $house->id;
                $houseprice->save();
                if (blank($houseprice)) {
                    throw  new \Exception('添加失败', 404404);
                }
                /*----- 房源-购置管理费单价添加 -----*/
                $housemanageprice = $housemanageprice_model;
                $housemanageprice->fill($request->input());
                $housemanageprice->house_id = $house->id;
                $housemanageprice->save();
                if (blank($housemanageprice)) {
                    throw  new \Exception('添加失败', 404404);
                }

                $code = 'success';
                $msg = '添加成功';
                $sdata = $house;
                $edata = null;
                $url = route('g_house');
                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '添加失败';
                $sdata = null;
                $edata = $house;
                $url = null;
                DB::rollBack();
            }
            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }

    /* ========== 详情 ========== */
    public function info(Request $request){
        $id=$request->input('id');
        if(!$id){
            $result=['code'=>'error','message'=>'请先选择数据','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }
        /* ********** 当前数据 ********** */
        DB::beginTransaction();
        $house=House::withTrashed()
            ->with(['housecommunity'=> function ($query) {
                $query->withTrashed()->select(['id','name']);
            },
                'layout'=> function ($query) {
                    $query->withTrashed()->select(['id','name']);
                },
                'housecompany'=> function ($query) {
                    $query->withTrashed()->select(['id','name']);
                },
                 'houselayoutimg'=> function ($query) {
                    $query->withTrashed()->select(['id', 'name','picture']);
              }])
            ->sharedLock()
            ->find($id);
        $house['manage_price'] = Housemanageprice::withTrashed()->where('house_id',$id)->first();
        $house['price'] = Houseprice::withTrashed()->where('house_id',$id)->first();
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
            $edata=new House();
            $url=null;

            $view='gov.house.info';
        }
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view($view)->with($result);
        }
    }

    /* ========== 修改 ========== */
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
            $house=House::withTrashed()
                ->with(['housecommunity'=> function ($query) {
                    $query->withTrashed()->select(['id','name']);
                },
                    'housecompany'=> function ($query) {
                        $query->withTrashed()->select(['id','name']);
                    },
                    'houselayoutimg'=> function ($query) {
                        $query->withTrashed()->select(['id', 'name','picture']);
                    }])
                ->sharedLock()
                ->find($id);
            $house['layout'] = Layout::withTrashed()->select(['id','name'])->get();
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
                $edata=new House();
                $url=null;

                $view='gov.house.edit';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }else{
            $model=new House();
            /* ********** 表单验证 ********** */
            $rules=[
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
                'delive_at'=>'required_if:is_buy,1',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'delive_at.required_if' => '购置房源必须填写交付日期',
            ];
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
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
                $house->editOther($request);
                $house->save();
                if(blank($house)){
                    throw new \Exception('修改失败',404404);
                }
                $code='success';
                $msg='修改成功';
                $sdata=$house;
                $edata=null;
                $url=route('g_house');

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=$house;
                $url=null;
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }
}