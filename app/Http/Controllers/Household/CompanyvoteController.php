<?php
/*
|--------------------------------------------------------------------------
| 项目-社会风险评估
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers\Household;

use App\Http\Model\Companyvote;
use App\Http\Model\Company;
use App\Http\Model\Household;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class  CompanyvoteController extends BaseController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    public function info(Request $request)
    {

        $item_id = session('household_user.item_id');
        $household_id = session('household_user.user_id');
        /* ********** 当前数据 ********** */
        DB::beginTransaction();

        $model = Companyvote::with(
            ['item' => function ($query) {
                $query->select(['id', 'name']);
            }, 'company' => function ($query) {
                $query->select(['id', 'name']);
            }, 'household' => function ($query) {
                $query->select(['id', 'username']);
            }])
            ->where('household_id', $household_id)
            ->where('item_id', $item_id)
            ->sharedLock()
            ->first();

        DB::commit();

        /* ++++++++++ 数据不存在 ++++++++++ */
        if (blank($model)) {
            $code = 'warning';
            $msg = '数据不存在';
            $sdata = null;
            $edata = null;
            $url = null;
        } else {
            $code = 'success';
            $msg = '获取成功';
            $sdata = $model;
            $edata = null;
            $url = null;
        }
        $view = 'household.itemcompanyvote.info';
        $result = ['code' => $code, 'message' => $msg, 'sdata' => $sdata, 'edata' => $edata, 'url' => $url];
        if ($request->ajax()) {
            return response()->json($result);
        } else {
            return view($view)->with($result);
        }
    }

    /*评估机构投票-添加页面*/
    public function add(Request $request)
    {
        $item_id = session('household_user.item_id');
        $household_id = session('household_user.user_id');

        if ($request->isMethod('get')) {
            DB::beginTransaction();
            $model = Companyvote::where('household_id', $household_id)
                ->where('item_id', $item_id)
                ->sharedLock()
                ->first();
            DB::commit();

            if (filled($model)) {
                return response()->json(['code' => 'error', 'message' => '评估机构投票不允许重复添加!', 'sdata' => null, 'edata' => null, 'url' => null]);
            }
            $model = Household::with(
                ['item' => function ($query) {
                    $query->select(['id', 'name']);
                }])
                ->where('item_id', $item_id)
                ->sharedLock()
                ->first();
            $model->company = Company::where('type',0)->pluck('name', 'id');
            $result = ['code' => 'success', 'message' => '请求成功', 'sdata' => $model, 'edata' => null, 'url' => null];

            if ($request->ajax()) {
                return response()->json($result);
            } else {
                return view('household.itemcompanyvote.add')->with($result);
            }
        } /*数据保存*/
        else {

            $company_id=$request->input('company_id');

            if(!$company_id){
                $result=['code'=>'error', 'message'=>'请选择评估机构', 'sdata'=>null, 'edata'=>null, 'url'=>null];
                if($request->ajax()){
                    return response()->json($result);
                }else {
                    return view('gov.error')->with($result);
                }
            }

            $model = new Companyvote();
            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try {
                $company=Company::sharedLock()->find($company_id);
                if(blank($company)){
                    throw new \Exception('评估机构不存在',404404);
                }

                /* ++++++++++ 批量赋值 ++++++++++ */
                $model->fill($request->all());
                $model->addOther($request);
                $model->item_id = $item_id;
                $model->household_id = $household_id;
                $model->save();
                if (blank($model)) {
                    throw new \Exception('添加失败', 404404);
                }
                $code = 'success';
                $msg = '添加成功';
                $sdata = $model;
                $edata = null;
                $url = route('h_itemcompanyvote_info', ['item' => $item_id]);
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
            $result = ['code' => $code, 'message' => $msg, 'sdata' => $sdata, 'edata' => $edata, 'url' => $url];
            return response()->json($result);
        }
    }

    /*社会稳定风险评估-修改页面*/
    public function edit(Request $request)
    {
        $id = $request->input('id');
        $item_id = session('household_user.item_id');
        $household_id = session('household_user.user_id');

        if (!$id) {
            $result = ['code' => 'error', 'message' => '请先选择数据', 'sdata' => null, 'edata' => null, 'url' => null];
            if ($request->ajax()) {
                return response()->json($result);
            } else {
                return view('household.error')->with($result);
            }
        }
        if ($request->isMethod('get')) {
            /* ********** 当前数据 ********** */
            DB::beginTransaction();
            $model =Companyvote ::with(['item' => function ($query) {
                $query->select(['id', 'name']);
            }, 'household' => function ($query) {
                $query->select(['id', 'username']);
            }])
                ->sharedLock()
                ->find($id);
            $model->company = Company::where('type',0)->pluck('name', 'id');
            DB::commit();

            /* ++++++++++ 数据不存在 ++++++++++ */
            if (blank($model)) {
                $code = 'warning';
                $msg = '数据不存在';
                $sdata = null;
                $edata = null;
                $url = null;
            } else {
                $code = 'success';
                $msg = '获取成功';
                $sdata = $model;
                $edata = null;
                $url = null;
                $view = 'household.itemcompanyvote.edit';
            }
            $result = ['code' => $code, 'message' => $msg, 'sdata' => $sdata, 'edata' =>null, 'url' => $url];
            if ($request->ajax()) {
                return response()->json($result);
            } else {
                return view($view)->with($result);
            }
        } else {

            $company_id=$request->input('company_id');

            if(!$company_id){
                $result=['code'=>'error', 'message'=>'请选择评估机构', 'sdata'=>null, 'edata'=>null, 'url'=>null];
                if($request->ajax()){
                    return response()->json($result);
                }else {
                    return view('household.error')->with($result);
                }
            }

            /* ********** 更新 ********** */
            DB::beginTransaction();
            try {
                $company=Company::sharedLock()->find($company_id);
                if(blank($company)){
                    throw new \Exception('评估机构不存在',404404);
                }

                /* ++++++++++ 锁定数据模型 ++++++++++ */
                $model = Companyvote::lockForUpdate()->find($id);
                if (blank($model)) {
                    throw new \Exception('指定数据项不存在', 404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $model->fill($request->all());
                $model->editOther($request);
                $model->item_id = $item_id;
                $model->household_id = $household_id;
                $model->save();
                if (blank($model)) {
                    throw new \Exception('修改失败', 404404);
                }
                $code = 'success';
                $msg = '修改成功';
                $sdata = $model;
                $edata = null;
                $url = route('h_itemcompanyvote_info');

                DB::commit();
            } catch (\Exception $exception) {
                $code = 'error';
                $msg = $exception->getCode() == 404404 ? $exception->getMessage() : '网络异常';
                $sdata = null;
                $edata = $exception->getMessage();
                $url = null;
                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result = ['code' => $code, 'message' => $msg, 'sdata' => $sdata, 'edata' => $edata, 'url' => $url];
            return response()->json($result);
        }

    }
}