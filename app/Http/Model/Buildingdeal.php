<?php
/*
|--------------------------------------------------------------------------
| 被征收户-违建处理 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buildingdeal extends Model
{
    use SoftDeletes;
    protected $table='item_household_building_deal';
    protected $primaryKey='id';
    protected $fillable=['way','price','state','picture'];
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
        'way'=>'处理方式',
        'price'=>'拆除补助单价（罚款单价）',
        'amount'=>'拆除补助总价（罚款总价）',
        'state'=>'登记建筑面积',
        'picture'=>'处理结果',
    ];
    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 处理方式 ++++++++++ */
    public function getWayAttribute($key=null)
    {
        $array=[0=>'自行拆除',1=>'转为合法'];
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
    /* ++++++++++ 关联地块 ++++++++++ */
    public function itemland(){
        return $this->belongsTo('App\Http\Model\Itemland','land_id','id')->withDefault();
    }
    /* ++++++++++ 关联楼栋 ++++++++++ */
    public function itembuilding(){
        return $this->belongsTo('App\Http\Model\Itembuilding','building_id','id')->withDefault();
    }
    /* ++++++++++ 关联被征户 ++++++++++ */
    public function household(){
        return $this->belongsTo('App\Http\Model\Household','household_id','id')->withDefault();
    }

    public function householdbuilding(){
        return $this->belongsTo('App\Http\Model\Householdbuilding','household_building_id','id')->withDefault();
    }
}