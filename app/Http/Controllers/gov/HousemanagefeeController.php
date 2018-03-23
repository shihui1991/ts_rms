<?php
/*
|--------------------------------------------------------------------------
| 房源- 房源管理费
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use App\Http\Model\House;
use App\Http\Model\Housemanagefee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HousemanagefeeController extends BaseauthController
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
            $manage_fees=Housemanagefee::with(['house'=>function($query){
                $query->with(['housecompany'=>function($query){
                    $query->select(['id','name']);
                },'housecommunity'=>function($query){
                    $query->select(['id','name','address']);
                },'layout'=>function($query){
                    $query->select(['id','name']);
                }])
                    ->select(['id','company_id','community_id','layout_id','building','unit','floor','number','area']);
            }])
                ->sharedLock()
                ->orderBy('manage_at','asc')
                ->orderBy('house_id','asc')
                ->paginate();

            $code='success';
            $msg='获取成功';
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'网络错误';
        }
        $sdata=[
            'manage_fees'=>$manage_fees,
        ];
        $edata=null;
        $url=null;
        DB::commit();
        $result=['code'=>$code, 'message'=>$msg, 'sdata'=>$sdata, 'edata'=>$edata, 'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else {
            return view('gov.housemanagefee.index')->with($result);
        }
    }

    /* ========== 计算 ========== */
    public function add(Request $request){
        $year=$request->input('year');
        DB::beginTransaction();
        try{
            if($year>date('Y')){
                throw new \Exception('计算年份不能超过当前年',404404);
            }
           House::with(['housemanageprice'=>function($query) use ($year){
               $query->where([
                   ['start_at','<=',$year],
                   ['end_at','>=',$year],
               ])
                   ->orderBy('start_at','asc');
           },'transits'=>function($query) use($year){
               $query->where('start_at','<=',$year.'-12-31')
                   ->where(function ($query) use($year){
                       $query->whereNull('end_at')->orWhere('end_at','>=',$year.'-01-01');
                   })
                   ->select(['id','house_id','start_at','end_at'])
                   ->orderBy('start_at','asc');
           },'resettles'=>function($query) use($year){
               $query->where('settle_at','<=',$year.'-12-31')
                   ->select(['id','house_id','settle_at'])
                   ->orderBy('settle_at','asc');
           },'housemanagefees'=>function($query) use ($year){
               $query->where([
                   ['manage_at','>=',$year.'-01'],
                   ['manage_at','<=',$year.'-12'],
               ]);
           }])
               ->sharedLock()
               ->where([
                   ['is_buy',1],
                   ['code','<>','154'],
                   ['delive_at','<=',$year.'-12-31'],
               ])
               ->select(['id','is_buy','code','delive_at'])
               ->chunk(100,function($houses) use($year){
                   if(blank($houses)){
                       throw new \Exception('没有可计算的房源',404404);
                   }
                   if($year==date('Y')){
                       $month=date('m');
                   }else{
                       $month=12;
                   }
                   $fee_data=[];
                   $del_ids=[];
                   foreach($houses as $house){
                       for($i=1;$i<=$month;$i++){
                           $date_at=date('Y-m',strtotime($year.'-'.$i));

                           $nofee=false;
                           /* ++++++++++ 安置记录 ++++++++++ */
                           if(filled($house->resettles)){
                               foreach ($house->resettles as $resettle){
                                   if(date('Y-m',strtotime($resettle->settle_at)) <= $date_at){
                                       $nofee=true;
                                       break;
                                   }
                               }
                           }
                           /* ++++++++++ 临时安置记录 ++++++++++ */
                           if(!$nofee){
                               if(filled($house->transits)){
                                   foreach ($house->transits as $transit){
                                       if(date('Y-m',strtotime($transit->start_at)) <= $date_at){
                                           if($transit->end_at){
                                               if(date('Y-m',strtotime($transit->end_at)) >= $date_at){
                                                   $nofee=true;
                                                   break;
                                               }
                                           }else{
                                               $nofee=true;
                                               break;
                                           }
                                       }
                                   }
                               }
                           }

                           unset($fee_model);
                           /* ++++++++++ 获取已计算费用的模型 ++++++++++ */
                           if(filled($house->housemanagefees)){
                               foreach ($house->housemanagefees as $managefee){
                                   if($managefee->manage_at == $date_at){
                                       $fee_model=$managefee;
                                       break;
                                   }
                               }
                           }

                           if($nofee){
                               if(isset($fee_model)){
                                   $del_ids[]=$fee_model->id;
                               }
                           }else{

                               if(date('Y-m',strtotime($house->delive_at))>$date_at){
                                   if(isset($fee_model)){
                                       $del_ids[]=$fee_model->id;
                                   }
                                   continue;
                               }

                               /* ++++++++++ 整理数据 ++++++++++ */
                               $fee_data[]=[
                                   'id'=>isset($fee_model)?$fee_model->id:null,
                                   'house_id'=>$house->id,
                                   'manage_at'=>$date_at,
                                   'manage_fee'=>$house->housemanageprice->manage_price,
                                   'created_at'=>date('Y-m-d H:i:s'),
                                   'updated_at'=>date('Y-m-d H:i:s'),
                               ];
                           }
                       }
                   }

                   /* ++++++++++ 删除没有费用的数据 ++++++++++ */
                   if(filled($del_ids)){
                       Housemanagefee::whereIn('id',$del_ids)->delete();
                   }
                   /* ++++++++++ 批量添加数据 ++++++++++ */
                   if(filled($fee_data)){
                       $field=['id','house_id','manage_at','manage_fee','created_at','updated_at'];
                       $sqls=batch_update_or_insert_sql('house_manage_fee',$field,$fee_data,$field);
                       if(!$sqls){
                           throw new \Exception('数据错误',404404);
                       }
                       foreach ($sqls as $sql){
//                           DB::statement($sql);
                           $pdo=new \PDO(env('DB_CONNECTION').':dbname='.env('DB_DATABASE').';host='.env('DB_HOST'),env('DB_USERNAME'),env('DB_PASSWORD'));
                           $sth=$pdo->prepare($sql);
                           $sth->execute();
                       }
                   }
               });

            $code='success';
            $msg='计算成功';
            $sdata=null;
            $edata=null;
            $url=route('g_housemanagefee');

            DB::commit();
        }catch (\Exception $exception){
            $code='error';
            $msg=$exception->getCode()==404404?$exception->getMessage():'计算失败';
            $sdata=null;
            $edata=null;
            $url=null;

            DB::rollBack();
        }


        $result=['code'=>$code, 'message'=>$msg, 'sdata'=>$sdata, 'edata'=>$edata, 'url'=>$url];
        return response()->json($result);
    }
}