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
    protected $fillable=['community_id','layout_id','name','picture'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [
        'picture'=>'array'
    ];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'community_id'=>'房源社区',
        'layout_id'=>'户型',
        'name'=>'户型图名称',
        'picture'=>'户型图'
    ];

    /* ++++++++++ 名称去空 ++++++++++ */
    public function setNameAttribute($value)
    {
        $this->attributes['name']=trim($value);
    }

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

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