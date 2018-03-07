<?php
/*
|--------------------------------------------------------------------------
| 必备附件分类-数据表 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Filetable extends Model
{
    use SoftDeletes;
    protected $table='a_file_table';
    protected $primaryKey='id';
    protected $fillable=['name','infos'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'name'=>'表名',
        'infos'=>'描述'
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    public function filecates(){
        return $this->hasMany('App\Http\Model\filecate','file_table_id','id');
    }
}