<?php
/*
|--------------------------------------------------------------------------
| 项目-公共附属物
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;
use App\Http\Model\Itembuilding;
use App\Http\Model\Itemland;
use App\Http\Model\Itempublic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItempublicController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 查询地块下所有公共附属物 ========== */
    public function index(Request $request){
        $item_id=$request->input('item_id');
        if(!$item_id){
            $result=['code'=>'error','message'=>'请先选择项目','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }

        $land_id=$request->input('land_id');
        if(!$land_id){
            $result=['code'=>'error','message'=>'请先选择地块','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }
        /* ********** 查询条件 ********** */
        $where=[];
        $select=['id','item_id','land_id','building_id','name','num_unit','number','infos','picture'];

        $where[]=['item_id',$item_id];
        $infos['item_id']=$item_id;
        $where[]=['land_id',$land_id];
        $infos['land_id']=$land_id;
        /* ********** 排序 ********** */
        $ordername=$request->input('ordername');
        $ordername=$ordername?$ordername:'id';
        $infos['ordername']=$ordername;

        $orderby=$request->input('orderby');
        $orderby=$orderby?$orderby:'asc';
        $infos['orderby']=$orderby;
        /* ********** 每页条数 ********** */
        $displaynum=$request->input('displaynum');
        $infos['displaynum']=$displaynum;
        /* ********** 查询 ********** */
        $model=new Itempublic();
        DB::beginTransaction();
        try{
            /* ********** 是否分页 ********** */
            if($displaynum){
                $itempublics=$model
                    ->with(['item'=>function($query){
                        $query->select(['id','name']);
                    },
                        'itemland'=>function($query){
                            $query->select(['id','address']);
                        },
                        'itembuilding'=>function($query){
                            $query->select(['id','building']);
                        }])
                    ->where($where)
                    ->select($select)
                    ->orderBy($ordername,$orderby)
                    ->sharedLock()
                    ->paginate($displaynum);
            }else{
                $itempublics=$model
                    ->with(['item'=>function($query){
                        $query->select(['id','name']);
                    },
                        'itemland'=>function($query){
                            $query->select(['id','address']);
                        },
                        'itembuilding'=>function($query){
                            $query->select(['id','building']);
                        }])
                    ->where($where)
                    ->select($select)
                    ->orderBy($ordername,$orderby)
                    ->sharedLock()
                    ->get();
            }

            if(blank($itempublics)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$itempublics;
            $edata=$infos;
            $url=null;
        }catch (\Exception $exception){
            $itempublics=collect();
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=$itempublics;
            $edata=$infos;
            $url=null;
        }
        DB::commit();

        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.itempublic.index')->with($result);
        }
    }

    /* ========== 添加 ========== */
    public function add(Request $request){
        $item_id=$request->input('item_id');
        if(!$item_id){
            $result=['code'=>'error','message'=>'请先选择项目','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }

        $land_id=$request->input('land_id');
        if(!$land_id){
            $result=['code'=>'error','message'=>'请先选择地块','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }
        $building_id=$request->input('building_id');
        if($request->input('building')=='buildingpublic'){
            if(!$building_id){
                $result=['code'=>'error','message'=>'请先选择楼栋','sdata'=>null,'edata'=>null,'url'=>null];
                if($request->ajax()){
                    return response()->json($result);
                }else{
                    return view('gov.error')->with($result);
                }
            }
        }

        $itemland_count = Itemland::where(['item_id'=>$item_id,'id'=>$land_id])->count();
        if(!$itemland_count){
            $result=['code'=>'error','message'=>'该条数据不存在','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }

        $model=new Itempublic();
        if($request->isMethod('get')){
            $sdata['land_id'] = $land_id;
            $sdata['item_id'] = $item_id;
            $sdata['building_id'] = $building_id;
            $sdata['building'] = $request->input('building');
            $result=['code'=>'success','message'=>'请求成功','sdata'=>$sdata,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.itempublic.add')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else {
            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'item_id' => 'required',
                'land_id' => 'required',
                'building_id' => 'required',
                'name' => 'required',
                'num_unit' => 'required',
                'number' => 'required'
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
                $itempublic = $model;
                $itempublic->fill($request->input());
                $itempublic->addOther($request);
                $itempublic->save();
                if (blank($itempublic)) {
                    throw new \Exception('添加失败', 404404);
                }

                $code = 'success';
                $msg = '添加成功';
                $sdata = $itempublic;
                $edata = null;
                if($request->input('building')=='buildingpublic') {
                    $url = route('g_itembuilding_info',['id'=>$building_id,'land_id'=>$land_id,'item_id'=>$item_id]);
                }else{
                    $url = route('g_itemland_info',['id'=>$land_id,'item_id'=>$item_id]);
                }
                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '添加失败';
                $sdata = null;
                $edata = $itempublic;
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
        $item_id=$request->input('item_id');
        if(!$item_id){
            $result=['code'=>'error','message'=>'请先选择项目','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }
        $building_id = $request->input('building_id');
        if($request->input('building')=='buildingpublic') {

            if (!$building_id) {
                $result = ['code' => 'error', 'message' => '请先选择楼栋', 'sdata' => null, 'edata' => null, 'url' => null];
                if ($request->ajax()) {
                    return response()->json($result);
                } else {
                    return view('gov.error')->with($result);
                }
            }
        }
        $land_id=$request->input('land_id');
        if(!$land_id){
            $result=['code'=>'error','message'=>'请先选择地块','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }
        $itemland_count = Itemland::where(['item_id'=>$item_id,'id'=>$land_id])->count();
        if(!$itemland_count){
            $result=['code'=>'error','message'=>'该条数据不存在','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }
        /* ********** 当前数据 ********** */
        $data['item_id'] = $item_id;
        $data['land_id'] = $land_id;
        $data['building_id'] = $building_id;
        $data['building'] = $request->input('building');
        DB::beginTransaction();
        $itempublic=Itempublic::with(
            ['item'=>function($query){
                $query->select(['id','name']);
            },
                'itemland'=>function($query){
                    $query->select(['id','address']);
                }])
            ->sharedLock()
            ->find($id);
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($itempublic)){
            $code='warning';
            $msg='数据不存在';
            $sdata=null;
            $edata=$data;
            $url=null;
        }else{
            $code='success';
            $msg='获取成功';
            $sdata=$itempublic;
            $edata=$data;
            $url=null;

            $view='gov.itempublic.info';
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
        $item_id=$request->input('item_id');
        if(!$item_id){
            $result=['code'=>'error','message'=>'请先选择项目','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }
        $land_id=$request->input('land_id');
        if(!$land_id){
            $result=['code'=>'error','message'=>'请先选择地块','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }
        $building_id = $request->input('building_id');
        if($request->input('building')=='buildingpublic') {
            if (!$building_id) {
                $result = ['code' => 'error', 'message' => '请先选择楼栋', 'sdata' => null, 'edata' => null, 'url' => null];
                if ($request->ajax()) {
                    return response()->json($result);
                } else {
                    return view('gov.error')->with($result);
                }
            }
        }
        $itemland_count = Itemland::where(['item_id'=>$item_id,'id'=>$land_id])->count();
        if(!$itemland_count){
            $result=['code'=>'error','message'=>'该条数据不存在','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }
        if ($request->isMethod('get')) {
            /* ********** 当前数据 ********** */
            $data['item_id'] = $request->input('item_id');
            $data['land_id'] = $request->input('land_id');
            $data['building_id'] = $building_id;
            $data['building'] = $request->input('building');
            DB::beginTransaction();
            $itempublic=Itempublic::with(
                ['item'=>function($query){
                    $query->select(['id','name']);
                },
                    'itemland'=>function($query){
                        $query->select(['id','address']);
                    }])
                ->sharedLock()
                ->find($id);
            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($itempublic)){
                $code='warning';
                $msg='数据不存在';
                $sdata=null;
                $edata=$data;
                $url=null;
            }else{
                $code='success';
                $msg='获取成功';
                $sdata=$itempublic;
                $edata=$data;
                $url=null;

                $view='gov.itempublic.edit';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }else{
            $model=new Itempublic();
            /* ********** 表单验证 ********** */
            $rules=[
                'name' => 'required',
                'num_unit' => 'required',
                'number' => 'required'
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
                $itempublic=Itempublic::lockForUpdate()->find($id);
                if(blank($itempublic)){
                    throw new \Exception('指定数据项不存在',404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $itempublic->fill($request->all());
                $itempublic->editOther($request);
                $itempublic->save();
                if(blank($itempublic)){
                    throw new \Exception('修改失败',404404);
                }
                $code='success';
                $msg='修改成功';
                $sdata=$itempublic;
                $edata=null;
                if($request->input('building')=='buildingpublic') {
                    $url = route('g_itembuilding_info',['id'=>$building_id,'land_id'=>$land_id,'item_id'=>$item_id]);
                }else{
                    $url = route('g_itemland_info',['id'=>$land_id,'item_id'=>$item_id]);
                }


                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=$itempublic;
                $url=null;
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }


}