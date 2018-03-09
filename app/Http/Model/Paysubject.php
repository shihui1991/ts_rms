<?php
/*
|--------------------------------------------------------------------------
| 兑付 - 补偿科目 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paysubject extends Model
{
    use SoftDeletes;
    protected $table='pay_subject';
    protected $primaryKey='id';
    protected $fillable=['subject_id','calculate','amount',];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'household_id'=>'被征收户',
        'land_id'=>'地块',
        'building_id'=>'楼栋',
        'pay_id'=>'兑付汇总',
        'pact_id'=>'兑付协议',
        'subject_id'=>'补偿科目',
        'total_id'=>'兑付总单',
        'calculate'=>'计算公式',
        'amount'=>'补偿小计',
        'state'=>'状态',
    ];

    public function getStateAttribute($key=null){
        $array=[0=>'未兑付',1=>'签约',2=>'兑付中',3=>'已兑付'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }

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
    public function pay(){
        return $this->belongsTo('App\Http\Model\Pay','pay_id','id')->withDefault();
    }
    public function pact(){
        return $this->belongsTo('App\Http\Model\Pact','pact_id','id')->withDefault();
    }
    public function subject(){
        return $this->belongsTo('App\Http\Model\Subject','subject_id','id')->withDefault();
    }
    public function fundstotal(){
        return $this->belongsTo('App\Http\Model\Fundstotal','total_id','id')->withDefault();
    }
}