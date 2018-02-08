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

class ItempublicController extends BaseController
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
        $select=['id','item_id','land_id','building_id','name','num_unit','number','infos','picture'];

        $where[]=['item_id',$item_id];
        $infos['item_id']=$item_id;
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
        $model=new Itempublic();
        DB::beginTransaction();
        try{
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
            $sdata['building'] = $request->input('building')?:'';
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
                $url = route('g_itemland_info',['id'=>$land_id,'item_id'=>$item_id]);
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


}