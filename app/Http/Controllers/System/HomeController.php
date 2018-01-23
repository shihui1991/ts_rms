<?php
/*
|--------------------------------------------------------------------------
| 控制台
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\System;
use App\Http\Model\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends BaseController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {

    }

    public function index(Request $request){
        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $menus=Menu::select(['id','parent_id','name','icon','url'])
                ->withCount(['childs'=>function($query){
                    $query->where('display',1);
                }])
                ->where([
                    ['display',1]
                    ,['parent_id',(int)$request->input('id')]
                ])
                ->sharedLock()
                ->orderBy('sort','asc')
                ->get();

            if(blank($menus)){
                throw new \Exception('没有符合条件的数据',404404);
            }

            $error=0;
            $code='success';
            $msg='查询成功';
            $data=$menus;
            $url='';
        }catch (\Exception $exception){
            $menus=collect();

            $error=1;
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $data=$menus;
            $url='';
        }
        DB::commit();

        /* ********** 输出 ********** */
        if($request->ajax()){
            return response()->json(['error'=>$error,'code'=>$code,'message'=>$msg,'data'=>$data,'url'=>$url]);
        }else{
            $infos['menus']=$menus;
            $infos['current_url']=route('sys_home');
            return view('system.home',$infos);
        }
    }

}
