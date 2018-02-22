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
        $item_id=$request->input('item');
        if(blank($item_id)){
            $result=['code'=>'error','message'=>'请指定征收项目','sdata'=>null,'edata'=>null,'url'=>null];
            if(request()->ajax()){
                return response()->json($result);
            }else{
                return redirect()->route('g_error')->with($result);
            }
        }

        return $next($request);
    }
}
