<?php
/*
|--------------------------------------------------------------------------
| 项目-补偿科目说明 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Itemsubject extends Model
{
    use SoftDeletes;
    protected $table='item_subject';
    protected $primaryKey='id';
    protected $fillable=['subject_id','infos'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'subject_id'=>'重要补偿科目',
        'infos'=>'补偿说明'
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){
        $this->attributes['item_id'] = $request->input('item_id');
    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 关联项目 ++++++++++ */
    public function item(){
        return $this->belongsTo('App\Http\Model\Item','item_id','id')->withDefault();
    }
    /* ++++++++++ 关联重要补偿科目 ++++++++++ */
    public function subject(){
        return $this->belongsTo('App\Http\Model\Subject','subject_id','id')->withDefault();
    }
}