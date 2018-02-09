<?php
/*
|--------------------------------------------------------------------------
| 项目信息
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use App\Http\Model\Filecate;
use App\Http\Model\Filetable;
use App\Http\Model\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IteminfoController extends BaseController
{
    /* ========== 初始化 ========== */
    public function __construct()
    {

    }

    /* ========== 项目概述 ========== */
    public function index(Request $request){
        $select=['id','name','place','map','infos','code','created_at','updated_at','deleted_at'];
        $where[]=['id',1];
        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $item=Item::select($select)
                ->where($where)
                ->sharedLock()
                ->first();

            if(blank($item)){
                throw new \Exception('项目不存在',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$item;
            $edata=null;
            $url=null;

            $view='gov.iteminfo.index';
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=null;
            $url=null;

            $view='gov.error';
        }
        DB::commit();

        /* ++++++++++ 结果 ++++++++++ */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view($view)->with($result);
        }
    }

    /* ========== 项目信息 ========== */
    public function info(Request $request){

        $where[]=['id',1];
        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $file_table_id=Filetable::where('name','item')->sharedLock()->value('id');
            $file_cates=Filecate::where('file_table_id',$file_table_id)->sharedLock()->pluck('name','filename');

            $item=Item::where($where)
                ->sharedLock()
                ->first();

            if(blank($item)){
                throw new \Exception('项目不存在',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$item;
            $edata=$file_cates;
            $url=null;

            $view='gov.iteminfo.info';
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=null;
            $url=null;

            $view='gov.error';
        }
        DB::commit();

        /* ++++++++++ 结果 ++++++++++ */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view($view)->with($result);
        }
    }


    /* ========== 修改项目 ========== */
    public function edit(Request $request){
        $id=1;
        $where[]=['id',$id];
        if($request->isMethod('get')){
            /* ********** 获取数据 ********** */
            DB::beginTransaction();

            $file_table_id=Filetable::where('name','item')->sharedLock()->value('id');
            $file_cates=Filecate::where('file_table_id',$file_table_id)->sharedLock()->get();

            $item=Item::where($where)
                ->sharedLock()
                ->first();

            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($item)){
                $code='error';
                $msg='数据不存在';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='gov.error';
            }else{
                $code='success';
                $msg='查询成功';
                $sdata=$item;
                $edata=$file_cates;
                $url=null;

                $view='gov.iteminfo.edit';
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
            $model=new Item();
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules=[
                'name'=>'required|unique:item,name,'.$id.',id',
                'place'=>'required',
                'map'=>'required'
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'unique'=>':attribute 已存在',
            ];
            $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }

            DB::beginTransaction();
            try{
                $file_table_id=Filetable::where('name','item')->sharedLock()->value('id');
                $file_cates=Filecate::where('file_table_id',$file_table_id)->sharedLock()->get();
                $rules=[];
                $messages=[];
                foreach ($file_cates as $file_cate){
                    $name='picture.'.$file_cate->filename;
                    $rules[$name]='required';
                    $messages[$name.'.required']='必须上传【'.$file_cate->name.'】';
                }
                $validator = Validator::make($request->all(),$rules,$messages);
                if($validator->fails()){
                    throw new \Exception($validator->errors()->first(),404404);
                }
                /* ++++++++++ 批量赋值 ++++++++++ */
                $item=Item::where($where)
                    ->sharedLock()
                    ->first();

                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }

                $item->fill($request->input());
                $item->code=0;

                $item->save();
                if(blank($item)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=$item;
                $edata=null;
                $url=route('g_iteminfo_info');

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