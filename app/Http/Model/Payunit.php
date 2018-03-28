<?php
/*
|--------------------------------------------------------------------------
| 兑付 - 公房单位 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payunit extends Model
{
    use SoftDeletes;
    protected $table='pay_unit';
    protected $primaryKey='id';
    protected $fillable=['state'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'household_id'=>'被征收户',
        'land_id'=>'地块',
        'unit_id'=>'公房单位',
        'pay_id'=>'兑付汇总',
        'pact_id'=>'公房单位补偿协议',
        'total_id'=>'支付总单',
        'calculate'=>'计算公式',
        'amount'=>'补偿金额',
        'portion'=>'公房单位补偿比例',
        'total'=>'公房单位补偿金额',
        'state'=>'状态',
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
    public function household(){
        return $this->belongsTo('App\Http\Model\Household','household_id','id')->withDefault();
    }
    public function adminunit(){
        return $this->belongsTo('App\Http\Model\Adminunit','unit_id','id')->withDefault();
    }
    public function pay(){
        return $this->belongsTo('App\Http\Model\Pay','pay_id','id')->withDefault();
    }
    public function unitpact(){
        return $this->belongsTo('App\Http\Model\Payunitpact','pact_id','id')->withDefault();
    }
    public function fundstotal(){
        return $this->belongsTo('App\Http\Model\Fundstotal','total_id','id')->withDefault();
    }
    public function state(){
        return $this->belongsTo('App\Http\Model\Statecode','code','code')->withDefault();
    }
}