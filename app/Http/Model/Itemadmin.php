<?php
/*
|--------------------------------------------------------------------------
| 项目-项目负责人 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Itemadmin extends Model
{
    use SoftDeletes;
    protected $table='item_admin';
    protected $primaryKey='id';
    protected $fillable=['item_id','dept_id','role_id','user_id'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [

    ];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
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
        return $this->belongsTo('App\Http\Model\Item','item_id','id');
    }

    public function dept(){
        return $this->belongsTo('App\Http\Model\Dept','dept_id','id');
    }

    public function role(){
        return $this->belongsTo('App\Http\Model\Role','role_id','id');
    }

    public function user(){
        return $this->belongsTo('App\Http\Model\User','user_id','id');
    }

}