<?php
/*
|--------------------------------------------------------------------------
| 项目-操作控制
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use App\Http\Model\Ctrlcate;
use App\Http\Model\Itemctrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ItemctrlController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 操作控制 ========== */
    public function index(Request $request){
        DB::beginTransaction();
        try{
            $itemctrls=Itemctrl::with(['ctrlcate'=>function($query){
                $query->select(['id','name']);
            }])
                ->where('item_id',$this->item_id)
                ->orderBy('start_at','asc')
                ->orderBy('cate_id','asc')
                ->orderBy('serial','asc')
                ->sharedLock()
                ->get();
            if(blank($itemctrls)){
                throw new \Exception('没有符合条件的数据',404404);
            }

            $code='success';
            $msg='请求成功';
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络错误';
        }
        DB::commit();
        $sdata=[
            'item'=>$this->item,
            'itemctrls'=>$itemctrls,
        ];
        $edata=null;
        $url=null;

        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view('gov.itemctrl.index')->with($result);
        }
    }

    /* ========== 添加操作 ========== */
    public function add(Request $request){
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                /* ++++++++++ 操作控制分类 ++++++++++ */
                $ctrlcates=Ctrlcate::sharedLock()->get();
                if(blank($ctrlcates)){
                    throw new \Exception('没有操作控制分类数据',404404);
                }

                $code='success';
                $msg='请求成功';
                $sdata=[
                    'item'=>$this->item,
                    'ctrlcates'=>$ctrlcates,
                ];
                $edata=null;
                $url=null;

                $view='gov.itemctrl.add';
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
        /* ********** 保存 ********** */
        else {
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'cate_id' => 'required',
                'serial' => ['required',Rule::unique('item_control')->where(function($query){
                    $query->where([
                        ['item_id',$this->item_id],
                        ['cate_id',request()->input('cate_id')],
                    ]);
                }),'size:1'],
                'start_at' => 'required|date_format:Y-m-d H:i:s',
                'end_at' => 'required|date_format:Y-m-d H:i:s|after:start_at',
            ];
            $messages = [
                'required' => ':attribute 为必须项',
                'unique' => ':attribute 已存在',
                'size' => ':attribute 长度必须为 :size',
                'min' => ':attribute 不能少于 :min',
                'date_format' => ':attribute 输入格式错误',
                'after' => ':attribute 必须在 :date 之后',
            ];
            $model = new Itemctrl();
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result = ['code' => 'error', 'message' => $validator->errors()->first(), 'sdata' => null, 'edata' => null, 'url' => null];
                return response()->json($result);
            }
            DB::beginTransaction();
            try{
                $itemctrl=$model;
                $itemctrl->fill($request->input());
                $itemctrl->addOther($request);
                $itemctrl->item_id=$this->item_id;
                $itemctrl->save();
                if(blank($itemctrl)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=[
                    'item'=>$this->item,
                    'itemctrl'=>$itemctrl,
                ];
                $edata=null;
                $url=route('g_itemctrl',['item'=>$this->item_id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'保存失败';
                $sdata=null;
                $edata=null;
                $url=null;

                DB::rollBack();
            }

            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }

    /* ========== 修改操作 ========== */
    public function edit(Request $request){
        $id=$request->input('id');
        if(!$id){
            $result=['code'=>'error','message'=>'请选择数据','sdata'=>null,'edata'=>null,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.error')->with($result);
            }
        }
        if($request->isMethod('get')){
            DB::beginTransaction();
            try{
                /* ++++++++++ 操作控制 ++++++++++ */
                $itemctrl=Itemctrl::with('ctrlcate')
                    ->sharedLock()
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$id],
                    ])
                    ->first();
                if(blank($itemctrl)){
                    throw new \Exception('数据不存在',404404);
                }

                $code='success';
                $msg='请求成功';
                $sdata=[
                    'item'=>$this->item,
                    'itemctrl'=>$itemctrl,
                ];
                $edata=null;
                $url=null;

                $view='gov.itemctrl.edit';
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
        /* ********** 保存 ********** */
        else {
            DB::beginTransaction();
            try{
                /* ++++++++++ 操作控制 ++++++++++ */
                $itemctrl=Itemctrl::lockForUpdate()
                    ->where([
                        ['item_id',$this->item_id],
                        ['id',$id],
                    ])
                    ->first();
                if(blank($itemctrl)){
                    throw new \Exception('数据不存在',404404);
                }
                /* ++++++++++ 表单验证 ++++++++++ */
                $rules = [
                    'serial' => ['required',Rule::unique('item_control')->where(function($query) use ($itemctrl){
                        $query->where([
                            ['item_id',$this->item_id],
                            ['cate_id',$itemctrl->cate_id],
                            ['id','<>',$itemctrl->id],
                        ]);
                    }),'size:1'],
                    'start_at' => 'required|date_format:Y-m-d H:i:s',
                    'end_at' => 'required|date_format:Y-m-d H:i:s|after:start_at',
                ];
                $messages = [
                    'required' => ':attribute 为必须项',
                    'unique' => ':attribute 已存在',
                    'size' => ':attribute 长度必须为 :size',
                    'min' => ':attribute 不能少于 :min',
                    'date_format' => ':attribute 输入格式错误',
                    'after' => ':attribute 必须在 :date 之后',
                ];
                $model = new Itemctrl();
                $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
                if ($validator->fails()) {
                    throw new \Exception($validator->errors()->first(),404404);
                }
                $itemctrl->fill($request->input());
                $itemctrl->save();
                if(blank($itemctrl)){
                    throw new \Exception('保存失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=[
                    'item'=>$this->item,
                    'itemctrl'=>$itemctrl,
                ];
                $edata=null;
                $url=route('g_itemctrl',['item'=>$this->item_id]);

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'保存失败';
                $sdata=null;
                $edata=null;
                $url=null;

                DB::rollBack();
            }

            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }
}