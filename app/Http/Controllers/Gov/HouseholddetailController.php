<?php
/*
|--------------------------------------------------------------------------
| 项目-被征收户详情
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;
use App\Http\Model\Buildinguse;
use App\Http\Model\Household;
use App\Http\Model\Householddetail;
use App\Http\Model\Layout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HouseholddetailController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 添加 ========== */
    public function add(Request $request){
        $item_id=$this->item_id;
        $model=new Householddetail();
        $household_id =$request->input('household_id');
        if($request->isMethod('get')){
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
            $sdata['layout'] = Layout::select(['id','name'])->get()?:[];
            $sdata['item_id'] = $item_id;
            $sdata['detailmodel'] = $model;
            $result=['code'=>'success','message'=>'请求成功','sdata'=>$sdata,'edata'=>$model,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.householddetail.add')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else {
            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'household_id'=>'required',
                'land_id'=>'required',
                'building_id'=>'required',
                'state'=>'required',
                'dispute'=>'required',
                'layout_img'=>'required',
                'real_use'=>'required',
                'has_assets'=>'required',
                'agree'=>'required',
                'repay_way'=>'required',
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
                $householddetail = $model;
                $householddetail->fill($request->all());
                $householddetail->addOther($request);
                $householddetail->item_id=$this->item_id;
                $householddetail->save();
                if (blank($householddetail)) {
                    throw new \Exception('添加失败', 404404);
                }

                $code = 'success';
                $msg = '添加成功';
                $sdata = $householddetail;
                $edata = null;
                $url = route('g_household_info',['id'=>$household_id,'item'=>$this->item_id]);
                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '添加失败';
                $sdata = null;
                $edata = $householddetail;
                $url = null;
                DB::rollBack();
            }
            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }

    /* ========== 修改 ========== */
    public function edit(Request $request){
        $item_id=$this->item_id;
        $model=new Householddetail();
        $id =$request->input('id');
        if($request->isMethod('get')){
            $sdata['household'] = Householddetail::with([
                    'itemland'=>function($query){
                        $query->select(['id','address']);
                    },
                    'itembuilding'=>function($query){
                        $query->select(['id','building']);
                    },
                    'defbuildinguse'=>function($query){
                        $query->select(['id','name']);
                    },
                    'realbuildinguse'=>function($query){
                        $query->select(['id','name']);
                    },
                    'layout'=>function($query){
                        $query->select(['id','name']);
                    }])
                ->where('id',$id)
                ->first();
            $sdata['defuse'] = Buildinguse::select(['id','name'])->get()?:[];
            $sdata['layout'] = Layout::select(['id','name'])->get()?:[];
            $sdata['item_id'] = $item_id;
            $sdata['detailmodel'] = $model;
            $result=['code'=>'success','message'=>'请求成功','sdata'=>$sdata,'edata'=>$model,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.householddetail.edit')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else {
            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'state'=>'required',
                'dispute'=>'required',
                'layout_img'=>'required',
                'real_use'=>'required',
                'has_assets'=>'required',
                'agree'=>'required',
                'repay_way'=>'required',
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
                /* ++++++++++ 锁定数据模型 ++++++++++ */
                $householddetail=Householddetail::lockForUpdate()->find($id);
                if(blank($householddetail)){
                    throw new \Exception('指定数据项不存在',404404);
                }
                /* ++++++++++ 批量赋值 ++++++++++ */
                $householddetail->fill($request->all());
                $householddetail->editOther($request);
                $householddetail->save();
                if (blank($householddetail)) {
                    throw new \Exception('修改失败', 404404);
                }

                $code = 'success';
                $msg = '修改成功';
                $sdata = $householddetail;
                $edata = null;
                $url = route('g_household_info',['id'=>$request->input('household_id'),'item'=>$this->item_id]);
                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '修改失败';
                $sdata = null;
                $edata = $householddetail;
                $url = null;
                DB::rollBack();
            }
            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }
}