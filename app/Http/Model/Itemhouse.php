<?php
/*
|--------------------------------------------------------------------------
| 项目-冻结房源 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Itemhouse extends Model
{
    use SoftDeletes;
    protected $table='item_house';
    protected $fillable=['house_id','type'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'house_id'=>'房源',
        'type'=>'添加时期'
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 获取添加时期状态 ++++++++++ */
    public function getTypeAttribute($key=null)
    {
        $array=[0=>'项目准备',1=>'项目实施'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }



    /* ++++++++++ 关联项目 ++++++++++ */
    public function item(){
        return $this->belongsTo('App\Http\Model\Item','item_id','id')->withDefault();
    }
    /* ++++++++++ 关联房源 ++++++++++ */
    public function house(){
        return $this->belongsTo('App\Http\Model\House','house_id','id')->withDefault();
    }

}