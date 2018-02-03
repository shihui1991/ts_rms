<?php
/*
|--------------------------------------------------------------------------
| 权限与角色-权限菜单模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rolemenu extends Model
{
    protected $table='role_menu';
    protected $primaryKey='';
    protected $guarded=[];
    protected $dates=['created_at','updated_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'role_id'=>'角色',
        'menu_id'=>'菜单',
    ];


    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 关联角色 ++++++++++ */
    public function role(){
        return $this->belongsTo('App\Http\Model\Role','role_id','id')->withDefault();
    }

    /* ++++++++++ 关联菜单 ++++++++++ */
    public function menu(){
        return $this->belongsTo('App\Http\Model\Menu','menu_id','id')->withDefault();
    }

}