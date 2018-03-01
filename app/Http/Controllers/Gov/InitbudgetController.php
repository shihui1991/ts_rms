<?php
/*
|--------------------------------------------------------------------------
| 项目-初步预算
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use App\Http\Model\Initbudget;
use App\Http\Model\Itemnotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InitbudgetController extends BaseitemController
{
    /* ========== 初始化 ========== */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 初步预算 ========== */
    public function index(Request $request){
        /* ********** 查询 ********** */
        DB::beginTransaction();
        $init_budget=Initbudget::sharedLock()->where('item_id',$this->item_id)->first();
        $item_notice=Itemnotice::sharedLock()
            ->where([
                ['item_id',$this->item_id],
                ['cate_id',2],
            ])
            ->first();

        DB::commit();

        /* ++++++++++ 结果 ++++++++++ */
        $result=[
            'code'=>'success',
            'message'=>'请求成功',
            'sdata'=>[
                'item'=>$this->item,
                'init_budget'=>$init_budget,
                'item_notice'=>$item_notice,
            ],
            'edata'=>null,
            'url'=>null];

        if($request->ajax()){
            return response()->json($result);
        }else{
            return view('gov.initbudget.index')->with($result);
        }
    }

    /* ========== 添加初步预算 ========== */
    public function add(Request $request){
        $model=new Initbudget();

        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                $init_budget=Initbudget::sharedLock()->where('item_id',$this->item_id)->first();
                if(filled($init_budget)){
                    throw new \Exception('初步预算报告已添加',404404);
                }

                $code='success';
                $msg='请求成功';
                $sdata=['item'=>$this->item];
                $edata=$model;
                $url=null;

                $view='gov.initbudget.add';
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
            /* ++++++++++ 表单验证 初步预算 ++++++++++ */
            $rules=[
                'holder'=>'required|min:0',
                'money'=>'required|min:0',
                'house'=>'required|min:0',
                'picture'=>'required',
                ];
            $messages=[
                'required'=>':attribute 为必须项',
                'min'=>':attribute 不能少于 :min',
                ];
            
            $validator = Validator::make($request->input('budget'),$rules,$messages,$model->columns);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /* ++++++++++ 表单验证 预算通知 ++++++++++ */
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
                $init_budget=Initbudget::sharedLock()->where('item_id',$this->item_id)->first();
                if(filled($init_budget)){
                    throw new \Exception('初步预算报告已添加',404404);
                }

                /* ++++++++++ 批量赋值 ++++++++++ */
                $init_budget=$model;
                $init_budget->fill($request->input('budget'));
                $init_budget->item_id=$this->item_id;
                $init_budget->save();
                if(blank($init_budget)){
                    throw new \Exception('保存失败',404404);
                }
                $item_notice=$item_notice_model;
                $item_notice->fill($request->input('notice'));
                $item_notice->item_id=$this->item_id;
                $item_notice->cate_id=2;
                $item_notice->save();
                if(blank($item_notice)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=['init_budget'=>$init_budget,'item_notice'=>$item_notice];
                $edata=null;
                $url=route('g_initbudget',['item'=>$this->item_id]);

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

    /* ========== 修改初步预算 ========== */
    public function edit(Request $request){
        $model=new Initbudget();

        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                $init_budget=Initbudget::sharedLock()->where('item_id',$this->item_id)->first();
                $item_notice=Itemnotice::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['cate_id',2],
                    ])
                    ->first();
                if(blank($init_budget)){
                    throw new \Exception('初步预算报告还未添加',404404);
                }

                $code='success';
                $msg='请求成功';
                $sdata=['item'=>$this->item,'init_budget'=>$init_budget,'item_notice'=>$item_notice];
                $edata=$model;
                $url=null;

                $view='gov.initbudget.edit';
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
            /* ++++++++++ 表单验证 初步预算 ++++++++++ */
            $rules=[
                'holder'=>'required|min:0',
                'money'=>'required|min:0',
                'house'=>'required|min:0',
                'picture'=>'required',
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'min'=>':attribute 不能少于 :min',
            ];

            $validator = Validator::make($request->input('budget'),$rules,$messages,$model->columns);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /* ++++++++++ 表单验证 预算通知 ++++++++++ */
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
                $init_budget=Initbudget::sharedLock()->where('item_id',$this->item_id)->first();
                $item_notice=Itemnotice::sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['cate_id',2],
                    ])
                    ->first();
                if(blank($init_budget)){
                    throw new \Exception('初步预算报告还未添加',404404);
                }

                /* ++++++++++ 批量赋值 ++++++++++ */
                $init_budget->fill($request->input('budget'));
                $init_budget->save();
                if(blank($init_budget)){
                    throw new \Exception('保存失败',404404);
                }
                $item_notice->fill($request->input('notice'));
                $item_notice->save();
                if(blank($item_notice)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=['init_budget'=>$item_notice,'item_notice'=>$item_notice];
                $edata=null;
                $url=route('g_initbudget',['item'=>$this->item_id]);

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