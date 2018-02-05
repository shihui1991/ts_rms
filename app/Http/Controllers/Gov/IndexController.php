<?php
/*
|--------------------------------------------------------------------------
| 登录入口
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\Gov;

use App\Http\Controllers\Controller;
use App\Http\Model\User;
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
        /* ********** 数据验证 ********** */
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
            return response()->json(['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null]);
        }

        /* ********** 查询用户 ********** */
        DB::beginTransaction();
        $user=User::select(['id','dept_id','role_id','username','password','secret','name'])
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

        /* ********** 更新登录 ********** */
        $user->session=session_id();
        $user->action_at=date('Y-m-d H:i:s');
        $user->login_at=date('Y-m-d H:i:s');
        $user->login_ip=$request->ip();
        $user->save();

        /* ********** 生成session ********** */
        session(['gov_user'=>[
            'user_id'=>$user->id,
            'name'=>$user->name,
            'secret'=>$user->secret,
        ]]);

        return response()->json(['code'=>'success','message'=>'登录成功','sdata'=>session('gov_user'),'edata'=>null,'url'=>route('g_home')]);
    }

    /* ========== 退出登录 ========== */
    public function logout(Request $request){
        $request->session()->forget('gov_user');

        return redirect()->route('g_index');
    }

}