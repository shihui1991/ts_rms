<?php
/*
|--------------------------------------------------------------------------
| 评估-房产-房屋建筑 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;

class Comestatebuilding extends Model
{
    protected $table='com_estate_building';
    protected $primaryKey='id';
    protected $fillable=['company_id','assess_id','estate_id','household_id','household_building_id', 'land_id',
        'building_id','real_outer','real_use','struct_id','direct','floor','layout_img','picture','price','amount'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [
        'picture'=>'array'
    ];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'company_id'=>'评估公司',
        'assess_id'=>'评估',
        'estate_id'=>'房产评估',
        'household_id'=>'被征收户',
        'household_building_id'=>'被征收户-房屋建筑',
        'land_id'=>'地块',
        'building_id'=>'楼栋',

        'real_outer'=>'实际建筑面积',
        'real_use'=>'实际用途',
        'struct_id'=>'结构类型',
        'direct'=>'朝向',
        'floor'=>'楼层',
        'layout_img'=>'户型图',
        'picture'=>'图片',
        'price'=>'评估单价',
        'amount'=>'评估总价'
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){
    }
}