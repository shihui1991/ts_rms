<?php
/*
|--------------------------------------------------------------------------
| 项目-操作控制 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Itemctrl extends Model
{
    use SoftDeletes;
    protected $table='item_control';
    protected $primaryKey='id';
    protected $fillable=['serial','start_at','end_at'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'cate_id'=>'分类',
        'serial'=>'序列（轮次）',
        'start_at'=>'开始时间',
        'end_at'=>'结束时间',
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){
        $this->attributes['cate_id']=$request->input('cate_id');
    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }


    /* ++++++++++ 项目 ++++++++++ */
    public function item(){
        return $this->belongsTo('App\Http\Model\item','item_id','id')->withDefault();
    }

    /* ++++++++++ 关联分类 ++++++++++ */
    public function ctrlcate(){
        return $this->belongsTo('App\Http\Model\Ctrlcate','cate_id','id')->withDefault();
    }
}