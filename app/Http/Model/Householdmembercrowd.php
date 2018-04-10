<?php
/*
|--------------------------------------------------------------------------
| 项目-被征收户 家庭成员  特殊人群 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Householdmembercrowd extends Model
{
    use SoftDeletes;
    protected $table='item_household_member_crowd';
    protected $primaryKey='id';
    protected $fillable=['crowd_id','picture'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [
        'picture'=>'array'
    ];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'household_id'=>'被征收户',
        'land_id'=>'地块',
        'building_id'=>'楼栋',
        'member_id'=>'成员',
        'crowd_id'=>'特殊人群',
        'picture'=>'证件'
    ];
    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){
        $this->attributes['household_id'] = $request->input('household_id');
        $this->attributes['land_id'] = $request->input('land_id');
        $this->attributes['building_id'] = $request->input('building_id');
        $this->attributes['member_id'] = $request->input('member_id');
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
    /* ++++++++++ 关联特殊人群 ++++++++++ */
    public function crowd(){
        return $this->belongsTo('App\Http\Model\Crowd','crowd_id','id')->withDefault();
    }
    public function member(){
        return $this->belongsTo('App\Http\Model\Householdmember','member_id','id')->withDefault();
    }

}