<?php
/*
|--------------------------------------------------------------------------
| 项目-公共附属物
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;
use App\Http\Model\Itembuilding;
use App\Http\Model\Itemland;
use App\Http\Model\Itempublic;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItempublicController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 查询地块下所有公共附属物 ========== */
    public function index(Request $request){
        $item_id=$this->item_id;

        $land_id=$request->input('land_id');
        if(blank($land_id)){
            $result=['code'=>'error','message'=>'请先选择地块','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }
        $infos['item'] = $this->item;
        /* ********** 是否分页 ********** */
        $app = $request->input('app');
        /* ********** 查询条件 ********** */
        $where=[];
        $select=['id','item_id','land_id','building_id','name','num_unit','number','infos','picture'];

        $where[]=['item_id',$item_id];
        $infos['item_id']=$item_id;
        $where[]=['land_id',$land_id];
        $infos['land_id']=$land_id;
        /* ********** 排序 ********** */
        $ordername=$request->input('ordername');
        $ordername=$ordername?$ordername:'id';
        $infos['ordername']=$ordername;

        $orderby=$request->input('orderby');
        $orderby=$orderby?$orderby:'asc';
        $infos['orderby']=$orderby;
        /* ********** 每页条数 ********** */
        $per_page=15;
        $page=$request->input('page',1);
        /* ********** 查询 ********** */
        $model=new Itempublic();
        DB::beginTransaction();
        try{
            /* ********** 是否分页 ********** */
            if($app){
                $total=$model->sharedLock()
                    ->where('item_id',$item_id)
                    ->where($where)
                    ->count();
                $itempublics=$model
                    ->with([
                        'itemland'=>function($query){
                            $query->select(['id','address']);
                        },
                        'itembuilding'=>function($query){
                            $query->select(['id','building']);
                        }])
                    ->where($where)
                    ->select($select)
                    ->orderBy($ordername,$orderby)
                    ->sharedLock()
                    ->offset($per_page*($page-1))
                    ->limit($per_page)
                    ->get();
                $itempublics=new LengthAwarePaginator($itempublics,$total,$per_page,$page);
                $itempublics->withPath(route('g_itempublic',['item'=>$item_id]));
            }else{
                $itempublics=$model
                    ->with([
                        'itemland'=>function($query){
                            $query->select(['id','address']);
                        },
                        'itembuilding'=>function($query){
                            $query->select(['id','building']);
                        }])
                    ->where($where)
                    ->select($select)
                    ->orderBy($ordername,$orderby)
                    ->sharedLock()
                    ->get();
            }

            if(blank($itempublics)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$itempublics;
            $edata=$infos;
            $url=null;
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=$infos;
            $url=null;
        }
        DB::commit();

        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.itempublic.index')->with($result);
        }
    }

    /* ========== 添加 ========== */
    public function add(Request $request){
        $item_id=$this->item_id;

        $model=new Itempublic();
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                $land_id=$request->input('land_id');
                $itemland=Itemland::sharedLock()->find($land_id);
                if(blank($itemland)){
                    throw new \Exception('数据错误', 404404);
                }

                $building_id=(int)($request->input('building_id'));
                $itembuilding=null;
                if($building_id){
                    $itembuilding=Itembuilding::sharedLock()->find($building_id);
                }

                $code='success';
                $msg='获取成功';
                $sdata=[
                    'item'=>$this->item,
                    'itemland'=>$itemland,
                    'itembuilding'=>$itembuilding,
                ];
                $edata=null;
                $url=null;

                $view='gov.itempublic.add';
            }catch (\Exception $exception){
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '网络错误';
                $sdata = null;
                $edata = null;
                $url = null;

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
        else {
            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'land_id' => 'required',
                'name' => 'required',
                'num_unit' => 'required',
                'gov_num' => 'required',
                'gov_pic' => 'required'
            ];
            $messages = [
                'required' => ':attribute必须填写',
                'unique' => ':attribute已存在'
            ];
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }

            /* ++++++++++ 赋值 ++++++++++ */
            DB::beginTransaction();
            try {
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if(!in_array($item->process_id,[24,25]) || ($item->process_id==24 && $item->code!='22') || ($item->process_id==25 && $item->code!='1')){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 检查操作权限 ++++++++++ */
                $count=Itemuser::sharedLock()
                    ->where([
                        ['item_id',$item->id],
                        ['process_id',26],
                        ['user_id',session('gov_user.user_id')],
                    ])
                    ->count();
                if(!$count){
                    throw new \Exception('您没有执行此操作的权限',404404);
                }
                $item->process_id=26;
                $item->code='1';
                $item->save();
                /* ++++++++++ 公共附属物是否存在 ++++++++++ */
                $name = $request->input('name');
                $itempublic = Itempublic::where('item_id',$item_id)->where('land_id',$request->input('land_id'))->where('building_id',$request->input('building_id'))->where('name',$name)->lockForUpdate()->first();
                if(blank($itempublic)){
                    /* ++++++++++ 新增数据 ++++++++++ */
                    $itempublic = $model;
                    $itempublic->fill($request->input());
                    $itempublic->addOther($request);
                    $itempublic->item_id=$item_id;
                    $itempublic->save();
                }else{
                    /* ++++++++++ 修改数据 ++++++++++ */
                    $itempublic->gov_num=$request->input('gov_num');
                    $itempublic->gov_pic=$request->input('gov_pic');
                    $itempublic->save();
                }
                if (blank($itempublic)) {
                    throw new \Exception('添加失败', 404404);
                }

                $code = 'success';
                $msg = '添加成功';
                $sdata = $itempublic;
                $edata = null;
                if(0!=$request->input('building_id')) {
                    $url = route('g_itembuilding_info',['id'=>$request->input('building_id'),'item'=>$item_id]);
                }else{
                    $url = route('g_itemland_info',['id'=>$request->input('land_id'),'item'=>$item_id]);
                }
                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '添加失败';
                $sdata = null;
                $edata = $itempublic;
                $url = null;
                DB::rollBack();
            }
            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }

    /* ========== 详情 ========== */
    public function info(Request $request){
        $id=$request->input('id');
        if(blank($id)){
            $result=['code'=>'error','message'=>'请先选择数据','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }

        DB::beginTransaction();
        $itempublic=Itempublic::with([
            'itemland'=>function($query){
                $query->select(['id','address']);
             },'itembuilding'=>function($query){
                $query->select(['id','building']);
             }])
            ->sharedLock()
            ->find($id);
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($itempublic)){
            $code='warning';
            $msg='数据不存在';
            $sdata=null;
            $edata=null;
            $url=null;

            $view='gov.error';
        }else{
            $code='success';
            $msg='获取成功';
            $sdata=['item'=>$this->item,'itempublic'=>$itempublic];
            $edata=null;
            $url=null;

            $view='gov.itempublic.info';
        }
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view($view)->with($result);
        }
    }

    /* ========== 修改 ========== */
    public function edit(Request $request){
        $id=$request->input('id');
        if(blank($id)){
            $result=['code'=>'error','message'=>'请先选择数据','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }

        if ($request->isMethod('get')) {
            /* ********** 当前数据 ********** */

            DB::beginTransaction();
            $itempublic=Itempublic::with([
                'itemland'=>function($query){
                     $query->select(['id','address']);
                },'itembuilding'=>function($query){
                    $query->select(['id','building']);
                }])
                ->sharedLock()
                ->find($id);
            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($itempublic)){
                $code='warning';
                $msg='数据不存在';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='gov.error';
            }else{
                $code='success';
                $msg='获取成功';
                $sdata=['item'=>$this->item,'itempublic'=>$itempublic];
                $edata=null;
                $url=null;

                $view='gov.itempublic.edit';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }else{
            $model=new Itempublic();
            /* ********** 表单验证 ********** */
            $rules=[
                'name' => 'required',
                'num_unit' => 'required',
                'gov_num' => 'required',
                'gov_pic' => 'required'
            ];
            $messages=[
                'required'=>':attribute必须填写',
                'unique'=>':attribute已存在'
            ];
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /* ********** 更新 ********** */
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if(!in_array($item->process_id,[24,25]) || ($item->process_id==24 && $item->code!='22') || ($item->process_id==25 && $item->code!='1')){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 检查操作权限 ++++++++++ */
                $count=ItemuserController::sharedLock()
                    ->where([
                        ['item_id',$item->id],
                        ['process_id',26],
                        ['user_id',session('gov_user.user_id')],
                    ])
                    ->count();
                if(!$count){
                    throw new \Exception('您没有执行此操作的权限',404404);
                }
                $item->process_id=26;
                $item->code='1';
                $item->save();
                /* ++++++++++ 锁定数据模型 ++++++++++ */
                $itempublic=Itempublic::lockForUpdate()->find($id);
                if(blank($itempublic)){
                    throw new \Exception('指定数据项不存在',404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $itempublic->fill($request->all());
                $itempublic->editOther($request);
                $itempublic->save();
                if(blank($itempublic)){
                    throw new \Exception('修改失败',404404);
                }
                $code='success';
                $msg='修改成功';
                $sdata=$itempublic;
                $edata=null;

                if($itempublic->building_id) {
                    $url = route('g_itembuilding_info',['id'=>$itempublic->building_id,'item'=>$this->item_id]);
                }else{
                    $url = route('g_itemland_info',['id'=>$itempublic->land_id,'item'=>$this->item_id]);
                }

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=$itempublic;
                $url=null;
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }

    /* ========== 删除 ========== */
    public function del(Request $request){
        $ids = $request->input('id');
        if(blank($ids)){
            $result=['code'=>'error','message'=>'请选择要删除的数据！','sdata'=>null,'edata'=>null,'url'=>null];
            return response()->json($result);
        }
        /* ********** 删除数据 ********** */
        DB::beginTransaction();
        try{
            $item=$this->item;
            if(blank($item)){
                throw new \Exception('项目不存在',404404);
            }
            /* ++++++++++ 检查项目状态 ++++++++++ */
            if(!in_array($item->process_id,[24,25]) || ($item->process_id==24 && $item->code!='22') || ($item->process_id==25 && $item->code!='1')){
                throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
            }
            /* ++++++++++ 检查操作权限 ++++++++++ */
            $count=Itemuser::sharedLock()
                ->where([
                    ['item_id',$item->id],
                    ['process_id',26],
                    ['user_id',session('gov_user.user_id')],
                ])
                ->count();
            if(!$count){
                throw new \Exception('您没有执行此操作的权限',404404);
            }

            /*---------是否已确认数量----------*/
            $itempublic = Itempublic::where('id',$ids)->first();
            if($itempublic->number){
                throw new \Exception('该公共附属物正在被使用,暂时不能被删除！',404404);
            }
            /*---------公共附属物----------*/
            $itempublic = Itempublic::where('id',$ids)->delete();
            if(!$itempublic){
                throw new \Exception('删除失败',404404);
            }
            $code='success';
            $msg='删除成功';
            $sdata=$ids;
            $edata=$itempublic;
            $url=null;
            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常,请刷新后重试！';
            $sdata=$ids;
            $edata=null;
            $url=null;
            DB::rollBack();
        }
        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        return response()->json($result);
    }

    /* ========== 确认地块附属物 ========== */
    /*------------- 地块列表 -------------*/
    public function landiist(Request $request){
        $item_id=$this->item_id;
        /* ********** 查询条件 ********** */
        $where=[];
        $where[] = ['item_id',$item_id];
        $infos['item_id'] = $item_id;
        /* ++++++++++ 地址 ++++++++++ */
        $address=trim($request->input('address'));
        if($address){
            $where[]=['address','like','%'.$address.'%'];
            $infos['address']=$address;
        }
        /* ********** 排序 ********** */
        $ordername=$request->input('ordername');
        $ordername=$ordername?$ordername:'id';
        $infos['ordername']=$ordername;

        $orderby=$request->input('orderby');
        $orderby=$orderby?$orderby:'asc';
        $infos['orderby']=$orderby;
        /* ********** 每页条数 ********** */
        $per_page=20;
        $page=$request->input('page',1);
        /* ********** 查询 ********** */
        $model=new Itemland();
        DB::beginTransaction();
        try{
            $total=$model->sharedLock()
                ->where($where)
                ->where('item_id',$item_id)
                ->count();
            $itemlands=$model
                ->with([
                    'landprop'=>function($query){
                        $query->select(['id','name']);
                    },
                    'landsource'=>function($query){
                        $query->select(['id','name']);
                    },
                    'landstate'=>function($query){
                        $query->select(['id','name']);
                    },
                    'adminunit'=>function($query){
                        $query->select(['id','name']);
                    }])
                ->withCount([
                    'itempublics'=>function($query){
                        $query->whereNull('number');
                    }])
                ->where($where)
                ->orderBy($ordername,$orderby)
                ->sharedLock()
                ->offset($per_page*($page-1))
                ->limit($per_page)
                ->get();
            $itemlands=new LengthAwarePaginator($itemlands,$total,$per_page,$page);
            $itemlands->withPath(route('g_public_landiist',['item'=>$item_id]));
            if(blank($itemlands)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$itemlands;
            $edata=$infos;
            $url=null;
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=$infos;
            $url=null;
        }
        DB::commit();

        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.itempublic.landlist')->with($result);
        }
    }

    /*------------- 地块下附属物列表 -------------*/
    public function publiclist(Request $request){
        $item_id=$this->item_id;
        /* ********** 查询条件 ********** */
        $where=[];
        $where[] = ['item_id',$item_id];
        $infos['item_id'] = $item_id;
        /* ++++++++++ 地块 ++++++++++ */
        $land_id = $request->input('land_id');
        if(blank($land_id)){
            /* ********** 结果 ********** */
            $result=['code'=>'error','message'=>'请先选择地块','sdata'=>null,'edata'=>null,'url'=>null];
            return view('gov.error')->with($result);
        }
        $where[] = ['land_id',$land_id];
        $infos['land_id'] = $land_id;
        /* ********** 排序 ********** */
        $ordername=$request->input('ordername');
        $ordername=$ordername?$ordername:'building_id';
        $infos['ordername']=$ordername;

        $orderby=$request->input('orderby');
        $orderby=$orderby?$orderby:'asc';
        $infos['orderby']=$orderby;
        /* ********** 每页条数 ********** */
        $per_page=20;
        $page=$request->input('page',1);
        /* ********** 查询 ********** */
        $model=new Itempublic();
        DB::beginTransaction();
        try{
            $total=$model->sharedLock()
                ->where($where)
                ->count();
            $itempublics=$model->with(['itembuilding'])
                ->where($where)
                ->orderBy($ordername,$orderby)
                ->sharedLock()
                ->offset($per_page*($page-1))
                ->limit($per_page)
                ->get();
            $itempublics=new LengthAwarePaginator($itempublics,$total,$per_page,$page);
            $itempublics->withPath(route('g_publiclist',['item'=>$item_id,'land_id'=>$land_id]));
            if(blank($itempublics)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$itempublics;
            $edata=$infos;
            $url=null;
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=null;
            $edata=$infos;
            $url=null;
        }
        DB::commit();

        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.itempublic.publiclist')->with($result);
        }
    }

    /*------------- 地块下附属物详情-修改【确认信息】 -------------*/
    public function publicinfo(Request $request){
        $item_id = $this->item_id;
        $id=$request->input('id');
        if(blank($id)){
            $result=['code'=>'error','message'=>'请先选择数据','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }
        $land_id = $request->input('land_id');
        if(blank($land_id)){
            $result=['code'=>'error','message'=>'请先选择地块','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }
        if ($request->isMethod('get')) {
            /* ********** 当前数据 ********** */

            DB::beginTransaction();
            $itempublic=Itempublic::with([
                'itemland'=>function($query){
                    $query->select(['id','address']);
                },'itembuilding'=>function($query){
                    $query->select(['id','building']);
                }])
                ->sharedLock()
                ->find($id);
            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($itempublic)){
                $code='warning';
                $msg='数据不存在';
                $sdata=null;
                $edata=['item'=>$this->item,'itempublic'=>$itempublic,'item_id'=>$item_id,'land_id'=>$land_id];
                $url=null;

                $view='gov.error';
            }else{
                $code='success';
                $msg='获取成功';
                $sdata=$itempublic;
                $edata=['item'=>$this->item,'itempublic'=>$itempublic,'item_id'=>$item_id,'land_id'=>$land_id];
                $url=null;

                $view='gov.itempublic.publicinfo';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }else{
            $model=new Itempublic();
            /* ********** 表单验证 ********** */
            $rules=[
                'number' => 'required',

            ];
            $messages=[
                'required'=>':attribute必须填写'
            ];
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /* ********** 更新 ********** */
            DB::beginTransaction();
            try{
                /* ++++++++++ 锁定数据模型 ++++++++++ */
                $itempublic=Itempublic::lockForUpdate()->find($id);
                if(blank($itempublic)){
                    throw new \Exception('指定数据项不存在',404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $itempublic->fill($request->all());
                $itempublic->editOther($request);
                $itempublic->save();
                if(blank($itempublic)){
                    throw new \Exception('修改失败',404404);
                }
                $code='success';
                $msg='修改成功';
                $sdata=$itempublic;
                $edata=null;
                $url = route('g_publiclist',['land_id'=>$land_id,'item'=>$item_id]);
                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=$itempublic;
                $url=null;
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }


}