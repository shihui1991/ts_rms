<?php
/*
|--------------------------------------------------------------------------
| 项目-地块楼栋
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;
use App\Http\Model\Buildingstruct;
use App\Http\Model\Itembuilding;
use App\Http\Model\Itemland;
use App\Http\Model\Itempublic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ItembuildingController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 查询地块下所有楼栋 ========== */
    public function index(Request $request){
        $item_id=$this->item_id;

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
        $model=new Itembuilding();
        DB::beginTransaction();
        try{
            /* ********** 是否分页 ********** */
            if($displaynum){
                $itembuildings=$model
                    ->with(['item'=>function($query){
                        $query->select(['id','name']);
                    },
                        'itemland'=>function($query){
                            $query->select(['id','address']);
                        },
                        'buildingstruct'=>function($query){
                            $query->select(['id','name']);
                        }])
                    ->where($where)
                    ->orderBy($ordername,$orderby)
                    ->sharedLock()
                    ->paginate($displaynum);
            }else{
                $itembuildings=$model
                    ->with(['item'=>function($query){
                        $query->select(['id','name']);
                    },
                        'itemland'=>function($query){
                            $query->select(['id','address']);
                        },
                        'buildingstruct'=>function($query){
                            $query->select(['id','name']);
                        }])
                    ->where($where)
                    ->orderBy($ordername,$orderby)
                    ->sharedLock()
                    ->get();
            }

            if(blank($itembuildings)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$itembuildings;
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
        return response()->json($result);
    }

    /* ========== 添加 ========== */
    public function add(Request $request){
        $item_id=$this->item_id;
        $land_id=$request->input('land_id');
        if(!$land_id){
            $result=['code'=>'error','message'=>'请先选择地块','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }

        $model=new Itembuilding();
        if($request->isMethod('get')){
            DB::beginTransaction();

            $itemland = Itemland::sharedLock()->find($land_id);
            $buildingstructs=Buildingstruct::sharedLock()->select(['id','name'])->get();
            if(blank($itemland)){
                $result=['code'=>'error','message'=>'数据不存在','sdata'=>null,'edata'=>null,'url'=>null];
                if($request->ajax()){
                    return response()->json($result);
                }else{
                    return view('gov.error')->with($result);
                }
            }
            $result=[
                'code'=>'success',
                'message'=>'请求成功',
                'sdata'=>[
                    'item'=>$this->item,
                    'itemland'=>$itemland,
                    'buildingstructs'=>$buildingstructs,
                ],
                'edata'=>null,
                'url'=>null];

            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.itembuilding.add')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else {
            /* ********** 保存 ********** */
            $land_id = $request->input('land_id');
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'land_id' => 'required',
                'building' => ['required',Rule::unique('item_building')->where(function ($query) use($land_id){
                    $query->where('land_id', $land_id);
                 })],
                'total_floor' => 'required',
                'area' => 'required',
                'build_year' => 'required',
                'struct_id' => 'required',
            ];
            $messages = [
                'required' => ':attribute必须填写',
                'unique'=>':attribute已经存在'
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
                $itembuilding = $model;
                $itembuilding->fill($request->input());
                $itembuilding->addOther($request);
                $itembuilding->item_id=$this->item_id;
                $itembuilding->save();
                if (blank($itembuilding)) {
                    throw new \Exception('添加失败', 404404);
                }

                $code = 'success';
                $msg = '添加成功';
                $sdata = $itembuilding;
                $edata = null;
                $url = route('g_itemland_info',['id'=>$land_id,'item'=>$item_id]);
                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '添加失败';
                $sdata = null;
                $edata = $itembuilding;
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
        DB::beginTransaction();
        $itembuilding=Itembuilding::with(['itemland'=>function($query){
            $query->select(['id','address']);
        },'buildingstruct'=>function($query){
            $query->select(['id','name']);
        }])
            ->sharedLock()
            ->find($id);

        if(!$itembuilding){
            $result=['code'=>'error','message'=>'数据不存在','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }

        $itempublics=Itempublic::sharedLock()
            ->where('item_id',$this->item_id)
            ->where('land_id',$itembuilding->land_id)
            ->where('building_id',$id)
            ->get();
        DB::commit();

        $result=[
            'code'=>'success',
            'message'=>'获取成功',
            'sdata'=>[
                'item'=>$this->item,
                'itembuilding'=>$itembuilding,
                'itempublics'=>$itempublics,
            ],
            'edata'=>null,
            'url'=>null];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view('gov.itembuilding.info')->with($result);
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
            $itembuilding=Itembuilding::with(['itemland'=>function($query){
                $query->select(['id','address']);
            }])
                ->sharedLock()
                ->find($id);

            $buildingstructs=Buildingstruct::sharedLock()->select(['id','name'])->get();
            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($itembuilding)){
                $code='warning';
                $msg='数据不存在';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='gov.error';
            }else{
                $code='success';
                $msg='获取成功';
                $sdata=['item'=>$this->item,'itembuilding'=>$itembuilding,'buildingstructs'=>$buildingstructs];
                $edata=null;
                $url=null;

                $view='gov.itembuilding.edit';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }else{
            $model=new Itembuilding();
            /* ********** 更新 ********** */
            DB::beginTransaction();
            try{
                /* ++++++++++ 锁定数据模型 ++++++++++ */
                $itembuilding=Itembuilding::lockForUpdate()->find($id);
                if(blank($itembuilding)){
                    throw new \Exception('指定数据项不存在',404404);
                }
                $land_id=$itembuilding->land_id;
                /* ********** 表单验证 ********** */
                $rules=[
                    'building' =>['required',Rule::unique('item_building')->where(function ($query) use($land_id,$id){
                        $query->where('land_id', $land_id)->where('id','<>',$id);
                    })],
                    'total_floor' => 'required',
                    'area' => 'required',
                    'build_year' => 'required',
                    'struct_id' => 'required',
                ];
                $messages=[
                    'required'=>':attribute必须填写',
                    'unique'=>':attribute已存在'
                ];
                $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
                if ($validator->fails()) {
                    throw new \Exception($validator->errors()->first(),404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $itembuilding->fill($request->input());
                $itembuilding->editOther($request);
                $itembuilding->save();
                if(blank($itembuilding)){
                    throw new \Exception('修改失败',404404);
                }
                $code='success';
                $msg='修改成功';
                $sdata=$itembuilding;
                $edata=null;
                $url = route('g_itembuilding_info',['id'=>$id,'item'=>$this->item_id]);
                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=$itembuilding;
                $url=null;
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }
}