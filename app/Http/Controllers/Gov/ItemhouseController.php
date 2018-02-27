<?php
/*
|--------------------------------------------------------------------------
| 项目-冻结房源
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;
use App\Http\Model\Housecommunity;
use App\Http\Model\Itemhouse;
use App\Http\Model\Layout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemhouseController extends BaseitemController
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
        $select=['item_id','house_id','type','created_at'];
        /* ********** 排序 ********** */
        $ordername=$request->input('ordername');
        $ordername=$ordername?$ordername:'created_at';
        $infos['ordername']=$ordername;

        $orderby=$request->input('orderby');
        $orderby=$orderby?$orderby:'asc';
        $infos['orderby']=$orderby;
        /* ********** 每页条数 ********** */
        $displaynum=$request->input('displaynum');
        $displaynum=$displaynum?$displaynum:15;
        $infos['displaynum']=$displaynum;
        /* ********** 查询 ********** */
        $model=new Itemhouse();
        DB::beginTransaction();
        try{
            $itemhouses=$model
                ->with(['item'=>function($query){
                    $query->select(['id','name']);
                },
                    'house'=>function($query){
                        $query->with([
                            'housecommunity'=> function ($query) {
                                $query->withTrashed()->select(['id','name']);
                            },
                            'layout'=> function ($query) {
                                $query->withTrashed()->select(['id','name']);
                            },
                            'housecompany'=> function ($query) {
                                $query->withTrashed()->select(['id','name']);
                            }]);
                    }])
                ->where($where)
                ->select($select)
                ->orderBy($ordername,$orderby)
                ->sharedLock()
                ->paginate($displaynum);
            if(blank($itemhouses)){
                throw new \Exception('没有符合条件的数据',404404);
            }
            $code='success';
            $msg='查询成功';
            $sdata=$itemhouses;
            $edata=$infos;
            $url=null;
        }catch (\Exception $exception){
            dd($exception);
            $itemhouses=collect();
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络异常';
            $sdata=$itemhouses;
            $edata=$infos;
            $url=null;
        }
        DB::commit();

        /* ********** 结果 ********** */
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.itemhouse.index')->with($result);
        }
    }

    /* ========== 添加 ========== */
    public function add(Request $request){
        $item_id=$this->item_id;
        $model=new Itemhouse();
        if($request->isMethod('get')){
            $sdata['item_id'] = $item_id;
            $sdata['housecommunity'] = Housecommunity::select(['id','name'])->get()?:[];
            $sdata['layout'] = Layout::select(['id','name'])->get()?:[];
            $result=['code'=>'success','message'=>'请求成功','sdata'=>$sdata,'edata'=>$model,'url'=>null];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view('gov.itemhouse.add')->with($result);
            }
        }
        /* ++++++++++ 保存 ++++++++++ */
        else {
            /* ********** 保存 ********** */
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules = [
                'house_id'=>'required',
            ];
            $messages = [
                'required' => ':attribute必须填写'
            ];
            $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
            if ($validator->fails()) {
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /* ++++++++++ 新增 ++++++++++ */
            DB::beginTransaction();
            try {
                $house_ids = $request->input('house_id');
                $datas = [];
                foreach ($house_ids as $k=>$v){
                    $datas[$k]['item_id'] = $item_id;
                    $datas[$k]['house_id'] = $v;
                    $datas[$k]['type'] = 0;
                    $datas[$k]['created_at'] = date('Y-m-d H:i:s');
                    $datas[$k]['updated_at'] = date('Y-m-d H:i:s');
                }
                /* ++++++++++ 批量赋值 ++++++++++ */
                $field=['item_id','house_id','type','created_at','updated_at'];
                $sqls=batch_update_or_insert_sql('item_house',$field,$datas,$field);
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
                $url = route('g_house',['item'=>$item_id]);
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