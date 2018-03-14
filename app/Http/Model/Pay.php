<?php
/*
|--------------------------------------------------------------------------
| 兑付 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pay extends Model
{
    use SoftDeletes;
    protected $table='pay';
    protected $primaryKey='id';
    protected $fillable=['repay_way','transit_way','move_way','picture'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [
        'picture'=>'array'
    ];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'household_id'=>'被征收户',
        'land_id'=>'地块',
        'building_id'=>'楼栋',
        'repay_way'=>'补偿方式',
        'transit_way'=>'过渡方式',
        'move_way'=>'搬迁方式',
        'total'=>'补偿总额',
        'picture'=>'征收决定',
    ];

    /* ++++++++++ 补偿方式 ++++++++++ */
    public function getRepayWayAttribute($key=null){
        $array=[0=>'货币补偿',1=>'房屋产权调换'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }

    /* ++++++++++ 补偿方式 ++++++++++ */
    public function getTransitWayAttribute($key=null){
        $array=[0=>'货币过渡',1=>'临时周转房'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }

    /* ++++++++++ 搬迁方式 ++++++++++ */
    public function getMoveWayAttribute($key=null){
        $array=[0=>'自行搬迁',1=>'政府协助'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }
    
    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }


    public function item(){
        return $this->belongsTo('App\Http\Model\Item','item_id','id')->withDefault();
    }

    public function household(){
        return $this->belongsTo('App\Http\Model\Household','household_id','id')->withDefault();
    }

    public function itemland(){
        return $this->belongsTo('App\Http\Model\Itemland','land_id','id')->withDefault();
    }

    public function itembuilding(){
        return $this->belongsTo('App\Http\Model\Itembuilding','building_id','id')->withDefault();
    }
}