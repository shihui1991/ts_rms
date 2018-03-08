<?php
/*
|--------------------------------------------------------------------------
| 项目-选定评估机构 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Itemcompany extends Model
{
    use SoftDeletes;
    protected $table='item_company';
    protected $primaryKey='id';
    protected $fillable=['company_id','type','picture'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [
        'picture'=>'array'
    ];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'type'=>'评估机构类型',
        'company_id'=>'评估机构',
        'picture'=>'评估委托书'
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 获取评估机构类型 ++++++++++ */
    public function getTypeAttribute($key=null)
    {
        $array=[0=>'房产评估机构',1=>'资产评估机构'];
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

    /* ++++++++++ 关联评估机构 ++++++++++ */
    public function company(){
        return $this->belongsTo('App\Http\Model\Company','company_id','id')->withDefault();
    }

    public function companyvotes(){
        return $this->hasMany('App\Http\Model\Companyvote','company_id','company_id');
    }

}