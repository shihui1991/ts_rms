<?php
/*
|--------------------------------------------------------------------------
| 项目 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Itemriskreport extends Model
{
    use SoftDeletes;
    protected $table='item_risk_report';
    protected $primaryKey='id';
    protected $fillable=['name','content','picture','agree'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [
        'picture'=>'array',
    ];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'name'=>'报告名称',
        'item_id'=>'项目',
        'content'=>'内容',
        'agree'=>'评估结论',
        'picture'=>'图片',
    ];

    /* ++++++++++ 获取评估结论 ++++++++++ */
    public function getAgreeAttribute($key=null)
    {
        $array=[0=>'风险高',1=>'风险低'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }
    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 关联项目 ++++++++++ */
    public function item(){
        return $this->belongsTo('App\Http\Model\Item','item_id','id')->withDefault();
    }

    /* ++++++++++ 项目状态 ++++++++++ */
    public function state(){
        return $this->belongsTo('App\Http\Model\Statecode','code','code')->withDefault();
    }
}