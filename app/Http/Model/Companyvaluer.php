<?php
/*
|--------------------------------------------------------------------------
| 评估机构-评估师 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Companyvaluer extends Model
{
    use SoftDeletes;

    protected $table='company_valuer';
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
        'register'=>'注册号',
        'valid_at'=>'有效期'
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