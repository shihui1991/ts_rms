<?php
/*
|--------------------------------------------------------------------------
| 项目-社会稳定风险评估 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Itemrisk extends Model{
    use SoftDeletes;
    protected $table='item_risk';
    protected $primaryKey='id';
    protected $fillable=['household_id','land_id','building_id','agree','repay_way','house_price','house_area','house_num','house_addr','more_price','layout_id','transit_way','move_way','move_fee','decoration','device','business'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'household_id'=>'被征户',
        'land_id'=>'地块',
        'building_id'=>'楼栋',
        'agree'=>'征收意见稿态度',
        'repay_way'=>'补偿方式',
        'house_price'=>'房源单价',
        'house_area'=>'房源面积',
        'house_num'=>'房源数量',
        'house_addr'=>'房源地址',
        'more_price'=>'增加面积单价',
        'layout_id'=>'户型图',
        'transit_way'=>'过渡方式',
        'move_way'=>'搬迁方式',
        'move_fee'=>'搬迁补偿',
        'decoration'=>'装修补偿',
        'device'=>'设备拆移费',
        'business'=>'停产停业损失补偿'
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 获取评估结论 ++++++++++ */
    public function getAgreeAttribute($key=null)
    {
        $array=[0=>'反对',1=>'同意'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }

    /* ++++++++++ 获取补偿方式 ++++++++++ */
    public function getRepayWayAttribute($key=null)
    {
        $array=[0=>'货币补偿',1=>'房屋产权调换'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }
    /* ++++++++++ 获取过度方式 ++++++++++ */
    public function getTransitWayAttribute($key=null)
    {
        $array=[0=>'货币过渡',1=>'临时周转房'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }

    /* ++++++++++ 获取搬迁方式 ++++++++++ */
    public function getMoveWayAttribute($key=null)
    {
        $array=[0=>'自行搬迁',1=>'政府协助'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }
    /* ++++++++++ 关联项目 ++++++++++ */
    public function item(){
        return $this->belongsTo('App\Http\Model\Item','item_id','id')->withDefault();
    }

    /* ++++++++++ 关联被征户 ++++++++++ */
    public function household(){
        return $this->belongsTo('App\Http\Model\Household','household_id','id')->withDefault();
    }

    /* ++++++++++ 关联地块 ++++++++++ */
    public function land(){
        return $this->belongsTo('App\Http\Model\Itemland','land_id','id')->withDefault();
    }

    /* ++++++++++ 关联楼栋 ++++++++++ */
    public function building(){
        return $this->belongsTo('App\Http\Model\Itembuilding','building_id','id')->withDefault();
    }

    /* ++++++++++ 关联户型 ++++++++++ */
    public function layout(){
        return $this->belongsTo('App\Http\Model\Layout','layout_id','id')->withDefault();
    }
}