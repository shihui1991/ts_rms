<?php
/*
|--------------------------------------------------------------------------
| 必备附件分类
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;
use App\Http\Model\Filecate;
use App\Http\Model\Filetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FilecateController extends BaseauthController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        DB::beginTransaction();
        try{
            $filetables=Filetable::with('filecates')->sharedLock()->get();
            if(blank($filetables)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='请求成功';
            $sdata=$filetables;
            $edata=null;
            $url=null;

            $view='gov.filecate.index';
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=null;
            $url=null;

            $view='gov.error';
        }
        DB::commit();

        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view($view)->with($result);
        }
    }

    /* ========== 添加分类 ========== */
    public function add(Request $request){
        $file_table_id=$request->input('file_table_id');
        if(!$file_table_id){
            $result=['code'=>'error','message'=>'错误操作','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                $filetable=Filetable::sharedLock()->find($file_table_id);
                if(blank($filetable)){
                    throw new \Exception('分类不存在',404404);
                }

                $code='success';
                $msg='请求成功';
                $sdata=$filetable;
                $edata=null;
                $url=null;

                $view='gov.filecate.add';
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='gov.error';
            }
            DB::commit();

            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else {
                return view($view)->with($result);
            }
        }
        /* ********** 保存 ********** */
        else{
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules=[
                'file_table_id'=>['required','regex:/^[0-9]+$/'],
                'name'=>'required|unique:file_cate',
                'filename'=>['required',Rule::unique('file_cate')->where(function ($query){
                    $query->where('file_table_id',request()->input('file_table_id'));
                })]
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'file_table_id.regex'=>'错误操作',
                'unique'=>':attribute 已存在',
            ];
            $model=new Filecate();
            $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }

            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try{
                /* ++++++++++ 批量赋值 ++++++++++ */
                $filecate=$model;
                $filecate->fill($request->input());
                $filecate->addOther($request);
                $filecate->save();
                if(blank($filecate)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=$filecate;
                $edata=null;
                $url=route('g_filecate');

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

        if($request->isMethod('get')){
            /* ********** 获取数据 ********** */
            DB::beginTransaction();
            $filecate=Filecate::withTrashed()
                ->with('filetable')
                ->sharedLock()
                ->find($id);
            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($filecate)){
                $code='error';
                $msg='数据不存在';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='gov.error';
            }else{
                $code='success';
                $msg='请求成功';
                $sdata=$filecate;
                $edata=null;
                $url=null;

                $view='gov.filecate.edit';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }
        /* ********** 保存 ********** */
        else{
            /* ********** 更新 ********** */
            DB::beginTransaction();
            try{
                /* ++++++++++ 锁定数据模型 ++++++++++ */
                $filecate=Filecate::withTrashed()->lockForUpdate()->find($id);
                if(blank($filecate)){
                    throw new \Exception('数据不存在',404404);
                }
                /* ++++++++++ 表单验证 ++++++++++ */
                $rules=[
                    'name'=>'required|unique:file_cate,name,'.$id.',id',
                    'filename'=>['required',Rule::unique('file_cate')->where(function ($query) use ($filecate){
                        $query->where('file_table_id',$filecate->file_table_id)->where('id','<>',$filecate->id);
                    })]
                ];
                $messages=[
                    'required'=>':attribute 为必须项',
                    'unique'=>':attribute 已存在',
                ];
                $model=new Filecate();
                $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
                if($validator->fails()){
                    throw new \Exception($validator->errors()->first(),404404);
                }

                /* ++++++++++ 处理其他数据 ++++++++++ */
                $filecate->fill($request->input());
                $filecate->editOther($request);
                $filecate->save();
                if(blank($filecate)){
                    throw new \Exception('修改失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=$filecate;
                $edata=null;
                $url=route('g_filecate');

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'保存失败';
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
}