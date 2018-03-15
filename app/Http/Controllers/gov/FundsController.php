<?php
/*
|--------------------------------------------------------------------------
| 项目-资金管理
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use App\Http\Model\Bank;
use App\Http\Model\Funds;
use App\Http\Model\Fundscate;
use App\Http\Model\Itemuser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FundsController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){
        DB::beginTransaction();

        $funds_details=Fundscate::with(['fundses'=>function($query){
            $query->with(['bank'=>function($query){
                $query->select(['id','name']);
            }])
                ->where('item_id',$this->item_id)
                ->orderBy('entry_at','asc');
        }])
            ->Select(['*',DB::raw('(SELECT SUM(`amount`) FROM `item_funds` WHERE `item_id`='.$this->item_id.' AND `item_funds`.`cate_id`=`a_item_funds_cate`.`id`) AS `total`')])
            ->sharedLock()
            ->get();

        DB::commit();

        /* ********** 结果 ********** */
        $result=[
            'code'=>'success',
            'message'=>'请求成功',
            'sdata'=>[
                'item'=>$this->item,
                'funds_details'=>$funds_details,
            ],
            'edata'=>null,
            'url'=>null];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.funds.index')->with($result);
        }
    }

    /* ========== 录入资金 ========== */
    public function add(Request $request){
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                $item=$this->item;
                if(blank($item)){
                    throw new \Exception('项目不存在',404404);
                }
                /* ++++++++++ 检查项目状态 ++++++++++ */
                if($item->schedule_id!=2 || $item->process_id!=18 ||  $item->code!='1'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
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

                $banks=Bank::sharedLock()->select('id','name')->get();

                $code='success';
                $msg='查询成功';
                $sdata=['item'=>$item,'banks'=>$banks];
                $edata=null;
                $url=null;

                $view='gov.funds.add';
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
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
        /* ********** 保存 ********** */
        else{
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules=[
                'amount'=>'required|min:1',
                'voucher'=>'required',
                'bank_id'=>'required',
                'account'=>'required',
                'name'=>'required',
                'entry_at'=>'required|date_format:Y-m-d H:i:s',
                'infos'=>'required',
                'picture'=>'required',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'date_format'=>':attribute 输入格式错误',
                'min'=>':attribute 不能少于 :min',
            ];
            $model=new Funds();
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
                if($item->schedule_id!=2 || $item->process_id!=18 ||  $item->code!='1'){
                    throw new \Exception('当前项目处于【'.$item->schedule->name.' - '.$item->process->name.'('.$item->state->name.')】，不能进行当前操作',404404);
                }
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
                /* ++++++++++ 批量赋值 ++++++++++ */
                $funds=$model;
                $funds->fill($request->input());
                $funds->addOther($request);
                $funds->item_id=$this->item_id;
                $funds->cate_id=1;
                $funds->save();
                if(blank($funds)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=$funds;
                $edata=null;
                $url=route('g_funds',['item'=>$this->item_id]);

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

    /* ========== 转账详情 ========== */
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
        $funds=Funds::with(['fundscate'=>function($query){
            $query->select(['id','name']);
        },'bank'=>function($query){
            $query->select(['id','name']);
        }])
            ->sharedLock()
            ->find($id);

        DB::commit();
        if(filled($funds)){
            $code='success';
            $msg='获取成功';
            $sdata=['item'=>$this->item,'funds'=>$funds];
            $edata=null;
            $url=null;

            $view='gov.funds.info';
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
}