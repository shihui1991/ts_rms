<?php
/*
|--------------------------------------------------------------------------
| 公共附属物评估 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compublic extends Model
{
    use SoftDeletes;
    protected $table='com_public';
    protected $primaryKey='id';
    protected $fillable=['picture'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [
        'picture'=>'array',
    ];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'company_id'=>'评估机构',
        'total'=>'评估总价',
        'picture'=>'评估报告',
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

    /* ++++++++++ 评估机构 ++++++++++ */
    public function company(){
        return $this->belongsTo('App\Http\Model\Company','company_id','id')->withDefault();
    }

    public function publicdetails(){
        return $this->hasMany('App\Http\Model\Publicdetail','com_public_id','id');
    }
}