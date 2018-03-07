<?php
/*
|--------------------------------------------------------------------------
| 评估---公共附属物
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Com;
use App\Http\Model\Companyhousehold;
use App\Http\Model\Compublic;
use App\Http\Model\Compublicdetail;
use App\Http\Model\Itempublic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CompublicController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ++++++++++ 公共附属物列表 ++++++++++ */
    public function index(Request $request)
    {
        $item_id = $this->item_id;
        $company_id = session('com_user.company_id');
        $infos['item_id'] = $item_id;
        $infos['company_id'] = $company_id;
        /* ********** 每页条数 ********** */
        $displaynum=$request->input('displaynum');
        $displaynum=$displaynum?$displaynum:20;
        /* ********** 查询 ********** */
        DB::beginTransaction();
        try{
            $compublics=Compublic::with([
                'company'=>function($query){
                    $query->select(['id','name']);
                }])
                ->where('item_id',$item_id)
                ->where('company_id',$company_id)
                ->sharedLock()
                ->paginate($displaynum);
            if(blank($compublics)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$compublics;
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
            return view('com.compublic.index')->with($result);
        }
    }

    /* ========== 评估公共附属物 ========== */
    public function add(Request $request){
        $model=new Compublic();
        $item_id = $this->item_id;
        $company_id = session('com_user.company_id');
        if($request->isMethod('get')){
           $sdata['companyhousehold'] = Companyhousehold::with([
                'household'=>function($query){
                    $query->with([
                        'itemland'=>function($querys){
                            $querys->select(['id','address']);
                        }])
                        ->select(['id','land_id']);
                }])
                ->where('item_id',$item_id)
                ->where('company_id',$company_id)
                ->get();
            $sdata['item_id'] = $item_id;
            $result=['code'=>'success','message'=>'请求成功','sdata'=>$sdata,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('com.compublic.add')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else {
            /* ++++++++++ 表单验证 ++++++++++ */
            $price = $request->input('price');
            $picture = $request->input('picture');
            $publicdetail_datas = [];
            $i = 0;
            foreach ($price as $k=>$v){
                if(blank($v)){
                    $result=['code'=>'error','message'=>'评估单价不能为空','sdata'=>null,'edata'=>null,'url'=>null];
                    return response()->json($result);
                }
                $publicdetail_datas[$i]['item_id'] = $item_id;
                $publicdetail_datas[$i]['item_public_id'] = $k;
                $publicdetail_datas[$i]['company_id'] = $company_id;
                $publicdetail_datas[$i]['price'] = $v;
                $i++;
            }
            /* ++++++++++ 数据验证 ++++++++++ */
            $item_public_id = $request->input('item_public_id');
            if(count($price)!=count($item_public_id)){
                $result=['code'=>'error','message'=>'数据异常','sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            $itempublic = Itempublic::whereIn('id',$item_public_id)->get();
            if(blank($itempublic)){
                $result=['code'=>'error','message'=>'数据异常','sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'picture' => 'required'
            ];
            $messages = [
                'required' => ':attribute不能为空'
            ];
            $filed_msg = [
                'picture'=>'评估报告'
            ];
            $validator = Validator::make($request->all(), $rules, $messages, $filed_msg);
            if ($validator->fails()) {
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try {
                /* ++++++++++ 评估-公共附属物 ++++++++++ */
                $compublic = $model;
                $compublic->item_id = $item_id;
                $compublic->company_id = $company_id;
                $compublic->total = 0;
                $compublic->picture = $picture;
                $compublic->save();
                if (blank($compublic)) {
                    throw new \Exception('添加失败', 404404);
                }
                /* ++++++++++ 评估-公共附属物明细 ++++++++++ */
                $totals = 0;
                foreach ($itempublic as $k=>$v){
                    if($publicdetail_datas[$k]['item_public_id']==$v->id){
                        $amount = $publicdetail_datas[$k]['price']*$v->number;
                        $publicdetail_datas[$k]['land_id'] = $v->land_id;
                        $publicdetail_datas[$k]['building_id'] = $v->building_id;
                        $publicdetail_datas[$k]['com_public_id'] = $compublic->id;
                        $publicdetail_datas[$k]['amount'] = $amount;
                        $publicdetail_datas[$k]['created_at'] = date('Y-m-d H:i:s');
                        $publicdetail_datas[$k]['updated_at'] = date('Y-m-d H:i:s');
                        $totals += $amount;
                    }
                }
                $compublicdetail = Compublicdetail::insert($publicdetail_datas);
                if(blank($compublicdetail)){
                    throw new \Exception('添加失败', 404404);
                }
                /* ++++++++++ 【修改总价】评估-公共附属物 ++++++++++ */
                $compublics_data =  Compublic::lockForUpdate()->find($compublic->id);
                $compublics_data->total = $totals;
                $compublics_data->save();
                if(blank($compublics_data)){
                    throw new \Exception('添加失败', 404404);
                }
                $code = 'success';
                $msg = '添加成功';
                $sdata = $compublic;
                $edata = null;
                $url = route('c_compublic',['item'=>$item_id]);
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

    /* ========== 修改评估公共附属物 ========== */
    public function edit(Request $request){
        $id = $request->input('id');
        $model=new Compublic();
        $item_id = $this->item_id;
        $company_id = session('com_user.company_id');
        if($request->isMethod('get')){
            $data['item_id'] = $item_id;
            DB::beginTransaction();
            try{
                $data['companyhousehold'] = Companyhousehold::with([
                    'household'=>function($query){
                        $query->with([
                            'itemland'=>function($querys){
                                $querys->select(['id','address']);
                            }])
                            ->select(['id','land_id']);
                    }])
                    ->where('item_id',$item_id)
                    ->where('company_id',$company_id)
                    ->get();
                $compublics=Compublic::sharedLock()->find($id);
                if(blank($compublics)){
                    throw new \Exception('没有符合条件的数据',404404);
                }
                $code='success';
                $msg='查询成功';
                $sdata=$data;
                $edata=$compublics;
                $url=null;
                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
                $sdata=null;
                $edata=null;
                $url=null;
            }
            if($code=='error'){
                $view = 'com.error';
            }else{
                $view = 'com.compublic.add';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else {
            /* ++++++++++ 表单验证 ++++++++++ */
            $price = $request->input('price');
            $picture = $request->input('picture');
            $publicdetail_datas = [];
            $i = 0;
            foreach ($price as $k=>$v){
                if(blank($v)){
                    $result=['code'=>'error','message'=>'评估单价不能为空','sdata'=>null,'edata'=>null,'url'=>null];
                    return response()->json($result);
                }
                $publicdetail_datas[$i]['item_id'] = $item_id;
                $publicdetail_datas[$i]['item_public_id'] = $k;
                $publicdetail_datas[$i]['company_id'] = $company_id;
                $publicdetail_datas[$i]['price'] = $v;
                $i++;
            }
            /* ++++++++++ 数据验证 ++++++++++ */
            $item_public_id = $request->input('item_public_id');
            if(count($price)!=count($item_public_id)){
                $result=['code'=>'error','message'=>'数据异常','sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            $itempublic = Itempublic::whereIn('id',$item_public_id)->get();
            if(blank($itempublic)){
                $result=['code'=>'error','message'=>'数据异常','sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'picture' => 'required'
            ];
            $messages = [
                'required' => ':attribute不能为空'
            ];
            $filed_msg = [
                'picture'=>'评估报告'
            ];
            $validator = Validator::make($request->all(), $rules, $messages, $filed_msg);
            if ($validator->fails()) {
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try {
                /* ++++++++++ 评估-公共附属物 ++++++++++ */
                $compublic = $model;
                $compublic->item_id = $item_id;
                $compublic->company_id = $company_id;
                $compublic->total = 0;
                $compublic->picture = $picture;
                $compublic->save();
                if (blank($compublic)) {
                    throw new \Exception('添加失败', 404404);
                }
                /* ++++++++++ 评估-公共附属物明细 ++++++++++ */
                $totals = 0;
                foreach ($itempublic as $k=>$v){
                    if($publicdetail_datas[$k]['item_public_id']==$v->id){
                        $amount = $publicdetail_datas[$k]['price']*$v->number;
                        $publicdetail_datas[$k]['land_id'] = $v->land_id;
                        $publicdetail_datas[$k]['building_id'] = $v->building_id;
                        $publicdetail_datas[$k]['com_public_id'] = $compublic->id;
                        $publicdetail_datas[$k]['amount'] = $amount;
                        $publicdetail_datas[$k]['created_at'] = date('Y-m-d H:i:s');
                        $publicdetail_datas[$k]['updated_at'] = date('Y-m-d H:i:s');
                        $totals += $amount;
                    }
                }
                $compublicdetail = Compublicdetail::insert($publicdetail_datas);
                if(blank($compublicdetail)){
                    throw new \Exception('添加失败', 404404);
                }
                /* ++++++++++ 【修改总价】评估-公共附属物 ++++++++++ */
                $compublics_data =  Compublic::lockForUpdate()->find($compublic->id);
                $compublics_data->total = $totals;
                $compublics_data->save();
                if(blank($compublics_data)){
                    throw new \Exception('添加失败', 404404);
                }
                $code = 'success';
                $msg = '添加成功';
                $sdata = $compublic;
                $edata = null;
                $url = route('c_compublic',['item'=>$item_id]);
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


}