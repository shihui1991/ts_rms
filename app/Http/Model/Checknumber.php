<?php
/*
|--------------------------------------------------------------------------
| 审查流程限制同级角色执行人数 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checknumber extends Model
{
    use SoftDeletes;

    protected $table='check_number';
    protected $primaryKey='id';
    protected $guarded=[];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [

    ];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'process_id'=>'流程',
        'menu_id'=>'菜单'
    ];

    /* ++++++++++ 设置其他数据 ++++++++++ */
    public function setOther($request){

    }
}