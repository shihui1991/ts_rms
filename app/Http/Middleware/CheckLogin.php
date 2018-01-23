<?php

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
    public function handle($request, Closure $next)
    {
        $data = $request->session()->all();
        if(array_key_exists('userinfo',$data)==false){
            return redirect(route('sys_index'))->with('info','请先登录');
        }
        return $next($request);
    }
}
