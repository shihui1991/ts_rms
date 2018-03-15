<?php
/*
|--------------------------------------------------------------------------
| 项目-产权争议解决 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Householdbuildingdeal extends Model
{
    use SoftDeletes;
    protected $table='item_household_building_deal';
    protected $primaryKey='id';
    protected $fillable=['way','price','amount','picture'];
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
        'household_building_id'=>'建筑',
        'way'=>'处理方式',
        'price'=>'单价',
        'amount'=>'总价',
        'code'=>'状态代码',
        'picture'=>'解决结果'
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){
        $this->attributes['household_id'] = $request->input('household_id');
        $this->attributes['land_id'] = $request->input('land_id');
        $this->attributes['building_id'] = $request->input('building_id');
        $this->attributes['household_building_id'] = $request->input('household_building_id');
    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 获取处理方式 ++++++++++ */
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
    /* ++++++++++ 关联楼栋 ++++++++++ */
    public function householdbuilding(){
        return $this->hasOne('App\Http\Model\Householdbuilding','household_building_id','id')->withDefault();
    }

}