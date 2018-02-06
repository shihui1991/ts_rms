<?php
/*
|--------------------------------------------------------------------------
| 房源 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class House extends Model
{
    use SoftDeletes;
    protected $table='house';
    protected $primaryKey='id';
    protected $fillable=['company_id','community_id','layout_id','layout_img_id','building',
        'unit','floor','number','area','total_floor','lift','is_real','is_buy','is_transit',
        'is_public','picture','delive_at','state'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'company_id'=>'所属管理机构',
        'community_id'=>'所在房源社区',
        'layout_id'=>'所属房源户型',
        'layout_img_id'=>'所属房源户型图',
        'building'=>'楼栋',
        'unit'=>'单元',
        'floor'=>'楼层',
        'number'=>'房号',
        'area'=>'面积',
        'total_floor'=>'总楼层',
        'lift'=>'是否有电梯',
        'is_real'=>'房源类型',
        'is_buy'=>'房源购置状态',
        'is_transit'=>'可临时周转状况',
        'is_public'=>'可项目共享状况',
        'picture'=>'房源图片',
        'delive_at'=>'购置交付日期',
        'state'=>'房源状况'
    ];

    /* ++++++++++ 名称去空 ++++++++++ */
    public function setNameAttribute($value)
    {
        $this->attributes['name']=trim($value);
    }
    /* ++++++++++ 获取是否有电梯 ++++++++++ */
    public function getLiftAttribute($key=null)
    {
        $array=[0=>'否',1=>'是'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }
    /* ++++++++++ 获取房源类型 ++++++++++ */
    public function getIsRealAttribute($key=null)
    {
        $array=[0=>'期房',1=>'现房'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }
    /* ++++++++++ 获取房源购置状态 ++++++++++ */
    public function getIsBuyAttribute($key=null)
    {
        $array=[0=>'未购买',1=>'已购买'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }
    /* ++++++++++ 获取可临时周转状况 ++++++++++ */
    public function getIsTransitAttribute($key=null)
    {
        $array=[0=>'不可作临时周转',1=>'可作临时周转'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }
    /* ++++++++++ 获取项目共享状况 ++++++++++ */
    public function getIsPublicAttribute($key=null)
    {
        $array=[0=>'不可项目共享',1=>'可项目共享'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }
    /* ++++++++++ 获取房源状况 ++++++++++ */
    public function getStateAttribute($key=null)
    {
        $array=[0=>'空闲',1=>'冻结',2=>'临时周转',3=>'产权调换',4=>'失效',5=>'售出'];
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

    /* ++++++++++ 关联房源管理机构 ++++++++++ */
    public function housecompany(){
        return $this->belongsTo('App\Http\Model\Housecompany','company_id','id')->withDefault();
    }

    /* ++++++++++ 关联房源社区 ++++++++++ */
    public function housecommunity(){
        return $this->belongsTo('App\Http\Model\Housecommunity','community_id','id')->withDefault();
    }

    /* ++++++++++ 关联房屋户型 ++++++++++ */
    public function layout(){
        return $this->belongsTo('App\Http\Model\Layout','layout_id','id')->withDefault();
    }

    /* ++++++++++ 关联房屋户型图 ++++++++++ */
    public function houselayoutimg(){
        return $this->belongsTo('App\Http\Model\Houselayoutimg','layout_img_id','id')->withDefault();
    }
}