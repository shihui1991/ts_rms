<?php
/*
|--------------------------------------------------------------------------
| 项目 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;
    protected $table='item';
    protected $primaryKey='id';
    protected $fillable=['name','place','map','infos','picture'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [
        'picture'=>'array',
    ];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'name'=>'项目名称',
        'place'=>'征收范围',
        'map'=>'征收范围红线地图',
        'infos'=>'描述',
        'picture'=>'审查资料',
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 项目状态 ++++++++++ */
    public function state(){
        return $this->belongsTo('App\Http\Model\Statecode','code','code')->withDefault();
    }

    /* ++++++++++ 项目负责人 ++++++++++ */
    public function itemadmins(){
        return $this->belongsToMany('App\Http\Model\User','item_admin','item_id','user_id');
    }

    /* ++++++++++ 被征收户 ++++++++++ */
    public function households(){
        return $this->hasMany('App\Http\Model\Household','item_id','id');
    }
}