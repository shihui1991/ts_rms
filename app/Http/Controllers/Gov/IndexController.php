<?php
/*
|--------------------------------------------------------------------------
| 登录入口
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    /* ========== 初始化 ========== */
    public function __construct()
    {

    }

    /* ========== 登录页 ========== */
    public function index(Request $request){
        return view('gov.login');
    }

    /* ========== 登录 ========== */
    public function login(Request $request){

        $rules=[
            'username'=>'required',
            'password'=>'required',
        ];
        $messages=[
            'required'=>'请输入 :attribute',
        ];
        $names=[
            'username'=>'用户名',
            'password'=>'密码',
        ];
        $validator = Validator::make($request->all(),$rules,$messages,$names);
        if($validator->fails()){
            return response()->json(['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>'','edata'=>'']);
        }
        return response()->json(['code'=>'error','message'=>'错误','sdata'=>null,'edata'=>null,'url'=>null]);
    }

    /* ========== 退出登录 ========== */
    public function logout(Request $request){
        $request->session()->forget('gov_user');

        return redirect()->route('g_index');
    }

}