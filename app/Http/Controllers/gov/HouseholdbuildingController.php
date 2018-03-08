<?php
/*
|--------------------------------------------------------------------------
| 项目-被征收户-房屋建筑
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;
use App\Http\Model\Buildingstruct;
use App\Http\Model\Buildinguse;
use App\Http\Model\Household;
use App\Http\Model\Householdbuilding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HouseholdbuildingController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        $item_id=$this->item_id;
        /* ********** 查询条件 ********** */
        $where=[];
        $where[] = ['item_id',$item_id];
        $infos['item_id'] = $item_id;

        $where[] = ['household_id',$request->input('household_id')];
        $infos['household_id'] = $request->input('household_id');
        /* ********** 地块 ********** */
        $land_id=$request->input('land_id');
        if(is_numeric($land_id)){
            $where[] = ['land_id',$land_id];
            $infos['land_id'] = $land_id;
        }
        /* ********** 楼栋 ********** */
        $building_id=$request->input('building_id');
        if(is_numeric($building_id)){
            $where[] = ['building_id',$building_id];
            $infos['building_id'] = $building_id;
        }
        /* ********** 排序 ********** */
        $ordername=$request->input('ordername');
        $ordername=$ordername?$ordername:'id';
        $infos['ordername']=$ordername;

        $orderby=$request->input('orderby');
        $orderby=$orderby?$orderby:'asc';
        $infos['orderby']=$orderby;
        /* ********** 查询 ********** */
        $model=new Householdbuilding();
        DB::beginTransaction();
        try{
            $householdbuildings=$model
                ->with(['item'=>function($query){
                        $query->select(['id','name']);
                    },
                    'itemland'=>function($query){
                        $query->select(['id','address']);
                    },
                    'itembuilding'=>function($query){
                        $query->select(['id','building']);
                    },
                    'buildingstruct'=>function($query){
                        $query->select(['id','name']);
                    }])
                ->where($where)
                ->orderBy($ordername,$orderby)
                ->sharedLock()
                ->get();
            if(blank($householdbuildings)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$householdbuildings;
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
            return view('gov.householdbuilding.index')->with($result);
        }
    }

    /* ========== 添加 ========== */
    public function add(Request $request){
        $item_id=$this->item_id;
        $household_id=$request->input('household_id');
        $model=new Householdbuilding();
        if($request->isMethod('get')){
            $sdata['buildingstruct'] = Buildingstruct::select(['id','name'])->get()?:[];
            $sdata['buildinguse'] = Buildinguse::select(['id','name'])->get()?:[];
            $sdata['item_id'] = $item_id;
            $sdata['household'] = Household::select(['id','land_id','building_id'])->find($household_id);
            $result=['code'=>'success','message'=>'请求成功','sdata'=>$sdata,'edata'=>$model,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.householdbuilding.add')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else {
            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'household_id' => 'required',
                'land_id' => 'required',
                'building_id' => 'required',
                'register' => 'required',
                'reg_inner' => 'required',
                'reg_outer' => 'required',
                'balcony' => 'required',
                'dispute' => 'required',
                'real_inner' => 'required',
                'real_outer' => 'required',
                'def_use' => 'required',
                'real_use' => 'required',
                'struct_id' => 'required',
                'direct' => 'required',
                'floor' => 'required',
                'layout_img' => 'required',
                'picture' => 'required'
            ];
            $messages = [
                'required' => ':attribute必须填写'
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
                $householdbuilding = $model;
                $householdbuilding->fill($request->all());
                $householdbuilding->addOther($request);
                $householdbuilding->item_id=$this->item_id;
                $householdbuilding->save();
                if (blank($householdbuilding)) {
                    throw new \Exception('添加失败', 404404);
                }

                $code = 'success';
                $msg = '添加成功';
                $sdata = $householdbuilding;
                $edata = null;
                $url = route('g_householddetail_info',['id'=>$household_id,'item'=>$item_id]);
                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '添加失败';
                $sdata = null;
                $edata = $householdbuilding;
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
        $item_id=$this->item_id;

        /* ********** 当前数据 ********** */
        $data['item_id'] = $item_id;

        DB::beginTransaction();
        $householdbuilding=Householdbuilding::with([
            'item'=>function($query){
                 $query->select(['id','name']);
             },
            'itemland'=>function($query){
                $query->select(['id','address']);
            },
            'itembuilding'=>function($query){
                $query->select(['id','building']);
            },
            'buildingstruct'=>function($query){
                $query->select(['id','name']);
            },
             'buildinguse'=>function($query){
                $query->select(['id','name']);
            },
            'buildinguses'=>function($query){
                $query->select(['id','name']);
            }])
            ->sharedLock()
            ->find($id);
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($householdbuilding)){
            $code='warning';
            $msg='数据不存在';
            $sdata=null;
            $edata=$data;
            $url=null;
        }else{
            $code='success';
            $msg='获取成功';
            $sdata=$householdbuilding;
            $edata=$data;
            $url=null;

            $view='gov.householdbuilding.info';
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
        $item_id=$this->item_id;
        $household_id = $request->input('household_id');
        if ($request->isMethod('get')) {
            /* ********** 当前数据 ********** */
            $data['buildingstruct'] = Buildingstruct::select(['id','name'])->get()?:[];
            $data['buildinguse'] = Buildinguse::select(['id','name'])->get()?:[];
            $data['item_id'] = $item_id;
            $data['models'] = new Householdbuilding();
            $data['household'] = Household::select(['id','land_id','building_id'])->find($household_id);
            DB::beginTransaction();
            $householdbuilding=Householdbuilding::with([
                'itemland'=>function($query){
                    $query->select(['id','address']);
                },
                'itembuilding'=>function($query){
                    $query->select(['id','building']);
                }])
                ->sharedLock()
                ->find($id);
            DB::commit();

            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($householdbuilding)){
                $code='warning';
                $msg='数据不存在';
                $sdata=null;
                $edata=$data;
                $url=null;
            }else{
                $code='success';
                $msg='获取成功';
                $sdata=$householdbuilding;
                $edata=$data;
                $url=null;

                $view='gov.householdbuilding.edit';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }else{
            $model=new Household();
            /* ********** 表单验证 ********** */
            $rules = [
                'household_id' => 'required',
                'register' => 'required',
                'reg_inner' => 'required',
                'reg_outer' => 'required',
                'balcony' => 'required',
                'dispute' => 'required',
                'real_inner' => 'required',
                'real_outer' => 'required',
                'def_use' => 'required',
                'real_use' => 'required',
                'struct_id' => 'required',
                'direct' => 'required',
                'floor' => 'required',
                'layout_img' => 'required',
                'picture' => 'required'
            ];
            $messages = [
                'required' => ':attribute必须填写'
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
                $householdbuilding=Householdbuilding::lockForUpdate()->find($id);
                if(blank($householdbuilding)){
                    throw new \Exception('指定数据项不存在',404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $householdbuilding->fill($request->all());
                $householdbuilding->editOther($request);
                $householdbuilding->save();
                if(blank($householdbuilding)){
                    throw new \Exception('修改失败',404404);
                }
                $code='success';
                $msg='修改成功';
                $sdata=$householdbuilding;
                $edata=null;
                $url = route('g_householddetail_info',['id'=>$household_id,'item'=>$item_id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=$householdbuilding;
                $url=null;
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }
}