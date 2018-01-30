<?php
/*
|--------------------------------------------------------------------------
| 房源社区户型图 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Houselayoutimg extends Model
{
    use SoftDeletes;

    protected $table='house_layout_img';
    protected $primaryKey='id';
    protected $guarded=[];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [

    ];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'name'=>'户型图名称',
        'picture'=>'户型图'
    ];

    /* ++++++++++ 名称去空 ++++++++++ */
    public function setNameAttribute($value)
    {
        $this->attributes['name']=trim($value);
    }

    /* ++++++++++ 设置其他数据 ++++++++++ */
    public function setOther($request){

    }

    /* ++++++++++ 关联房源社区 ++++++++++ */
    public function housecommunity(){
        return $this->belongsTo('App\Http\Model\Housecommunity','community_id','id')->withDefault();
    }

    /* ++++++++++ 关联房屋户型 ++++++++++ */
    public function layout(){
        return $this->belongsTo('App\Http\Model\Layout','layout_id','id')->withDefault();
    }
}