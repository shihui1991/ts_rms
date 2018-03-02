<?php
/*
|--------------------------------------------------------------------------
| 评估-汇总 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;

class Comassess extends Model
{
    protected $table='com_assess';
    protected $primaryKey='id';
    protected $fillable=['assets','estate','state'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'household_id'=>'被征收户',
        'land_id'=>'地块',
        'building_id'=>'楼栋',
        'assets'=>'资产评估总价',
        'estate'=>'房产评估总价',
        'state'=>'状态'
    ];


    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){
    }

}