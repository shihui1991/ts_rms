<?php
/*
|--------------------------------------------------------------------------
| 项目-项目审查
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\gov;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuditController extends BaseitemController
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