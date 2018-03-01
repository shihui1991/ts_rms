<?php
/*
|--------------------------------------------------------------------------
| 项目-征收意见稿 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Itemdraftreport extends Model
{
    use SoftDeletes;
    protected $table='item_draft_report';
    protected $primaryKey='id';
    protected $fillable=['name','content','code','draft_id','item_id'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'draft_id'=>'征收意见稿',
        'name'=>'标题',
        'content'=>'内容',
        'code'=>'状态代码'
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

    /* ++++++++++ 项目状态 ++++++++++ */
    public function state(){
        return $this->belongsTo('App\Http\Model\Statecode','code','code')->withDefault();
    }

    /*++++++++++ 关联征收意见稿 ++++++++++*/
    public function draft(){
        return $this->belongsTo('App\Http\Model\Itemdraft','draft_id','id')->withDefault();
    }
}