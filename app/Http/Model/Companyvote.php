<?php
/*
|--------------------------------------------------------------------------
| 评估机构投票 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Companyvote extends Model
{

    protected $table='item_company_vote';
    protected $fillable=[];
    protected $dates=['created_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'company_id'=>'评估机构',
        'household_id'=>'被征收户',
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

    /* ++++++++++ 关联评估机构 ++++++++++ */
    public function company(){
        return $this->belongsTo('App\Http\Model\Company','company_id','id')->withDefault();
    }

    /* ++++++++++ 关联被征收户 ++++++++++ */
    public function household(){
        return $this->belongsTo('App\Http\Model\Household','household_id','id')->withDefault();
    }

}