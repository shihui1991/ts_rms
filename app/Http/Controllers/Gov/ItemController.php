<?php
/*
|--------------------------------------------------------------------------
| 项目
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;
use App\Http\Model\Filecate;
use App\Http\Model\Filetable;
use App\Http\Model\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemController extends BaseController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {

    }

    /* ========== 我的项目 ========== */
    public function index(Request $request){

    }


    /* ========== 所有项目 ========== */
    public function all(Request $request){
        $select=['id','name','place','map','infos','code','created_at','updated_at','deleted_at'];
        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $items=Item::select($select)
                ->sharedLock()
                ->paginate();

            if(blank($items)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$items;
            $edata=null;
            $url=null;
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=null;
            $url=null;
        }
        DB::commit();

        /* ++++++++++ 结果 ++++++++++ */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view('gov.item.all')->with($result);
        }
    }


    /* ========== 新建项目 ========== */
    public function add(Request $request){
        $model=new Item();

        if($request->isMethod('get')){
            /* ++++++++++ 必备附件分类 ++++++++++ */
            DB::beginTransaction();
            $file_table_id=Filetable::where('name','item')->sharedLock()->value('id');
            $file_cates=Filecate::where('file_table_id',$file_table_id)->sharedLock()->get();
            DB::commit();

            $result=['code'=>'success','message'=>'请求成功','sdata'=>['filecates'=>$file_cates],'edata'=>$model,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.item.add')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else{
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules=[
                'name'=>'required|unique:item',
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
                $item=$model;
                $item->fill($request->input());
                $item->addOther($request);
                $item->code=0;

                $item->save();
                if(blank($item)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=$item;
                $edata=null;
                $url=route('g_item_all');

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