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
    protected $guarded=[];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'file_table_id'=>'分类数据表',
        'name'=>'分类名称',
        'filename'=>'保存文件名'
    ];

    /* ++++++++++ 名称去空 ++++++++++ */
    public function setNameAttribute($value)
    {
        $this->attributes['name']=trim($value);
    }

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function setOther($request){

    }
}