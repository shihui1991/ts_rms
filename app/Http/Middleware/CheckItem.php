<?php
/*
|--------------------------------------------------------------------------
| 检查是否指定项目
|--------------------------------------------------------------------------
*/
namespace App\Http\Middleware;

use Closure;

class CheckItem
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

        return $next($request);
    }
}
