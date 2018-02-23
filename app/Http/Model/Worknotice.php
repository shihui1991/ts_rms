<?php
/*
|--------------------------------------------------------------------------
|  项目工作流程提醒 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worknotice extends Model
{
    use SoftDeletes;
    protected $table='item_work_notice';
    protected $primaryKey='id';
    protected $fillable=['sign','infos','picture'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [
        'picture'=>'array',
    ];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'schedule_id'=>'进度',
        'process_id'=>'项目流程',
        'menu_id'=>'功能菜单',
        'dept_id'=>'部门',
        'parent_id'=>'上级角色',
        'role_id'=>'角色',
        'user_id'=>'人员',
        'url'=>'操作地址',
        'code'=>'状态代码',
        'sign'=>'签名',
        'infos'=>'意见',
        'picture'=>'附件',
    ];
    
    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 关联项目 ++++++++++ */
    public function item(){
        return $this->belongsTo('App\Http\Model\Item','item_id','id');
    }

    /* ++++++++++ 关联进度 ++++++++++ */
    public function schedule(){
        return $this->belongsTo('App\Http\Model\Schedule','schedule_id','id');
    }

    /* ++++++++++ 关联流程 ++++++++++ */
    public function process(){
        return $this->belongsTo('App\Http\Model\Process','process_id','id');
    }

    /* ++++++++++ 关联菜单 ++++++++++ */
    public function menu(){
        return $this->belongsTo('App\Http\Model\Menu','menu_id','id');
    }

    /* ++++++++++ 关联部门 ++++++++++ */
    public function dept(){
        return $this->belongsTo('App\Http\Model\Dept','dept_id','id');
    }

    /* ++++++++++ 关联上级角色 ++++++++++ */
    public function parentrole(){
        return $this->belongsTo('App\Http\Model\Role','parent_id','id');
    }

    /* ++++++++++ 关联角色 ++++++++++ */
    public function role(){
        return $this->belongsTo('App\Http\Model\Role','role_id','id');
    }

    /* ++++++++++ 关联人员 ++++++++++ */
    public function user(){
        return $this->belongsTo('App\Http\Model\User','user_id','id');
    }

    /* ++++++++++ 关联状态 ++++++++++ */
    public function state(){
        return $this->belongsTo('App\Http\Model\Statecode','code','code');
    }
}