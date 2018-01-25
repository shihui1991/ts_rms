<?php
/*
|--------------------------------------------------------------------------
| 项目流程模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $table='a_process';
    protected $primaryKey='id';
    protected $guarded=[];
    protected $dates=['created_at','updated_at'];
    protected $casts = [];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'name'=>'名称',
        'sort'=>'排序',
        'infos'=>'流程描述'
    ];

    /* ++++++++++ 名称去空 ++++++++++ */
    public function setNameAttribute($value)
    {
        $this->attributes['name']=trim($value);
    }
    /* ++++++++++ 设置其他数据 ++++++++++ */
    public function setOther($request){

    }

    /* ++++++++++ 关联项目进度 ++++++++++ */
    public function schedule(){
        return $this->belongsTo('App\Http\Model\Schedule','schedule_id','id')->withDefault();
    }

}