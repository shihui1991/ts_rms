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
    protected $guarded=[];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [

    ];
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

    /* ++++++++++ 设置其他数据 ++++++++++ */
    public function setOther($request){

    }
}