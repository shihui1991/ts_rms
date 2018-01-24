<?php
/*
|--------------------------------------------------------------------------
| 组织与部门模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dept extends Model
{
    use SoftDeletes;

    protected $table='dept';
    protected $primaryKey='id';
    protected $guarded=[];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [

    ];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'parent_id'=>'上级部门',
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
        $array=[0=>'直属',1=>'从属'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }

    /* ++++++++++ 设置其他数据 ++++++++++ */
    public function setOther($request){

    }

    /* ++++++++++ 父级关联 ++++++++++ */
    public function father(){
        return $this->belongsTo('App\Http\Model\Dept','parent_id','id')->withDefault();
    }

    /* ++++++++++ 子级关联 ++++++++++ */
    public function childs(){
        return $this->hasMany('App\Http\Model\Dept','parent_id','id');
    }
}