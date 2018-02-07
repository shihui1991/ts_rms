<?php
/*
|--------------------------------------------------------------------------
| 房源社区模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Housecommunity extends Model
{
    use SoftDeletes;
    protected $table='house_community';
    protected $primaryKey='id';
    protected $fillable=['company_id','name','address','infos'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'company_id'=>'房源管理机构',
        'name'=>'房源社区名称',
        'address'=>'地址',
        'infos'=>'描述'
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 关联房源管理机构 ++++++++++ */
    public function housecompany(){
        return $this->belongsTo('App\Http\Model\Housecompany','company_id','id')->withDefault();
    }
}