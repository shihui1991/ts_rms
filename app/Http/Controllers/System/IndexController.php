<?php
/*
|--------------------------------------------------------------------------
| 登陆后台
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    public $security_code = '123456';

    /* ========== 初始化 ========== */
    public function __construct()
    {

    }

    /* ++++++++++ 登陆页面 ++++++++++ */
    public function index()
    {
        return view('system.login');
    }

    /* ++++++++++ 处理登陆页面 ++++++++++ */
    public function login(Request $request)
    {
        if($request->isMethod('post')){
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules=[
                'username'=>'required',
                'password'=>'required',
                'security_code'=>'required',
            ];
            $messages=[
                'username.required'=>'请输入用户名',
                'password.required'=>'请输入密码',
                'security_code.required'=>'请输入安全码',
            ];
            $validator = Validator::make($request->all(),$rules,$messages);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }

            /* ********** 查询用户 ********** */
            DB::beginTransaction();
            $user=User::select(['id','role_id','username','password','secret','name'])
                ->where('username',$request->input('username'))
                ->sharedLock()
                ->first();
            DB::commit();
            if(blank($user)){
                return response()->json(['code'=>'error','message'=>'用户不存在或已被禁用','sdata'=>null,'edata'=>null,'url'=>null]);
            }

            /* ********** 验证密码 ********** */
            if($request->input('password') != decrypt($user->password)){
                return response()->json(['code'=>'error','message'=>'密码错误','sdata'=>null,'edata'=>null,'url'=>null]);
            }

            if($user->role_id != 1){
                $result=['code'=>'error','message'=>'没有操作权限','sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }

            if($this->security_code!=$request->input('security_code')){
                $result=['code'=>'error','message'=>'安全码输入错误','sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }

            /* ++++++++++ 存入Session ++++++++++ */
            session(['sys_user'=>[
                'username'=>$user->name,
                'secret'=>$user->secret,
            ]]);

            $result=['code'=>'success','message'=>'登录成功','sdata'=>session('sys_user'),'edata'=>null,'url'=>route('sys_home')];
            return response()->json($result);
        }
    }

    /* ========== 退出 ========== */
    public function logout(Request $request)
    {
        $request->session()->forget('sys_user');
        return redirect()->route('sys_index');
    }
}