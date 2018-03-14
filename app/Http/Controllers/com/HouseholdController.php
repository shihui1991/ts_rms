<?php
/*
|--------------------------------------------------------------------------
| 入户摸底------>评估
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\com;
use App\Http\Model\Assess;
use App\Http\Model\Assets;
use App\Http\Model\Buildinguse;
use App\Http\Model\Comassessvaluer;
use App\Http\Model\Companyvaluer;
use App\Http\Model\Estate;
use App\Http\Model\Estatebuilding;
use App\Http\Model\Companyhousehold;
use App\Http\Model\Household;
use App\Http\Model\Householdassets;
use App\Http\Model\Householdbuilding;
use App\Http\Model\Layout;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        $infos = [];
        $where = [];
       $item_id = $this->item_id;
        $infos['item_id'] = $item_id;
        $where[] = ['item_id',$item_id];
        $infos['type'] = session('com_user.type');
        $company_id = session('com_user.company_id');
        $infos['company_id'] = $company_id;
        $where[] = ['company_id',$company_id];
        /* ********** 每页条数 ********** */
        $per_page=15;
        $page=$request->input('page',1);
        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $total=Companyhousehold::sharedLock()
                ->where($where)
                ->count();
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
                ->where($where)
                ->offset($per_page*($page-1))
                ->limit($per_page)
                ->get();
            $households=new LengthAwarePaginator($households,$total,$per_page,$page);
            $households->withPath(route('c_household'));
            if(blank($households)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$households;
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
            return view('com.household.index')->with($result);
        }
    }

    /* ++++++++++ 入户摸底详情 ++++++++++ */
    public function info(Request $request){
        $item_id = $this->item_id;
        $type = session('com_user.type');
        $company_id = session('com_user.company_id');
        $id=$request->input('id');
        if(blank($id)){
            $result=['code'=>'error','message'=>'请先选择数据','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('com.error')->with($result);
            }
        }
        /* ********** 当前数据 ********** */
        DB::beginTransaction();
        try{
            /*------------- 基本信息 -------------*/
            $household=Household::with([
                'itemland'=>function($query){
                    $query->select(['id','address']);
                },
                'itembuilding'=>function($query){
                    $query->select(['id','building']);
                },
                'householddetail'=>function($query){
                    $query->select(['id','household_id','register','reg_inner','reg_outer',
                        'balcony','dispute','picture','def_use','real_use',
                        'has_assets','agree','repay_way','layout_id']);
                }])
                ->sharedLock()
                ->find($id);
            if(blank($household)){
                throw new \Exception('数据异常',404404);
            }
            /*------------- [房产][资产]信息 -------------*/
            if($type==0){
                $data['estate']=Estate::with([
                    'defbuildinguse'=>function($query){
                        $query->select(['id','name']);
                    },
                    'realbuildinguse'=>function($query){
                        $query->select(['id','name']);
                    }])
                    ->where('item_id',$item_id)
                    ->where('household_id',$id)
                    ->where('company_id',$company_id)
                    ->sharedLock()
                    ->first();
            }else{
                $data['householdassets'] = Householdassets::where('item_id',$item_id)
                    ->where('household_id',$id)
                    ->get();
            }

            $data['type'] = $type;
            $code='success';
            $msg='获取成功';
            $sdata=$household;
            $edata=$data;
            $url=null;

            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=null;
            $url='';
            DB::rollBack();
        }
        if($code=='error'){
            $view='com.error';
        }else{
            $view='com.household.info';
        }
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view($view)->with($result);
        }
    }

    /* ++++++++++ 入户摸底-添加[房产][资产] ++++++++++ */
    public function add(Request $request){
        $type = session('com_user.type');
        $company_id = session('com_user.company_id');
        $item_id=$this->item_id;
        $item=$this->item;
        $household_id =$request->input('household_id');

        if($request->isMethod('get')){
            $sdata['type'] = $type;
            $sdata['item_id'] = $item_id;
            $sdata['item'] = $item;
            if($type==0){
                $model=new Estate();
                $sdata['household'] = Household::select(['id','land_id','building_id'])
                    ->with([
                        'itemland'=>function($query){
                            $query->select(['id','address']);
                        },
                        'itembuilding'=>function($query){
                            $query->select(['id','building']);
                        }])
                    ->where('id',$household_id)
                    ->first();
                $sdata['defuse'] = Buildinguse::select(['id','name'])->get()?:[];
                $sdata['models'] = $model;
            }else{
                $model=new Householdassets();
                $sdata['household'] = Household::select(['id','land_id','building_id'])->find($household_id);
            }

            $result=['code'=>'success','message'=>'请求成功','sdata'=>$sdata,'edata'=>$model,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('com.household.add')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else {
            if($type==0){
                $model=new Estate();
                /* ++++++++++ 表单验证 ++++++++++ */
                $rules = [
                    'household_id'=>'required',
                    'land_id'=>'required',
                    'building_id'=>'required',
                    'status'=>'required',
                    'dispute'=>'required',
                    'area_dispute'=>'required',
                    'real_use'=>'required',
                    'has_assets'=>'required',
                    'sign'=>'required'
                ];
                $messages = [
                    'required' => ':attribute必须填写',
                    'unique' => ':attribute已存在'
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
                    $household = $model;
                    $household->fill($request->all());
                    $household->addOther($request);
                    $household->item_id=$this->item_id;
                    $household->assess_id=0;
                    $household->company_id=$company_id;
                    $household->code=130;
                    $household->save();
                    if (blank($household)) {
                        throw new \Exception('添加失败', 404404);
                    }

                    $code = 'success';
                    $msg = '添加成功';
                    $sdata = $household;
                    $edata = null;
                    $url = route('c_household_info',['id'=>$household_id,'item'=>$item_id]);
                    DB::commit();
                } catch (\Exception $exception) {
                    $code = 'error';
                    $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '添加失败';
                    $sdata = null;
                    $edata = $household;
                    $url = null;
                    DB::rollBack();
                }
            }else{
                $model=new Householdassets();
                /* ++++++++++ 表单验证 ++++++++++ */
                $rules = [
                    'household_id' => 'required',
                    'land_id' => 'required',
                    'building_id' => 'required',
                    'name' => 'required',
                    'num_unit' => 'required',
                    'com_num' => 'required',
                    'com_pic' => 'required'
                ];
                $messages = [
                    'required' => ':attribute必须填写'
                ];
                $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
                if ($validator->fails()) {
                    $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                    return response()->json($result);
                }
                /* ++++++++++ 赋值 ++++++++++ */
                DB::beginTransaction();
                try {
                    /* ++++++++++ 资产是否存在 ++++++++++ */
                    $name = $request->input('name');
                    $householdassets = Householdassets::where('item_id',$item_id)->where('land_id',$request->input('land_id'))->where('name',$name)->lockForUpdate()->first();
                    if(blank($householdassets)){
                        /* ++++++++++ 新增数据 ++++++++++ */
                        $householdassets = $model;
                        $householdassets->fill($request->input());
                        $householdassets->addOther($request);
                        $householdassets->item_id=$item_id;
                        $householdassets->save();
                    }else{
                        /* ++++++++++ 修改数据 ++++++++++ */
                        $householdassets->com_num=$request->input('com_num');
                        $householdassets->com_pic=$request->input('com_pic');
                        $householdassets->save();
                    }
                    if (blank($householdassets)) {
                        throw new \Exception('添加失败', 404404);
                    }

                    $code = 'success';
                    $msg = '添加成功';
                    $sdata = $householdassets;
                    $edata = null;
                    $url = route('c_household_info',['id'=>$household_id,'item'=>$item_id]);
                    DB::commit();
                } catch (\Exception $exception) {
                    $code = 'error';
                    $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '添加失败';
                    $sdata = null;
                    $edata = $householdassets;
                    $url = null;
                    DB::rollBack();
                }
            }

            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }

    /* ++++++++++ 修改摸底信息 ++++++++++ */
    public function edit(Request $request){
        $id = $request->input('id');
        $household_id = $request->input('household_id');
        $item_id = $this->item_id;
        $item = $this->item;
        $type = session('com_user.type');
        $company_id = session('com_user.company_id');

        if($request->isMethod('get')){
            $data['type'] = $type;
            $data['company_id'] = $company_id;
            $data['item_id'] = $item_id;
            $data['item'] = $item;
            if($type==0){
                $model = new Estate();
                $data['household'] = Household::select(['id','land_id','building_id'])
                    ->with([
                        'itemland'=>function($query){
                            $query->select(['id','address']);
                        },
                        'itembuilding'=>function($query){
                            $query->select(['id','building']);
                        }])
                    ->where('id',$household_id)
                    ->first();
                $data['defuse'] = Buildinguse::select(['id','name'])->get()?:[];
                $data['models'] = $model;
                DB::beginTransaction();
                   $estate = Estate::with([
                       'itemland'=>function($query){
                           $query->select(['id','address']);
                       },
                       'itembuilding'=>function($query){
                           $query->select(['id','building']);
                       }])
                       ->sharedLock()
                       ->find($id);
                DB::commit();
                if(blank($estate)){
                    $code = 'error';
                    $msg = '数据异常';
                    $sdata = null;
                    $edata = $data;
                    $url = null;
                }else{
                    $code = 'success';
                    $msg = '获取成功';
                    $sdata = $estate;
                    $edata = $data;
                    $url = null;
                }

            }else{
                /* ********** 当前数据 ********** */

                DB::beginTransaction();
                $householdassets=Householdassets::with([
                    'itemland'=>function($query){
                        $query->select(['id','address']);
                    },'itembuilding'=>function($query){
                        $query->select(['id','building']);
                    }])
                    ->sharedLock()
                    ->find($id);
                DB::commit();
                /* ++++++++++ 数据不存在 ++++++++++ */
                if(blank($householdassets)){
                    $code='warning';
                    $msg='数据不存在';
                    $sdata=null;
                    $edata=$data;
                    $url=null;
                }else{
                    $code='success';
                    $msg='获取成功';
                    $sdata= $householdassets;
                    $edata=$data;
                    $url=null;
                }
            }

            if($code=='error'){
                $view='com.error';
            }else{
                $view='com.household.edit';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }else{
            /* ********** 保存 ********** */
            if($type==0){
                $model = new Estate();
                /* ++++++++++ 表单验证 ++++++++++ */
                $rules = [
                    'household_id'=>'required',
                    'status'=>'required',
                    'dispute'=>'required',
                    'area_dispute'=>'required',
                    'real_use'=>'required',
                    'has_assets'=>'required',
                    'sign'=>'required'
                ];
                $messages = [
                    'required' => ':attribute必须填写',
                    'unique' => ':attribute已存在'
                ];
                $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
                if ($validator->fails()) {
                    $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                    return response()->json($result);
                }
                /* ++++++++++ 修改 ++++++++++ */
                DB::beginTransaction();
                try {
                    /* ++++++++++ 锁定数据 ++++++++++ */
                    $estate = Estate::lockforupdate()->find($id);
                    /* ++++++++++ 批量赋值 ++++++++++ */
                    $estate->fill($request->all());
                    $estate->editOther($request);
                    $estate->save();
                    if (blank($estate)) {
                        throw new \Exception('修改失败', 404404);
                    }

                    $code = 'success';
                    $msg = '修改成功';
                    $sdata = $estate;
                    $edata = null;
                    $url = route('c_household_info',['id'=>$household_id,'item'=>$item_id]);
                    DB::commit();
                } catch (\Exception $exception) {
                    $code = 'error';
                    $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '修改失败';
                    $sdata = null;
                    $edata = $estate;
                    $url = null;
                    DB::rollBack();
                }
            }else{
                $model=new Householdassets();
                /* ********** 表单验证 ********** */
                $rules=[
                    'name'=> ['required',Rule::unique('item_household_assets')->where(function ($query) use($item_id,$id,$household_id){
                        $query->where('item_id', $item_id)->where('household_id',$household_id)->where('id','<>',$id);
                    })],
                    'num_unit' => 'required',
                    'com_num' => 'required',
                    'com_pic' => 'required'
                ];
                $messages=[
                    'required'=>':attribute必须填写',
                    'unique'=>':attribute已存在'
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
                    $householdassets=Householdassets::lockForUpdate()->find($id);
                    if(blank($householdassets)){
                        throw new \Exception('指定数据项不存在',404404);
                    }
                    /* ++++++++++ 处理其他数据 ++++++++++ */
                    $householdassets->fill($request->all());
                    $householdassets->editOther($request);
                    $householdassets->save();
                    if(blank($householdassets)){
                        throw new \Exception('修改失败',404404);
                    }
                    $code='success';
                    $msg='修改成功';
                    $sdata=$householdassets;
                    $edata=null;
                    $url = route('c_household_info',['id'=>$household_id,'item'=>$this->item_id]);

                    DB::commit();
                }catch (\Exception $exception){
                    $code='error';
                    $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                    $sdata=null;
                    $edata=null;
                    $url=null;
                    DB::rollBack();
                }
            }

            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }

    }


//    public function test(){
//            /*----------- 添加评估-汇总---------------*/
//            $comassess = Assess::where('item_id',$item_id)->where('household_id',$id)->count();
//            $comassesss = new Assess();
//            if($comassess==0){
//                $comassesss->item_id = $item_id;
//                $comassesss->household_id = $id;
//                $comassesss->land_id = $household->land_id;
//                $comassesss->building_id = $household->building_id;
//                $comassesss->assets = 0;
//                $comassesss->estate = 0;
//                $comassesss->state = 0;
//                $comassesss->save();
//                if(blank($comassesss)){
//                    throw new \Exception('数据异常',404404);
//                }
//            }
//            /*----------- 添加评估-[房产]【资产】---------------*/
//            if($type==0){
//                /*=== 房产 ===*/
//                $comassessestate = new Estate();
//                $state_count = Estate::where('item_id',$item_id)->where('household_id',$id)->count();
//                if($state_count==0){
//                    $comassessestate->item_id = $item_id;
//                    $comassessestate->household_id = $id;
//                    $comassessestate->land_id = $household->land_id;
//                    $comassessestate->building_id = $household->building_id;
//                    $comassessestate->assess_id = $comassesss->id;
//                    $comassessestate->company_id = $company_id;
//                    $comassessestate->main_total = 0;
//                    $comassessestate->tag_total = 0;
//                    $comassessestate->total = 0;
//                    $comassessestate->state = 0;
//                    $comassessestate->save();
//                    if(blank($comassessestate)){
//                        throw new \Exception('数据异常',404404);
//                    }
//                }
//
//            }else{
//                /*=== 资产 ===*/
//                $comassessassets = new Assets();
//                $assets_count = Assets::where('item_id',$item_id)->where('household_id',$id)->count();
//                if($assets_count==0){
//                    $comassessassets->item_id = $item_id;
//                    $comassessassets->household_id = $id;
//                    $comassessassets->land_id = $household->land_id;
//                    $comassessassets->building_id = $household->building_id;
//                    $comassessassets->assess_id = $comassesss->id;
//                    $comassessassets->company_id = $company_id;
//                    $comassessassets->total = 0;
//                    $comassessassets->state = 0;
//                    $comassessassets->save();
//                    if(blank($comassessassets)){
//                        throw new \Exception('数据异常',404404);
//                    }
//                }
//
//            }
//        /*------------------- 数据填写验证 -----------------------*/
//        $valuer_id = $request->input('valuer_id');
//        $picture = $request->input('picture');
//        if($type==0){
//            $prices = $request->input('price');
//            $price_datas = [];
//            $ids = [];
//            $i = 0;
//            foreach ($prices as $k=>$v){
//                if(blank($v)){
//                    $result=['code'=>'error','message'=>'评估单价不能为空','sdata'=>null,'edata'=>null,'url'=>null];
//                    return response()->json($result);
//                }
//                $ids[] = $k;
//                $price_datas[$i]['id'] = $k;
//                $price_datas[$i]['price'] = $v;
//                $i++;
//            }
//        }
//
//        $rules=[
//            'valuer_id'=>'required',
//            'picture'=>'required'
//        ];
//        $messages=[
//            'required'=>':attribute 不能为空'
//        ];
//        $fild_msg = [
//            'valuer_id'=>'评估师',
//            'picture'=>'评估报告'
//        ];
//        $validator = Validator::make($request->all(), $rules, $messages, $fild_msg);
//        if ($validator->fails()) {
//            $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
//            return response()->json($result);
//        }
//        /*------------------- 被征户基本信息 -----------------------*/
//        $household=Household::sharedLock()->find($id);
//        if($type==0){
//            /*------------------- 房产汇总信息 -----------------------*/
//            $estates = Estate::where('item_id',$item_id)->where('household_id',$id)->where('company_id',$company_id)->first();
//            /*------------------- 评估价格修改数据 -----------------------*/
//            $realputer = Estatebuilding::select(['id','real_outer','real_use'])->whereIn('id',$ids)->get();
//            if(count($price_datas) == count($realputer)){
//                $main_total = 0;
//                $tag_total = 0;
//                foreach ($realputer as $k=>$v){
//                    if($price_datas[$k]['id']==$v->id){
//                        $amount = $price_datas[$k]['price']*$v->real_outer;
//                        $price_datas[$k]['amount'] = $amount;
//                        $price_datas[$k]['updated_at'] = date('Y-m-d H:i:s');
//                        if($v->real_use==5){
//                            $tag_total += $amount;
//                        }else{
//                            $main_total += $amount;
//                        }
//                    }
//                }
//                $total = $tag_total+ $main_total;
//            }else{
//                $result=['code'=>'error','message'=>'数据异常','sdata'=>null,'edata'=>null,'url'=>null];
//                return response()->json($result);
//            }
//            /*------------------- 评估师评估记录数据 -----------------------*/
//            $valuer_datas = [];
//            foreach ($valuer_id as $key=>$val){
//                $valuer_datas[$key]['item_id'] = $item_id;
//                $valuer_datas[$key]['household_id'] = $id;
//                $valuer_datas[$key]['land_id'] = $household->land_id;
//                $valuer_datas[$key]['building_id'] = $household->building_id;
//                $valuer_datas[$key]['assess_id'] = $estates->assess_id;
//                $valuer_datas[$key]['assets_id'] = 0;
//                $valuer_datas[$key]['estate_id'] = $estates->id;
//                $valuer_datas[$key]['company_id'] = $company_id;
//                $valuer_datas[$key]['valuer_id'] = $val;
//                $valuer_datas[$key]['created_at'] = date('Y-m-d H:i:s');
//                $valuer_datas[$key]['updated_at'] = date('Y-m-d H:i:s');
//            }
//        }else{
//            /*------------------- 资产汇总信息 -----------------------*/
//            $assets = Assets::where('item_id',$item_id)->where('household_id',$id)->where('company_id',$company_id)->first();
//            /*------------------- 评估师评估记录数据 -----------------------*/
//            $valuer_datas = [];
//            foreach ($valuer_id as $key=>$val){
//                $valuer_datas[$key]['item_id'] = $item_id;
//                $valuer_datas[$key]['household_id'] = $id;
//                $valuer_datas[$key]['land_id'] = $household->land_id;
//                $valuer_datas[$key]['building_id'] = $household->building_id;
//                $valuer_datas[$key]['assess_id'] = $assets->assess_id;
//                $valuer_datas[$key]['assets_id'] = $assets->id;
//                $valuer_datas[$key]['estate_id'] = 0;
//                $valuer_datas[$key]['company_id'] = $company_id;
//                $valuer_datas[$key]['valuer_id'] = $val;
//                $valuer_datas[$key]['created_at'] = date('Y-m-d H:i:s');
//                $valuer_datas[$key]['updated_at'] = date('Y-m-d H:i:s');
//            }
//        }
//
//
//        /* ********** 评估 ********** */
//        DB::beginTransaction();
//        try{
//            if($type==0){
//                /* ++++++++++ 评估房产建筑价格 ++++++++++ */
//                $upd_field = ['id','price','amount','updated_at'];
//                $sqls = batch_update_sql('com_estate_building', $upd_field, $price_datas,$upd_field);
//                if (!$sqls) {
//                    throw new \Exception('数据错误', 404404);
//                }
//                foreach ($sqls as $sql) {
//                    DB::statement($sql);
//                }
//                /* ++++++++++ 修改房产评估汇总数据 ++++++++++ */
//                $estate = Estate::where('id',$estates->id)->update(['main_total'=>$main_total,'tag_total'=>$tag_total,'total'=>$total,'picture'=>json_encode($picture),'updated_at'=>date('Y-m-d H:i:s')]);
//                if(blank($estate)){
//                    throw new \Exception('数据错误', 404404);
//                }
//                /* ++++++++++ 修改评估汇总数据 ++++++++++ */
//                $comassess = Assess::where('id',$estates->assess_id)->update(['estate'=>$total,'updated_at'=>date('Y-m-d H:i:s')]);
//                if(blank($comassess)){
//                    throw new \Exception('数据错误', 404404);
//                }
//                /* ++++++++++ 查询评估师评估记录数据 ++++++++++ */
//                $comassessvaluers = Comassessvaluer::where('household_id',$id)->where('estate_id','<>','0')->where('item_id',$item_id)->where('company_id',$company_id)->delete();
//                if(blank($comassessvaluers)){
//                    throw new \Exception('数据错误', 404404);
//                }
//            }else{
//                /* ++++++++++ 修改资产评估汇总数据 ++++++++++ */
//                $assetss = Assets::where('id',$assets->id)->update(['total'=>$request->input('total'),'picture'=>json_encode($picture),'updated_at'=>date('Y-m-d H:i:s')]);
//                if(blank($assetss)){
//                    throw new \Exception('数据错误', 404404);
//                }
//                /* ++++++++++ 修改评估汇总数据 ++++++++++ */
//                $comassess = Assess::where('id',$assets->assess_id)->update(['assets'=>$request->input('total'),'updated_at'=>date('Y-m-d H:i:s')]);
//                if(blank($comassess)){
//                    throw new \Exception('数据错误', 404404);
//                }
//                /* ++++++++++ 查询评估师评估记录数据 ++++++++++ */
//                $comassessvaluers = Comassessvaluer::where('household_id',$id)->where('assets_id','<>','0')->where('item_id',$item_id)->where('company_id',$company_id)->delete();
//                if(blank($comassessvaluers)){
//                    throw new \Exception('数据错误', 404404);
//                }
//            }
//            /* ++++++++++ 添加评估师评估记录 ++++++++++ */
//            $comassessvaluer = new Comassessvaluer();
//            $comassessvaluer::insert($valuer_datas);
//            if(blank($comassessvaluer)){
//                throw new \Exception('数据错误', 404404);
//            }
//
//            $code='success';
//            $msg='修改成功';
//            $sdata=null;
//            $edata=null;
//            $url=route('c_household',['item'=>$item_id]);
//
//            DB::commit();
//        }catch (\Exception $exception){
//            dd($exception->getMessage());
//            $code='error';
//            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
//            $sdata=null;
//            $edata=null;
//            $url=null;
//            DB::rollBack();
//        }
//    }
}