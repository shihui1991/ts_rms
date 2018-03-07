<?php
/*
|--------------------------------------------------------------------------
| 控制台
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\system;
use App\Http\Model\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends BaseController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request){
        return view('system.home');
    }

}
