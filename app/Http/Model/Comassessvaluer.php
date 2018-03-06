<?php
/*
|--------------------------------------------------------------------------
| 评估----评估师评估记录  模型
|--------------------------------------------------------------------------
*/
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;

class Comassessvaluer extends Model
{
    protected $table='com_assess_valuer';
    protected $dates=['created_at','updated_at','deleted_at'];
    protected $casts = [

    ];

}