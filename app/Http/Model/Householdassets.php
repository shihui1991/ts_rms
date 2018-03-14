<?php
/*
|--------------------------------------------------------------------------
| 项目-被征收户-资产 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Householdassets extends Model
{
    use SoftDeletes;
    protected $table='item_household_assets';
    protected $primaryKey='id';
    protected $fillable=['name','num_unit','gov_num','com_num','number','gov_pic','com_pic'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [
        'gov_pic'=>'array',
        'com_pic'=>'array'
    ];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'household_id'=>'被征收户',
        'land_id'=>'地块',
        'building_id'=>'楼栋',
        'name'=>'名称',
        'num_unit'=>'计量单位',
        'gov_num'=>'数量',
        'com_num'=>'数量',
        'number'=>'数量',
        'gov_pic'=>'图片',
        'com_pic'=>'图片'
    ];
    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){
        $this->attributes['land_id'] = $request->input('land_id');
        $this->attributes['building_id'] = $request->input('building_id');
        $this->attributes['household_id'] = $request->input('household_id');
    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 关联项目 ++++++++++ */
    public function item(){
        return $this->belongsTo('App\Http\Model\Item','item_id','id')->withDefault();
    }
    /* ++++++++++ 关联地块 ++++++++++ */
    public function itemland(){
        return $this->belongsTo('App\Http\Model\Itemland','land_id','id')->withDefault();
    }
    /* ++++++++++ 关联楼栋 ++++++++++ */
    public function itembuilding(){
        return $this->belongsTo('App\Http\Model\Itembuilding','building_id','id')->withDefault();
    }
    /* ++++++++++ 关联被征户 ++++++++++ */
    public function household(){
        return $this->belongsTo('App\Http\Model\Household','household_id','id')->withDefault();
    }

}