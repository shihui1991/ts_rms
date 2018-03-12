<?php
/*
|--------------------------------------------------------------------------
| 项目-签约奖励 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Itemreward  extends Model
{
    use SoftDeletes;
    protected $table='item_reward';
    protected $primaryKey='id';
    protected $fillable=['start_at','end_at','price','portion'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'start_at'=>'开始日期',
        'end_at'=>'截止日期',
        'price'=>'奖励单价',
        'portion'=>'奖励比例',
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
}