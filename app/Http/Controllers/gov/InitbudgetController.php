<?php
/*
|--------------------------------------------------------------------------
| 项目-初步预算
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use App\Http\Model\Initbudget;
use App\Http\Model\Itemnotice;
use App\Http\Model\Itemuser;
use App\Http\Model\Worknotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InitbudgetController extends BaseitemController
{
    /* ========== 初始化 ========== */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 初步预算 ========== */
    public function index(Request $request){
        /* ********** 查询 ********** */
        DB::beginTransaction();
        $init_budget=Initbudget::sharedLock()->where('item_id',$this->item_id)->first();
        $item_notice=Itemnotice::sharedLock()
            ->where([
                ['item_id',$this->item_id],
                ['cate_id',2],
            ])
            ->first();

        DB::commit();

        /* ++++++++++ 结果 ++++++++++ */
        $result=[
            'code'=>'success',
            'message'=>'请求成功',
            'sdata'=>[
                'item'=>$this->item,
                'init_budget'=>$init_budget,
                'item_notice'=>$item_notice,
            ],
            'edata'=>null,
            'url'=>null];

        if($request->ajax()){
            return response()->json($result);
        }else{
            return view('gov.initbudget.index')->with($result);
        }
    }

    /* ========== 添加初步预算 ========== */
    public function add(Request $request){
        $model=new Initbudget();

        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if(!in_array($item->schedule_id,[1,2]) || !in_array($item->process_id,[13,14]) || ($item->process_id==13 && $item->code!='2') || ($item->process_id==14 && $item->code!='1')){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 是否存在预算报告 ++++++++++ */
                $init_budget=Initbudget::sharedLock()->where('item_id',$this->item_id)->first();
                if(filled($init_budget)){
                    throw new \Exception('初步预算报告已添加',404404);
                }
                /* ++++++++++ 是否有推送 ++++++++++ */
                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];
                $worknotice->code='1';
                $worknotice->save();

                $item->schedule_id=$worknotice->schedule_id;
                $item->process_id=$worknotice->process_id;
                $item->code=$worknotice->code;
                $item->save();

                $code='success';
                $msg='请求成功';
                $sdata=['item'=>$this->item];
                $edata=$model;
                $url=null;

                $view='gov.initbudget.add';
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络错误';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='gov.error';
            }
            DB::commit();

            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }

        }
        /* ++++++++++ 保存 ++++++++++ */
        else{
            /* ++++++++++ 表单验证 初步预算 ++++++++++ */
            $rules=[
                'holder'=>'required|min:0',
                'money'=>'required|min:0',
                'house'=>'required|min:0',
                'picture'=>'required',
                ];
            $messages=[
                'required'=>':attribute 为必须项',
                'min'=>':attribute 不能少于 :min',
                ];
            
            $validator = Validator::make($request->input('budget'),$rules,$messages,$model->columns);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /* ++++++++++ 表单验证 预算通知 ++++++++++ */
            $rules=[
                'infos'=>'required',
                'picture'=>'required',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
            ];
            $item_notice_model=new Itemnotice();
            $validator = Validator::make($request->input('notice'),$rules,$messages,$item_notice_model->columns);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }

            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if(!in_array($item->schedule_id,[1,2]) || !in_array($item->process_id,[13,14]) || ($item->process_id==13 && $item->code!='2') || ($item->process_id==14 && $item->code!='1')){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 是否存在预算报告 ++++++++++ */
                $init_budget=Initbudget::sharedLock()->where('item_id',$this->item_id)->first();
                if(filled($init_budget)){
                    throw new \Exception('初步预算报告已添加',404404);
                }
                /* ++++++++++ 是否有推送 ++++++++++ */
                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];
                $worknotice->code='2';
                $worknotice->save();

                /* ++++++++++ 批量赋值 ++++++++++ */
                $init_budget=$model;
                $init_budget->fill($request->input('budget'));
                $init_budget->item_id=$this->item_id;
                $init_budget->save();
                if(blank($init_budget)){
                    throw new \Exception('保存失败',404404);
                }
                $item_notice=$item_notice_model;
                $item_notice->fill($request->input('notice'));
                $item_notice->item_id=$this->item_id;
                $item_notice->cate_id=2;
                $item_notice->save();
                if(blank($item_notice)){
                    throw new \Exception('保存失败',404404);
                }
                /* ++++++++++ 删除相同工作推送 ++++++++++ */
                Worknotice::lockForUpdate()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$process->schedule_id],
                        ['process_id',$process->id],
                        ['menu_id',$process->menu_id],
                        ['code','0'],
                    ])
                    ->delete();

                /* ++++++++++ 初步预算审查 可操作人员 ++++++++++ */
                $itemusers=Itemuser::with(['role'=>function($query){
                    $query->select(['id','parent_id']);
                }])
                    ->where('process_id',17)
                    ->get();
                $values=[];
                /* ++++++++++ 初步预算审查 工作提醒推送 ++++++++++ */
                foreach ($itemusers as $user){
                    $values[]=[
                        'item_id'=>$user->item_id,
                        'schedule_id'=>$user->schedule_id,
                        'process_id'=>$user->process_id,
                        'menu_id'=>$user->menu_id,
                        'dept_id'=>$user->dept_id,
                        'parent_id'=>$user->role->parent_id,
                        'role_id'=>$user->role_id,
                        'user_id'=>$user->user_id,
                        'url'=>route('g_ready_init_check',['item'=>$this->item->id]),
                        'code'=>'20',
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ];
                }

                $field=['item_id','schedule_id','process_id','menu_id','dept_id','parent_id','role_id','user_id','url','code','created_at','updated_at'];
                $sqls=batch_update_or_insert_sql('item_work_notice',$field,$values,'updated_at');
                if(!$sqls){
                    throw new \Exception('操作失败',404404);
                }
                foreach ($sqls as $sql){
                    DB::statement($sql);
                }

                $item->schedule_id=$worknotice->schedule_id;
                $item->process_id=$worknotice->process_id;
                $item->code=$worknotice->code;
                $item->save();

                $code='success';
                $msg='保存成功';
                $sdata=['init_budget'=>$init_budget,'item_notice'=>$item_notice];
                $edata=null;
                $url=route('g_initbudget',['item'=>$this->item_id]);

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

    /* ========== 修改初步预算 ========== */
    public function edit(Request $request){
        $model=new Initbudget();

        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=2 || !in_array($item->process_id,[14,17]) || ($item->process_id==14 && $item->code!='2') || ($item->process_id==17 && $item->code!='23')){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 审查驳回处理 ++++++++++ */
                if($item->schedule_id==2 && $item->process_id==17 && $item->code=='23'){
                    /* ++++++++++ 是否有推送 ++++++++++ */
                    $result=$this->hasNotice();
                    $process=$result['process'];
                    $worknotice=$result['worknotice'];
                }
                /* ++++++++++ 修改 ++++++++++ */
                else{
                    /* ++++++++++ 检查操作权限 ++++++++++ */
                    $count=Itemuser::sharedLock()
                        ->where([
                            ['item_id',$item->id],
                            ['schedule_id',$item->schedule_id],
                            ['process_id',$item->process_id],
                            ['user_id',session('gov_user.user_id')],
                        ])
                        ->get();
                    if(!$count){
                        throw new \Exception('您没有执行此操作的权限',404404);
                    }
                }

                $init_budget=Initbudget::sharedLock()->where('item_id',$this->item_id)->first();
                $item_notice=Itemnotice::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['cate_id',2],
                    ])
                    ->first();
                if(blank($init_budget)){
                    throw new \Exception('初步预算报告还未添加',404404);
                }

                $code='success';
                $msg='请求成功';
                $sdata=['item'=>$this->item,'init_budget'=>$init_budget,'item_notice'=>$item_notice];
                $edata=$model;
                $url=null;

                $view='gov.initbudget.edit';
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络错误';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='gov.error';
            }
            DB::commit();

            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }

        }
        /* ++++++++++ 保存 ++++++++++ */
        else{
            /* ++++++++++ 表单验证 初步预算 ++++++++++ */
            $rules=[
                'holder'=>'required|min:0',
                'money'=>'required|min:0',
                'house'=>'required|min:0',
                'picture'=>'required',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'min'=>':attribute 不能少于 :min',
            ];

            $validator = Validator::make($request->input('budget'),$rules,$messages,$model->columns);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /* ++++++++++ 表单验证 预算通知 ++++++++++ */
            $rules=[
                'infos'=>'required',
                'picture'=>'required',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
            ];
            $item_notice_model=new Itemnotice();
            $validator = Validator::make($request->input('notice'),$rules,$messages,$item_notice_model->columns);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }

            /* ++++++++++ 保存 ++++++++++ */
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=2 || !in_array($item->process_id,[14,17]) || ($item->process_id==14 && $item->code!='2') || ($item->process_id==17 && $item->code!='23')){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 审查驳回处理 ++++++++++ */
                if($item->schedule_id==2 && $item->process_id==17 && $item->code=='23'){
                    /* ++++++++++ 是否有推送 ++++++++++ */
                    $result=$this->hasNotice();
                    $process=$result['process'];
                    $worknotice=$result['worknotice'];
                    $worknotice->code='2';
                    $worknotice->save();
                    /* ++++++++++ 删除相同工作推送 ++++++++++ */
                    Worknotice::lockForUpdate()
                        ->where([
                            ['item_id',$item->id],
                            ['schedule_id',$process->schedule_id],
                            ['process_id',$process->id],
                            ['menu_id',$process->menu_id],
                            ['code','0'],
                        ])
                        ->delete();

                    /* ++++++++++ 初步预算审查 可操作人员 ++++++++++ */
                    $itemusers=Itemuser::with(['role'=>function($query){
                        $query->select(['id','parent_id']);
                    }])
                        ->where('process_id',17)
                        ->get();
                    $values=[];
                    /* ++++++++++ 初步预算审查 工作提醒推送 ++++++++++ */
                    foreach ($itemusers as $user){
                        $values[]=[
                            'item_id'=>$user->item_id,
                            'schedule_id'=>$user->schedule_id,
                            'process_id'=>$user->process_id,
                            'menu_id'=>$user->menu_id,
                            'dept_id'=>$user->dept_id,
                            'parent_id'=>$user->role->parent_id,
                            'role_id'=>$user->role_id,
                            'user_id'=>$user->user_id,
                            'url'=>route('g_ready_init_check',['item'=>$this->item->id]),
                            'code'=>'20',
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s'),
                        ];
                    }

                    $field=['item_id','schedule_id','process_id','menu_id','dept_id','parent_id','role_id','user_id','url','code','created_at','updated_at'];
                    $sqls=batch_update_or_insert_sql('item_work_notice',$field,$values,'updated_at');
                    if(!$sqls){
                        throw new \Exception('操作失败',404404);
                    }
                    foreach ($sqls as $sql){
                        DB::statement($sql);
                    }

                    $item->schedule_id=2;
                    $item->process_id=14;
                    $item->code='2';
                    $item->save();
                }
                /* ++++++++++ 修改 ++++++++++ */
                else{
                    /* ++++++++++ 检查操作权限 ++++++++++ */
                    $count=Itemuser::sharedLock()
                        ->where([
                            ['item_id',$item->id],
                            ['schedule_id',$item->schedule_id],
                            ['process_id',$item->process_id],
                            ['user_id',session('gov_user.user_id')],
                        ])
                        ->get();
                    if(!$count){
                        throw new \Exception('您没有执行此操作的权限',404404);
                    }
                }
                $init_budget=Initbudget::sharedLock()->where('item_id',$this->item_id)->first();
                $item_notice=Itemnotice::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['cate_id',2],
                    ])
                    ->first();
                if(blank($init_budget)){
                    throw new \Exception('初步预算报告还未添加',404404);
                }

                /* ++++++++++ 批量赋值 ++++++++++ */
                $init_budget->fill($request->input('budget'));
                $init_budget->save();
                if(blank($init_budget)){
                    throw new \Exception('保存失败',404404);
                }
                $item_notice->fill($request->input('notice'));
                $item_notice->save();
                if(blank($item_notice)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=['init_budget'=>$item_notice,'item_notice'=>$item_notice];
                $edata=null;
                $url=route('g_initbudget',['item'=>$this->item_id]);

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