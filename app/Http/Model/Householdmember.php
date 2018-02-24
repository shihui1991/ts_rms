<?php
/*
|--------------------------------------------------------------------------
| 项目-被征收户 家庭成员  模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Householdmember extends Model
{
    use SoftDeletes;
    protected $table='item_household_member';
    protected $primaryKey='id';
    protected $fillable=['name','relation','card_num','phone','nation_id','sex','age','crowd','holder','portion','picture'];
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
        'name'=>'姓名',
        'relation'=>'与户主关系',
        'card_num'=>'身份证',
        'phone'=>'电话',
        'nation_id'=>'民族',
        'sex'=>'性别',
        'age'=>'年龄',
        'crowd'=>'特殊人群优惠',
        'holder'=>'权属类型',
        'portion'=>'权属分配比例',
        'picture'=>'身份证，户口本页',
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){
        $this->attributes['household_id'] = $request->input('household_id');
        $this->attributes['land_id'] = $request->input('land_id');
        $this->attributes['building_id'] = $request->input('building_id');
    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 获取性别 ++++++++++ */
    public function getSexAttribute($key=null)
    {
        $array=[0=>'男',1=>'女'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }

    /* ++++++++++ 获取享受特殊人群优惠状态 ++++++++++ */
    public function getCrowdAttribute($key=null)
    {
        $array=[0=>'否',1=>'是'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }

    /* ++++++++++ 获取权属类型 ++++++++++ */
    public function getHolderAttribute($key=null)
    {
        $array=[0=>'非权属人',1=>'产权人',2=>'承租人'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
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
    /* ++++++++++ 关联民族 ++++++++++ */
    public function nation(){
        return $this->belongsTo('App\Http\Model\Nation','nation_id','id')->withDefault();
    }

}