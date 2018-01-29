<?php
/*
|--------------------------------------------------------------------------
| 必备附件分类模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Filetable extends Model
{
    protected $table='a_file_table';
    protected $guarded=[];
    protected $dates=['created_at','updated_at'];
    protected $casts = [];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'name'=>'名称',
        'table_name'=>'表名'
    ];
}