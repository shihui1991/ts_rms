<?php
/*
|--------------------------------------------------------------------------
| 状态代码 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Statecode extends Model
{
    use SoftDeletes;
    protected $table='a_state_code';
    protected $primaryKey='id';
    protected $fillable=['code','name'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'code'=>'代码',
        'name'=>'名称'
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

}