<?php
/*
|--------------------------------------------------------------------------
| 项目-评估机构-评估范围
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;

class Companyhousehold extends Model
{
    protected $table='item_company_household';
    protected $fillable=['company_id','item_company_id','household_id'];
    protected $dates=['created_at','updated_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'company_id'=>'评估机构',
        'item_company_id'=>'项目评估机构',
        'household_id'=>'被征收户'
    ];


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

    /* ++++++++++ 关联被征收户账号 ++++++++++ */
    public function household(){
        return $this->belongsTo('App\Http\Model\Household','household_id','id')->withDefault();
    }

}