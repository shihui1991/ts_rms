<?php
/*
|--------------------------------------------------------------------------
| 项目流程-功能菜单
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\System;
use App\Http\Model\Processmenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcessmenuController extends BaseController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {

    }

    /* ++++++++++ 详情 ++++++++++ */
    public function info(Request $request){
        $process_id = $request->input('process_id');
        if(!$process_id){
            $code = 'error';
            $msg = '请先选择项目流程';
            $data = '';
            if($request->ajax()){
                return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'']);
            }else{
                $infos[$code]=$msg;
                return view('system.processmenu.info',$infos);
            }
        }
        /* ********** 当前数据 ********** */
        DB::beginTransaction();
        $process=Processmenu::withTrashed()
            ->where('process_id',$process_id)
            ->sharedLock()
            ->get();

        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($process)){
            $code='warning';
            $msg='数据不存在';
            $data=[];
            $url='';
        }else{
            $code='success';
            $msg='获取成功';
            $data=$process;
            $url='';
        }
        $infos=[
            'code'=>$code,
            'msg'=>$msg,
            'sdata'=>$data,'edata'=>'',
            'url'=>$url,
        ];
        return view('system.processmenu.info',$infos);
    }

    /* ========== 修改 ========== */
    public function edit(Request $request){
        $process_id = $request->input('process_id');
        if($request->isMethod('post')){
            /* ********** 更新 ********** */
            DB::beginTransaction();
            try{
                /* ++++++++++ 锁定数据模型 ++++++++++ */
                $processmenu=Processmenu::withTrashed()
                    ->where('process_id',$process_id)
                    ->lockForUpdate()
                    ->get();

                if(blank($processmenu)){
                    throw new \Exception('指定数据项不存在',404404);
                }
                /* ++++++++++ 删除数据 ++++++++++ */
                $processmenu=Processmenu::where('process_id',$process_id)->delete();
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $datas = [];
                $i = 0;
                foreach ($request->input('menu_id') as $k=>$v){
                    $datas[$i]['menu_id'] = $v;
                    $datas[$i]['process_id'] = $process_id;
                    $i++;
                }
                DB::table('a_process_menu')->insert([$datas]);


                $code='success';
                $msg='修改成功';
                $data=$processmenu;
                $url='';
                DB::commit();
            }catch (\Exception $exception){

                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $data=[];
                $url='';
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            if($request->ajax()){
                return response()->json(['code'=>$code,'message'=>$msg,'sdata'=>$data,'edata'=>'','url'=>$url]);
            }else{
                return redirect()->back()->withInput()->with($code,$msg);
            }
        }else{
            /* ********** 当前数据 ********** */
            DB::beginTransaction();
            $processmenu=Processmenu::withTrashed()
                ->where('process_id',$process_id)
                ->sharedLock()
                ->get();

            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($processmenu)){

                $code='warning';
                $msg='数据不存在';
                $data=[];
                $url='';
            }else{

                $code='success';
                $msg='获取成功';
                $data=$processmenu;
                $url='';
            }
            $infos=[

                'code'=>$code,
                'msg'=>$msg,
                'sdata'=>$data,'edata'=>'',
                'url'=>$url,
            ];

            /* ********** 输出视图 ********** */
            return view('system.processmenu.edit',$infos);
        }

    }
    
    
}