<?php
/*
|--------------------------------------------------------------------------
| 具体公共附属物评估 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publicdetail extends Model
{
    use SoftDeletes;
    protected $table='com_public_detail';
    protected $primaryKey='id';
    protected $fillable=['price'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'land_id'=>'地块',
        'building_id'=>'楼栋',
        'item_public_id'=>'公共附属物',
        'company_id'=>'评估机构',
        'com_public_id'=>'公共附属物评估',
        'price'=>'评估单价',
        'amount'=>'评估总价',
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
    /* ++++++++++ 关联地块 ++++++++++ */
    public function itemland(){
        return $this->belongsTo('App\Http\Model\Itemland','land_id','id')->withDefault();
    }
    /* ++++++++++ 关联楼栋 ++++++++++ */
    public function itembuilding(){
        return $this->belongsTo('App\Http\Model\Itembuilding','building_id','id')->withDefault();
    }
    /* ++++++++++ 公共附属物 ++++++++++ */
    public function itempublic(){
        return $this->belongsTo('App\Http\Model\Itempublic','item_public_id','id')->withDefault();
    }
    /* ++++++++++ 评估机构 ++++++++++ */
    public function company(){
        return $this->belongsTo('App\Http\Model\Company','company_id','id')->withDefault();
    }
    /* ++++++++++ 公共附属物评估 ++++++++++ */
    public function compublic(){
        return $this->belongsTo('App\Http\Model\Compublic','com_public_id','id')->withDefault();
    }
}