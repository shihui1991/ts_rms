<?php
/*
|--------------------------------------------------------------------------
| 项目流程
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\System;

use App\Http\Model\Menu;
use App\Http\Model\Process;
use App\Http\Model\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProcessController extends BaseController
{
    /* ========== 初始化 ========== */
    public function __construct()
    {
        parent::__construct();

    }

    /* ========== 默认列表 ========== */
    public function index(Request $request)
    {
        /* ********** 查询条件 ********** */
        /* ++++++++++ 上级 ID ++++++++++ */
        $id=$request->input('id')?$request->input('id'):0;
        $where[]=['parent_id',$id];

        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $processs=Process::with(['schedule'=>function($query){
                $query->select(['id','name']);
            },'menu'=>function($query){
                $query->select(['id','name','url']);
            }])
                ->withCount('childs')
                ->where($where)
                ->sharedLock()
                ->orderBy('schedule_id','asc')
                ->orderBy('sort','asc')
                ->get();

            if(blank($processs)){
                throw new \Exception('没有符合条件的数据',404404);
            }

            $code='success';
            $msg='查询成功';
            $sdata=$processs;
            $edata=new Process();
            $url=null;
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=new Process();
            $url=null;
        }
        DB::commit();

        /* ++++++++++ 结果 ++++++++++ */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view('system.process.index')->with($result);
        }
    }
    
    /* ========== 添加 ========== */
    public function add(Request $request){
        if($request->isMethod('get')){
            $id=$request->input('id');
            $process=null;
            DB::beginTransaction();
            $schedules=Schedule::sharedLock()->pluck('name','id');
            if($id){
                $process=Process::select(['id','schedule_id','name'])->sharedLock()->find($id);
            }
            $menus=Menu::sharedLock()
                ->where([
                    ['module',0],
                    ['login',1],
                ])
                ->select(['id','parent_id','name',])
                ->get();
            DB::commit();
            $menu_tree='';
            if(!blank($menus)){
                $str="<tr data-tt-id='\$id' data-tt-parent-id='\$parent_id'>
                          <td>\$name</td>
                          <td><input type='radio' name='menu_id' value='\$id'></td>
                      </tr>";

                $menu_tree=get_tree($menus,$str,0,1,['','',''],'');
            }
            if(blank($process)){
                $id=0;
                $schedule_id=null;
                $name=null;
            }else{
                $schedule_id=$process->schedule_id;
                $name=$process->name;
            }

            $result=['code'=>'success','message'=>'请求成功','sdata'=>['id'=>$id,'schedule_id'=>$schedule_id,'name'=>$name,'schedules'=>$schedules,'menu_tree'=>$menu_tree],'edata'=>new Process(),'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('system.process.add')->with($result);
            }
        }
        /* ********** 保存 ********** */
        else{
            $model=new Process();
            $types=$model->getTypeAttribute();
            $keys=array_keys($types);
            $keys_str=implode(',',$keys);
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules=[
                'schedule_id'=>['nullable','regex:/^[0-9]+$/'],
                'parent_id'=>['required','regex:/^[0-9]+$/'],
                'name'=>'required',
                'type'=>'required:in:'.$keys_str,
                'menu_id'=>['required','regex:/^[0-9]+$/','unique:a_process'],
                'sort'=>'required|integer|min:0|unique:a_process',
                'number'=>'required|integer|min:1',
            ];
            $messages=[
                'schedule_id.regex'=>'选择正确的 :attribute',
                'required'=>':attribute 为必须项',
                'parent_id.regex'=>'选择正确的 :attribute',
                'in'=>'选择正确的 :attribute',
                'menu_id.regex'=>'选择正确的 :attribute',
                'integer'=>':attribute 必须是整数',
                'min'=>':attribute 必须不小于 :min',
                'unique'=>':attribute 已占用',
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
                $process=$model;
                $process->fill($request->input());
                $process->addOther($request);
                $process->save();
                if(blank($process)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=$process;
                $edata=null;
                $url=route('sys_process');

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
                return view('system.error')->with($result);
            }
        }
        $model=new Process();

        if($request->isMethod('get')){
            /* ********** 获取数据 ********** */
            DB::beginTransaction();
            $process=Process::withTrashed()
                ->with(['father'=>function($query){
                    $query->withTrashed()->select(['id','name']);
                },'schedule'=>function($query){
                    $query->withTrashed()->select(['id','name']);
                }])
                ->sharedLock()
                ->find($id);

            $menus=Menu::sharedLock()
                ->where([
                    ['module',0],
                    ['login',1],
                ])
                ->select(['id','parent_id','name',])
                ->get();
            DB::commit();

            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($process)){
                $code='error';
                $msg='数据不存在';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='system.error';
            }else{
                $menu_tree='';
                if(!blank($menus)){
                    $array=[];
                    foreach($menus as $menu){
                        $menu->checked=$menu->id==$process->menu_id?'checked':'';
                        $array[]=$menu;
                    }
                    $str="<tr data-tt-id='\$id' data-tt-parent-id='\$parent_id'>
                          <td>\$name</td>
                          <td><input type='radio' name='menu_id' value='\$id' \$checked></td>
                      </tr>";

                    $menu_tree=get_tree($array,$str,0,1,['','',''],'');
                }

                $process->menu_tree=$menu_tree;

                $code='success';
                $msg='查询成功';
                $sdata=$process;
                $edata=$model;
                $url=null;

                $view='system.process.edit';
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
            $types=$model->getTypeAttribute();
            $keys=array_keys($types);
            $keys_str=implode(',',$keys);
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules=[
                'name'=>'required',
                'type'=>'required:in:'.$keys_str,
                'menu_id'=>['required','regex:/^[0-9]+$/','unique:a_process,menu_id,'.$id.',id'],
                'sort'=>'required|integer|min:0|unique:a_process,sort,'.$id.',id',
                'number'=>'required|integer|min:1',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'in'=>'选择正确的 :attribute',
                'menu_id.regex'=>'选择正确的 :attribute',
                'integer'=>':attribute 必须是整数',
                'min'=>':attribute 必须不小于 :min',
                'unique'=>':attribute 已占用',
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
                $process=Process::withTrashed()->sharedLock()->find($id);
                $process->fill($request->input());
                $process->editOther($request);
                $process->save();
                if(blank($process)){
                    throw new \Exception('修改失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=$process;
                $edata=null;
                $url=route('sys_process');

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'保存失败';
                $sdata=null;
                $edata=$process;
                $url=null;

                DB::rollBack();
            }
            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }
}
