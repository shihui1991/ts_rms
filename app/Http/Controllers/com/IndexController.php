<?php
/*
|--------------------------------------------------------------------------
| 登录入口
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\com;
use App\Http\Controllers\Controller;
use App\Http\Model\Companyuser;
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
        return view('com.login')->with(session('code'),session('message'));
    }

    /* ========== 登录 ========== */
    public function login(Request $request){
        $model =new Companyuser();
        /* ********** 数据验证 ********** */
        $rules=[
            'username'=>'required',
            'password'=>'required'
        ];
        $messages=[
            'required'=>'请输入 :attribute',
        ];
        $validator = Validator::make($request->all(), $rules, $messages, $model->columns);
        if ($validator->fails()) {
            $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
            return response()->json($result);
        }
        /* ********** 查询用户 ********** */
        DB::beginTransaction();
        $user=Companyuser::select(['id','name','username','password','secret','company_id'])
            ->with(['company'=>function($query){
                $query->select(['id','code','type']);
            }])
            ->where('username',$request->input('username'))
            ->sharedLock()
            ->first();
        DB::commit();
        if(blank($user)){
            return response()->json(['code'=>'error','message'=>'用户不存在','sdata'=>null,'edata'=>null,'url'=>null]);
        }
        if($user->company->getoriginal('code')!='41'){
            return response()->json(['code'=>'error','message'=>'用户不合法','sdata'=>null,'edata'=>null,'url'=>null]);
        }
        /* ********** 验证密码 ********** */
        if($request->input('password') != decrypt($user->password)){
            return response()->json(['code'=>'error','message'=>'密码错误','sdata'=>null,'edata'=>null,'url'=>null]);
        }

        /* ********** 更新登录 ********** */
        $user->session=session()->getId();
        $user->action_at=date('Y-m-d H:i:s');
        $user->save();

        /* ********** 生成session ********** */
        session(['com_user'=>[
            'user_id'=>$user->id,
            'name'=>$user->name,
            'company_id'=>$user->company_id,
            'type'=>$user->company->getOriginal('type'),
            'secret'=>$user->secret
        ]]);

        return response()->json(['code'=>'success','message'=>'登录成功','sdata'=>session('com_user'),'edata'=>null,'url'=>route('c_home')]);
    }

    /* ========== 退出登录 ========== */
    public function logout(Request $request){
        $request->session()->forget('com_user');

        return redirect()->route('c_index');
    }

}