<?php
/*
|--------------------------------------------------------------------------
| 房源-评估单价
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;
use App\Http\Model\House;
use App\Http\Model\Houseprice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HousepriceController extends BaseauthController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        $house_id = $request->input('house_id');
        if(!$house_id){
            $result=['code'=>'error','message'=>'请先选择房源','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }

        /* ********** 查询条件 ********** */
        $select=['id','house_id','start_at','end_at','market','price','deleted_at'];
        /* ********** 查询 ********** */
        $model=new Houseprice();
        DB::beginTransaction();
        try{
            $houseprices['house_id'] = $house_id;
            $houseprices['house_info'] = House::withTrashed()
                ->with(['housecommunity'=> function ($query) {
                    $query->withTrashed()->select(['id','name']);
                }])
                ->select(['id','community_id','unit','building','floor','number'])
                ->find($house_id);
            $houseprices['houseprice']=$model->withTrashed()
                ->with(
                ['house'=> function ($query) {
                    $query->withTrashed()->select(['id', 'unit','building','floor','number']);
                }])
                ->where('house_id',$house_id)
                ->select($select)
                ->orderBy('start_at','asc')
                ->sharedLock()
                ->get();
            if(blank($houseprices)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$houseprices;
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
            return view('gov.houseprice.index')->with($result);
        }
    }

    /* ========== 添加 ========== */
    public function add(Request $request){
        $house_id = $request->input('house_id');
        if(!$house_id){
            $result=['code'=>'error','message'=>'请先选择房源','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }

        $model=new Houseprice();
        if($request->isMethod('get')){
            $edata['house_id'] = $house_id;
            $result=['code'=>'success','message'=>'请求成功','sdata'=>null,'edata'=>$edata,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.houseprice.add')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else {
            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'house_id' => 'required',
                'start_at' => 'required',
                'end_at' => 'required',
                'market' => 'required',
                'price' => 'required'
            ];
            $messages = [
                'required' => ':attribute 为必须项'
            ];
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try {
                /* ++++++++++ 批量赋值 ++++++++++ */
                $houseprice = $model;
                $houseprice->fill($request->input());
                $houseprice->addOther($request);
                $houseprice->save();
                if (blank($houseprice)) {
                    throw new \Exception('添加失败', 404404);
                }
                $code = 'success';
                $msg = '添加成功';
                $sdata = $houseprice;
                $edata = null;
                $url = route('g_houseprice',['house_id'=>$house_id]);
                DB::commit();
            } catch (\Exception $exception) {
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
        $houseprice=Houseprice::withTrashed()
            ->sharedLock()
            ->find($id);
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($houseprice)){
            $code='warning';
            $msg='数据不存在';
            $sdata=null;
            $edata=null;
            $url=null;
        }else{
            $code='success';
            $msg='获取成功';
            $sdata=$houseprice;
            $edata=new Houseprice();
            $url=null;

            $view='gov.houseprice.info';
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
            $houseprice=Houseprice::withTrashed()
                ->sharedLock()
                ->find($id);
            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($houseprice)){
                $code='warning';
                $msg='数据不存在';
                $sdata=null;
                $edata=null;
                $url=null;
            }else{
                $code='success';
                $msg='获取成功';
                $sdata=$houseprice;
                $edata=new Houseprice();
                $url=null;

                $view='gov.houseprice.edit';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }else {
            $model = new Houseprice();
            /* ********** 表单验证 ********** */
            $rules = [
                'start_at' => 'required',
                'end_at' => 'required',
                'market' => 'required',
                'price' => 'required'
            ];
            $messages = [
                'required' => ':attribute 为必须项'
            ];
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result = ['code' => 'error', 'message' => $validator->errors()->first(), 'sdata' => null, 'edata' => null, 'url' => null];
                return response()->json($result);
            }
            /* ********** 更新 ********** */
            DB::beginTransaction();
            try {
                /* ++++++++++ 锁定数据模型 ++++++++++ */
                $houseprice = Houseprice::withTrashed()
                    ->lockForUpdate()
                    ->find($id);
                $house_id = $houseprice->house_id;
                if (blank($houseprice)) {
                    throw new \Exception('指定数据项不存在', 404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $houseprice->fill($request->input());
                $houseprice->editOther($request);
                $houseprice->save();
                if (blank($houseprice)) {
                    throw new \Exception('修改失败', 404404);
                }
                $code = 'success';
                $msg = '修改成功';
                $sdata=$houseprice;
                $edata=null;
                $url=route('g_houseprice',['house_id'=>$house_id]);
                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '网络异常';
                $sdata=null;
                $edata=$houseprice;
                $url=null;
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }
}