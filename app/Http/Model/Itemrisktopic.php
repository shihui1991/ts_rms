<?php
/*
|--------------------------------------------------------------------------
| 被征户-用户自选调查话题 模型
|--------------------------------------------------------------------------
*/
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/29
 * Time: 11:07
 */
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Itemrisktopic extends Model{
    use SoftDeletes;
    protected $table='item_risk_topic';
    protected $fillable=['item_id','topic_id','answer','risk_id'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'topic_id'=>'话题',
        'answer'=>'意见',
        'risk_id'=>'调查报告'
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
    /* ++++++++++ 关联话题 ++++++++++ */
    public function topic(){
        return $this->belongsTo('App\Http\Model\Topic','topic_id','id')->withDefault();
    }
    /* ++++++++++ 关联调查 ++++++++++ */
    public function risk(){
        return $this->belongsTo('App\Http\Model\Itemrisk','risk_id','id')->withDefault();
    }

}