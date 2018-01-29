<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Statecode extends Model
{
    protected $table='a_state_code';
    protected $primaryKey='id';
    protected $guarded=[];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [

    ];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'code'=>'状态代码',
        'name'=>'状态名称'
    ];
}