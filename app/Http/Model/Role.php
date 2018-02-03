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
    protected $guarded=['id','parent_id'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'parent_id'=>'上级角色',
        'name'=>'名称',
        'type'=>'类型',
        'infos'=>'描述'
    ];

    /* ++++++++++ 名称去空 ++++++++++ */
    public function setNameAttribute($value)
    {
        $this->attributes['name']=trim($value);
    }
    /* ++++++++++ 获取类型 ++++++++++ */
    public function getTypeAttribute($key=null)
    {
        $array=[0=>'普通',1=>'管理员'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){
        $this->attributes['parent_id']=$request->input('parent_id');
    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

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