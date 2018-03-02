<?php
/*
|--------------------------------------------------------------------------
| 项目-被征收户 家庭成员
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;
use App\Http\Model\Household;
use App\Http\Model\Householdmember;
use App\Http\Model\Householdmembercrowd;
use App\Http\Model\Nation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HouseholdmemberController extends BaseitemController
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

        $select=['id','item_id','household_id','land_id','building_id','name','relation','card_num','phone','nation_id','sex','age','crowd','holder','portion','deleted_at'];
        /* ********** 排序 ********** */
        $ordername=$request->input('ordername');
        $ordername=$ordername?$ordername:'id';
        $infos['ordername']=$ordername;

        $orderby=$request->input('orderby');
        $orderby=$orderby?$orderby:'asc';
        $infos['orderby']=$orderby;
        /* ********** 查询 ********** */
        $model=new Householdmember();
        DB::beginTransaction();
        try{
            $householdmembers=$model
                ->with(['item'=>function($query){
                    $query->select(['id','name']);
                    },
                    'itemland'=>function($query){
                        $query->select(['id','address']);
                    },
                    'itembuilding'=>function($query){
                        $query->select(['id','building']);
                    },
                    'nation'=>function($query){
                            $query->select(['id','name']);
                    }])
                ->where($where)
                ->select($select)
                ->orderBy($ordername,$orderby)
                ->sharedLock()
                ->get();
            if(blank($householdmembers)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$householdmembers;
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
            return view('gov.householdmember.index')->with($result);
        }
    }

    /* ========== 添加 ========== */
    public function add(Request $request){
        $item_id = $this->item_id;
        $household_id = $request->input('household_id');
        $model=new Householdmember();
        if($request->isMethod('get')){
            $sdata['household'] = Household::select(['id','land_id','item_id','building_id','type'])->find($household_id);
            $sdata['nation'] = Nation::select(['id','name'])->get();
            $edata = $model;
            $result=['code'=>'success','message'=>'请求成功','sdata'=>$sdata,'edata'=>$edata,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.householdmember.add')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else {
           $item_ids = $request->input('item');
            /* ++++++++++ 同一被征户是否存在第二个承租人【公产】 ++++++++++ */
            $holder = $request->input('holder');
            if($holder==2){
               $holder2_count =  Householdmember::where('item_id',$item_ids)
                    ->where('household_id',$household_id)
                    ->where('holder',$holder)
                    ->count();
               if($holder2_count){
                   $result=['code'=>'error','message'=>'承租人已经存在','sdata'=>null,'edata'=>null,'url'=>null];
                   if($request->ajax()){
                       return response()->json($result);
                   }else{
                       return view('gov.householdmember.add')->with($result);
                   }
               }
            }
            /* ++++++++++ 份额是否超过 ++++++++++ */
            $portion = $request->input('portion');
            $portion_sum = Householdmember::where('item_id',$item_ids)
                ->where('household_id',$household_id)
                ->sum('portion');
            $sums = $portion+$portion_sum;
            if($sums>100){
                $result=['code'=>'error','message'=>'总份额超出限定范围(0-100)','sdata'=>null,'edata'=>null,'url'=>null];
                if($request->ajax()){
                    return response()->json($result);
                }else{
                    return view('gov.householdmember.add')->with($result);
                }
            }

            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'household_id'=>'required',
                'name' =>  ['required',Rule::unique('item_household_member')->where(function ($query) use($household_id){
                    $query->where('household_id', $household_id);
                })],
                'land_id'=>'required',
                'building_id'=>'required',
                'relation'=>'required',
                'card_num'=>'required',
                'phone'=>'required',
                'nation_id'=>'required',
                'sex'=>'required',
                'age'=>'required',
                'crowd'=>'required',
                'holder'=>'required',
                'portion'=>'required',
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

            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try {
                /* ++++++++++ 批量赋值 ++++++++++ */
                $householdmember = $model;
                $householdmember->fill($request->input());
                $householdmember->addOther($request);
                $householdmember->item_id = $item_id;
                $householdmember->save();
                if (blank($householdmember)) {
                    throw new \Exception('添加失败', 404404);
                }

                $code = 'success';
                $msg = '添加成功';
                $sdata = $householdmember;
                $edata = null;
                $url = route('g_householddetail_info',['item'=>$item_id,'id'=>$household_id]);
                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '添加失败';
                $sdata = null;
                $edata = $householdmember;
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
        $householdmembercrowd = Householdmembercrowd::select(['id','item_id','crowd_id'])
                        ->with(['crowd'=>function($query){
                            $query->select(['id','name']);
                        }])
                        ->where('item_id',$this->item_id)->where('member_id',$id)->get();
        $householdmember=Householdmember::with([
            'nation'=>function($query){
                $query->select(['id','name']);
            }])
            ->sharedLock()
            ->find($id);
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($householdmember)){
            $code='warning';
            $msg='数据不存在';
            $sdata=null;
            $edata=$householdmembercrowd;
            $url=null;
        }else{
            $code='success';
            $msg='获取成功';
            $sdata=$householdmember;
            $edata=$householdmembercrowd;
            $url=null;

            $view='gov.householdmember.info';
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
            $data['household'] = Household::select(['id','land_id','item_id','building_id','type'])->find($household_id);
            $data['nation'] = Nation::select(['id','name'])->get();
            $data['householdmember'] = new Householdmember();
            $householdmember=Householdmember::with([
                'nation'=>function($query){
                    $query->select(['id','name']);
                }])
                ->sharedLock()
                ->find($id);
            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($householdmember)){
                $code='warning';
                $msg='数据不存在';
                $sdata=null;
                $edata=$data;
                $url=null;
            }else{
                $code='success';
                $msg='获取成功';
                $sdata=$householdmember;
                $edata=$data;
                $url=null;
                $view='gov.householdmember.edit';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }else{
            $item_ids = $request->input('item');
            /* ++++++++++ 同一被征户是否存在第二个承租人【公产】 ++++++++++ */
            $holder = $request->input('holder');
            if($holder==2){
                $holder2_count =  Householdmember::where('item_id',$item_ids)
                    ->where('household_id',$household_id)
                    ->where('holder',$holder)
                    ->count();
                if($holder2_count){
                    $result=['code'=>'error','message'=>'承租人已经存在','sdata'=>null,'edata'=>null,'url'=>null];
                    if($request->ajax()){
                        return response()->json($result);
                    }else{
                        return view('gov.householdmember.add')->with($result);
                    }
                }
            }
            /* ++++++++++ 份额是否超过 ++++++++++ */
            $portion = $request->input('portion');
            $portion_sum = Householdmember::where('item_id',$item_ids)
                ->where('household_id',$household_id)
                ->where('id','<>',$id)
                ->sum('portion');
            $sums = $portion+$portion_sum;
            if($sums>100){
                $result=['code'=>'error','message'=>'总份额超出限定范围(0-100)','sdata'=>null,'edata'=>null,'url'=>null];
                if($request->ajax()){
                    return response()->json($result);
                }else{
                    return view('gov.householdmember.add')->with($result);
                }
            }

            $model=new Household();
            /* ********** 表单验证 ********** */
            $rules = [
                'household_id'=>'required',
                'name' =>['required',Rule::unique('item_household_member')->where(function ($query) use($household_id,$id){
                    $query->where('household_id', $household_id)->where('id','<>',$id);
                })],
                'land_id'=>'required',
                'building_id'=>'required',
                'relation'=>'required',
                'card_num'=>'required',
                'phone'=>'required',
                'nation_id'=>'required',
                'sex'=>'required',
                'age'=>'required',
                'crowd'=>'required',
                'holder'=>'required',
                'portion'=>'required',
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
                $householdmember=Householdmember::lockForUpdate()->find($id);
                if(blank($householdmember)){
                    throw new \Exception('指定数据项不存在',404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $householdmember->fill($request->all());
                $householdmember->editOther($request);
                $householdmember->save();
                if(blank($householdmember)){
                    throw new \Exception('修改失败',404404);
                }
                $code='success';
                $msg='修改成功';
                $sdata=$householdmember;
                $edata=null;
                $url = route('g_householddetail_info',['id'=>$household_id,'item'=>$item_id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=$householdmember;
                $url=null;
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }


}