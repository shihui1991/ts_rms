<?php
/*
|--------------------------------------------------------------------------
| 项目-地块
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;
use App\Http\Model\Adminunit;
use App\Http\Model\Itembuilding;
use App\Http\Model\Itemland;
use App\Http\Model\Itempublic;
use App\Http\Model\Landprop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemlandController extends BaseController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {

    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        //        $item_id=$request->input('item_id');
        $item_id=1;
        if(!$item_id){
            $result=['code'=>'error','message'=>'请先选择项目','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }

        /* ********** 查询条件 ********** */
        $where=[];
        $where[] = ['item_id',$item_id];
        $infos['item_id'] = $item_id;
        $select=['id','item_id','address','land_prop_id','land_source_id','land_state_id','admin_unit_id','area','infos'];
        /* ++++++++++ 地址 ++++++++++ */
        $address=trim($request->input('address'));
        if($address){
            $where[]=['address','like','%'.$address.'%'];
            $infos['address']=$address;
        }
        /* ********** 排序 ********** */
        $ordername=$request->input('ordername');
        $ordername=$ordername?$ordername:'id';
        $infos['ordername']=$ordername;

        $orderby=$request->input('orderby');
        $orderby=$orderby?$orderby:'asc';
        $infos['orderby']=$orderby;
        /* ********** 每页条数 ********** */
        $displaynum=$request->input('displaynum');
        $displaynum=$displaynum?$displaynum:15;
        $infos['displaynum']=$displaynum;
        /* ********** 查询 ********** */
        $model=new Itemland();
        DB::beginTransaction();
        try{
            $itemlands=$model
                ->with(['item'=>function($query){
                    $query->select(['id','name']);
                },
                    'landprop'=>function($query){
                        $query->select(['id','name']);
                    },
                    'landsource'=>function($query){
                        $query->select(['id','name']);
                    },
                    'landstate'=>function($query){
                        $query->select(['id','name']);
                    },
                    'adminunit'=>function($query){
                        $query->select(['id','name']);
                }])
                ->where($where)
                ->select($select)
                ->orderBy($ordername,$orderby)
                ->sharedLock()
                ->paginate($displaynum);
            if(blank($itemlands)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$itemlands;
            $edata=$infos;
            $url=null;
        }catch (\Exception $exception){
            $itemlands=collect();
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=$itemlands;
            $edata=$infos;
            $url=null;
        }
        DB::commit();

        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.itemland.index')->with($result);
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

        $model=new Itemland();
        if($request->isMethod('get')){
            $sdata['landprop'] = Landprop::select(['id','name'])->get()?:[];
            $sdata['adminunit'] = Adminunit::select(['id','name'])->get()?:[];
            $sdata['item_id'] = $item_id;
            $result=['code'=>'success','message'=>'请求成功','sdata'=>$sdata,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.itemland.add')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else {
            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'item_id' => 'required',
                'address' => 'required|unique:item_land',
                'land_prop_id' => 'required',
                'land_source_id' => 'required',
                'land_state_id' => 'required',
                'admin_unit_id' => 'required',
                'area' => 'required'
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
                $itemland = $model;
                $itemland->fill($request->input());
                $itemland->addOther($request);
                $itemland->save();
                if (blank($itemland)) {
                    throw new \Exception('添加失败', 404404);
                }

                $code = 'success';
                $msg = '添加成功';
                $sdata = $itemland;
                $edata = null;
                $url = route('g_itemland');
                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '添加失败';
                $sdata = null;
                $edata = $itemland;
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
//        $item_id=$request->input('item_id');
        $item_id=1;
        if(!$item_id){
            $result=['code'=>'error','message'=>'请先选择项目','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }

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
        $data['item_id'] = $item_id;
        /* ++++++++++ 地块信息 ++++++++++ */
        $data['itemland']=Itemland::sharedLock()->find($id);
        /* ++++++++++ 楼栋信息 ++++++++++ */
        $itembuilding_select=['id','item_id','land_id','building','total_floor','area','build_year','struct_id','picture','deleted_at'];
        $data['itembuilding']=Itembuilding::with(
                ['item'=>function($query){
                    $query->select(['id','name']);
                },
                'itemland'=>function($query){
                    $query->select(['id','address']);
                },
                'buildingstruct'=>function($query){
                    $query->select(['id','name']);
                }])
            ->where('item_id',$item_id)
            ->where('land_id',$id)
            ->select($itembuilding_select)
            ->sharedLock()
            ->get();
        /* ++++++++++ 地块公共附属物 ++++++++++ */
        $itempublic_select=['id','item_id','land_id','building_id','name','num_unit','number','infos','picture'];
        $data['itempublic']=Itempublic::with(
                ['item'=>function($query){
                     $query->select(['id','name']);
                },
                'itemland'=>function($query){
                    $query->select(['id','address']);
                },
                'itembuilding'=>function($query){
                    $query->select(['id','building']);
                }])
            ->where('item_id',$item_id)
            ->where('land_id',$id)
            ->where('building_id',0)
            ->select($itempublic_select)
            ->sharedLock()
            ->get();
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($data)){
            $code='warning';
            $msg='数据不存在';
            $sdata=null;
            $edata=null;
            $url=null;
        }else{
            $code='success';
            $msg='获取成功';
            $sdata=$data;
            $edata=null;
            $url=null;

            $view='gov.itemland.info';
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
            $itemland=Itemland::sharedLock()->find($id);
            $data['landprop'] = Landprop::select(['id','name'])->get()?:[];
            $data['adminunit'] = Adminunit::select(['id','name'])->get()?:[];
            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($itemland)){
                $code='warning';
                $msg='数据不存在';
                $sdata=null;
                $edata=$data;
                $url=null;

            }else{
                $code='success';
                $msg='获取成功';
                $sdata=$itemland;
                $edata=$data;
                $url=null;

                $view='gov.itemland.edit';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }else{
            $model=new Itemland();
            /* ********** 表单验证 ********** */
            $rules=[
                'address'=>'required|unique:item_land,address,'.$id.',id'
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
                $itemland=Itemland::lockForUpdate()->find($id);
                if(blank($itemland)){
                    throw new \Exception('指定数据项不存在',404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $itemland->fill($request->input());
                $itemland->addOther($request);
                $itemland->save();
                if(blank($itemland)){
                    throw new \Exception('修改失败',404404);
                }
                $code='success';
                $msg='修改成功';
                $sdata=$itemland;
                $edata=null;
                $url=route('g_itemland');

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=$itemland;
                $url=null;
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }

}