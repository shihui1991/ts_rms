<?php
/*
|--------------------------------------------------------------------------
| 项目-被征收户-房屋建筑 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Householdbuilding extends Model
{
    use SoftDeletes;
    protected $table='item_household_building';
    protected $primaryKey='id';
    protected $fillable=['name','code','reg_inner','reg_outer','balcony', 'real_inner','real_outer','def_use','real_use',
        'struct_id','direct','floor','build_year','layout_id','picture'];
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
        'code'=>'状态',
        'name'=>'名称',
        'reg_inner'=>'登记套内面积',
        'reg_outer'=>'登记建筑面积',
        'balcony'=>'其中阳台面积',
        'real_inner'=>'实际套内面积',
        'real_outer'=>'实际建筑面积',
        'def_use'=>'批准用途',
        'real_use'=>'实际用途',
        'struct_id'=>'结构类型',
        'direct'=>'朝向',
        'floor'=>'楼层',
        'build_year'=>'建造年份',
        'layout_id'=>'地块户型',
        'picture'=>'图片'
    ];
    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){
        $this->attributes['land_id'] = $request->input('land_id');
        $this->attributes['building_id'] = $request->input('building_id');
        $this->attributes['household_id'] = $request->input('household_id');
    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }


    /* ++++++++++ 关联状态 ++++++++++ */
    public function state(){
        return $this->belongsTo('App\Http\Model\Statecode','code','code')->withDefault();
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

    /* ++++++++++ 关联建筑结构类型 ++++++++++ */
    public function buildingstruct(){
        return $this->belongsTo('App\Http\Model\Buildingstruct','struct_id','id')->withDefault();
    }

    /* ++++++++++ 关联建筑批准用途 ++++++++++ */
    public function buildinguse(){
        return $this->belongsTo('App\Http\Model\Buildinguse','def_use','id')->withDefault();
    }
    /* ++++++++++ 关联建筑实际用途 ++++++++++ */
    public function buildinguses(){
        return $this->belongsTo('App\Http\Model\Buildinguse','real_use','id')->withDefault();
    }
    /* ++++++++++ 违建处理 ++++++++++ */
    public function buildingdeal(){
        return $this->hasOne('App\Http\Model\Buildinguse','real_use','id')->withDefault();
    }
    /* ++++++++++ 关联地块户型 ++++++++++ */
    public function landlayout(){
        return $this->belongsTo('App\Http\Model\Landlayout','layout_id','id')->withDefault();
    }

    /* ++++++++++ 关联评估-房产建筑 ++++++++++ */
    public function estatebuilding(){
        return $this->hasOne('App\Http\Model\Estatebuilding','household_building_id','id')->withDefault();
    }
}