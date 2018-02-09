<?php
/*
|--------------------------------------------------------------------------
| 项目-自选社会风险评估调查话题 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Itemtopic extends Model
{
    use SoftDeletes;
    protected $table='item_topic';
    protected $primaryKey='id';
    protected $fillable=['topic_id'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'topic_id'=>'话题'
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){
        $this->attributes['item_id'] = $request->input('item_id');
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

}