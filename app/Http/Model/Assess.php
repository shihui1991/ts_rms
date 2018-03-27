<?php
/*
|--------------------------------------------------------------------------
| 评估-汇总 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assess extends Model
{
    use SoftDeletes;
    protected $table='com_assess';
    protected $primaryKey='id';
    protected $fillable=[];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'household_id'=>'被征收户',
        'land_id'=>'地块',
        'building_id'=>'楼栋',
        'assets'=>'资产评估总价',
        'estate'=>'房产评估总价',
        'code'=>'状态'
    ];


    public function state(){
        return $this->belongsTo('App\Http\Model\Statecode','code','code')->withDefault();
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

    public function estates(){
        return $this->hasMany('App\Http\Model\Estate','assess_id','id');
    }

    public function estate(){
        return $this->hasOne('App\Http\Model\Estate','assess_id','id')->withDefault();
    }

    public function assetses(){
        return $this->hasMany('App\Http\Model\Assets','assess_id','id');
    }

    public function assets(){
        return $this->hasOne('App\Http\Model\Assets','assess_id','id')->withDefault();
    }
}