<?php
/*
|--------------------------------------------------------------------------
| 兑付协议 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pact extends Model
{
    use SoftDeletes;
    protected $table='pact';
    protected $primaryKey='id';
    protected $fillable=['content','sign_at','sign','state'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'household_id'=>'被征收户',
        'land_id'=>'地块',
        'building_id'=>'楼栋',
        'pay_id'=>'兑付汇总',
        'cate_id'=>'协议分类',
        'content'=>'协议内容',
        'sign_at'=>'签约时间',
        'sign'=>'签字',
        'code'=>'状态代码',
        'status'=>'有效状态',
    ];


    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    public function getStatusAttribute($key=null)
    {
        $array=[0=>'未生效',1=>'生效',2=>'失效'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
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
    public function pay(){
        return $this->belongsTo('App\Http\Model\Pay','pay_id','id')->withDefault();
    }
    public function pactcate(){
        return $this->belongsTo('App\Http\Model\Pactcate','cate_id','id')->withDefault();
    }
    public function state(){
        return $this->belongsTo('App\Http\Model\Statecode','code','code')->withDefault();
    }

    public function paysubjects(){
        return $this->hasMany('App\Http\Model\Paysubject','pact_id','id');
    }
}