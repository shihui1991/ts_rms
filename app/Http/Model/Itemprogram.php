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
    protected $fillable=['name','content','portion_holder','portion_renter','move_base','move_house','move_office','move_business','move_factory','transit_base','transit_house','transit_other','transit_real','transit_future','reward_house','reward_other','reward_real','reward_move','item_end'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'name'=>'名称',
        'content'=>'内容',
        'item_end'=>'项目期限',
        'portion_holder'=>'被征收人比例',
        'portion_renter'=>'承租人比例',
        'move_base'=>'基本搬迁补助',
        'move_house'=>'住宅搬迁补助单价',
        'move_office'=>'办公搬迁补助单价',
        'move_business'=>'商服搬迁补助单价',
        'move_factory'=>'生产加工搬迁补助单价',
        'transit_base'=>'临时安置基本费用',
        'transit_house'=>'临时安置住宅单价',
        'transit_other'=>'临时安置非住宅单价',
        'transit_real'=>'现房临时安置时长',
        'transit_future'=>'期房临时安置时长',
        'reward_house'=>'住宅签约奖励单价',
        'reward_other'=>'非住宅签约奖励单价',
        'reward_real'=>'房屋奖励单价',
        'reward_move'=>'搬迁奖励'
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){
      /*  $this->attributes['item_id'] = $request->input('item_id');
//        $this->attributes['code'] = $request->input('code');
        $this->attributes['code'] = 0;*/
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
}