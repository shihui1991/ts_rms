<?php
/*
|--------------------------------------------------------------------------
| 评估-汇总-资产评估 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;

class Assets extends Model
{
    protected $table='com_assess_assets';
    protected $primaryKey='id';
    protected $fillable=['total','picture','state'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'household_id'=>'被征收户',
        'land_id'=>'地块',
        'building_id'=>'楼栋',
        'assess_id'=>'评估汇总',
        'company_id'=>'评估公司',
        'total'=>'评估总价',
        'picture'=>'评估报告',
        'state'=>'状态'
    ];


    public function getStateAttribute($key=null){
        $array=[0=>'待评估',1=>'评估中',2=>'完成',3=>'通过',4=>'驳回',5=>'反对',6=>'同意'];
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

    public function assess(){
        return $this->belongsTo('App\Http\Model\Assess','assess_id','id')->withDefault();
    }

    public function company(){
        return $this->belongsTo('App\Http\Model\Company','company_id','id')->withDefault();
    }

}