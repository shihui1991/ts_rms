<?php
/*
|--------------------------------------------------------------------------
| 协议分类 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pactcate extends Model
{
    use SoftDeletes;
    protected $table='a_pact_cate';
    protected $primaryKey='id';
    protected $fillable=['name','infos'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'name'=>'名称',
        'infos'=>'描述'
    ];
    
    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }
}