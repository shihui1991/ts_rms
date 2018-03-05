<?php
/*
|--------------------------------------------------------------------------
| 入户摸底------>评估
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Com;
use App\Http\Model\Assess;
use App\Http\Model\Assets;
use App\Http\Model\Estate;
use App\Http\Model\Estatebuilding;
use App\Http\Model\Companyhousehold;
use App\Http\Model\Household;
use App\Http\Model\Householdbuilding;
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
                },
                'householdmember'=>function($query){
                    $query->where('holder',1)->orderBy('portion','desc')->first();
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
            dd($exception);
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
                },
                'householdmember'=>function($query){
                    $query->where('holder',1)->orderBy('portion','desc')->first();
                }])
                ->sharedLock()
                ->find($id);
            if(blank($household)){
                throw new \Exception('数据异常',404404);
            }
            if($type==0){
                /*=== 房产 ===*/
                $comassessestate = new Estate();
                $comassessestate->where('item_id',$item_id)->where('household_id',$id)->first();
                $comestatebuilding_count = Estatebuilding::where('item_id',$item_id)->where('company_id',$company_id)->where('household_id',$id)->count();
                if($comestatebuilding_count==0){
                    $householdbuilding = Householdbuilding::where('item_id',$item_id)->where('household_id',$id)->get();

                    $comestatebuilding_data = [];
                    foreach ($comestatebuilding_data as $k=>$v){
                        $comestatebuilding_data[$k]['item_id'] = $item_id;
                        $comestatebuilding_data[$k]['company_id'] = $company_id;
                    }

                }
            }else{
                /*=== 资产 ===*/
                $comassessassets = new Assets();
            }

            $code='success';
            $msg='获取成功';
            $sdata=$household;
            $edata=null;
            $url=null;

            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=null;
            $url=null;
            DB::rollBack();
        }
dd($householdbuilding);

    }
}