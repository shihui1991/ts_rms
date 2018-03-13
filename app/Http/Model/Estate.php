<?php
/*
|--------------------------------------------------------------------------
| 评估-汇总-房产评估 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estate extends Model
{
    use SoftDeletes;
    protected $table='com_assess_estate';
    protected $primaryKey='id';
    protected $fillable=['picture'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [
        'picture'=>'array',
    ];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'household_id'=>'被征收户',
        'land_id'=>'地块',
        'building_id'=>'楼栋',
        'assess_id'=>'评估汇总',
        'company_id'=>'评估公司',
        'main_total'=>'主体建筑评估总价',
        'tag_total'=>'附属物评估总价',
        'total'=>'评估总价',
        'picture'=>'评估报告',
        'state'=>'状态'
    ];




    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 获取房屋状况 ++++++++++ */
    public function getStatusAttribute($key=null)
    {
        $array=[0=>'正常',1=>'存在新建',2=>'存在改建',3=>'存在扩建'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }

    /* ++++++++++ 获取产权争议状态 ++++++++++ */
    public function getDisputeAttribute($key=null)
    {
        $array=[0=>'无争议',1=>'存在争议',2=>'产权明确'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }

    /* ++++++++++ 面积争议 ++++++++++ */
    public function getAreaDisputeAttribute($key=null)
    {
        $array=[0=>'无争议',1=>'待测绘',2=>'面积明确'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }

    /* ++++++++++ 获取资产评估状态 ++++++++++ */
    public function getHasAssetsAttribute($key=null)
    {
        $array=[0=>'否',1=>'是'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }

    /* ++++++++++ 批准用途关联建筑用途 ++++++++++ */
    public function defbuildinguse(){
        return $this->belongsTo('App\Http\Model\Buildinguse','def_use','id')->withDefault();
    }
    /* ++++++++++ 实际用途关联建筑用途 ++++++++++ */
    public function realbuildinguse(){
        return $this->belongsTo('App\Http\Model\Buildinguse','real_use','id')->withDefault();
    }

    public function item(){
        return $this->belongsTo('App\Http\Model\Item','item_id','id')->withDefault();
    }

    public function state(){
        return $this->belongsTo('App\Http\Model\Statecode','code','code')->withDefault();
    }

    public function household(){
        return $this->belongsTo('App\Http\Model\Household','household_id','id')->withDefault();
    }

    public function itemland(){
        return $this->belongsTo('App\Http\Model\Itemland','land_id','id')->withDefault();
    }

    public function itembuilding(){
        return $this->belongsTo('App\Http\Model\Itembuilding','building_id','id')->withDefault();
    }

    public function assess(){
        return $this->belongsTo('App\Http\Model\Assess','assess_id','id')->withDefault();
    }

    public function company(){
        return $this->belongsTo('App\Http\Model\Company','company_id','id')->withDefault();
    }
}