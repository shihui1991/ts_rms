<?php
/*
|--------------------------------------------------------------------------
| 项目-时间规划 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Itemtime extends Model
{
    use SoftDeletes;
    protected $table='item_time';
    protected $primaryKey='id';
    protected $fillable=['start_at','end_at'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [

    ];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'schedule_id'=>'项目进度',
        'start_at'=>'开始时间',
        'end_at'=>'结束时间',
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }

    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    public function item(){
        return $this->belongsTo('App\Http\Model\Item','item_id','id')->withDefault();
    }

    public function schedule(){
        return $this->belongsTo('App\Http\Model\Schedule','schedule_id','id')->withDefault();
    }
}