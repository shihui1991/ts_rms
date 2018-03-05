<?php
/*
|--------------------------------------------------------------------------
| 项目-选定评估机构 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Itemcrowd extends Model
{
    use SoftDeletes;
    protected $table='item_crowd';
    protected $primaryKey='id';
    protected $fillable=['crowd_id','rate'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'crowd_cate_id'=>'特殊人群分类',
        'crowd_id'=>'特殊人群',
        'rate'=>'上浮率'
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }


    /* ++++++++++ 项目 ++++++++++ */
    public function item(){
        return $this->belongsTo('App\Http\Model\item','item_id','id')->withDefault();
    }

    /* ++++++++++ 关联总类 ++++++++++ */
    public function cate(){
        return $this->belongsTo('App\Http\Model\Crowd','crowd_cate_id','id')->withDefault();
    }

    /* ++++++++++ 关联二级分类 ++++++++++ */
    public function crowd(){
        return $this->belongsTo('App\Http\Model\Crowd','crowd_id','id')->withDefault();
    }

}