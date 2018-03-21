<?php
/*
|--------------------------------------------------------------------------
| 项目-监督拆除
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TearController extends BaseitemController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 首页 ========== */
    public function index(Request $request){

    }
}