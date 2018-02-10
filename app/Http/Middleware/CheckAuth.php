<?php
/*
|--------------------------------------------------------------------------
| 检查是否授权
|--------------------------------------------------------------------------
*/
namespace App\Http\Middleware;

use App\Http\Model\Menu;
use App\Http\Model\Rolemenu;
use App\Http\Model\User;
use Closure;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $url=request()->getPathInfo();
        /* ++++++++++ 当前菜单 ++++++++++ */
        $current_menu=Menu::sharedLock()->where('url',$url)->first();
        if(blank($current_menu)){
            $result=['code'=>'error','message'=>'功能已禁用或不存在','sdata'=>null,'edata'=>null,'url'=>null];
            if(request()->ajax()){
                return response()->json($result);
            }else{
                return back()->with($result);
            }
        }

        /* ++++++++++ 当前用户 ++++++++++ */
        $user=User::sharedLock()
            ->where('secret',session('gov_user.secret'))
            ->select(['id','role_id','secret','session'])
            ->first();
        if(blank($user)){
            $result=['code'=>'error','message'=>'用户不存在','sdata'=>null,'edata'=>null,'url'=>null];
            if(request()->ajax()){
                return response()->json($result);
            }else{
                return redirect()->route('g_index')->with($result);
            }
        }
        /* ++++++++++ 检查操作权限 ++++++++++ */
        if($user->role_id != 1 && $current_menu->getOriginal('auth')){
            $rolemenu_ids=Rolemenu::where('role_id',$user->role_id)->pluck('menu_id');
            if(!$rolemenu_ids->contains($current_menu->id)){
                $result=['code'=>'error','message'=>'您没有操作权限','sdata'=>null,'edata'=>null,'url'=>null];
                if(request()->ajax()){
                    return response()->json($result);
                }else{
                    return back()->with($result);
                }
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

            request()->session()->flash('menu',['cur_menu'=>$current_menu,'cur_pids'=>$parents_menus_ids]);
            view()->share(['parents_menus'=>$parents_menus,'current_menu'=>$current_menu]);
        }

        return $next($request);
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
