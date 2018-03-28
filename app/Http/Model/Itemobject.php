<?php
/*
|--------------------------------------------------------------------------
| 项目-其他补偿事项单价 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Itemobject extends Model
{
    use SoftDeletes;
    protected $table='item_object';
    protected $primaryKey='id';
    protected $fillable=['object_id','price'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'object_id'=>'其他补偿事项',
        'price'=>'单价'
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
    /* ++++++++++ 关联其他补偿事项 ++++++++++ */
    public function object(){
        return $this->belongsTo('App\Http\Model\Objects','object_id','id')->withDefault();
    }

}