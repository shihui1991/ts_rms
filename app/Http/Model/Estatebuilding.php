<?php
/*
|--------------------------------------------------------------------------
| 评估-房产-房屋建筑 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estatebuilding extends Model
{
    use SoftDeletes;
    protected $table='com_estate_building';
    protected $primaryKey='id';
    protected $fillable=['real_outer','real_use','struct_id','direct','floor','layout_img','picture','price'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [
        'picture'=>'array',
    ];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'company_id'=>'评估公司',
        'assess_id'=>'评估',
        'estate_id'=>'房产评估',
        'household_id'=>'被征收户',
        'household_building_id'=>'被征收户-房屋建筑',
        'land_id'=>'地块',
        'building_id'=>'楼栋',
        'real_outer'=>'实际建筑面积',
        'real_use'=>'实际用途',
        'struct_id'=>'结构类型',
        'direct'=>'朝向',
        'floor'=>'楼层',
        'layout_img'=>'户型图',
        'picture'=>'图片',
        'price'=>'评估单价',
        'amount'=>'评估总价'
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){
    }

    public function item(){
        return $this->belongsTo('App\Http\Model\Item','item_id','id')->withDefault();
    }

    public function company(){
        return $this->belongsTo('App\Http\Model\Company','company_id','id')->withDefault();
    }

    public function assess(){
        return $this->belongsTo('App\Http\Model\Assess','assess_id','id')->withDefault();
    }

    public function estate(){
        return $this->belongsTo('App\Http\Model\Estate','estate_id','id')->withDefault();
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

    public function householdbuilding(){
        return $this->belongsTo('App\Http\Model\Householdbuilding','household_building_id','id')->withDefault();
    }

    public function realuse(){
        return $this->belongsTo('App\Http\Model\Buildinguse','real_use','id')->withDefault();
    }

    public function buildingstruct(){
        return $this->belongsTo('App\Http\Model\Buildingstruct','struct_id','id')->withDefault();
    }
}