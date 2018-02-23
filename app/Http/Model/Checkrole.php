<?php
/*
|--------------------------------------------------------------------------
|  项目审查执行角色 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checkrole extends Model
{
    use SoftDeletes;
    protected $table='check_role';
    protected $fillable=['role_id'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'process_id'=>'项目流程',
        'menu_id'=>'功能菜单',
        'dept_id'=>'部门',
        'parent_id'=>'上级角色',
        'role_id'=>'角色',
    ];
    
    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }


    public function checkroleusers(){
        return $this->hasMany('App\Http\Model\User','role_id','role_id');
    }
}