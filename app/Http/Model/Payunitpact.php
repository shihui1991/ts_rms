<?php
/*
|--------------------------------------------------------------------------
| 兑付 - 公房单位-兑付协议 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payunitpact extends Model
{
    use SoftDeletes;
    protected $table='pay_unit_pact';
    protected $primaryKey='id';
    protected $fillable=['content','sign_at','sign','state'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'unit_id'=>'公房单位',
        'cate_id'=>'协议分类',
        'content'=>'协议内容',
        'sign_at'=>'签约时间',
        'sign'=>'签字',
        'code'=>'状态代码',
        'state'=>'有效状态',
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
    public function adminunit(){
        return $this->belongsTo('App\Http\Model\Adminunit','unit_id','id')->withDefault();
    }
    public function pactcate(){
        return $this->belongsTo('App\Http\Model\Pactcate','cate_id','id')->withDefault();
    }
}