<?php
/*
|--------------------------------------------------------------------------
| 拆除记录 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teardetail extends Model
{
    use SoftDeletes;
    protected $table='tear_detail';
    protected $primaryKey='id';
    protected $fillable=['tear_at','picture'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [
        'picture'=>'array',
    ];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'tear_id'=>'拆除委托',
        'tear_at'=>'记录时间',
        'picture'=>'现场图片',
    ];
    
    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){
        $this->attributes['tear_id']=$request->input('tear_id');
    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 关联项目 ++++++++++ */
    public function item(){
        return $this->belongsTo('App\Http\Model\Item','item_id','id')->withDefault();
    }
    public function tear(){
        return $this->belongsTo('App\Http\Model\Tear','tear_id','id')->withDefault();
    }
}