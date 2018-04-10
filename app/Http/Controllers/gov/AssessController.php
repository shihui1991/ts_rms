<?php
/*
|--------------------------------------------------------------------------
| 项目-评估报告
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use App\Http\Model\Assess;
use App\Http\Model\Assets;
use App\Http\Model\Household;
use App\Http\Model\Estate;
use App\Http\Model\Itemriskreport;
use App\Http\Model\Itemuser;
use App\Http\Model\Worknotice;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AssessController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        $assess=null;
        DB::beginTransaction();
        try{
            $total=Assess::sharedLock()
                ->where('item_id',$this->item_id)
                ->count();

            $per_page=15;
            $page=$request->input('page',1);
            $assesses=Assess::with(['itemland'=>function($query){
                $query->select(['id','address']);
            },'itembuilding'=>function($query){
                $query->select(['id','building']);
            },'household'=>function($query){
                $query->select(['id','unit','floor','number','type']);
            },'state'])
                ->sharedLock()
                ->where('item_id',$this->item_id)
                ->offset($per_page*($page-1))
                ->limit($per_page)
                ->get();
            
            $assesses=new LengthAwarePaginator($assesses,$total,$per_page,$page);
            $assesses->withPath(route('g_assess',['item'=>$this->item_id]));

            $code='success';
            $msg='获取成功';
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络错误';
        }
        $sdata=[
            'item'=>$this->item,
            'assesses'=>$assesses,
        ];
        $edata=null;
        $url=null;
        DB::commit();
        $result=['code'=>$code, 'message'=>$msg, 'sdata'=>$sdata, 'edata'=>$edata, 'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.assess.index')->with($result);
        }
    }

    /* ========== 详情 ========== */
    public function info(Request $request){
        $id=$request->input('id');
        DB::beginTransaction();
        try{
            if(!$id){
                throw new \Exception('错误操作',404404);
            }
            /* ********** 评估汇总 ********** */
            $assess=Assess::with(['itemland'=>function($query){
                $query->select(['id','address']);
            },'itembuilding'=>function($query){
                $query->select(['id','building']);
            },'household'=>function($query){
                $query->with(['householddetail'=>function($query){
                    $query->select(['id','household_id','status','register','has_assets']);
                }])
                    ->select(['id','unit','floor','number','type']);
            },'state'])
                ->sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['id',$id],
                ])
                ->first();
            if(blank($assess)){
                throw new \Exception('数据不存在',404404);
            }
            /* ********** 房产评估 ********** */
            $estate=Estate::with(['estatebuildings'=>function($query){
                $query->with(['realbuildinguse','buildingstruct','state']);
            },'company'=>function($query){
                $query->select(['id','name']);
            },'state'])
                ->sharedLock()
                ->where([
                    ['item_id',$this->item_id],
                    ['assess_id',$assess->id],
                ])
                ->first();
            $assets=null;
            if($assess->household->householddetail->getOriginal('has_assets')==1){
                $assets=Assets::with(['company'=>function($query){
                    $query->select(['id','name']);
                },'state'])->sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['assess_id',$assess->id],
                    ])
                    ->first();
            }

            $code='success';
            $msg='获取成功';
            $sdata=[
                'item'=>$this->item,
                'assess'=>$assess,
                'estate'=>$estate,
                'assets'=>$assets,
            ];
            $edata=null;
            $url=null;

            $view='gov.assess.info';
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络错误';
            $sdata=null;
            $edata=null;
            $url=null;

            $view='gov.error';
        }

        DB::commit();
        $result=['code'=>$code, 'message'=>$msg, 'sdata'=>$sdata, 'edata'=>$edata, 'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view($view)->with($result);
        }
    }

    /* ========== 评估报告审查 ========== */
    public function edit(Request $request){
        $model=new Assess();
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }

                /* ++++++++++ 检查操作权限 ++++++++++ */
                $count=Itemuser::sharedLock()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$item->schedule_id],
                        ['process_id',34],
                        ['user_id',session('gov_user.user_id')],
                    ])
                    ->get();
                if(!$count){
                    throw new \Exception('您没有执行此操作的权限',404404);
                }

                $household = Household::with(
                    ['item' => function ($query) {
                        $query->select(['id', 'name']);
                    }, 'itemland' => function ($query) {
                        $query->select(['id', 'address']);
                    }, 'itembuilding' => function ($query) {
                        $query->select(['id', 'building']);
                    }])
                    ->sharedLock()
                    ->find($request->input('household_id'));
                if (blank($household)){
                    throw new \Exception('被征户不存在', 404404);
                }

                $assess=Assess::sharedLock()->where('item_id',$this->item_id)->where('household_id',$request->input('household_id'))->where('code',132)->first();
                if(blank($assess)){
                    throw new \Exception('该被征户暂无有效评估报告',404404);
                }
                $code='success';
                $msg='请求成功';
                $sdata=['item'=>$this->item,'assess'=>$assess,'item_id'=>$this->item_id,];
                $edata=$model;
                $url=null;

                $view='gov.assess.edit';
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
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'content'=>'required',
                'name'=>'required',
                'agree' => 'required',
            ];
            $messages = [
                'required' => ':attribute必须填写'
            ];

            $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }

            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if(!in_array($item->process_id,['34','35']) || ($item->process_id =='34' && $item->code!='2') || ($item->process_id =='35' && $item->code!='23')){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 检查操作权限 ++++++++++ */
                $count=Itemuser::sharedLock()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$item->schedule_id],
                        ['process_id',34],
                        ['user_id',session('gov_user.user_id')],
                    ])
                    ->get();
                if(!$count){
                    throw new \Exception('您没有执行此操作的权限',404404);
                }
                /* ++++++++++ 审查驳回处理 ++++++++++ */
                if($item->process_id==35 && $item->code=='23'){
                    /* ++++++++++ 删除相同工作推送 ++++++++++ */
                    Worknotice::lockForUpdate()
                        ->where([
                            ['item_id',$item->id],
                            ['schedule_id',$item->schedule_id],
                            ['process_id',34],
                            ['code','0'],
                        ])
                        ->delete();
                    /* ++++++++++ 风险评估报告审查 可操作人员 ++++++++++ */
                    $itemusers=Itemuser::with(['role'=>function($query){
                        $query->select(['id','parent_id']);
                    }])
                        ->sharedLock()
                        ->where([
                            ['item_id',$item->id],
                            ['process_id',35],
                        ])
                        ->get();
                    $values=[];
                    /* ++++++++++ 风险评估报告审查 工作提醒推送 ++++++++++ */
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
                            'url'=>route('g_riskreport_check',['item'=>$this->item->id],false),
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

                    $item->schedule_id=4;
                    $item->process_id=34;
                    $item->code='22';
                    $item->save();
                }
                /* ++++++++++ 社会稳定风险评估报告 ++++++++++ */
                $risk_report=Itemriskreport::lockForUpdate()->where('item_id',$this->item_id)->first();
                if(blank($risk_report)){
                    throw new \Exception('社会稳定风险评估报告还未添加',404404);
                }

                /* ++++++++++ 批量赋值 ++++++++++ */
                $risk_report->fill($request->input());
                $risk_report->editOther($request);
                $risk_report->code='22';
                $risk_report->save();
                if(blank($risk_report)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=['news'=>$risk_report];
                $edata=null;
                $url=route('g_itemriskreport',['item'=>$this->item_id]);

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