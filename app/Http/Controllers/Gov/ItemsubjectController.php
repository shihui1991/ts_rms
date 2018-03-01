<?php
/*
|--------------------------------------------------------------------------
| 项目-补偿科目说明
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;
use App\Http\Model\Itemsubject;
use App\Http\Model\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ItemsubjectController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        $item_id=$this->item_id;
        /* ********** 检测是否已添加所有的重要补偿科目【固定科目】 ********** */
        DB::beginTransaction();
        $subjects = Subject::where('main',1)
            ->sharedLock()
            ->pluck('infos','id');
        $subject_ids=$subjects->keys();
        $itemsubject_subids=Itemsubject::where('item_id',$item_id)->whereIn('subject_id',$subject_ids)->pluck('subject_id');
        $diff = $subject_ids->diff($itemsubject_subids);
        /*---------存在差集【添加】------------*/
        if(filled($diff)){
            $itemsubject_array = [];
            foreach ($diff as $v){
                    $itemsubject_array[] = [
                        'item_id'=>$item_id,
                        'subject_id'=>$v,
                        'infos'=>$subjects[$v],
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s')
                    ];
            }
            $fild_arr = ['item_id','subject_id','infos','created_at','updated_at'];
            $sqls=batch_update_or_insert_sql('item_subject',$fild_arr,$itemsubject_array,$fild_arr);

            if(!$sqls){
                $result=['code'=>'warning','message'=>'暂无数据可更新','sdata'=>$itemsubject_array,'edata'=>null,'url'=>null];
                if($request->ajax()){
                    return response()->json($result);
                }else {
                    return view('gov.itemsubject.index')->with($result);
                }
            }
            foreach ($sqls as $sql){
                DB::statement($sql);
            }
        }
        DB::commit();
        /* ********** 查询条件 ********** */
        $where=[];
        $where[] = ['item_id',$item_id];
        $infos['item_id'] = $item_id;
        $select=['id','item_id','subject_id'];
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
        $model=new Itemsubject();
        DB::beginTransaction();
        try{
            $itemsubjects=$model
                ->with(['subject'=>function($query){
                        $query->select(['id','name']);
                    }])
                ->where($where)
                ->select($select)
                ->orderBy($ordername,$orderby)
                ->sharedLock()
                ->paginate($displaynum);
            if(blank($itemsubjects)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$itemsubjects;
            $edata=$infos;
            $url=null;
        }catch (\Exception $exception){
            $itemsubjects=collect();
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=$itemsubjects;
            $edata=$infos;
            $url=null;
        }
        DB::commit();

        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.itemsubject.index')->with($result);
        }
    }

    /* ========== 添加 ========== */
    public function add(Request $request){
        $item_id=$this->item_id;

        $model=new Itemsubject();
        if($request->isMethod('get')){
            $sdata['subject'] = Subject::select(['id','name'])->where('main',0)->get()?:[];
            $sdata['item_id'] = $item_id;
            $result=['code'=>'success','message'=>'请求成功','sdata'=>$sdata,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.itemsubject.add')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else {
            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'item_id' => 'required',
                'subject_id' => ['required',Rule::unique('item_subject')->where(function ($query) use($item_id){
                    $query->where('item_id', $item_id);
                })],
                'infos' => 'required'
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
                $itemsubject = $model;
                $itemsubject->fill($request->all());
                $itemsubject->addOther($request);
                $itemsubject->item_id=$this->item_id;
                $itemsubject->save();
                if (blank($itemsubject)) {
                    throw new \Exception('添加失败', 404404);
                }

                $code = 'success';
                $msg = '添加成功';
                $sdata = $itemsubject;
                $edata = null;
                $url = route('g_itemsubject',['item'=>$this->item_id]);
                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '添加失败';
                $sdata = null;
                $edata = $itemsubject;
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

        $itemtopid=Itemsubject::with(
            ['item'=>function($query){
                $query->select(['id','name']);
            },
                'subject'=>function($query){
                    $query->select(['id','name']);
                }])
            ->sharedLock()
            ->find($id);
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($itemtopid)){
            $code='warning';
            $msg='数据不存在';
            $sdata=null;
            $edata=null;
            $url=null;
        }else{
            $code='success';
            $msg='获取成功';
            $sdata=$itemtopid;
            $edata=null;
            $url=null;

            $view='gov.itemsubject.info';
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
            $itemsubject=Itemsubject::with(
                [ 'subject'=>function($query){
                    $query->select(['id','name']);
                 }])
                ->sharedLock()
                ->find($id);
            $data['subject'] = Subject::select(['id','name'])->get()?:[];
            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($itemsubject)){
                $code='warning';
                $msg='数据不存在';
                $sdata=null;
                $edata=$data;
                $url=null;

            }else{
                $code='success';
                $msg='获取成功';
                $sdata=$itemsubject;
                $edata=$data;
                $url=null;

                $view='gov.itemsubject.edit';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }else{
            $model=new Itemsubject();
            /* ********** 表单验证 ********** */
            $rules=[
                'subject_id'=>['required',Rule::unique('item_subject')->where(function ($query) use($item_id,$id){
                    $query->where('item_id', $item_id)->where('id','<>',$id);
                })],
                'infos' => 'required'
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
                $itemsubject=Itemsubject::lockForUpdate()->find($id);
                if(blank($itemsubject)){
                    throw new \Exception('指定数据项不存在',404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $itemsubject->fill($request->all());
                $itemsubject->editOther($request);
                $itemsubject->save();
                if(blank($itemsubject)){
                    throw new \Exception('修改失败',404404);
                }
                $code='success';
                $msg='修改成功';
                $sdata=$itemsubject;
                $edata=null;
                $url=route('g_itemsubject',['item'=>$this->item_id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=$itemsubject;
                $url=null;
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }
}