<?php
/*
|--------------------------------------------------------------------------
| 土地来源模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Landsource extends Model
{
    use SoftDeletes;
    protected $table='land_source';
    protected $primaryKey='id';
    protected $fillable=['name','infos'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'prop_id'=>'土地性质',
        'name'=>'名称',
        'infos'=>'描述'
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){
        $this->attributes['prop_id']=$request->input('prop_id');
    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 土地性质关联 ++++++++++ */
    public function landprop(){
        return $this->belongsTo('App\Http\Model\Landprop','prop_id','id')->withDefault();
    }

    public function landstates(){
        return $this->hasMany('App\Http\Model\landstate','source_id','id');
    }
}