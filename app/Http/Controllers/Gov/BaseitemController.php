<?php
/*
|--------------------------------------------------------------------------
| 项目管理
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use App\Http\Model\Menu;
use Illuminate\Http\Request;

class BaseitemController extends BaseController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();

        $this->middleware(function ($request,$next){
            $menus=Menu::with(['childs'=>function($query){
                $query->where('display',1)->orderBy('sort','asc');
            }])
                ->withCount(['childs'=>function($query){
                    $query->where('display',1);
                }])
                ->sharedLock()
                ->where([
                    ['parent_id',40],
                    ['id','<>',41],
                    ['display',1],
                ])
                ->orderBy('sort','asc')
                ->get();

            $cur_menu=session('menu.cur_menu');
            $nav_menus=$this->makeMenu($menus,$cur_menu['id'],session('menu.cur_pids'),1,41);

            view()->share(['nav_menus'=>$nav_menus]);

            return $next($request);
        });
    }

}
