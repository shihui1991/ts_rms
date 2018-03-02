<?php
/*
|--------------------------------------------------------------------------
| 项目资金 模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Funds extends Model
{
    use SoftDeletes;
    protected $table='item_funds';
    protected $primaryKey='id';
    protected $fillable=['amount','voucher','bank_id','account','name','entry_at','infos','picture'];
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [
        'picture'=>'array',
    ];

    /* ++++++++++ 数据字段注释 ++++++++++ */
    public $columns=[
        'item_id'=>'项目',
        'cate_id'=>'进出类型',
        'total_id'=>'兑付总单',
        'amount'=>'金额',
        'voucher'=>'凭证号',
        'bank_id'=>'转账银行',
        'account'=>'银行账号',
        'name'=>'账户姓名',
        'entry_at'=>'到账时间',
        'infos'=>'款项说明',
        'picture'=>'转账凭证',
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

    public function fundscate(){
        return $this->belongsTo('App\Http\Model\Fundscate','cate_id','id')->withDefault();
    }

    public function bank(){
        return $this->belongsTo('App\Http\Model\Bank','bank_id','id')->withDefault();
    }
}