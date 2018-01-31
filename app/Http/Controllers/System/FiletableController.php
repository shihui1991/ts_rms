<?php
/*
|--------------------------------------------------------------------------
| 必备附件分类
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\System;
use App\Http\Model\Afiletable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FiletableController extends BaseController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {

    }

    /* ++++++++++ 首页 ++++++++++ */
    public function index(Request $request)
    {
        /* ********** 查询条件 ********** */
        $where=[];
        /* ++++++++++ 名称 ++++++++++ */
        $name=trim($request->input('name'));
        if($name){
            $where[]=['name','like','%'.$name.'%'];
            $infos['name']=$name;
        }
        /* ********** 排序 ********** */
        $ordername=$request->input('ordername');
        $ordername=$ordername?$ordername:'sort';
        $infos['ordername']=$ordername;

        $orderby=$request->input('orderby');
        $orderby=$orderby?$orderby:'asc';
        $infos['orderby']=$orderby;
        /* ********** 每页条数 ********** */
        $nums=[15,30,50,100,200];
        $infos['nums']=$nums;
        $displaynum=$request->input('displaynum');
        $displaynum=$displaynum?$displaynum:15;
        $infos['displaynum']=$displaynum;
        /* ********** 查询 ********** */
        $model=new Afiletable();
        DB::beginTransaction();
        try{
            $filetables=$model->where($where)->orderBy($ordername,$orderby)->sharedLock()->paginate($displaynum);
            if(blank($filetables)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='error';
            $msg='查询成功';
            $data=$filetables;
        }catch (\Exception $exception){
            $filetables=collect();
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=$filetables;
        }
        DB::commit();
        $infos['filetables']=$filetables;
        $infos[$code]=$msg;

        /* ********** 结果 ********** */
        if($request->ajax()){
            return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>'']);
        }else{
            return view('system.file_table',$infos);
        }

    }
}