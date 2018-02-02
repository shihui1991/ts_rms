<?php
/*
|--------------------------------------------------------------------------
| 首页
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HomeController extends BaseController
{
    /* ========== 初始化 ========== */
    public function __construct()
    {

    }

    /* ========== 登录页 ========== */
    public function index(Request $request){
        return view('gov.layout');
    }
}