<?php
/*
|--------------------------------------------------------------------------
| 项目进度模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;
    protected $table='a_schedule';
    protected $primaryKey='id';
    protected $fillable=['name','sort','infos'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'name'=>'名称',
        'sort'=>'排序',
        'infos'=>'描述'
    ];

    public function setSortAttribute($value){
        $this->attributes['sort']=is_null($value)?0:(integer)$value;
    }

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 关联项目流程 ++++++++++ */
    public function processes(){
        return $this->hasMany('App\Http\Model\Process','schedule_id','id');
    }

    /* ++++++++++ 关联项目时间规划 ++++++++++ */
    public function itemtime(){
        return $this->hasOne('App\Http\Model\Itemtime','schedule_id','id');
    }

    /* ++++++++++ 关联项目流程工作提醒 ++++++++++ */
    public function worknotices(){
        return $this->hasMany('App\Http\Model\Worknotice','schedule_id','id');
    }
}