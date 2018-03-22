<?php
/*
|--------------------------------------------------------------------------
| 临时周转 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Housetransit extends Model
{
    use SoftDeletes;
    protected $table='house_transit';
    protected $primaryKey='id';
    protected $fillable=['start_at','exp_end','end_at'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'household_id'=>'被征收户',
        'land_id'=>'地块',
        'building_id'=>'楼栋',
        'house_id'=>'房源',
        'pay_id'=>'兑付',
        'pact_id'=>'协议',
        'start_at'=>'开始日期',
        'exp_end'=>'预计结束日期',
        'end_at'=>'结束日期',
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
    public function house(){
        return $this->belongsTo('App\Http\Model\House','house_id','id')->withDefault();
    }
    public function pay(){
        return $this->belongsTo('App\Http\Model\Pay','pay_id','id')->withDefault();
    }
    public function pact(){
        return $this->belongsTo('App\Http\Model\Pact','pact_id','id')->withDefault();
    }

}