<?php
/*
|--------------------------------------------------------------------------
| 项目-被征收户 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Household extends Model
{
    use SoftDeletes;
    protected $table='item_household';
    protected $primaryKey='id';
    protected $fillable=['unit','floor','number','type','username','infos'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [
        'picture'=>'array'
    ];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'land_id'=>'地块',
        'building_id'=>'楼栋',
        'unit'=>'单元号',
        'floor'=>'楼层',
        'number'=>'房号',
        'type'=>'房产类型',
        'username'=>'用户名',
        'password'=>'密码',
        'secret'=>'密钥',
        'infos'=>'描述',
        'code'=>'状态'
    ];

    /* ++++++++++ 获取房产类型 ++++++++++ */
    public function getTypeAttribute($key=null)
    {
        $array=[0=>'私产',1=>'公房'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }


    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){
        $this->attributes['land_id'] = $request->input('land_id');
        $this->attributes['building_id'] = $request->input('building_id');
        $this->attributes['secret']=$this->get_secret();
        $this->attributes['code'] = '60';
        $this->attributes['password'] = encrypt($request->input('password'));
    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){
        $this->attributes['password'] = encrypt($request->input('password'));
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
    public function householddetail(){
        return $this->hasOne('App\Http\Model\Householddetail','household_id','id')->withDefault();
    }
    /* ++++++++++ 关联被征户-家庭成员 ++++++++++ */
    public function householdmembers(){
        return $this->hasMany('App\Http\Model\Householdmember','household_id','id');
    }
    /* ++++++++++ 兑付 ++++++++++ */
    public function pay(){
        return $this->hasOne('App\Http\Model\Pay','household_id','id')->withDefault();
    }
    /* ++++++++++ 状态 ++++++++++ */
    public function state(){
        return $this->belongsTo('App\Http\Model\Statecode','code','code')->withDefault();
    }


    /* ++++++++++ 密钥 ++++++++++ */
    public function get_secret(){
        $secret=create_guid();
        $res=self::withTrashed()->where('secret',$secret)->count();
        if($res){
            self::get_secret();
        }
        return $secret;
    }
}