<?php
/*
|--------------------------------------------------------------------------
| 兑付 - 特殊人群 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paycrowd extends Model
{
    use SoftDeletes;
    protected $table='pay_crowd';

    protected $fillable=[];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'household_id'=>'被征收户',
        'land_id'=>'地块',
        'building_id'=>'楼栋',
        'pay_id'=>'兑付汇总',
        'item_subject_id'=>'项目补偿科目',
        'subject_id'=>'补偿科目',
        'item_crowd_id'=>'项目特殊人群',
        'member_crowd_id'=>'被征收户特殊人群',
        'crowd_cate_id'=>'特殊人群分类',
        'crowd_id'=>'特殊人群',
        'transit'=>'临时安置费',
        'rate'=>'上浮比例',
        'amount'=>'上浮总额',
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
    public function pay(){
        return $this->belongsTo('App\Http\Model\Pay','pay_id','id')->withDefault();
    }
    public function itemsubject(){
        return $this->belongsTo('App\Http\Model\Itemsubject','item_subject_id','id')->withDefault();
    }
    public function subject(){
        return $this->belongsTo('App\Http\Model\Subject','subject_id','id')->withDefault();
    }
    public function itemcrowd(){
        return $this->belongsTo('App\Http\Model\Itemcrowd','item_crowd_id','id')->withDefault();
    }
    public function membercrowd(){
        return $this->belongsTo('App\Http\Model\Householdmembercrowd','member_crowd_id','id')->withDefault();
    }
    public function crowdcate(){
        return $this->belongsTo('App\Http\Model\Crowd','crowd_cate_id','id')->withDefault();
    }
    public function crowd(){
        return $this->belongsTo('App\Http\Model\Crowd','crowd_id','id')->withDefault();
    }
}