<?php
/*
|--------------------------------------------------------------------------
| 项目-被征收户 家庭成员  特殊人群
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;
use App\Http\Model\Crowd;
use App\Http\Model\Householdmember;
use App\Http\Model\Householdmembercrowd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HouseholdmembercrowdController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 添加 ========== */
    public function add(Request $request){
        $item_id = $this->item_id;
        $household_id = $request->input('household_id');
        $member_id = $request->input('member_id');
        $model=new Householdmembercrowd();
        if($request->isMethod('get')){
            $sdata['crowd'] = Crowd::select(['id','name'])->where('parent_id','>',0)->get();
            $sdata['item_id'] = $item_id;
            $sdata['householdmember'] = Householdmember::select(['id','land_id','building_id'])->find($member_id);
            $sdata['member_id'] = $member_id;
            $sdata['household_id'] = $household_id;
            $result=['code'=>'success','message'=>'请求成功','sdata'=>$sdata,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.householdmembercrowd.add')->with($result);
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
                'member_id'=>'required',
                'picture'=>'required',
                 'crowd_id'=>['required',Rule::unique('item_household_member_crowd')->where(function ($query) use($member_id){
                $query->where('member_id', $member_id);
            })],
            ];
            $messages = [
                'required' => ':attribute 为必须项',
                'unique' => ':attribute 已存在'
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
                $householdmembercrowd = $model;
                $householdmembercrowd->fill($request->input());
                $householdmembercrowd->addOther($request);
                $householdmembercrowd->item_id = $item_id;
                $householdmembercrowd->save();
                if (blank($householdmembercrowd)) {
                    throw new \Exception('添加失败', 404404);
                }

                $code = 'success';
                $msg = '添加成功';
                $sdata = $householdmembercrowd;
                $edata = null;
                $url = route('g_householdmember_info',['item'=>$item_id,'id'=>$member_id]);
                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '添加失败';
                $sdata = null;
                $edata = $householdmembercrowd;
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
        $householdmembercrowd=Householdmembercrowd::with([
            'crowd'=>function($query){
                $query->select(['id','name']);
            }])
            ->sharedLock()
            ->find($id);
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($householdmembercrowd)){
            $code='warning';
            $msg='数据不存在';
            $sdata=null;
            $edata=null;
            $url=null;
        }else{
            $code='success';
            $msg='获取成功';
            $sdata=$householdmembercrowd;
            $edata=new Householdmembercrowd();
            $url=null;

            $view='gov.householdmembercrowd.info';
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
            DB::beginTransaction();
            $householdmembercrowd=Householdmembercrowd::with([
                'crowd'=>function($query){
                    $query->select(['id','name']);
                }])
                ->sharedLock()
                ->find($id);
            $data['crowd'] = Crowd::select(['id','name'])->where('parent_id','>',0)->get()?:[];
            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($householdmembercrowd)){
                $code='warning';
                $msg='数据不存在';
                $sdata=null;
                $edata=$data;
                $url=null;
            }else{
                $code='success';
                $msg='获取成功';
                $sdata=$householdmembercrowd;
                $edata=$data;
                $url=null;

                $view='gov.householdmembercrowd.edit';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }else{
            $member_id = $request->input('member_id');
            $model=new Householdmembercrowd();
            /* ********** 表单验证 ********** */
            $rules = [
                'member_id'=>'required',
                'crowd_id'=>['required',Rule::unique('item_household_member_crowd')->where(function ($query) use($member_id,$id){
                    $query->where('member_id', $member_id)->where('id','<>',$id);
                })],
                'picture'=>'required'
            ];
            $messages = [
                'required' => ':attribute 为必须项',
                'unique' => ':attribute 已存在'
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
                $householdmembercrowd=Householdmembercrowd::lockForUpdate()->find($id);
                if(blank($householdmembercrowd)){
                    throw new \Exception('指定数据项不存在',404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $householdmembercrowd->fill($request->all());
                $householdmembercrowd->editOther($request);
                $householdmembercrowd->save();
                if(blank($householdmembercrowd)){
                    throw new \Exception('修改失败',404404);
                }
                $code='success';
                $msg='修改成功';
                $sdata=$householdmembercrowd;
                $edata=null;
                $url = route('g_householdmember_info',['id'=>$member_id,'item'=>$item_id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=$householdmembercrowd;
                $url=null;
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }


}