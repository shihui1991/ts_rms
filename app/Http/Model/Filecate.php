<?php
/*
|--------------------------------------------------------------------------
| 必备附件分类 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;

class Filecate extends Model
{
    protected $table='file_cate';
    protected $primaryKey='id';
    protected $fillable=['file_table_id','name','filename'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'file_table_id'=>'分类数据表',
        'name'=>'分类名称',
        'filename'=>'保存文件名'
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }
    /* ++++++++++ 关联必备附件表 ++++++++++ */
    public function afiletable(){
        return $this->belongsTo('App\Http\Model\Filetable','file_table_id','id')->withDefault();
    }
}