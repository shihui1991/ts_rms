<?php
/*
|--------------------------------------------------------------------------
| 项目-通知公告
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use App\Http\Model\Itemnotice;
use App\Http\Model\Itemuser;
use App\Http\Model\News;
use App\Http\Model\Worknotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NewsController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        DB::beginTransaction();

        $newses=News::with(['newscate'=>function($query){
            $query->select(['id','name']);
        },'state'=>function($query){
            $query->select(['code','name']);
        }])
            ->sharedLock()
            ->orderBy('is_top','desc')
            ->orderBy('release_at','asc')
            ->get();

        DB::commit();

        /* ********** 结果 ********** */
        $result=[
            'code'=>'success',
            'message'=>'请求成功',
            'sdata'=>[
                'item'=>$this->item,
                'newses'=>$newses,
            ],
            'edata'=>null,
            'url'=>null];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.news.index')->with($result);
        }
    }

    /* ========== 添加范围公告 ========== */
    public function add(Request $request){
        $model=new News();
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=2 || $item->process_id!=19 ||  $item->code!='22'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 检查推送 ++++++++++ */
                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];

                $news=News::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['cate_id',1],
                    ])
                    ->first();
                if(filled($news)){
                    throw new \Exception('项目征收范围公告已添加',404404);
                }

                $code='success';
                $msg='请求成功';
                $sdata=[
                    'item'=>$item,
                ];
                $edata=null;
                $url=null;

                $view='gov.news.add';
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
        /* ********** 保存 ********** */
        else{
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules=[
                'name'=>'required',
                'release_at'=>'required|date_format:Y-m-d',
                'infos'=>'required',
                'content'=>'required',
                'picture'=>'required',
                'is_top'=>'required|boolean',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'date_format'=>':attribute 输入格式错误',
                'boolean'=>'请选择 :attribute 正确的选择',
            ];
            
            $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /* ++++++++++ 表单验证 征收房屋相关手续停办通知 ++++++++++ */
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
                if($item->schedule_id!=2 || $item->process_id!=19 ||  $item->code!='22'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }

                $news=News::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['cate_id',1],
                    ])
                    ->first();
                if(filled($news)){
                    throw new \Exception('项目征收范围公告已添加',404404);
                }
                /* ++++++++++ 是否有推送 ++++++++++ */
                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];
                $worknotice->code='2';
                $worknotice->save();

                /* ++++++++++ 批量赋值 ++++++++++ */
                $news=$model;
                $news->fill($request->input());
                $news->addOther($request);
                $news->item_id=$this->item_id;
                $news->cate_id=1;
                $news->code='20';
                $news->save();
                if(blank($news)){
                    throw new \Exception('保存失败',404404);
                }
                $item_notice=$item_notice_model;
                $item_notice->fill($request->input('notice'));
                $item_notice->item_id=$this->item_id;
                $item_notice->cate_id=3;
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

                /* ++++++++++ 征收范围公告审查 可操作人员 ++++++++++ */
                $itemusers=Itemuser::with(['role'=>function($query){
                    $query->select(['id','parent_id']);
                }])
                    ->where('process_id',24)
                    ->get();
                $values=[];
                /* ++++++++++ 征收范围公告审查 工作提醒推送 ++++++++++ */
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
                        'url'=>route('g_ready_range_check',['item'=>$this->item->id]),
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
                $sdata=$news;
                $edata=null;
                $url=route('g_news',['item'=>$this->item_id]);

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

    /* ========== 公告详情 ========== */
    public function info(Request $request){
        $id=$request->input('id');
        if(!$id){
            $result=['code'=>'error', 'message'=>'错误操作', 'sdata'=>null, 'edata'=>null, 'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else {
                return view('gov.error')->with($result);
            }
        }

        DB::beginTransaction();
        $news=News::with(['newscate'=>function($query){
            $query->select(['id','name']);
        },'state'=>function($query){
            $query->select(['code','name']);
        }])
            ->sharedLock()
            ->find($id);

        DB::commit();
        if(filled($news)){
            $code='success';
            $msg='请求成功';
            $sdata=['item'=>$this->item,'news'=>$news];
            $edata=null;
            $url=null;

            $view='gov.news.info';
        }else{
            $code='error';
            $msg='数据不存在';
            $sdata=null;
            $edata=null;
            $url=null;

            $view='gov.error';
        }
        $result=['code'=>$code, 'message'=>$msg, 'sdata'=>$sdata, 'edata'=>$edata, 'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view($view)->with($result);
        }
    }

    /* ========== 修改范围公告 ========== */
    public function edit(Request $request){

        $model=new News();
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=2 || !in_array($item->process_id,[23,24]) || ($item->process_id==23 && $item->code!='2') || ($item->process_id==24 && $item->code!='23')){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 检查操作权限 ++++++++++ */
                $count=Itemuser::sharedLock()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$item->schedule_id],
                        ['process_id',23],
                        ['user_id',session('gov_user.user_id')],
                    ])
                    ->get();
                if(!$count){
                    throw new \Exception('您没有执行此操作的权限',404404);
                }

                $news=News::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['cate_id',1],
                    ])
                    ->first();
                $item_notice=Itemnotice::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['cate_id',3],
                    ])
                    ->first();
                if(blank($news)){
                    throw new \Exception('项目征收范围公告还未添加',404404);
                }

                $code='success';
                $msg='请求成功';
                $sdata=['item'=>$this->item,'news'=>$news,'item_notice'=>$item_notice];
                $edata=$model;
                $url=null;

                $view='gov.news.edit';
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
            $rules=[
                'name'=>'required',
                'release_at'=>'required|date_format:Y-m-d',
                'infos'=>'required',
                'content'=>'required',
                'picture'=>'required',
                'is_top'=>'required|boolean',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'date_format'=>':attribute 输入格式错误',
                'boolean'=>'请选择 :attribute 正确的选择',
            ];

            $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /* ++++++++++ 表单验证 征收房屋相关手续停办通知 ++++++++++ */
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

            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=2 || !in_array($item->process_id,[23,24]) || ($item->process_id==23 && $item->code!='2') || ($item->process_id==24 && $item->code!='23')){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 检查操作权限 ++++++++++ */
                $count=Itemuser::sharedLock()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$item->schedule_id],
                        ['process_id',23],
                        ['user_id',session('gov_user.user_id')],
                    ])
                    ->get();
                if(!$count){
                    throw new \Exception('您没有执行此操作的权限',404404);
                }
                /* ++++++++++ 审查驳回处理 ++++++++++ */
                if($item->schedule_id==2 && $item->process_id==24 && $item->code=='23'){
                    /* ++++++++++ 删除相同工作推送 ++++++++++ */
                    Worknotice::lockForUpdate()
                        ->where([
                            ['item_id',$item->id],
                            ['schedule_id',2],
                            ['process_id',23],
                            ['code','0'],
                        ])
                        ->delete();
                    /* ++++++++++ 征收范围公告审查 可操作人员 ++++++++++ */
                    $itemusers=Itemuser::with(['role'=>function($query){
                        $query->select(['id','parent_id']);
                    }])
                        ->where('process_id',24)
                        ->get();
                    $values=[];
                    /* ++++++++++ 征收范围公告审查 工作提醒推送 ++++++++++ */
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
                            'url'=>route('g_ready_range_check',['item'=>$this->item->id]),
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
                    $item->process_id=23;
                    $item->code='2';
                    $item->save();
                }

                $notice_id=$request->input('notice_id');
                if(!$notice_id){
                    throw new \Exception('错误操作',404404);
                }
                $news=News::lockForUpdate()
                    ->where([
                        ['item_id',$this->item_id],
                        ['cate_id',1],
                    ])
                    ->first();
                if(blank($news)){
                    throw new \Exception('数据不存在',404404);
                }
                $item_notice=Itemnotice::lockForUpdate()->find($notice_id);
                if(blank($item_notice)){
                    throw new \Exception('数据不存在',404404);
                }
                /* ++++++++++ 批量赋值 ++++++++++ */
                $news->fill($request->input());
                $news->editOther($request);
                $news->code='20';
                $news->save();
                if(blank($news)){
                    throw new \Exception('保存失败',404404);
                }
                $item_notice->fill($request->input('notice'));
                $item_notice->save();
                if(blank($item_notice)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=['news'=>$news,'item_notice'=>$item_notice];
                $edata=null;
                $url=route('g_news_info',['item'=>$this->item_id,'id'=>$id]);

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

    /* ========== 添加征收意见稿公告 ========== */
    public function draft_notice_add(Request $request){
        $model=new News();
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=4 || $item->process_id!=32 ||  $item->code!='22'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 检查推送 ++++++++++ */
                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];

                $news=News::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['cate_id',2],
                    ])
                    ->first();
                if(filled($news)){
                    throw new \Exception('征收意见稿公告已添加',404404);
                }

                $code='success';
                $msg='请求成功';
                $sdata=[
                    'item'=>$item,
                ];
                $edata=$model;
                $url=null;

                $view='gov.news.draft_notice_add';
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
        /* ********** 保存 ********** */
        else{
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules=[
                'name'=>'required',
                'release_at'=>'required|date_format:Y-m-d',
                'infos'=>'required',
                'content'=>'required',
                'picture'=>'required',
                'is_top'=>'required|boolean',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'date_format'=>':attribute 输入格式错误',
                'boolean'=>'请选择 :attribute 正确的选择',
            ];

            $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
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
                if($item->schedule_id!=4 || $item->process_id!=32 ||  $item->code!='22'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }

                $news=News::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['cate_id',2],
                    ])
                    ->first();
                if(filled($news)){
                    throw new \Exception('征收意见稿公告已添加',404404);
                }
                /* ++++++++++ 是否有推送 ++++++++++ */
                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];
                $worknotice->code='2';
                $worknotice->save();

                /* ++++++++++ 批量赋值 ++++++++++ */
                $news=$model;
                $news->fill($request->input());
                $news->addOther($request);
                $news->item_id=$this->item_id;
                $news->cate_id=2;
                $news->code='22';
                $news->save();
                if(blank($news)){
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

                /* ++++++++++ 社会稳定风险评估 可操作人员 ++++++++++ */
                $itemusers=Itemuser::with(['role'=>function($query){
                    $query->select(['id','parent_id']);
                }])
                    ->where('process_id',34)
                    ->get();
                $values=[];
                /* ++++++++++ 社会稳定风险评估 工作提醒推送 ++++++++++ */
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
                        'url'=>route('g_itemriskreport',['item'=>$this->item->id]),
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
                $sdata=$news;
                $edata=null;
                $url=route('g_news',['item'=>$this->item_id]);

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

    /* ========== 修改征收意见稿公告 ========== */
    public function draft_notice_edit(Request $request){
        $model=new News();
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=4 || $item->process_id!=33 ||  $item->code!='2'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 检查操作权限 ++++++++++ */
                $count=Itemuser::sharedLock()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$item->schedule_id],
                        ['process_id',33],
                        ['user_id',session('gov_user.user_id')],
                    ])
                    ->get();
                if(!$count){
                    throw new \Exception('您没有执行此操作的权限',404404);
                }

                $news=News::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['cate_id',2],
                    ])
                    ->first();
                if(blank($news)){
                    throw new \Exception('项目征收意见稿公告还未添加',404404);
                }

                $code='success';
                $msg='请求成功';
                $sdata=['item'=>$this->item,'news'=>$news];
                $edata=$model;
                $url=null;

                $view='gov.news.draft_notice_edit';
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
            $rules=[
                'name'=>'required',
                'release_at'=>'required|date_format:Y-m-d',
                'infos'=>'required',
                'content'=>'required',
                'picture'=>'required',
                'is_top'=>'required|boolean',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'date_format'=>':attribute 输入格式错误',
                'boolean'=>'请选择 :attribute 正确的选择',
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
                if($item->schedule_id!=4 || $item->process_id!=33 ||  $item->code!='2'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 检查操作权限 ++++++++++ */
                $count=Itemuser::sharedLock()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$item->schedule_id],
                        ['process_id',33],
                        ['user_id',session('gov_user.user_id')],
                    ])
                    ->get();
                if(!$count){
                    throw new \Exception('您没有执行此操作的权限',404404);
                }

                $news=News::lockForUpdate()
                    ->where([
                        ['item_id',$this->item_id],
                        ['cate_id',2],
                    ])
                    ->first();
                if(blank($news)){
                    throw new \Exception('数据不存在',404404);
                }
                /* ++++++++++ 批量赋值 ++++++++++ */
                $news->fill($request->input());
                $news->editOther($request);
                $news->save();
                if(blank($news)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=['news'=>$news];
                $edata=null;
                $url=route('g_news_info',['item'=>$this->item_id,'id'=>$news->id]);

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

    /* ========== 添加征收决定公告 ========== */
    public function program_notice_add(Request $request){
        $model=new News();
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=4 || $item->process_id!=37 ||  $item->code!='22'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 检查推送 ++++++++++ */
                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];

                $news=News::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['cate_id',3],
                    ])
                    ->first();
                if(filled($news)){
                    throw new \Exception('征收决定公告已添加',404404);
                }

                $code='success';
                $msg='请求成功';
                $sdata=[
                    'item'=>$item,
                ];
                $edata=$model;
                $url=null;

                $view='gov.news.program_notice_add';
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
        /* ********** 保存 ********** */
        else{
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules=[
                'name'=>'required',
                'release_at'=>'required|date_format:Y-m-d',
                'infos'=>'required',
                'content'=>'required',
                'picture'=>'required',
                'is_top'=>'required|boolean',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'date_format'=>':attribute 输入格式错误',
                'boolean'=>'请选择 :attribute 正确的选择',
            ];

            $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
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
                if($item->schedule_id!=4 || $item->process_id!=37 ||  $item->code!='22'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }

                $news=News::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['cate_id',3],
                    ])
                    ->first();
                if(filled($news)){
                    throw new \Exception('征收决定公告已添加',404404);
                }
                /* ++++++++++ 是否有推送 ++++++++++ */
                $result=$this->hasNotice();
                $process=$result['process'];
                $worknotice=$result['worknotice'];
                $worknotice->code='2';
                $worknotice->save();

                /* ++++++++++ 批量赋值 ++++++++++ */
                $news=$model;
                $news->fill($request->input());
                $news->addOther($request);
                $news->item_id=$this->item_id;
                $news->cate_id=3;
                $news->code='22';
                $news->save();
                if(blank($news)){
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

                /* ++++++++++ 项目实施 可操作人员 ++++++++++ */
                $itemusers=Itemuser::with(['role'=>function($query){
                    $query->select(['id','parent_id']);
                }])
                    ->where('process_id',39)
                    ->get();
                $values=[];
                /* ++++++++++ 项目实施 工作提醒推送 ++++++++++ */
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
                        'url'=>route('g_pay_start',['item'=>$this->item->id]),
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
                $sdata=$news;
                $edata=null;
                $url=route('g_news',['item'=>$this->item_id]);

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

    /* ========== 修改征收决定公告 ========== */
    public function program_notice_edit(Request $request){
        $model=new News();
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=4 || $item->process_id!=38 ||  $item->code!='2'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 检查操作权限 ++++++++++ */
                $count=Itemuser::sharedLock()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$item->schedule_id],
                        ['process_id',38],
                        ['user_id',session('gov_user.user_id')],
                    ])
                    ->get();
                if(!$count){
                    throw new \Exception('您没有执行此操作的权限',404404);
                }

                $news=News::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['cate_id',3],
                    ])
                    ->first();
                if(blank($news)){
                    throw new \Exception('项目征收决定公告还未添加',404404);
                }

                $code='success';
                $msg='请求成功';
                $sdata=['item'=>$this->item,'news'=>$news];
                $edata=$model;
                $url=null;

                $view='gov.news.program_notice_edit';
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
            $rules=[
                'name'=>'required',
                'release_at'=>'required|date_format:Y-m-d',
                'infos'=>'required',
                'content'=>'required',
                'picture'=>'required',
                'is_top'=>'required|boolean',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'date_format'=>':attribute 输入格式错误',
                'boolean'=>'请选择 :attribute 正确的选择',
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
                if($item->schedule_id!=4 || $item->process_id!=38 ||  $item->code!='2'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 检查操作权限 ++++++++++ */
                $count=Itemuser::sharedLock()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$item->schedule_id],
                        ['process_id',38],
                        ['user_id',session('gov_user.user_id')],
                    ])
                    ->get();
                if(!$count){
                    throw new \Exception('您没有执行此操作的权限',404404);
                }

                $news=News::lockForUpdate()
                    ->where([
                        ['item_id',$this->item_id],
                        ['cate_id',3],
                    ])
                    ->first();
                if(blank($news)){
                    throw new \Exception('数据不存在',404404);
                }
                /* ++++++++++ 批量赋值 ++++++++++ */
                $news->fill($request->input());
                $news->editOther($request);
                $news->save();
                if(blank($news)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=['news'=>$news];
                $edata=null;
                $url=route('g_news_info',['item'=>$this->item_id,'id'=>$news->id]);

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

    /* ========== 添加评估报告 ========== */
    public function assess_report_add(Request $request){
        $model=new News();
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=5 || $item->process_id!=39 ||  $item->code!='1'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 检查操作权限 ++++++++++ */
                $count=Itemuser::sharedLock()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$item->schedule_id],
                        ['process_id',39],
                        ['user_id',session('gov_user.user_id')],
                    ])
                    ->get();
                if(!$count){
                    throw new \Exception('您没有执行此操作的权限',404404);
                }

                $news=News::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['cate_id',4],
                    ])
                    ->first();
                if(filled($news)){
                    throw new \Exception('评估报告已添加',404404);
                }

                $code='success';
                $msg='请求成功';
                $sdata=[
                    'item'=>$item,
                ];
                $edata=$model;
                $url=null;

                $view='gov.news.assess_report_add';
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
        /* ********** 保存 ********** */
        else{
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules=[
                'name'=>'required',
                'release_at'=>'required|date_format:Y-m-d',
                'infos'=>'required',
                'content'=>'required',
                'picture'=>'required',
                'is_top'=>'required|boolean',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'date_format'=>':attribute 输入格式错误',
                'boolean'=>'请选择 :attribute 正确的选择',
            ];

            $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
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
                if($item->schedule_id!=5 || $item->process_id!=39 ||  $item->code!='1'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 检查操作权限 ++++++++++ */
                $count=Itemuser::sharedLock()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$item->schedule_id],
                        ['process_id',39],
                        ['user_id',session('gov_user.user_id')],
                    ])
                    ->get();
                if(!$count){
                    throw new \Exception('您没有执行此操作的权限',404404);
                }

                $news=News::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['cate_id',4],
                    ])
                    ->first();
                if(filled($news)){
                    throw new \Exception('评估报告已添加',404404);
                }

                /* ++++++++++ 批量赋值 ++++++++++ */
                $news=$model;
                $news->fill($request->input());
                $news->addOther($request);
                $news->item_id=$this->item_id;
                $news->cate_id=4;
                $news->code='22';
                $news->save();
                if(blank($news)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=$news;
                $edata=null;
                $url=route('g_news',['item'=>$this->item_id]);

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

    /* ========== 修改评估报告 ========== */
    public function assess_report_edit(Request $request){
        $model=new News();
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=5 || $item->process_id!=39 ||  $item->code!='1'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 检查操作权限 ++++++++++ */
                $count=Itemuser::sharedLock()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$item->schedule_id],
                        ['process_id',39],
                        ['user_id',session('gov_user.user_id')],
                    ])
                    ->get();
                if(!$count){
                    throw new \Exception('您没有执行此操作的权限',404404);
                }

                $news=News::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['cate_id',4],
                    ])
                    ->first();
                if(blank($news)){
                    throw new \Exception('项目征收决定公告还未添加',404404);
                }

                $code='success';
                $msg='请求成功';
                $sdata=['item'=>$this->item,'news'=>$news];
                $edata=$model;
                $url=null;

                $view='gov.news.assess_report_edit';
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
            $rules=[
                'name'=>'required',
                'release_at'=>'required|date_format:Y-m-d',
                'infos'=>'required',
                'content'=>'required',
                'picture'=>'required',
                'is_top'=>'required|boolean',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'date_format'=>':attribute 输入格式错误',
                'boolean'=>'请选择 :attribute 正确的选择',
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
                if($item->schedule_id!=5 || $item->process_id!=39 ||  $item->code!='1'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 检查操作权限 ++++++++++ */
                $count=Itemuser::sharedLock()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',$item->schedule_id],
                        ['process_id',39],
                        ['user_id',session('gov_user.user_id')],
                    ])
                    ->get();
                if(!$count){
                    throw new \Exception('您没有执行此操作的权限',404404);
                }

                $news=News::lockForUpdate()
                    ->where([
                        ['item_id',$this->item_id],
                        ['cate_id',4],
                    ])
                    ->first();
                if(blank($news)){
                    throw new \Exception('数据不存在',404404);
                }
                /* ++++++++++ 批量赋值 ++++++++++ */
                $news->fill($request->input());
                $news->editOther($request);
                $news->save();
                if(blank($news)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=['news'=>$news];
                $edata=null;
                $url=route('g_news_info',['item'=>$this->item_id,'id'=>$news->id]);

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