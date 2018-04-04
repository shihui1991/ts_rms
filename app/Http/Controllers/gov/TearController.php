<?php
/*
|--------------------------------------------------------------------------
| 项目-监督拆除
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use App\Http\Model\Tear;
use App\Http\Model\Teardetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TearController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        DB::beginTransaction();
        try{
            $tear=Tear::with('teardetails','state')
                ->sharedLock()
                ->where('item_id',$this->item_id)
                ->first();

            $code='success';
            $msg='获取成功';
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络错误';
        }
        $sdata=[
            'item'=>$this->item,
            'tear'=>$tear,
        ];
        $edata=null;
        $url=null;
        DB::commit();
        $result=['code'=>$code, 'message'=>$msg, 'sdata'=>$sdata, 'edata'=>$edata, 'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.tear.index')->with($result);
        }
    }

    /* ========== 添加委托 ========== */
    public function add(Request $request){
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->process_id!=39 || $item->code != '1'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 检查操作权限 ++++++++++ */
                $count=Itemuser::sharedLock()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',5],
                        ['process_id',43],
                        ['user_id',session('gov_user.user_id')],
                    ])
                    ->get();
                if(!$count){
                    throw new \Exception('您没有执行此操作的权限',404404);
                }

                $tear=Tear::sharedLock()
                    ->where('item_id',$this->item_id)
                    ->first();
                if(filled($tear)){
                    throw new \Exception('拆除委托已添加',404404);
                }

                $code='success';
                $msg='请求成功';
                $sdata=[
                    'item'=>$this->item,
                ];
                $edata=null;
                $url=null;

                $view='gov.tear.add';
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
        /* ********** 保存 ********** */
        else{
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'sign_at' => 'required|date_format:Y-m-d',
                'picture' => 'required',
            ];
            $messages = [
                'required' => ':attribute 为必须项',
                'date_format' => ':attribute 格式错误'
            ];
            $model=new Tear();
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result = ['code' => 'error', 'message' => $validator->errors()->first(), 'sdata' => null, 'edata' => null, 'url' => null];
                return response()->json($result);
            }

            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try {
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->process_id!=39 || $item->code != '1'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
                /* ++++++++++ 检查操作权限 ++++++++++ */
                $count=Itemuser::sharedLock()
                    ->where([
                        ['item_id',$item->id],
                        ['schedule_id',5],
                        ['process_id',43],
                        ['user_id',session('gov_user.user_id')],
                    ])
                    ->get();
                if(!$count){
                    throw new \Exception('您没有执行此操作的权限',404404);
                }
                $tear=Tear::sharedLock()
                    ->where('item_id',$this->item_id)
                    ->first();
                if(filled($tear)){
                    throw new \Exception('拆除委托已添加',404404);
                }
                /* ++++++++++ 批量赋值 ++++++++++ */
                $tear = $model;
                $tear->fill($request->input());
                $tear->addOther($request);
                $tear->item_id=$this->item_id;
                $tear->code='20';
                $tear->save();
                if (blank($tear)) {
                    throw new \Exception('添加失败', 404404);
                }

                $code = 'success';
                $msg = '添加成功';
                $sdata = [
                    'item'=>$this->item,
                    'tear'=>$tear,
                ];
                $edata = null;
                $url = route('g_tear',['item'=>$this->item_id]);
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

    /* ========== 添加拆除记录 ========== */
    public function detail_add(Request $request){
        $tear_id=$request->input('tear_id');
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                if(!$tear_id){
                    throw new \Exception('错误操作',404404);
                }
                $tear=Tear::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$tear_id],
                    ])
                    ->first();
                if(blank($tear)){
                    throw new \Exception('还未添加拆除委托',404404);
                }

                $code='success';
                $msg='请求成功';
                $sdata=[
                    'item'=>$this->item,
                    'tear_id'=>$tear_id,
                ];
                $edata=null;
                $url=null;

                $view='gov.tear.detail_add';
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
        /* ********** 保存 ********** */
        else{
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'tear_at' => 'required|date_format:Y-m-d',
                'picture' => 'required',
            ];
            $messages = [
                'required' => ':attribute 为必须项',
                'date_format' => ':attribute 格式错误'
            ];
            $model=new Teardetail();
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result = ['code' => 'error', 'message' => $validator->errors()->first(), 'sdata' => null, 'edata' => null, 'url' => null];
                return response()->json($result);
            }

            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try {
                if(!$tear_id){
                    throw new \Exception('错误操作',404404);
                }
                $tear=Tear::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$tear_id],
                    ])
                    ->first();
                if(blank($tear)){
                    throw new \Exception('还未添加拆除委托',404404);
                }
                /* ++++++++++ 批量赋值 ++++++++++ */
                $tear_detail = $model;
                $tear_detail->fill($request->input());
                $tear_detail->addOther($request);
                $tear_detail->item_id=$this->item_id;
                $tear_detail->save();
                if (blank($tear_detail)) {
                    throw new \Exception('添加失败', 404404);
                }

                $code = 'success';
                $msg = '添加成功';
                $sdata = [
                    'item'=>$this->item,
                    'tear'=>$tear,
                    'tear_detail'=>$tear_detail,
                ];
                $edata = null;
                $url = route('g_tear',['item'=>$this->item_id]);
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