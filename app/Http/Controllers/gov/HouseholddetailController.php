<?php
/*
|--------------------------------------------------------------------------
| 项目-被征收户详情
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;
use App\Http\Model\Buildinguse;
use App\Http\Model\Household;
use App\Http\Model\Householdassets;
use App\Http\Model\Householdbuilding;
use App\Http\Model\Householddetail;
use App\Http\Model\Householdmember;
use App\Http\Model\Householdobject;
use App\Http\Model\Layout;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HouseholddetailController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        $item_id=$this->item_id;
        $item=$this->item;
        $infos['item'] = $item;
        /* ********** 查询条件 ********** */
        $where=[];
        $where[] = ['item_id',$item_id];
        $infos['item_id'] = $item_id;
        $select=['id','item_id','land_id','building_id','household_id','has_assets'];
        /* ********** 地块 ********** */
        $land_id=$request->input('land_id');
        if(is_numeric($land_id)){
            $where[] = ['land_id',$land_id];
            $infos['land_id'] = $land_id;
        }
        /* ********** 楼栋 ********** */
        $building_id=$request->input('building_id');
        if(is_numeric($building_id)){
            $where[] = ['building_id',$building_id];
            $infos['building_id'] = $building_id;
        }
        /* ********** 资产评估 ********** */
        $has_assets=$request->input('has_assets');
        if(is_numeric($has_assets)){
            $where[] = ['has_assets',$has_assets];
            $infos['has_assets'] = $has_assets;
        }
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

        DB::beginTransaction();
        try{
            $total=Householddetail::sharedLock()
                ->where('item_id',$item_id)
                ->where($where)
                ->count();
            $households=Householddetail::with([
                    'itemland'=>function($query){
                        $query->select(['id','address']);
                    },
                    'itembuilding'=>function($query){
                        $query->select(['id','building']);
                    },
                    'household'=>function($query){
                        $query->select(['id','unit','floor','number','type','username']);
                    }])
                ->where($where)
                ->select($select)
                ->orderBy($ordername,$orderby)
                ->sharedLock()
                ->offset($per_page*($page-1))
                ->limit($per_page)
                ->get();
            $households=new LengthAwarePaginator($households,$total,$per_page,$page);
            $households->withPath(route('g_householddetail',['item'=>$item_id]));

            if(blank($households)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$households;
            $edata=$infos;
            $url=null;
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=$exception;
            $edata=$infos;
            $url=null;
        }
        DB::commit();

        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.householddetail.index')->with($result);
        }
    }

    /* ========== 添加 ========== */
    public function add(Request $request){
        $item_id=$this->item_id;
        $item=$this->item;
        $model=new Householddetail();
        $household_id =$request->input('household_id');
        if($request->isMethod('get')){
            $sdata['household'] = Household::select(['id','land_id','building_id'])
                ->with([
                    'itemland'=>function($query){
                        $query->select(['id','address']);
                    },
                    'itembuilding'=>function($query){
                        $query->select(['id','building']);
                    }])
                ->where('id',$household_id)
                ->first();
            $sdata['defuse'] = Buildinguse::select(['id','name'])->get()?:[];
            $sdata['layout'] = Layout::select(['id','name'])->get()?:[];
            $sdata['item_id'] = $item_id;
            $sdata['item'] = $item;
            $sdata['detailmodel'] = $model;
            $result=['code'=>'success','message'=>'请求成功','sdata'=>$sdata,'edata'=>$model,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.householddetail.add')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else {
            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'household_id'=>'required',
                'land_id'=>'required',
                'building_id'=>'required',
                'status'=>'required',
                'dispute'=>'required',
                'area_dispute'=>'required',
                'real_use'=>'required',
                'has_assets'=>'required',
                'agree'=>'required',
                'repay_way'=>'required',
                'sign'=>'required'
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
            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try {
                /* ++++++++++ 批量赋值 ++++++++++ */
                $householddetail = $model;
                $householddetail->fill($request->all());
                $householddetail->addOther($request);
                $householddetail->item_id=$this->item_id;
                $householddetail->save();
                if (blank($householddetail)) {
                    throw new \Exception('添加失败', 404404);
                }

                $code = 'success';
                $msg = '添加成功';
                $sdata = $householddetail;
                $edata = null;
                $url = route('g_householddetail_info',['id'=>$household_id,'item'=>$this->item_id]);
                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '添加失败';
                $sdata = null;
                $edata = $householddetail;
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
        $item_id=$this->item_id;
        $item=$this->item;

        /* ********** 当前数据 ********** */
        $data['item_id'] = $item_id;
        $data['item'] = $item;
        $data['household'] = new Household();
        $data['household_detail'] = Householddetail::with([
            'defbuildinguse'=>function($query){
                $query->select(['id','name']);
            },
            'realbuildinguse'=>function($query){
                $query->select(['id','name']);
            },
            'layout'=>function($query){
                $query->select(['id','name']);
            }])
            ->where('household_id',$id)
            ->first();
        DB::beginTransaction();
        $household=Household::with([
            'itemland'=>function($query){
                $query->select(['id','address']);
            },
            'itembuilding'=>function($query){
                $query->select(['id','building']);
            }])
            ->sharedLock()
            ->find($id);
            $data['householdmember']=Householdmember::with([
                'itemland'=>function($query){
                    $query->select(['id','address']);
                },
                'itembuilding'=>function($query){
                    $query->select(['id','building']);
                },
                'nation'=>function($query){
                    $query->select(['id','name']);
                },
                'householdmembercrowds'=>function($query){
                    $query->with([
                        'crowd'=>function($querys){
                            $querys->select(['id','name']);
                        }])
                        ->select(['id','member_id','crowd_id','picture']);
                }])
                ->where('item_id',$item_id)
                ->where('household_id',$id)
                ->sharedLock()
                ->get();
            $data['householdobject']=Householdobject::with([
                    'itemland'=>function($query){
                        $query->select(['id','address']);
                    },
                    'itembuilding'=>function($query){
                        $query->select(['id','building']);
                    },
                    'object'=>function($query){
                        $query->select(['id','name']);
                    }])
                ->where('item_id',$item_id)
                ->where('household_id',$id)
                ->sharedLock()
                ->get();
            $data['householdbuilding']=Householdbuilding::with([
                'itemland'=>function($query){
                    $query->select(['id','address']);
                },
                'itembuilding'=>function($query){
                    $query->select(['id','building']);
                },
                'buildingstruct'=>function($query){
                    $query->select(['id','name']);
                }])
                ->where('item_id',$item_id)
                ->where('household_id',$id)
                ->sharedLock()
                ->get();
        $data['householdassets']=Householdassets::with([
            'itemland'=>function($query){
                $query->select(['id','address']);
            },
            'itembuilding'=>function($query){
                $query->select(['id','building']);
            },
            ])
            ->where('item_id',$item_id)
            ->where('household_id',$id)
            ->sharedLock()
            ->get();
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($household)){
            $code='warning';
            $msg='数据不存在';
            $sdata=null;
            $edata=$data;
            $url=null;
        }else{
            $code='success';
            $msg='获取成功';
            $sdata=$household;
            $edata=$data;
            $url=null;

            $view='gov.householddetail.info';
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
        $item=$this->item;
        $model=new Householddetail();
        $id =$request->input('id');
        if($request->isMethod('get')){
            $sdata['household'] = Householddetail::with([
                    'itemland'=>function($query){
                        $query->select(['id','address']);
                    },
                    'itembuilding'=>function($query){
                        $query->select(['id','building']);
                    },
                    'defbuildinguse'=>function($query){
                        $query->select(['id','name']);
                    },
                    'realbuildinguse'=>function($query){
                        $query->select(['id','name']);
                    },
                    'layout'=>function($query){
                        $query->select(['id','name']);
                    }])
                ->where('id',$id)
                ->first();
            $sdata['defuse'] = Buildinguse::select(['id','name'])->get()?:[];
            $sdata['layout'] = Layout::select(['id','name'])->get()?:[];
            $sdata['item_id'] = $item_id;
            $sdata['item'] = $item;
            $sdata['detailmodel'] = $model;
            $result=['code'=>'success','message'=>'请求成功','sdata'=>$sdata,'edata'=>$model,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.householddetail.edit')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else {
            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'status'=>'required',
                'dispute'=>'required',
                'area_dispute'=>'required',
                'real_use'=>'required',
                'has_assets'=>'required',
                'agree'=>'required',
                'repay_way'=>'required',
                'sign'=>'required'
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
            /* ++++++++++ 修改 ++++++++++ */
            DB::beginTransaction();
            try {
                /* ++++++++++ 锁定数据模型 ++++++++++ */
                $householddetail=Householddetail::lockForUpdate()->find($id);
                if(blank($householddetail)){
                    throw new \Exception('指定数据项不存在',404404);
                }
                /* ++++++++++ 批量赋值 ++++++++++ */
                $householddetail->fill($request->all());
                $householddetail->editOther($request);
                $householddetail->save();
                if (blank($householddetail)) {
                    throw new \Exception('修改失败', 404404);
                }

                $code = 'success';
                $msg = '修改成功';
                $sdata = $householddetail;
                $edata = null;
                $url = route('g_householddetail_info',['id'=>$request->input('household_id'),'item'=>$this->item_id]);
                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '修改失败';
                $sdata = null;
                $edata = $householddetail;
                $url = null;
                DB::rollBack();
            }
            /* ++++++++++ 结果 ++++++++++ */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }
}