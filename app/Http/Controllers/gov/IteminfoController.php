<?php
/*
|--------------------------------------------------------------------------
| 项目信息
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use App\Http\Model\Filecate;
use App\Http\Model\Filetable;
use App\Http\Model\Household;
use App\Http\Model\Item;
use App\Http\Model\Itemadmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IteminfoController extends BaseitemController
{
    /* ========== 初始化 ========== */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 项目概述 ========== */
    public function index(Request $request){
        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            if(blank($this->item)){
                throw new \Exception('项目不存在',404404);
            }
            $itemadmins=Itemadmin::with(['user'=>function($query){
                $query->select(['id','name']);
            }])
                ->sharedLock()
                ->where('item_id',$this->item_id)
                ->get();
            $household_num=Household::sharedLock()->where('item_id',$this->item_id)->count();

            $code='success';
            $msg='查询成功';
            $sdata=['item'=>$this->item,'itemadmins'=>$itemadmins,'household_num'=>$household_num];
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
        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $file_table_id=Filetable::where('name','item')->sharedLock()->value('id');
            $file_cates=Filecate::where('file_table_id',$file_table_id)->sharedLock()->pluck('name','filename');

            if(blank($this->item)){
                throw new \Exception('项目不存在',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$this->item;
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
        if($request->isMethod('get')){
            try{
                if(blank($this->item)){
                    throw  new \Exception('数据不存在',404404);
                }

                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($this->item->schedule_id!=1 || $this->item->process_id!=1 || $this->item->code != '2'){
                    throw new \Exception('当前项目处于【'.$this->item->schedule->name.' - '.$this->item->process->name.'('.$this->item->state->name.')】，不能进行当前操作',404404);
                }

                /* ********** 获取数据 ********** */
                DB::beginTransaction();

                $file_table_id=Filetable::where('name','item')->sharedLock()->value('id');
                $file_cates=Filecate::where('file_table_id',$file_table_id)->sharedLock()->get();

                DB::commit();

                $code='success';
                $msg='查询成功';
                $sdata=$this->item;
                $edata=$file_cates;
                $url=null;

                $view='gov.iteminfo.edit';
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络错误';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='gov.error';
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
                'name'=>'required|unique:item,name,'.$this->item_id.',id',
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
//                $file_table_id=Filetable::where('name','item')->sharedLock()->value('id');
//                $file_cates=Filecate::where('file_table_id',$file_table_id)->sharedLock()->get();
//                $rules=[];
//                $messages=[];
//                foreach ($file_cates as $file_cate){
//                    $name='picture.'.$file_cate->filename;
//                    $rules[$name]='required';
//                    $messages[$name.'.required']='必须上传【'.$file_cate->name.'】';
//                }
//                $validator = Validator::make($request->all(),$rules,$messages);
//                if($validator->fails()){
//                    throw new \Exception($validator->errors()->first(),404404);
//                }

                if(blank($this->item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($this->item->schedule_id!=1 || $this->item->process_id!=1 || $this->item->code != '2'){
                    throw new \Exception('当前项目处于【'.$this->item->schedule->name.' - '.$this->item->process->name.'('.$this->item->state->name.')】，不能进行当前操作',404404);
                }

                $item=$this->item;

                $item->fill($request->input());

                $item->save();
                if(blank($item)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=$item;
                $edata=null;
                $url=route('g_iteminfo_info',['item'=>$this->item_id]);

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