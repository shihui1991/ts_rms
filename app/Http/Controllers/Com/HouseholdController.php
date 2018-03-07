<?php
/*
|--------------------------------------------------------------------------
| 入户摸底------>评估
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Com;
use App\Http\Model\Assess;
use App\Http\Model\Assets;
use App\Http\Model\Comassessvaluer;
use App\Http\Model\Companyvaluer;
use App\Http\Model\Estate;
use App\Http\Model\Estatebuilding;
use App\Http\Model\Companyhousehold;
use App\Http\Model\Household;
use App\Http\Model\Householdbuilding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        $infos = [];
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

    /* ++++++++++ 入户摸底详情【添加评估汇总】 ++++++++++ */
    public function info(Request $request){
        $item_id = $this->item_id;
        $type = session('com_user.type');
        $company_id = session('com_user.company_id');
        $id=$request->input('id');
        if(!$id){
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
            $household=Household::with([
                'itemland'=>function($query){
                    $query->select(['id','address']);
                },
                'itembuilding'=>function($query){
                    $query->select(['id','building']);
                },
                'householddetail'=>function($query){
                    $query->select(['id','household_id','state','register','reg_inner','reg_outer',
                        'balcony','dispute','layout_img','picture','house_img','def_use','real_use',
                        'has_assets','agree','repay_way','layout_id']);
                }])
                ->sharedLock()
                ->find($id);
            if(blank($household)){
                throw new \Exception('数据异常',404404);
            }
            /*----------- 添加评估-汇总---------------*/
            $comassess = Assess::where('item_id',$item_id)->where('household_id',$id)->count();
            $comassesss = new Assess();
            if($comassess==0){
                $comassesss->item_id = $item_id;
                $comassesss->household_id = $id;
                $comassesss->land_id = $household->land_id;
                $comassesss->building_id = $household->building_id;
                $comassesss->assets = 0;
                $comassesss->estate = 0;
                $comassesss->state = 0;
                $comassesss->save();
                if(blank($comassesss)){
                    throw new \Exception('数据异常',404404);
                }
            }else{
                $comassesss = $comassesss->where('item_id',$item_id)->where('household_id',$id)->first();
            }
            /*----------- 添加评估-[房产]【资产】---------------*/
            if($type==0){
                /*=== 房产 ===*/
                $comassessestate = new Estate();
                $state_count = Estate::where('item_id',$item_id)->where('household_id',$id)->count();
                if($state_count==0){
                    $comassessestate->item_id = $item_id;
                    $comassessestate->household_id = $id;
                    $comassessestate->land_id = $household->land_id;
                    $comassessestate->building_id = $household->building_id;
                    $comassessestate->assess_id = $comassesss->id;
                    $comassessestate->company_id = $company_id;
                    $comassessestate->main_total = 0;
                    $comassessestate->tag_total = 0;
                    $comassessestate->total = 0;
                    $comassessestate->state = 0;
                    $comassessestate->save();
                    if(blank($comassessestate)){
                        throw new \Exception('数据异常',404404);
                    }
                }

            }else{
                /*=== 资产 ===*/
                $comassessassets = new Assets();
                $assets_count = Assets::where('item_id',$item_id)->where('household_id',$id)->count();
                if($assets_count==0){
                    $comassessassets->item_id = $item_id;
                    $comassessassets->household_id = $id;
                    $comassessassets->land_id = $household->land_id;
                    $comassessassets->building_id = $household->building_id;
                    $comassessassets->assess_id = $comassesss->id;
                    $comassessassets->company_id = $company_id;
                    $comassessassets->total = 0;
                    $comassessassets->state = 0;
                    $comassessassets->save();
                    if(blank($comassessassets)){
                        throw new \Exception('数据异常',404404);
                    }
                }

            }
            $data['householdbuilding']=Householdbuilding::with([
                'itemland'=>function($query){
                    $query->select(['id','address']);
                },
                'itembuilding'=>function($query){
                    $query->select(['id','building']);
                },
                'buildingstruct'=>function($query){
                    $query->select(['id','name']);
                }])
                ->where('item_id',$item_id)
                ->where('household_id',$id)
                ->sharedLock()
                ->get();
            $data['dispute_count']=Householdbuilding::where('item_id',$item_id)
                ->where('household_id',$id)
                ->whereIn('dispute',[1,2,4])
                ->sharedLock()
                ->count();
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

    /* ++++++++++ 评估信息【添加评估信息】 ++++++++++ */
    public function edit(Request $request){
        $id = $request->input('id');
        $item_id = $this->item_id;
        $type = session('com_user.type');
        $company_id = session('com_user.company_id');
        if($request->isMethod('get')){
            /* ********** 当前数据 ********** */
            $data['type'] = $type;
            $data['item_id'] = $item_id;
            DB::beginTransaction();
            try{
                $household=Household::with([
                    'itemland'=>function($query){
                        $query->select(['id','address']);
                    },
                    'itembuilding'=>function($query){
                        $query->select(['id','building']);
                    },
                    'householddetail'=>function($query){
                        $query->select(['id','household_id','state','register','reg_inner','reg_outer',
                            'balcony','dispute','layout_img','picture','house_img','def_use','real_use',
                            'has_assets','agree','repay_way','layout_id']);
                    },
                    'householdmembers'=>function($query){
                        $query->where('holder',1)->orderBy('portion','desc')->first();
                    }])
                    ->sharedLock()
                    ->find($id);
                if(blank($household)){
                    throw new \Exception('数据异常',404404);
                }
                $data['valuer'] = Companyvaluer::where('company_id',$company_id)->where('valid_at','>=',date('Y-m-d'))->get();
                if($type==0){
                    /*=== 房产 ===*/
                    /*=== 添加评估房产-房屋建筑 ===*/
                    $estatebuilding = Estatebuilding::with([
                        'itemland'=>function($query){
                            $query->select(['id','address']);
                        },
                        'realuse'=>function($query){
                            $query->select(['id','name']);
                        },
                        'buildingstruct'=>function($query){
                            $query->select(['id','name']);
                        }])
                        ->where('item_id',$item_id)
                        ->where('company_id',$company_id)
                        ->where('household_id',$id)
                        ->get();
                    if(blank($estatebuilding)){
                        $estate = new Estate();
                        $estates = $estate->where('item_id',$item_id)->where('household_id',$id)->where('company_id',$company_id)->first();

                        $householdbuilding = Householdbuilding::where('item_id',$item_id)->where('household_id',$id)->get();
                        $estatebuilding_data = [];
                        foreach ($householdbuilding as $k=>$v){
                            $estatebuilding_data[$k]['item_id'] = $item_id;
                            $estatebuilding_data[$k]['company_id'] = $company_id;
                            $estatebuilding_data[$k]['assess_id'] = $estates->assess_id;
                            $estatebuilding_data[$k]['estate_id'] = $estates->id;
                            $estatebuilding_data[$k]['household_id'] = $id;
                            $estatebuilding_data[$k]['land_id'] = $household->land_id;
                            $estatebuilding_data[$k]['building_id'] = $household->building_id;
                            $estatebuilding_data[$k]['household_building_id'] = $v->id;
                            $estatebuilding_data[$k]['real_outer'] = $v->real_outer;
                            $estatebuilding_data[$k]['real_use'] = $v->real_use;
                            $estatebuilding_data[$k]['struct_id'] = $v->struct_id;
                            $estatebuilding_data[$k]['direct'] = $v->direct;
                            $estatebuilding_data[$k]['floor'] = $v->floor;
                            $estatebuilding_data[$k]['layout_img'] = json_encode($v->layout_img);
                            $estatebuilding_data[$k]['picture'] = json_encode($v->picture);
                            $estatebuilding_data[$k]['price'] = 0;
                            $estatebuilding_data[$k]['amount'] = 0;
                            $estatebuilding_data[$k]['created_at'] = date('Y-m-d H:i:s');
                            $estatebuilding_data[$k]['updated_at'] = date('Y-m-d H:i:s');
                        }
                        $estatebuildings = Estatebuilding::insert($estatebuilding_data);
                        if(blank($estatebuildings)){
                            throw new \Exception('数据异常',404404);
                        }
                        $estatebuilding = Estatebuilding::with([
                            'itemland'=>function($query){
                                $query->select(['id','address']);
                            },
                            'realuse'=>function($query){
                                $query->select(['id','name']);
                            },
                            'buildingstruct'=>function($query){
                                $query->select(['id','name']);
                            }])
                            ->where('item_id',$item_id)
                            ->where('company_id',$company_id)
                            ->where('household_id',$id)
                            ->get();
                    }
                    $data['estatebuilding'] = $estatebuilding;

                    $comassessvaluers = Comassessvaluer::where('estate_id','<>',0)->where('item_id',$item_id)->where('household_id',$id)->where('company_id',$company_id)->pluck('valuer_id');
                    $data['comassessvaluers'] = $comassessvaluers;

                    $estate = new Estate();
                    $estates = $estate->where('item_id',$item_id)->where('household_id',$id)->where('company_id',$company_id)->first();
                    if(blank($estates)){
                        throw new \Exception('数据异常',404404);
                    }
                    $data['estate'] = $estates;
                }else{
                    /*=== 资产 ===*/
                    $asset = new Assets();
                    $assets = $asset->where('item_id',$item_id)->where('household_id',$id)->where('company_id',$company_id)->first();
                    if(blank($assets)){
                        throw new \Exception('数据异常',404404);
                    }
                    $data['assets'] = $assets;

                    $comassessvaluers = Comassessvaluer::where('assets_id','<>',0)->where('item_id',$item_id)->where('household_id',$id)->where('company_id',$company_id)->pluck('valuer_id');
                    $data['comassessvaluers'] = $comassessvaluers;

                }

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
                $edata=$data;
                $url=null;
                DB::rollBack();
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
            /*------------------- 数据填写验证 -----------------------*/
            $valuer_id = $request->input('valuer_id');
            $picture = $request->input('picture');
            if($type==0){
                $prices = $request->input('price');
                $price_datas = [];
                $ids = [];
                $i = 0;
                foreach ($prices as $k=>$v){
                    if(blank($v)){
                        $result=['code'=>'error','message'=>'评估单价不能为空','sdata'=>null,'edata'=>null,'url'=>null];
                        return response()->json($result);
                    }
                    $ids[] = $k;
                    $price_datas[$i]['id'] = $k;
                    $price_datas[$i]['price'] = $v;
                    $i++;
                }
            }

            $rules=[
                'valuer_id'=>'required',
                'picture'=>'required'
            ];
            $messages=[
                'required'=>':attribute 不能为空'
            ];
            $fild_msg = [
                'valuer_id'=>'评估师',
                'picture'=>'评估报告'
            ];
            $validator = Validator::make($request->all(), $rules, $messages, $fild_msg);
            if ($validator->fails()) {
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /*------------------- 被征户基本信息 -----------------------*/
            $household=Household::sharedLock()->find($id);
            if($type==0){
                /*------------------- 房产汇总信息 -----------------------*/
                $estates = Estate::where('item_id',$item_id)->where('household_id',$id)->where('company_id',$company_id)->first();
                /*------------------- 评估价格修改数据 -----------------------*/
                $realputer = Estatebuilding::select(['id','real_outer','real_use'])->whereIn('id',$ids)->get();
                if(count($price_datas) == count($realputer)){
                    $main_total = 0;
                    $tag_total = 0;
                    foreach ($realputer as $k=>$v){
                        if($price_datas[$k]['id']==$v->id){
                            $amount = $price_datas[$k]['price']*$v->real_outer;
                            $price_datas[$k]['amount'] = $amount;
                            $price_datas[$k]['updated_at'] = date('Y-m-d H:i:s');
                            if($v->real_use==5){
                                $tag_total += $amount;
                            }else{
                                $main_total += $amount;
                            }
                        }
                    }
                    $total = $tag_total+ $main_total;
                }else{
                    $result=['code'=>'error','message'=>'数据异常','sdata'=>null,'edata'=>null,'url'=>null];
                    return response()->json($result);
                }
                /*------------------- 评估师评估记录数据 -----------------------*/
                $valuer_datas = [];
                foreach ($valuer_id as $key=>$val){
                    $valuer_datas[$key]['item_id'] = $item_id;
                    $valuer_datas[$key]['household_id'] = $id;
                    $valuer_datas[$key]['land_id'] = $household->land_id;
                    $valuer_datas[$key]['building_id'] = $household->building_id;
                    $valuer_datas[$key]['assess_id'] = $estates->assess_id;
                    $valuer_datas[$key]['assets_id'] = 0;
                    $valuer_datas[$key]['estate_id'] = $estates->id;
                    $valuer_datas[$key]['company_id'] = $company_id;
                    $valuer_datas[$key]['valuer_id'] = $val;
                    $valuer_datas[$key]['created_at'] = date('Y-m-d H:i:s');
                    $valuer_datas[$key]['updated_at'] = date('Y-m-d H:i:s');
                }
            }else{
                /*------------------- 资产汇总信息 -----------------------*/
                $assets = Assets::where('item_id',$item_id)->where('household_id',$id)->where('company_id',$company_id)->first();
                /*------------------- 评估师评估记录数据 -----------------------*/
                $valuer_datas = [];
                foreach ($valuer_id as $key=>$val){
                    $valuer_datas[$key]['item_id'] = $item_id;
                    $valuer_datas[$key]['household_id'] = $id;
                    $valuer_datas[$key]['land_id'] = $household->land_id;
                    $valuer_datas[$key]['building_id'] = $household->building_id;
                    $valuer_datas[$key]['assess_id'] = $assets->assess_id;
                    $valuer_datas[$key]['assets_id'] = $assets->id;
                    $valuer_datas[$key]['estate_id'] = 0;
                    $valuer_datas[$key]['company_id'] = $company_id;
                    $valuer_datas[$key]['valuer_id'] = $val;
                    $valuer_datas[$key]['created_at'] = date('Y-m-d H:i:s');
                    $valuer_datas[$key]['updated_at'] = date('Y-m-d H:i:s');
                }
            }


            /* ********** 评估 ********** */
            DB::beginTransaction();
            try{
                if($type==0){
                    /* ++++++++++ 评估房产建筑价格 ++++++++++ */
                    $upd_field = ['id','price','amount','updated_at'];
                    $sqls = batch_update_sql('com_estate_building', $upd_field, $price_datas,$upd_field);
                    if (!$sqls) {
                        throw new \Exception('数据错误', 404404);
                    }
                    foreach ($sqls as $sql) {
                        DB::statement($sql);
                    }
                    /* ++++++++++ 修改房产评估汇总数据 ++++++++++ */
                    $estate = Estate::where('id',$estates->id)->update(['main_total'=>$main_total,'tag_total'=>$tag_total,'total'=>$total,'picture'=>json_encode($picture),'updated_at'=>date('Y-m-d H:i:s')]);
                    if(blank($estate)){
                        throw new \Exception('数据错误', 404404);
                    }
                    /* ++++++++++ 修改评估汇总数据 ++++++++++ */
                    $comassess = Assess::where('id',$estates->assess_id)->update(['estate'=>$total,'updated_at'=>date('Y-m-d H:i:s')]);
                    if(blank($comassess)){
                        throw new \Exception('数据错误', 404404);
                    }
                    /* ++++++++++ 查询评估师评估记录数据 ++++++++++ */
                    $comassessvaluers = Comassessvaluer::where('household_id',$id)->where('estate_id','<>','0')->where('item_id',$item_id)->where('company_id',$company_id)->delete();
                    if(blank($comassessvaluers)){
                        throw new \Exception('数据错误', 404404);
                    }
                }else{
                    /* ++++++++++ 修改资产评估汇总数据 ++++++++++ */
                    $assetss = Assets::where('id',$assets->id)->update(['total'=>$request->input('total'),'picture'=>json_encode($picture),'updated_at'=>date('Y-m-d H:i:s')]);
                    if(blank($assetss)){
                        throw new \Exception('数据错误', 404404);
                    }
                    /* ++++++++++ 修改评估汇总数据 ++++++++++ */
                    $comassess = Assess::where('id',$assets->assess_id)->update(['assets'=>$request->input('total'),'updated_at'=>date('Y-m-d H:i:s')]);
                    if(blank($comassess)){
                        throw new \Exception('数据错误', 404404);
                    }
                    /* ++++++++++ 查询评估师评估记录数据 ++++++++++ */
                    $comassessvaluers = Comassessvaluer::where('household_id',$id)->where('assets_id','<>','0')->where('item_id',$item_id)->where('company_id',$company_id)->delete();
                    if(blank($comassessvaluers)){
                        throw new \Exception('数据错误', 404404);
                    }
                }
                /* ++++++++++ 添加评估师评估记录 ++++++++++ */
               $comassessvaluer = new Comassessvaluer();
                $comassessvaluer::insert($valuer_datas);
                if(blank($comassessvaluer)){
                    throw new \Exception('数据错误', 404404);
                }

                $code='success';
                $msg='修改成功';
                $sdata=null;
                $edata=null;
                $url=route('c_household',['item'=>$item_id]);

                DB::commit();
            }catch (\Exception $exception){
                dd($exception->getMessage());
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=null;
                $url=null;
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }

    }
}