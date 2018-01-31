<?php
/*
|--------------------------------------------------------------------------
| 特殊人群模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Crowd extends Model
{
    use SoftDeletes;
    protected $table='crowd';
    protected $primaryKey='id';
    protected $guarded=[];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'name'=>'特殊人群名称',
        'infos'=>'描述'
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

    /* ++++++++++ 关联特殊人群分类 ++++++++++ */
    public function crowdcate(){
        return $this->belongsTo('App\Http\Model\Crowdcate','cate_id','id')->withDefault();
    }

}