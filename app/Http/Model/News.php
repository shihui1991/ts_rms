<?php
/*
|--------------------------------------------------------------------------
| 通知公告 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;
    protected $table='news';
    protected $primaryKey='id';
    protected $fillable=['name','release_at','keys','infos','content','picture','is_top'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [
        'picture'=>'array'
    ];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'cate_id'=>'分类',
        'item_id'=>'项目',
        'name'=>'名称',
        'release_at'=>'发布时间',
        'keys'=>'关键词',
        'infos'=>'摘要',
        'content'=>'内容',
        'picture'=>'附件',
        'is_top'=>'是否置顶',
        'code'=>'状态',
    ];

    /* ++++++++++ 是否置顶 ++++++++++ */
    public function getIsTopAttribute($key=null){
        $array=[0=>'非置顶',1=>'置顶'];
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

    public function item(){
        return $this->belongsTo('App\Http\Model\Item','item_id','id')->withDefault();
    }

    public function newscate(){
        return $this->belongsTo('App\Http\Model\Newscate','cate_id','id')->withDefault();
    }

    public function state(){
        return $this->belongsTo('App\Http\Model\Statecode','code','code');
    }
}