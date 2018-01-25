<?php
/*
|--------------------------------------------------------------------------
| 项目流程-功能菜单模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Processmenu extends Model
{
    protected $table='a_process_menu';
    protected $guarded=[];
    protected $dates=['created_at','updated_at'];
    protected $casts = [];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'process_id'=>'项目流程',
        'menu_id'=>'菜单'
    ];


}