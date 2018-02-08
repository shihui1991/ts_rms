<?php
/*
|--------------------------------------------------------------------------
| 功能与菜单 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;
    protected $table='a_menu';
    protected $primaryKey='id';
    protected $fillable=['name','icon','module','url','method','login','auth','display','sort','infos'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'parent_id'=>'上级菜单',
        'name'=>'名称',
        'icon'=>'图标',
        'module'=>'模块',
        'url'=>'路由地址',
        'method'=>'限制请求方法',
        'login'=>'限制登陆访问',
        'auth'=>'限制操作访问',
        'display'=>'状态',
        'sort'=>'排序',
        'infos'=>'说明'
    ];
    
    /* ++++++++++ 路由地址去空 ++++++++++ */
    public function setUrlAttribute($value)
    {
        $this->attributes['url']=trim($value);
    }
    /* ++++++++++ 排序强制转换为数字 ++++++++++ */
    public function setSortAttribute($value)
    {
        $this->attributes['sort']=is_null($value)?0:(integer)$value;
    }
    /* ++++++++++ 获取限制登陆访问 ++++++++++ */
    public function getLoginAttribute($key=null)
    {
        $array=[0=>'无限制',1=>'受限'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }
    /* ++++++++++ 获取限制操作访问 ++++++++++ */
    public function getAuthAttribute($key=null)
    {
        $array=[0=>'无限制',1=>'受限'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }
    /* ++++++++++ 获取状态 ++++++++++ */
    public function getDisplayAttribute($key=null)
    {
        $array=[0=>'隐藏',1=>'显示'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }
    /* ++++++++++ 获取模块 ++++++++++ */
    public function getModuleAttribute($key=null)
    {
        $array=[0=>'征收管理',1=>'评估机构',2=>'被征收户',3=>'触摸屏'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){
        $this->attributes['parent_id']=$request->input('parent_id');
    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 父级关联 ++++++++++ */
    public function father(){
        return $this->belongsTo('App\Http\Model\Menu','parent_id','id')->withDefault();
    }
    /* ++++++++++ 子级关联 ++++++++++ */
    public function childs(){
        return $this->hasMany('App\Http\Model\Menu','parent_id','id');
    }
}