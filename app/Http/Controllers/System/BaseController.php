<?php
/*
|--------------------------------------------------------------------------
| 基础控制器
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\System;

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
            if(!request()->ajax()){
                /* ++++++++++ 所有父级菜单 ++++++++++ */
                $parents_menus=$this->get_parents_menus($current_menu);
                if($parents_menus){
                    $parents_menus_ids=$parents_menus['parents_menus_ids'];
                    $parents_menus=$parents_menus['parents_menus'];
                    krsort($parents_menus);
                }else{
                    $parents_menus_ids=[];
                    $parents_menus=[];
                }

                /* ++++++++++ 所有菜单 ++++++++++ */
                $where=[
                    ['module',4],
                    ['login',1],
                    ['display',1],
                ];
                $menus=Menu::sharedLock()->where($where)->orderBy('sort','asc')->get();
                /* ++++++++++ 导航菜单树 ++++++++++ */
                $nav_menus=get_nav_li_list($menus,$current_menu->id,$parents_menus_ids);

                view()->share(['nav'=>$nav_menus,'parents_menus'=>$parents_menus,'current_menu'=>$current_menu]);
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
            return false;
        }
    }

}
