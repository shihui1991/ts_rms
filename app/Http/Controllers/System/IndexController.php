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
    /*===== 账户信息 =====*/
    public $username = 'demo';
    public $password = '123456';
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
        $user_model = new User();
        $datas = $request->input();
        if($request->isMethod('post')){
            /* ++++++++++ 表单验证 ++++++++++ */
            $rules=[
                'username'=>['required','regex:/^[0-9A-Za-z]{4,20}$/'],
                'password'=>['required','regex:/^[0-9A-Za-z]{6,20}$/'],
                'security_code'=>['required','regex:/^[0-9A-Za-z]{4,20}$/']
            ];
            $messages=[
                'required'=>'请填写:attribute',
                'username.regex'=>'账号必须为4-20位数字或字母',
                'password.regex'=>'密码必须为6-20位数字或字母',
                'security_code.regex'=>'安全码必须为4-20位数字或字母'
            ];
            $validator = Validator::make($request->all(),$rules,$messages,$user_model->columns);
            if($validator->fails()){
                return response()->json(['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>'','edata'=>'']);
            }
            /* ++++++++++ 账号检测 ++++++++++ */
            if($this->username!=$datas['username']){
                return response()->json(['code'=>'error','message'=>'用户不存在','sdata'=>'','edata'=>'']);
            }
            if($this->password!=$datas['password']){
                return response()->json(['code'=>'error','message'=>'密码输入错误','sdata'=>'','edata'=>'']);
            }
            if($this->security_code!==$datas['security_code']){
                return response()->json(['code'=>'error','message'=>'安全码输入错误','sdata'=>'','edata'=>'']);
            }
            /* ++++++++++ 获取IP ++++++++++ */
            $request->setTrustedProxies(array('10.32.0.1/16'));
            $ip = $request->getClientIp();
            /* ++++++++++ 获取SessionID ++++++++++ */
            $sessionid = $request->session()->regenerate();
            /* ++++++++++ 存入Session ++++++++++ */
            $userinfo = [
                'username'=>$datas['username'],
                'login_ip'=>$ip,
                'login_at'=>date('Y-m-d H:i:s'),
                'session'=>$sessionid
            ];
            session(['userinfo'=>$userinfo]);
            return response()->json(['code'=>'success','message'=>$datas['username'].'，欢迎回来！','sdata'=>'','edata'=>'','url'=>route('sys_home')]);
        }
    }

    /* ========== 退出 ========== */
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('sys_index');
    }
}