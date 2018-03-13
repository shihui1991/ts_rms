<?php
/*
|--------------------------------------------------------------------------
| 项目-地块户型 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Landlayout extends Model
{
    use SoftDeletes;
    protected $table='item_land_layout';
    protected $primaryKey='id';
    protected $fillable=['name','area','gov_img','com_img','picture'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [
        'gov_img'=>'array',
        'com_img'=>'array',
        'picture'=>'array',
    ];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'land_id'=>'地块',
        'name'=>'名称',
        'area'=>'面积',
        'gov_img'=>'户型图',
        'com_img'=>'户型图',
        'picture'=>'测绘报告'
    ];


    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){
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

}