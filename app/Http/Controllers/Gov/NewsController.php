<?php
/*
|--------------------------------------------------------------------------
| 项目-通知公告
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use App\Http\Model\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NewsController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        DB::beginTransaction();

        $newses=News::with(['newscate'=>function($query){
            $query->select(['id','name']);
        }])
            ->sharedLock()
            ->orderBy('is_top','desc')
            ->orderBy('release_at','asc')
            ->get();

        DB::commit();

        /* ********** 结果 ********** */
        $result=[
            'code'=>'success',
            'message'=>'请求成功',
            'sdata'=>[
                'item'=>$this->item,
                'newses'=>$newses,
            ],
            'edata'=>null,
            'url'=>null];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.news.index')->with($result);
        }
    }

    /* ========== 添加范围公告 ========== */
    public function add(Request $request){
        $model=new News();
        if($request->isMethod('get')){

            $result=['code'=>'success','message'=>'请求成功','sdata'=>['item'=>$this->item],'edata'=>$model,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.news.add')->with($result);
            }
        }
        /* ********** 保存 ********** */
        else{

            /* ++++++++++ 表单验证 ++++++++++ */
            $rules=[
                'name'=>'required',
                'release_at'=>'required|date_format:Y-m-d',
                'infos'=>'required',
                'content'=>'required',
                'picture'=>'required',
                'is_top'=>'required|boolean',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'date_format'=>':attribute 输入格式错误',
                'boolean'=>'请选择 :attribute 正确的选择',
            ];
            
            $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }

            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try{
                /* ++++++++++ 批量赋值 ++++++++++ */
                $news=$model;
                $news->fill($request->input());
                $news->addOther($request);
                $news->item_id=$this->item_id;
                $news->cate_id=1;
                $news->state=0;
                $news->save();
                if(blank($news)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=$news;
                $edata=null;
                $url=route('g_news',['item'=>$this->item_id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'保存失败';
                $sdata=null;
                $edata=null;
                $url=null;

                DB::rollBack();
            }
            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }

    /* ========== 公告详情 ========== */
    public function info(Request $request){
        $id=$request->input('id');
        if(!$id){
            $result=['code'=>'error', 'message'=>'错误操作', 'sdata'=>null, 'edata'=>null, 'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else {
                return view('gov.error')->with($result);
            }
        }

        DB::beginTransaction();
        $news=News::with(['newscate'=>function($query){
            $query->select(['id','name']);
        }])
            ->sharedLock()
            ->find($id);

        DB::commit();
        if(filled($news)){
            $code='success';
            $msg='请求成功';
            $sdata=['item'=>$this->item,'news'=>$news];
            $edata=null;
            $url=null;

            $view='gov.news.info';
        }else{
            $code='error';
            $msg='数据不存在';
            $sdata=null;
            $edata=null;
            $url=null;

            $view='gov.error';
        }
        $result=['code'=>$code, 'message'=>$msg, 'sdata'=>$sdata, 'edata'=>$edata, 'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view($view)->with($result);
        }
    }

    /* ========== 修改公告 ========== */
    public function edit(Request $request){
        $id=$request->input('id');
        if(!$id){
            $result=['code'=>'error', 'message'=>'错误操作', 'sdata'=>null, 'edata'=>null, 'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else {
                return view('gov.error')->with($result);
            }
        }

        $model=new News();
        if($request->isMethod('get')){
            DB::beginTransaction();
            $news=News::with(['newscate'=>function($query){
                $query->select(['id','name']);
            }])
                ->sharedLock()
                ->find($id);

            DB::commit();
            if(filled($news)){
                $code='success';
                $msg='请求成功';
                $sdata=['item'=>$this->item,'news'=>$news];
                $edata=$model;
                $url=null;

                $view='gov.news.edit';
            }else{
                $code='error';
                $msg='数据不存在';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='gov.error';
            }
            $result=['code'=>$code, 'message'=>$msg, 'sdata'=>$sdata, 'edata'=>$edata, 'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else {
                return view($view)->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else{
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules=[
                'name'=>'required',
                'release_at'=>'required|date_format:Y-m-d',
                'infos'=>'required',
                'content'=>'required',
                'picture'=>'required',
                'is_top'=>'required|boolean',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'date_format'=>':attribute 输入格式错误',
                'boolean'=>'请选择 :attribute 正确的选择',
            ];

            $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }

            DB::beginTransaction();
            try{
                $news=News::lockForUpdate()->find($id);
                if(blank($news)){
                    throw new \Exception('数据不存在',404404);
                }
                /* ++++++++++ 批量赋值 ++++++++++ */
                $news->fill($request->input());
                $news->editOther($request);
                $news->save();
                if(blank($news)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=$news;
                $edata=null;
                $url=route('g_news_info',['item'=>$this->item_id,'id'=>$id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'保存失败';
                $sdata=null;
                $edata=null;
                $url=null;

                DB::rollBack();
            }
            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }
}