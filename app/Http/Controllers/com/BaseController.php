<?php
/*
|--------------------------------------------------------------------------
| 基础控制器
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\com;

use App\Http\Controllers\Controller;
use App\Http\Model\Menu;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /* ++++++++++ 初始化 ++++++++++ */
    public function __construct()
    {
        $this->middleware(function ($request,$next){
            $url=request()->getPathInfo();
            /* ++++++++++ 当前菜单 ++++++++++ */
            $current_menu=Menu::select('id','parent_id','name','infos','url')->where('url',$url)->sharedLock()->first();
            if(blank($current_menu)){
                $result=['code'=>'error','message'=>'功能已禁用或不存在','sdata'=>null,'edata'=>null,'url'=>null];
                if(request()->ajax()){
                    return response()->json($result);
                }else{
                    return back()->with($result);
                }
            }
            /* ++++++++++ 所有菜单 ++++++++++ */
            $parents_menus_ids=[];
            $parents_menus=[];
            if(!request()->ajax()){
                /* ++++++++++ 所有父级菜单 ++++++++++ */
                $parents_menus=$this->get_parents_menus($current_menu);
                if($parents_menus){
                    $parents_menus_ids=$parents_menus['parents_menus_ids'];
                    $parents_menus=$parents_menus['parents_menus'];
                    krsort($parents_menus);
                }
                /* ++++++++++ 一级菜单 ++++++++++ */
                if(session('com_user.isAdmin')==1) {
                    $top_menus = Menu::sharedLock()
                        ->where([
                            ['parent_id', 0],
                            ['module', 1],
                            ['login', 1],
                            ['display', 1],
                        ])
                        ->orderBy('sort', 'asc')
                        ->get();
                }else{
                    $top_menus = Menu::sharedLock()
                        ->where([
                            ['parent_id', 0],
                            ['id','<>',266],
                            ['module', 1],
                            ['login', 1],
                            ['display', 1],
                        ])
                        ->orderBy('sort', 'asc')
                        ->get();
                }
                session(['menu'=>['cur_menu'=>$current_menu,'cur_pids'=>$parents_menus_ids]]);
                view()->share(['top_menus'=>$top_menus,'parents_menus'=>$parents_menus,'current_menu'=>$current_menu]);
            }
            return $next($request);
        });
    }


    /* ========== 获取所有父级菜单 ========== */
    public function get_parents_menus($menu)
    {
        static $parents_menus=null;
        static $parents_menus_ids=null;
        if($menu->parent_id){
            $parent_menu=Menu::sharedLock()->find($menu->parent_id);
            if($parent_menu){
                $parents_menus[]=$parent_menu;
                $parents_menus_ids[]=$parent_menu->id;
                if($parent_menu->parent_id){
                    $this->get_parents_menus($parent_menu);
                }
            }
        }
        if($parents_menus){
            return ['parents_menus'=>$parents_menus,'parents_menus_ids'=>$parents_menus_ids];
        }else{
            return null;
        }
    }


}
