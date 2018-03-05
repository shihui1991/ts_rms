<?php
/*
|--------------------------------------------------------------------------
| 兑付 - 其他补偿事项 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payobject extends Model
{
    use SoftDeletes;
    protected $table='pay_object';
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
        'household_obj_id'=>'被征收户-其他补偿事项',
        'item_object_id'=>'项目其他补偿事项',
        'object_id'=>'其他补偿事项',
        'pay_id'=>'兑付汇总',
        'name'=>'名称',
        'num_unit'=>'计量单位',
        'number'=>'数量',
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
    public function householdobject(){
        return $this->belongsTo('App\Http\Model\Householdobject','household_obj_id','id')->withDefault();
    }
    public function itemobject(){
        return $this->belongsTo('App\Http\Model\Itemobject','item_object_id','id')->withDefault();
    }
    public function object(){
        return $this->belongsTo('App\Http\Model\Object','object_id','id')->withDefault();
    }
    public function pay(){
        return $this->belongsTo('App\Http\Model\Pay','pay_id','id')->withDefault();
    }
}