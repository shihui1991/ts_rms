<?php
/*
|--------------------------------------------------------------------------
| 兑付 - 房屋建筑 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paybuilding extends Model
{
    use SoftDeletes;
    protected $table='pay_building';
    protected $primaryKey='id';
    protected $fillable=['price',];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'household_id'=>'被征收户',
        'land_id'=>'地块',
        'building_id'=>'楼栋',
        'assess_id'=>'评估汇总',
        'estate_id'=>'房产评估',
        'household_building_id'=>'房屋建筑',
        'pay_id'=>'兑付汇总',
        'register'=>'是否登记',
        'state'=>'状态',
        'real_outer'=>'实际面积',
        'real_use'=>'实际用途',
        'struct_id'=>'建筑结构',
        'direct'=>'建筑朝向',
        'floor'=>'所在楼层',
        'price'=>'补偿单价',
        'amount'=>'补偿总价',
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

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
    public function household(){
        return $this->belongsTo('App\Http\Model\Household','household_id','id')->withDefault();
    }
    public function assess(){
        return $this->belongsTo('App\Http\Model\Assess','assess_id','id')->withDefault();
    }
    public function estate(){
        return $this->belongsTo('App\Http\Model\Estate','estate_id','id')->withDefault();
    }
    public function householdbuilding(){
        return $this->belongsTo('App\Http\Model\Householdbuilding','household_building_id','id')->withDefault();
    }
    public function pay(){
        return $this->belongsTo('App\Http\Model\Pay','pay_id','id')->withDefault();
    }
    public function realuse(){
        return $this->belongsTo('App\Http\Model\Buildinguse','real_use','id')->withDefault();
    }
    public function buildingstruct(){
        return $this->belongsTo('App\Http\Model\Buildingstruct','struct_id','id')->withDefault();
    }
}