<?php
/*
|--------------------------------------------------------------------------
| 项目-地块楼栋 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Itembuilding extends Model
{
    use SoftDeletes;
    protected $table='item_building';
    protected $primaryKey='id';
    protected $fillable=['building','total_floor','area','build_year','struct_id','infos','picture'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [
        'picture'=>'array'
    ];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'land_id'=>'地块地址',
        'building'=>'楼栋号',
        'total_floor'=>'总楼层',
        'area'=>'占地面积',
        'build_year'=>'建造年份',
        'struct_id'=>'结构类型',
        'infos'=>'描述',
        'picture'=>'图片'
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){
        $this->attributes['item_id'] = $request->input('item_id');
        $this->attributes['land_id'] = $request->input('land_id');
    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 关联项目 ++++++++++ */
    public function item(){
        return $this->belongsTo('App\Http\Model\Item','item_id','id')->withDefault();
    }
    /* ++++++++++ 关联地块 ++++++++++ */
    public function itemland(){
        return $this->belongsTo('App\Http\Model\Itemland','land_id','id')->withDefault();
    }
    /* ++++++++++ 关联结构类型++++++++++ */
    public function buildingstruct(){
        return $this->belongsTo('App\Http\Model\Buildingstruct','struct_id','id')->withDefault();
    }
}