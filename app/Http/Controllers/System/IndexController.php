<?php
/*
|--------------------------------------------------------------------------
| 登陆后台
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers\System;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

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
                'password'=>['required','regex:/^[0-9A-Za-z]{6,20}$/']
            ];
            $messages=[
                'required'=>'请填写:attribute',
                'username.regex'=>'账号必须为4-20位数字或字母',
                'password.regex'=>'密码必须为6-20位数字或字母'
            ];
            $this->validate($request,$rules,$messages,$user_model->columns);
            /* ++++++++++ 账号检测 ++++++++++ */
            if($this->username!==$datas['username']){
                return redirect()->back()->withInput()->with('error','用户不存在');
            }
            if(md5($this->password)!==md5($datas['password'])){
                return redirect()->back()->withInput()->with('error','密码输入错误');
            }
            if($this->security_code!==$datas['security_code']){
                return redirect()->back()->withInput()->with('error','安全码输入错误');
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
            return redirect(route('sys_home'))->with('info',$datas['username'].'，欢迎回来！');
        }
    }

    /* ========== 退出 ========== */
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('sys_index');
    }
}