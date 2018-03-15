<?php
/*
|--------------------------------------------------------------------------
| 评估机构 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
    protected $table='company';
    protected $primaryKey='id';
    protected $fillable=['type','name','address','phone','fax','contact_man','contact_tel','logo','infos','content','picture'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [];
    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'type'=>'类型',
        'name'=>'名称',
        'address'=>'地址',
        'phone'=>'电话',
        'fax'=>'传真',
        'contact_man'=>'联系人',
        'contact_tel'=>'联系电话',
        'logo'=>'logo',
        'infos'=>'描述',
        'content'=>'简介',
        'picture'=>'图片',
        'user_id'=>'评估机构操作员(管理员)',
        'state'=>'状态'
    ];
    
    /* ++++++++++ 获取类型 ++++++++++ */
    public function getTypeAttribute($key=null)
    {
        $array=[0=>'房产评估机构',1=>'资产评估机构'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }
    /* ++++++++++ 获取状态 ++++++++++ */
    public function getCodeAttribute($key=null)
    {
        $array=[40=>'待审查',41=>'审查通过',42=>'审查驳回',43=>'暂停业务'];
        if(is_numeric($key)){
            return $array[$key];
        }else{
            return $array;
        }
    }

    /* ++++++++++ 设置添加数据 ++++++++++ */
    public function addOther($request){

    }
    /* ++++++++++ 设置修改数据 ++++++++++ */
    public function editOther($request){

    }

    /* ++++++++++ 关联评估机构操作员 ++++++++++ */
    public function companyuser(){
        return $this->belongsTo('App\Http\Model\Companyuser','user_id','id')->withDefault();
    }


    public function companyvotes(){
        return $this->hasMany('App\Http\Model\Companyvote','company_id','id');
    }

    public function code(){
        return $this->belongsTo('App\Http\Model\Statecode','code','code');
    }
}