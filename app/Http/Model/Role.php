<?php
/*
|--------------------------------------------------------------------------
| 权限与角色模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $table='role';
    protected $primaryKey='id';
    protected $guarded=[];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [

    ];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'parent_id'=>'上级角色',
        'name'=>'名称',
        'dept_id'=>'所属部门',
        'admin'=>'管理员',
        'infos'=>'描述'
    ];

    /* ++++++++++ 名称去空 ++++++++++ */
    public function setNameAttribute($value)
    {
        $this->attributes['name']=trim($value);
    }
    /* ++++++++++ 获取是否管理员 ++++++++++ */
    public function getAdminAttribute($key=null)
    {
        $array=[0=>'否',1=>'是'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }

    /* ++++++++++ 设置其他数据 ++++++++++ */
    public function setOther($key='0'){
        if(is_numeric($key)){
            return $key;
        }else{
            return $key;
        }
    }

    /* ++++++++++ 部门关联 ++++++++++ */
    public function dept(){
        return $this->belongsTo('App\Http\Model\Dept','dept_id','id')->withDefault();
    }

    /* ++++++++++ 父级关联 ++++++++++ */
    public function father(){
        return $this->belongsTo('App\Http\Model\Role','parent_id','id')->withDefault();
    }

    /* ++++++++++ 子级关联 ++++++++++ */
    public function childs(){
        return $this->hasMany('App\Http\Model\Role','parent_id','id');
    }
}