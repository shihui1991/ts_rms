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
use App\Http\Model\Itemuser;
use App\Http\Model\Menu;
use App\Http\Model\Process;
use App\Http\Model\Role;
use App\Http\Model\Worknotice;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemController extends BaseController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request,$next){
            if(!$request->ajax()){
                $menus=Menu::sharedLock()
                    ->where([
                        ['parent_id',41],
                        ['display',1]
                    ])
                    ->orderBy('sort','asc')
                    ->get();

                $nav_menus=get_nav_li_list($menus,session('menu.cur_menu.id'),session('menu.cur_pids'),1,41);

                view()->share(['nav_menus'=>$nav_menus]);
            }

            return $next($request);
        });
    }

    /* ========== 我的项目 ========== */
    public function index(Request $request){
        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $total=Itemuser::where('user_id',session('gov_user.user_id'))
                ->sharedLock()
                ->count(DB::raw('DISTINCT `item_id`'));
            $per_page=15;
            $page=$request->input('page',1);
            $items=Itemuser::with(['item'=>function($query){
                $query->with(['itemadmins'=>function($query){
                    $query->select('name');
                },'state'=>function($query){
                    $query->select(['code','name']);
                },'schedule'=>function($query){
                    $query->select(['id','name']);
                },'process'=>function($query){
                    $query->select(['id','name']);
                }])->withCount('households');
            }])
                ->select(['item_id','user_id'])
                ->distinct()
                ->where('user_id',session('gov_user.user_id'))
                ->offset($per_page*($page-1))
                ->limit($per_page)
                ->orderBy('item_id','asc')
                ->get();

            $items=new LengthAwarePaginator($items,$total,$per_page,$page);
            $items->withPath(route('g_item'));

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
            return view('gov.item.index')->with($result);
        }
    }


    /* ========== 所有项目 ========== */
    public function all(Request $request){
        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $items=Item::withCount('households')
                ->with(['itemadmins'=>function($query){
                    $query->select('name');
                },'state'=>function($query){
                    $query->select(['code','name']);
                },'schedule'=>function($query){
                    $query->select(['id','name']);
                },'process'=>function($query){
                    $query->select(['id','name']);
                }])
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
                $item->schedule_id=1;
                $item->process_id=1;
                $item->code='2';
                $item->save();
                if(blank($item)){
                    throw new \Exception('保存失败',404404);
                }
                /* ++++++++++ 上级角色ID ++++++++++ */
                $parent_role_id=Role::where('id',session('gov_user.role_id'))->sharedLock()->value('parent_id');
                /* ++++++++++ 新建项目 流程记录 ++++++++++ */
                $values[]=[
                    'item_id'=>$item->id,
                    'schedule_id'=>1,
                    'process_id'=>1,
                    'menu_id'=>44,
                    'dept_id'=>session('gov_user.dept_id'),
                    'parent_id'=>$parent_role_id,
                    'role_id'=>session('gov_user.role_id'),
                    'user_id'=>session('gov_user.user_id'),
                    'url'=>route('g_item_add'),
                    'code'=>'2',
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                ];

                /* ++++++++++ 提交部门审查 可操作人员 ++++++++++ */
                $process=Process::with(['processusers'=>function($query){
                    $query->with('role');
                }])
                    ->select(['id','schedule_id','menu_id'])
                    ->find(2);
                /* ++++++++++ 提交部门审查 工作提醒推送 ++++++++++ */
                foreach ($process->processusers as $user){
                    $values[]=[
                        'item_id'=>$item->id,
                        'schedule_id'=>$process->schedule_id,
                        'process_id'=>$process->id,
                        'menu_id'=>$process->menu_id,
                        'dept_id'=>$user->dept_id,
                        'parent_id'=>$user->role->parent_id,
                        'role_id'=>$user->role_id,
                        'user_id'=>$user->id,
                        'url'=>route('g_iteminfo_info',['item'=>$item->id]),
                        'code'=>'0',
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ];
                }

                $field=['item_id','schedule_id','process_id','menu_id','dept_id','parent_id','role_id','user_id','url','code','created_at','updated_at'];
                $sqls=batch_update_or_insert_sql('item_work_notice',$field,$values,'updated_at');
                if(!$sqls){
                    throw new \Exception('保存失败',404404);
                }
                foreach ($sqls as $sql){
                    DB::statement($sql);
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