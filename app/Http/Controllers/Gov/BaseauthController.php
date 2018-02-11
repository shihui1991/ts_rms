<?php
/*
|--------------------------------------------------------------------------
| 授权菜单
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use App\Http\Model\Menu;
use Illuminate\Http\Request;

class BaseauthController extends BaseController
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        parent::__construct();

        $this->middleware(function ($request,$next){
            $cur_menu=session('menu.cur_menu');
            $cur_pids=session('menu.cur_pids');
            $top_id=array_last($cur_pids);

            $menus=Menu::with(['childs'=>function($query){
                $query->where('display',1)->orderBy('sort','asc');
            }])
                ->withCount(['childs'=>function($query){
                    $query->where('display',1);
                }])
                ->sharedLock()
                ->where([
                    ['parent_id',$top_id],
                    ['display',1],
                ])
                ->orderBy('sort','asc')
                ->get();


            $nav_menus=$this->makeMenu($menus,$cur_menu['id'],$cur_pids,1,$top_id);

            view()->share(['nav_menus'=>$nav_menus]);

            return $next($request);
        });
    }

}
