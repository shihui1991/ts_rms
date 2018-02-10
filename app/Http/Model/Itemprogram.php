<?php
/*
|--------------------------------------------------------------------------
| 项目-征收方案 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Itemprogram extends Model
{
    use SoftDeletes;
    protected $table='item_program';
    protected $primaryKey='id';
    protected $fillable=['name','content'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [
        'picture'=>'array'
    ];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'name'=>'名称',
        'content'=>'内容',
        'code'=>'状态代码'
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){
        $this->attributes['item_id'] = $request->input('item_id');
//        $this->attributes['code'] = $request->input('code');
        $this->attributes['code'] = 0;
    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 关联项目 ++++++++++ */
    public function item(){
        return $this->belongsTo('App\Http\Model\Item','item_id','id')->withDefault();
    }
}