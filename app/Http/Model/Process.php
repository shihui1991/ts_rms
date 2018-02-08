<?php
/*
|--------------------------------------------------------------------------
| 项目流程模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $table='a_process';
    protected $primaryKey='id';
    protected $fillable=['schedule_id','name','type','menu_id','sort','infos'];
    protected $dates=['created_at','updated_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'schedule_id'=>'项目进度',
        'parent_id'=>'上级',
        'name'=>'名称',
        'type'=>'操作类型',
        'menu_id'=>'菜单',
        'sort'=>'排序',
        'infos'=>'描述'
    ];


    /* ++++++++++ 获取操作类型 ++++++++++ */
    public function getAuthAttribute($key=null)
    {
        $array=[1=>'数据',2=>'审查'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 关联项目进度 ++++++++++ */
    public function schedule(){
        return $this->belongsTo('App\Http\Model\Schedule','schedule_id','id')->withDefault();
    }

    /* ++++++++++ 父级 ++++++++++ */
    public function father(){
        return $this->belongsTo('App\Http\Model\Process','parent_id','id')->withDefault();
    }

    /* ++++++++++ 下级 ++++++++++ */
    public function childs(){
        return $this->hasMany('App\Http\Model\Process','parent_id','id');
    }

    /* ++++++++++ 关联菜单 ++++++++++ */
    public function menu(){
        return $this->belongsTo('App\Http\Model\Menu','menu_id','id')->withDefault();
    }

}