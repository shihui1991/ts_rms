<?php
/*
|--------------------------------------------------------------------------
| 产权调换 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Houseresettle extends Model
{
    use SoftDeletes;
    protected $table='house_resettle';
    protected $primaryKey='id';
    protected $fillable=['settle_at','hold_at','end_at','register','picture'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [
        'picture'=>'array',
    ];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'household_id'=>'被征收户',
        'land_id'=>'地块',
        'building_id'=>'楼栋',
        'house_id'=>'房源',
        'pay_id'=>'兑付',
        'settle_at'=>'安置日期',
        'hold_at'=>'产权调换日期',
        'end_at'=>'结束日期',
        'register'=>'新证件号',
        'picture'=>'证件',
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

}