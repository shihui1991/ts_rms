<?php
/*
|--------------------------------------------------------------------------
| 项目-征收意见稿
|--------------------------------------------------------------------------
*/
namespace  App\Http\Controllers\gov;
use App\Http\Model\Crowd;
use App\Http\Model\Itemcrowd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;

class ItemcrowdController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 详情页 ========== */
    public function index(Request $request){

        $info['item_id']=$item_id=$this->item_id;

        /* ********** 每页条数 ********** */
        $per_page=15;
        $page=$request->input('page',1);

        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $total=Itemcrowd::sharedLock()
                ->where('item_id',$item_id)
                ->count();

            $itemrisk=Itemcrowd::with(['cate'=>function($query){
                    $query->select(['id','name']);
                },'crowd'=>function($query){
                    $query->select(['id','name']);
                }])
                ->where('item_id', $item_id)
                ->sharedLock()
                ->offset($per_page*($page-1))
                ->limit($per_page)
                ->get();
            $itemrisk=new LengthAwarePaginator($itemrisk,$total,$per_page,$page);
            $itemrisk->withPath(route('g_itemcrowd',['item'=>$item_id]));
            if(blank($itemrisk)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$itemrisk;
            $edata=$info;
            $url=null;
        }catch(\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=$info;
            $url=null;
        }
        DB::commit();
        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];

        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.itemcrowd.index')->with($result);
        }
    }

    /* ========== 添加页 ========== */
    public function add(Request $request){
        $item_id=$this->item_id;
        $model=new Itemcrowd();
        if($request->isMethod('get')){
            $sdata['item_id'] = $item_id;
            $sdata['crowd']=Crowd::where('parent_id','>',0)->pluck('name','id');
            $result=['code'=>'success','message'=>'请求成功','sdata'=>$sdata,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.itemcrowd.add')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else{
            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'crowd_id'=>'required|unique:item_crowd',
                'rate'=>'required'
            ];
            $messages = [
                'required' => ':attribute必须填写或选择',
                'unique' => ':attribute优惠不能重复添加'
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

                $model->fill($request->all());
                $model->addOther($request);
                $model->crowd_cate_id=DB::table('crowd')->where('id',$request->input('crowd_id'))->value('parent_id');
                $model->item_id=$this->item_id;
                $model->save();
                if (blank($model)) {
                    throw new \Exception('添加失败', 404404);
                }
                $code = 'success';
                $msg = '添加成功';
                $sdata = $model;
                $edata = null;
                $url = route('g_itemcrowd',['item'=>$this->item_id]);
                DB::commit();
            }catch (\Exception $exception){
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '添加失败';
                $sdata = null;
                $edata = null;
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
            $data=Itemcrowd::with(['cate'=>function($query){
                $query->select(['id','name']);
            },'crowd'=>function($query){
                $query->select(['id','name']);
            }])
                ->sharedLock()
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
                $view='gov.itemcrowd.edit';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }else{
            $model=new Itemcrowd();
            /* ********** 保存 ********** */
            $rules = [
                'crowd_id'=>'required',
                'rate'=>'required'
            ];
            $messages = [
                'required' => ':attribute必须填写或选择'
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
                $model=Itemcrowd::lockForUpdate()->find($id);
                if(blank($model)){
                    throw new \Exception('指定数据项不存在',404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $model->fill($request->all());
                $model->editOther($request);
                $model->crowd_cate_id=DB::table('crowd')->where('id',$request->input('crowd_id'))->value('parent_id');
                $model->item_id=$this->item_id;
                $model->save();
                if(blank($model)){
                    throw new \Exception('修改失败',404404);
                }
                $code='success';
                $msg='修改成功';
                $sdata=$model;
                $edata=null;
                $url=route('g_itemcrowd',['item'=>$this->item_id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=null;
                $url=null;
                DB::rollBack();
            }
            /* ********** 结果 ********** */
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

        $model= Itemcrowd::with(['cate'=>function($query){
            $query->select(['id','name']);
        },'crowd'=>function($query){
            $query->select(['id','name']);
        }])
            ->sharedLock()
            ->find($id);
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($model)){
            $code='warning';
            $msg='数据不存在';
            $sdata=null;
            $edata=null;
            $url=null;
        }else{
            $code='success';
            $msg='获取成功';
            $sdata=$model;
            $edata=null;
            $url=null;

            $view='gov.itemcrowd.info';
        }
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view($view)->with($result);
        }
    }
}