<?php
/*
|--------------------------------------------------------------------------
| 项目资金-支出总单 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fundstotal extends Model
{
    use SoftDeletes;
    protected $table='item_funds_total';
    protected $primaryKey='id';
    protected $fillable=[];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'type'=>'兑付对象',
        'val_id'=>'兑付对象ID',
        'cate_id'=>'进出类型',
        'amount'=>'金额',
        'state'=>'状态',
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

    public function fundscate(){
        return $this->belongsTo('App\Http\Model\Fundscate','cate_id','id')->withDefault();
    }
}