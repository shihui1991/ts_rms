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
    protected $fillable=['username','name','phone','email','infos'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'dept_id'=>'所在部门',
        'role_id'=>'所属角色',
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

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){
        $this->attributes['dept_id']=$request->input('dept_id');
        $this->attributes['role_id']=$request->input('role_id');
        $this->attributes['password']=encrypt($request->input('password'));
        $this->attributes['secret']=$this->get_secret();
    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 组织与部门关联 ++++++++++ */
    public function dept(){
        return $this->belongsTo('App\Http\Model\Dept','dept_id','id')->withDefault();
    }

    /* ++++++++++ 角色与权限关联 ++++++++++ */
    public function role(){
        return $this->belongsTo('App\Http\Model\Role','role_id','id')->withDefault();
    }

    /* ++++++++++ 生成密钥 ++++++++++ */
    public function get_secret(){
        $secret=create_guid();
        $res=self::withTrashed()->where('secret',$secret)->count();
        if($res){
            self::get_secret();
        }

        return $secret;
    }

}