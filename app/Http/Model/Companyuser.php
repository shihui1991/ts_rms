<?php
/*
|--------------------------------------------------------------------------
| 评估机构-操作员 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Companyuser extends Model
{
    use SoftDeletes;
    protected $table='company_user';
    protected $primaryKey='id';
    protected $fillable=['company_id','name','phone','username','password'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'company_id'=>'评估机构',
        'name'=>'名称',
        'phone'=>'电话',
        'username'=>'用户名',
        'password'=>'密码',
        'secret'=>'密钥',
        'session'=>'登录sessionID',
        'action_at'=>'最近操作时间'
    ];
    /* ++++++++++ 名称去空 ++++++++++ */
    public function setNameAttribute($value)
    {
        $this->attributes['name']=trim($value);
    }

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){
        $this->attributes['secret']=$this->get_secret();
    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 关联评估机构 ++++++++++ */
    public function company(){
        return $this->belongsTo('App\Http\Model\Company','company_id','id')->withDefault();
    }

    /* ++++++++++ 密钥 ++++++++++ */
    public function get_secret(){
        $secret=create_guid();
        $res=self::withTrashed()->where('secret',$secret)->count();
        if($res){
            self::get_secret();
        }
        return $secret;
    }
}