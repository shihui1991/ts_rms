<?php
/*
|--------------------------------------------------------------------------
| 土地性质模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Landprop extends Model
{
    use SoftDeletes;
    protected $table='land_prop';
    protected $primaryKey='id';
    protected $fillable=['name','infos'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'name'=>'土地性质名称',
        'infos'=>'描述'
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 关联土地来源 ++++++++++ */
    public function landsources(){
        return $this->hasMany('App\Http\Model\Landsource','prop_id','id');
    }
}