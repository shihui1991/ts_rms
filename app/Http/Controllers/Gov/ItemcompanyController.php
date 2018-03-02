<?php
/*
|--------------------------------------------------------------------------
| 项目-选定评估机构
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;
use App\Http\Model\Companyhousehold;
use App\Http\Model\Itembuilding;
use App\Http\Model\Itemcompany;
use App\Http\Model\Itemland;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemcompanyController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        $item_id=$this->item_id;
        /* ********** 查询条件 ********** */
        $where=[];
        $where[] = ['item_id',$item_id];
        $infos['item_id'] = $item_id;
        $select=['id','item_id','company_id','type','created_at'];
        /* ********** 排序 ********** */
        $ordername=$request->input('ordername');
        $ordername=$ordername?$ordername:'id';
        $infos['ordername']=$ordername;

        $orderby=$request->input('orderby');
        $orderby=$orderby?$orderby:'asc';
        $infos['orderby']=$orderby;
        /* ********** 每页条数 ********** */
        $displaynum=$request->input('displaynum');
        $displaynum=$displaynum?$displaynum:15;
        $infos['displaynum']=$displaynum;
        /* ********** 查询 ********** */
        $model=new Itemcompany();
        DB::beginTransaction();
        try{
            $itemcompanys=$model
                ->with(['item'=>function($query){
                    $query->select(['id','name']);
                },
                    'company'=>function($query){
                        $query->select(['id','name']);
                    }])
                ->where($where)
                ->select($select)
                ->orderBy($ordername,$orderby)
                ->sharedLock()
                ->paginate($displaynum);
            $infos['typecount'] = $model
                ->where($where)
                ->where('type',0)
                ->count();
            $infos['typecounts'] = $model
                ->where($where)
                ->where('type',1)
                ->count();
            if(blank($itemcompanys)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$itemcompanys;
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
            return view('gov.itemcompany.index')->with($result);
        }
    }

    /* ========== 添加 ========== */
    public function add(Request $request){
        $item_id=$this->item_id;
        $model=new Itemcompany();
        if($request->isMethod('get')){
            $sdata['item_id'] = $item_id;
            $sdata['type'] = $request->input('type');
            $sdata['itemland'] = Itemland::select(['id','address'])->where('item_id',$item_id)->get()?:[];
            $sdata['itembuilding'] = Itembuilding::select(['id','building'])->distinct()->where('item_id',$item_id)->get()?:[];
            $result=['code'=>'success','message'=>'请求成功','sdata'=>$sdata,'edata'=>$model,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.itemcompany.add')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else {
            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'type'=>'required',
                'company_id'=>'required'
            ];
            $messages = [
                'required' => ':attribute必须填写'
            ];
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            $household_ids = $request->input('household_id');
            if(blank($household_ids)){
                $result=['code'=>'error','message'=>'请勾选被征收户','sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try {
                /* ++++++++++ 【选定评估机构】 ++++++++++ */
                $itemcompany =$model;
                $itemcompany->fill($request->all());
                $itemcompany->item_id = $item_id;
                $itemcompany->save();
                if (blank($itemcompany)) {
                    throw new \Exception('添加失败', 404404);
                }
                /* ++++++++++ 【选定评估机构-评估范围】 ++++++++++ */
                $datas = [];
                foreach ($household_ids as $k=>$v){
                    $datas[$k]['item_id'] = $item_id;
                    $datas[$k]['company_id'] = $request->input('company_id');
                    $datas[$k]['item_company_id'] = $itemcompany->id;
                    $datas[$k]['household_id'] = $v;
                    $datas[$k]['created_at'] = date('Y-m-d H:i:s');
                }
                /* ++++++++++ 批量赋值 ++++++++++ */
                $field=['item_id','company_id','item_company_id','household_id','created_at'];
                $sqls=batch_update_or_insert_sql('item_company_household',$field,$datas,$field);
                if(!$sqls){
                    throw new \Exception('数据错误',404404);
                }
                foreach ($sqls as $sql){
                    DB::statement($sql);
                }
                $code = 'success';
                $msg = '添加成功';
                $sdata = null;
                $edata = null;
                $url = route('g_itemcompany',['item'=>$item_id]);
                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '添加失败';
                $sdata = null;
                $edata = null;
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
        if(!$id){
            $result=['code'=>'error','message'=>'请先选择数据','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }
        $item_id=$this->item_id;

        /* ********** 当前数据 ********** */
        $data['item_id'] = $item_id;
        $data['companyhousehold'] = Companyhousehold::with([
            'household'=>function($query){
                $query->select(['id','land_id','building_id','unit','floor','number','type'])
                    ->with(['itemland'=>function($querys){
                        $querys->select(['id','address']);
                    },
                    'itembuilding'=>function($querys){
                        $querys->select(['id','building']);
                    },
                    'householddetail'=>function($querys){
                        $querys->select(['id','household_id','has_assets']);
                    }]);
            }])
            ->where('item_company_id',$id)
            ->where('item_id',$item_id)
            ->get()?:[];
        DB::beginTransaction();
        $itemcompany=Itemcompany::with([
            'company'=>function($query){
                $query->select(['id','name']);
            }])
            ->sharedLock()
            ->find($id);
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($itemcompany)){
            $code='warning';
            $msg='数据不存在';
            $sdata=null;
            $edata=$data;
            $url=null;
        }else{
            $code='success';
            $msg='获取成功';
            $sdata=$itemcompany;
            $edata=$data;
            $url=null;

            $view='gov.itemcompany.info';
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
        $item_id=$this->item_id;
        $model=new Itemcompany();
        $id =$request->input('id');
        if($request->isMethod('get')){
            $edata['item_id'] = $item_id;
            $edata['itemland'] = Itemland::select(['id','address'])->where('item_id',$item_id)->get()?:[];
            $edata['itembuilding'] = Itembuilding::select(['id','building'])->distinct()->where('item_id',$item_id)->get()?:[];
            $edata['companyhousehold'] = Companyhousehold::with([
                'household'=>function($query){
                    $query->select(['id','land_id','building_id','unit','floor','number','type'])
                        ->with(['itemland'=>function($querys){
                            $querys->select(['id','address']);
                        },
                            'itembuilding'=>function($querys){
                                $querys->select(['id','building']);
                            },
                            'householddetail'=>function($querys){
                                $querys->select(['id','household_id','has_assets']);
                            }]);
                }])
                ->where('item_company_id',$id)
                ->where('item_id',$item_id)
                ->get()?:[];
            $household_ids_str = '';
            if(!blank($edata['companyhousehold'])){
                foreach ($edata['companyhousehold'] as $k=>$v){
                    if($k+1 == count($edata['companyhousehold'])){
                        $household_ids_str .= $v->household_id;
                    }else{
                        $household_ids_str .= $v->household_id.',';
                    }
                }
            }
            $edata['household_ids_str'] = $household_ids_str;
            $sdata = Itemcompany::with([
                'company'=>function($query){
                    $query->select(['id','name']);
                }])
                ->sharedLock()
                ->find($id);

            $result=['code'=>'success','message'=>'请求成功','sdata'=>$sdata,'edata'=>$edata,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.itemcompany.edit')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else {
            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'type'=>'required',
                'company_id'=>'required'
            ];
            $messages = [
                'required' => ':attribute必须填写'
            ];
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            $household_ids = $request->input('household_id');
            if(blank($household_ids)){
                $result=['code'=>'error','message'=>'请勾选被征收户','sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /* ++++++++++ 修改 ++++++++++ */
            DB::beginTransaction();
            try {
                /* ++++++++++ 【选定评估机构-修改】 ++++++++++ */
                /* ++++++++++ 锁定数据模型 ++++++++++ */
                $itemcompany=Itemcompany::lockForUpdate()->find($id);
                if(blank($itemcompany)){
                    throw new \Exception('指定数据项不存在',404404);
                }
                /* ++++++++++ 批量赋值 ++++++++++ */
                $itemcompany->fill($request->all());
                $itemcompany->editOther($request);
                $itemcompany->save();
                if (blank($itemcompany)) {
                    throw new \Exception('修改失败', 404404);
                }
                /* ++++++++++ 【选定评估机构-评估范围-删除旧数据】 ++++++++++ */
                $item_company_household = Companyhousehold::where('item_company_id',$id)
                    ->where('item_id',$item_id)
                    ->delete();
                if (blank($item_company_household)) {
                    throw new \Exception('修改失败', 404404);
                }
                /* ++++++++++ 【选定评估机构-评估范围-添加新数据】 ++++++++++ */
                $datas = [];
                foreach ($household_ids as $k=>$v){
                    $datas[$k]['item_id'] = $item_id;
                    $datas[$k]['company_id'] = $request->input('company_id');
                    $datas[$k]['item_company_id'] = $id;
                    $datas[$k]['household_id'] = $v;
                    $datas[$k]['created_at'] = date('Y-m-d H:i:s');
                }
                /* ++++++++++ 批量赋值 ++++++++++ */
                $field=['item_id','company_id','item_company_id','household_id','created_at'];
                $sqls=batch_update_or_insert_sql('item_company_household',$field,$datas,$field);
                if(!$sqls){
                    throw new \Exception('数据错误',404404);
                }
                foreach ($sqls as $sql){
                    DB::statement($sql);
                }

                $code = 'success';
                $msg = '修改成功';
                $sdata = $itemcompany;
                $edata = null;
                $url = route('g_itemcompany',['id'=>$id,'item'=>$item_id]);
                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '修改失败';
                $sdata = null;
                $edata = $itemcompany;
                $url = null;
                DB::rollBack();
            }
            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }

}