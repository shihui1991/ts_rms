<?php
/*
|--------------------------------------------------------------------------
| 项目-地块 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Itemland extends Model
{
    use SoftDeletes;
    protected $table='item_land';
    protected $primaryKey='id';
    protected $fillable=['address','land_prop_id','land_source_id','land_state_id','admin_unit_id','area','infos','picture'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [
        'picture'=>'array'
    ];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'address'=>'地址',
        'land_prop_id'=>'土地性质',
        'land_source_id'=>'土地来源',
        'land_state_id'=>'土地权益状况',
        'admin_unit_id'=>'所属单位',
        'area'=>'占地面积',
        'infos'=>'备注',
        'picture'=>'图片'
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
    /* ++++++++++ 关联土地性质 ++++++++++ */
    public function landprop(){
        return $this->belongsTo('App\Http\Model\Landprop','land_prop_id','id')->withDefault();
    }
    /* ++++++++++ 关联土地来源 ++++++++++ */
    public function landsource(){
        return $this->belongsTo('App\Http\Model\Landsource','land_source_id','id')->withDefault();
    }
    /* ++++++++++ 关联土地权益状况 ++++++++++ */
    public function landstate(){
        return $this->belongsTo('App\Http\Model\Landstate','land_state_id','id')->withDefault();
    }
    /* ++++++++++ 关联公产单位 ++++++++++ */
    public function adminunit(){
        return $this->belongsTo('App\Http\Model\Adminunit','admin_unit_id','id')->withDefault();
    }
}