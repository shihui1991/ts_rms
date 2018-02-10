<?php
/*
|--------------------------------------------------------------------------
| 检查是否登录
|--------------------------------------------------------------------------
*/
namespace App\Http\Middleware;

use Closure;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$session,$redirect)
    {
        $user=session($session);
        if(blank($user)){
            if($request->ajax()){
                return response()->json(['code'=>'error','message'=>'您还没有登录','sdata'=>null,'edata'=>null,'url'=>route($redirect)]);
            }else{
                session([$session.'_url'=>url()->current()]);
                return redirect()->route($redirect);
            }
        }
        $url=session($session.'_url',null);
        if($url){
            session()->forget($session.'_url');
            return redirect($url);
        }
        session([$session=>$user]);
        return $next($request);
    }
}
