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
        'state'=>'状态'
    ];

    /* ++++++++++ 获取房产类型 ++++++++++ */
    public function getTypeAttribute($key=null)
    {
        $array=[0=>'私产',1=>'公产'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }

    /* ++++++++++ 获取房产状态 ++++++++++ */
    public function getStateAttribute($key=null)
    {
        $array=[0=>'调查中',1=>'已调查',2=>'评估中',3=>'已评估',4=>'未签约', 5=>'已签约',
                6=>'已搬迁',7=>'强制搬迁',8=>'临时周转',9=>'安置中',10=>'已安置'];
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
        $this->attributes['state'] = 0;
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
        return $this->belongsTo('App\Http\Model\Householddetail','id','household_id')->withDefault();
    }
    /* ++++++++++ 关联被征户-家庭成员 ++++++++++ */
    public function householdmember(){
        return $this->belongsTo('App\Http\Model\Householdmember','id','household_id')->withDefault();
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