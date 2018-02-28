<?php
/*
|--------------------------------------------------------------------------
| 初步预算 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Initbudget extends Model
{
    use SoftDeletes;
    protected $table='item_init_budget';
    protected $primaryKey='id';
    protected $fillable=['holder','money','house','picture'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [
        'picture'=>'array',
    ];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'holder'=>'预计户数',
        'money'=>'预算总金额',
        'house'=>'预备房源数',
        'picture'=>'预算报告',
    ];
    
    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }
}