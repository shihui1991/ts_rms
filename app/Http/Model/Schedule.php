<?php
/*
|--------------------------------------------------------------------------
| 项目进度模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table='a_schedule';
    protected $primaryKey='id';
    protected $guarded=[];
    protected $dates=['created_at','updated_at'];
    protected $casts = [];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'name'=>'名称',
        'sort'=>'排序',
        'infos'=>'进度描述'
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

    /* ++++++++++ 关联项目流程 ++++++++++ */
    public function process(){
        return $this->hasMany('App\Http\Model\Process','id','schedule_id');
    }
}