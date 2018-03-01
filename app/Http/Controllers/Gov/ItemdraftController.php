<?php
/*
|--------------------------------------------------------------------------
| 项目-征收意见稿
|--------------------------------------------------------------------------
*/
namespace  App\Http\Controllers\Gov;
use App\Http\Model\Itemdraft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ItemdraftController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 详情页 ========== */
    public function index(Request $request){
        $item_id=$this->item_id;
        /* ********** 查询条件 ********** */
        $where=[];
        $where[] = ['item_id',$item_id];
        $infos['item_id'] = $item_id;
        $select=['id','name','code','content','item_id','created_at','updated_at','deleted_at'];

        /* ********** 查询 ********** */
        $model=new Itemdraft();
        DB::beginTransaction();
        try{
            $itemdraft=$model
                ->with(['item'=>function($query){
                    $query->select(['id','name']);
                }])
                ->where($where)
                ->select($select)
                ->sharedLock()
                ->first();
            if(blank($itemdraft)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$itemdraft;
            $edata=$infos;
            $url=null;
        }catch(\Exception $exception){
            $itemdraft=collect();
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=$itemdraft;
            $edata=$infos;
            $url=null;
        }
        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];

        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.itemdraft.index')->with($result);
        }
    }

    /* ========== 添加页 ========== */
    public function add(Request $request){
        $item_id=$this->item_id;
        $model=new Itemdraft();
        if($request->isMethod('get')){
            $sdata['item_id'] = $item_id;
            $result=['code'=>'success','message'=>'请求成功','sdata'=>$sdata,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.itemdraft.add')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else{
            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'content'=>'required',
                'name'=>'required',
                'code' => 'required'
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
            try{
                /* ++++++++++ 批量赋值 ++++++++++ */
                $itemdraft = $model;
                $itemdraft->fill($request->all());
                $itemdraft->addOther($request);
                $itemdraft->item_id=$this->item_id;
                $itemdraft->save();
                if (blank($itemdraft)) {
                    throw new \Exception('添加失败', 404404);
                }
                $code = 'success';
                $msg = '添加成功';
                $sdata = $itemdraft;
                $edata = null;
                $url = route('g_itemdarft',['item'=>$this->item_id]);
                DB::commit();
            }catch (\Exception $exception){
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '添加失败';
                $sdata = null;
                $edata = $itemdraft;
                $url = null;
                DB::rollBack();
            }
            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }

    /* ========== 修改页 ========== */
    public function edit(Request $request){
        $item_id=$this->item_id;
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
            $data=Itemdraft::sharedLock()
                ->find($id);

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

                $view='gov.itemdraft.edit';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }else{
            $model=new Itemdraft();
            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'content'=>'required',
                'name'=>'required',
                'code' => 'required'
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
                $itemdraft=Itemdraft::lockForUpdate()->find($id);
                if(blank($itemdraft)){
                    throw new \Exception('指定数据项不存在',404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $itemdraft->fill($request->all());
                $itemdraft->editOther($request);
                $itemdraft->save();
                if(blank($itemdraft)){
                    throw new \Exception('修改失败',404404);
                }
                $code='success';
                $msg='修改成功';
                $sdata=$itemdraft;
                $edata=null;
                $url=route('g_itemdraft',['item'=>$this->item_id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=$exception->getMessage();
                $url=null;
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }
}