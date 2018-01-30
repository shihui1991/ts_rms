<?php
/*
|--------------------------------------------------------------------------
| 房源-购置管理费单价 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Housemanageprice extends Model
{
    use SoftDeletes;

    protected $table='house_manage_price';
    protected $primaryKey='id';
    protected $guarded=[];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [

    ];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'house_id'=>'所属房源',
        'start_at'=>'起始时间',
        'end_at'=>'结束时间',
        'manage_price'=>'房源每月管理费单价（元/月）'
    ];

    /* ++++++++++ 设置其他数据 ++++++++++ */
    public function setOther($request){

    }

    /* ++++++++++ 关联房源 ++++++++++ */
    public function house(){
        return $this->belongsTo('App\Http\Model\House','house_id','id')->withDefault();
    }
}