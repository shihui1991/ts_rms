<?php
/*
|--------------------------------------------------------------------------
| 用户模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;
    protected $table='user';
    protected $primaryKey='id';
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [

    ];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'dept_id'=>'部门ID',
        'role_id'=>'角色ID',
        'username'=>'用户',
        'password'=>'登陆密码',
        'secret'=>'用户密钥',
        'name'=>'姓名',
        'phone'=>'电话',
        'email'=>'邮箱',
        'infos'=>'说明',
        'login_at'=>'最近登陆时间',
        'login_ip'=>'最近登陆IP',
        'session'=>'最近登陆session'
    ];

    /* ++++++++++ 名称去空 ++++++++++ */
    public function setNameAttribute($value)
    {
        $this->attributes['name']=trim($value);
    }

    /* ++++++++++ 设置其他数据 ++++++++++ */
    public function setOther($request){

    }

    /* ++++++++++ 组织与部门关联 ++++++++++ */
    public function dept(){
        return $this->belongsTo('App\Http\Model\Dept','dept_id','id')->withDefault();
    }

    /* ++++++++++ 角色与权限关联 ++++++++++ */
    public function role(){
        return $this->belongsTo('App\Http\Model\Role','role_id','id')->withDefault();
    }

    /* ++++++++++ 父级关联 ++++++++++ */
    public function father(){
        return $this->belongsTo('App\Http\Model\User','parent_id','id')->withDefault();
    }

    /* ++++++++++ 子级关联 ++++++++++ */
    public function childs(){
        return $this->hasMany('App\Http\Model\User','parent_id','id');
    }
}