<?php
/*
|--------------------------------------------------------------------------
| 项目-项目人员 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Itemuser extends Model
{
    use SoftDeletes;
    protected $table='item_user';
    protected $primaryKey='id';
    protected $fillable=['item_id','schedule_id','process_id','menu_id','dept_id','role_id','user_id'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [

    ];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'schedule_id'=>'项目进度',
        'process_id'=>'项目流程',
        'menu_id'=>'功能',
        'dept_id'=>'部门',
        'role_id'=>'角色',
        'user_id'=>'人员',
    ];

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }

    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    public function item(){
        return $this->belongsTo('App\Http\Model\Item','item_id','id')->withDefault();
    }

    public function schedule(){
        return $this->belongsTo('App\Http\Model\Schedule','schedule_id','id')->withDefault();
    }

    public function process(){
        return $this->belongsTo('App\Http\Model\Process','process_id','id')->withDefault();
    }

    public function processes(){
        return $this->hasMany('App\Http\Model\Itemuser','schedule_id','schedule_id');
    }

    public function menu(){
        return $this->belongsTo('App\Http\Model\Menu','menu_id','id')->withDefault();
    }

    public function dept(){
        return $this->belongsTo('App\Http\Model\Dept','dept_id','id')->withDefault();
    }

    public function depts(){
        return $this->hasMany('App\Http\Model\Itemuser','process_id','process_id');
    }

    public function role(){
        return $this->belongsTo('App\Http\Model\Role','role_id','id')->withDefault();
    }

    public function user(){
        return $this->belongsTo('App\Http\Model\User','user_id','id')->withDefault();
    }

    public function users(){
        return $this->hasMany('App\Http\Model\Itemuser','dept_id','dept_id');
    }
}