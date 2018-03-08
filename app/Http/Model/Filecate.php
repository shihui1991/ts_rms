<?php
/*
|--------------------------------------------------------------------------
| 必备附件分类 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Filecate extends Model
{
    use SoftDeletes;
    protected $table='file_cate';
    protected $primaryKey='id';
    protected $fillable=['name','filename'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'file_table_id'=>'分类',
        'name'=>'文件名称',
        'filename'=>'数据名称（英文）'
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){
        $this->attributes['file_table_id']=$request->input('file_table_id');
    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }
    /* ++++++++++ 关联必备附件表 ++++++++++ */
    public function filetable(){
        return $this->belongsTo('App\Http\Model\Filetable','file_table_id','id')->withDefault();
    }
}