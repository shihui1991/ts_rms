<?php
/*
|--------------------------------------------------------------------------
| 房源管理机构 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Housecompany extends Model
{
    use SoftDeletes;
    protected $table='house_company';
    protected $primaryKey='id';
    protected $fillable=['name','address','phone','contact_man','contact_tel','infos'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'name'=>'房源管理机构名称',
        'address'=>'地址',
        'phone'=>'电话',
        'contact_man'=>'联系人',
        'contact_tel'=>'联系电话',
        'infos'=>'描述'
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }
}