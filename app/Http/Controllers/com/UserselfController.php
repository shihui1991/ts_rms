<?php
/*
|--------------------------------------------------------------------------
| 个人中心
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers\com;

use App\Http\Model\Companyuser;
use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserselfController extends BaseauthController
{
    /* ========== 初始化 ========== */
    public function __construct()
    {
        parent::__construct();
    }

    /* ========== 个人信息 ========== */
    public function index(Request $request){
        /* ********** 获取数据 ********** */
        $select=['id','company_id','name','phone','username','action_at','created_at','updated_at','deleted_at'];
        DB::beginTransaction();
        $user=Companyuser::with(['company'=>function($query){
                $query->withTrashed()->select(['id','name']);
            }])
            ->select($select)
            ->where('secret',session('com_user.secret'))
            ->sharedLock()
            ->first();
        DB::commit();
        /* ++++++++++ 数据不存在 ++++++++++ */
        if(blank($user)){
            $code='error';
            $msg='数据不存在';
            $sdata=null;
            $edata=null;
            $url=null;

            $view='com.error';
        }else{
            $code='success';
            $msg='查询成功';
            $sdata=$user;
            $edata=null;
            $url=null;

            $view='com.userself.index';
        }
        $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
        if($request->ajax()){
            return response()->json($result);
        }else{
            return view($view)->with($result);
        }
    }

    /* ========== 修改 ========== */
    public function edit(Request $request){
        if($request->isMethod('get')){
            /* ********** 获取数据 ********** */
            $select=['id','company_id','name','phone','username','action_at','created_at','updated_at','deleted_at'];
            DB::beginTransaction();
            $user=Companyuser::with(['company'=>function($query){
                $query->withTrashed()->select(['id','name']);
            }])
                ->select($select)
                ->where('secret',session('com_user.secret'))
                ->sharedLock()
                ->first();
            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($user)){
                $code='error';
                $msg='数据不存在';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='com.error';
            }else{
                $code='success';
                $msg='查询成功';
                $sdata=$user;
                $edata=new User();
                $url=null;

                $view='com.userself.edit';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }
        /* ********** 保存 ********** */
        else{
            /* ********** 表单验证 ********** */
            $model=new User();
            $rules=[
                'username'=>['required','alpha_num','between:4,20','unique:company_user,username,'.session('com_user.user_id').',id'],
                'name'=>'required|min:2',
                'phone'=>'nullable|min:7'
            ];
            $messages=[
                'required'=>':attribute 为必须项',
                'alpha_num'=>':attribute 须为字母或与数字组合',
                'between'=>':attribute 长度在 :min 到 :max 位之间',
                'unique'=>':attribute 已占用',
                'min'=>':attribute 长度至少 :min 位'
            ];

            $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /* ********** 更新 ********** */
            DB::beginTransaction();
            try{
                /* ++++++++++ 锁定数据模型 ++++++++++ */
                $user=Companyuser::withTrashed()->where('secret',session('com_user.secret'))->lockForUpdate()->first();
                if(blank($user)){
                    throw new \Exception('数据不存在',404404);
                }
                /* ++++++++++ 处理其他数据 ++++++++++ */
                $user->fill($request->input());
                $user->save();
                if(blank($user)){
                    throw new \Exception('修改失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=$user;
                $edata=null;
                $url=route('c_userself');

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'保存失败';
                $sdata=null;
                $edata=$user;
                $url=null;

                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }


    /* ========== 修改密码 ========== */
    public function password(Request $request){
        if($request->isMethod('get')){
            /* ********** 获取数据 ********** */
            $select=['id','company_id','username','name'];
            DB::beginTransaction();
            $user=Companyuser::with(['company'=>function($query){
                $query->withTrashed()->select(['id','name']);
            }])
                ->select($select)
                ->where('secret',session('com_user.secret'))
                ->sharedLock()
                ->first();
            DB::commit();
            /* ++++++++++ 数据不存在 ++++++++++ */
            if(blank($user)){
                $code='error';
                $msg='数据不存在';
                $sdata=null;
                $edata=null;
                $url=null;

                $view='com.error';
            }else{
                $code='success';
                $msg='查询成功';
                $sdata=$user;
                $edata=new Companyuser();
                $url=null;

                $view='com.userself.password';
            }
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            if($request->ajax()){
                return response()->json($result);
            }else{
                return view($view)->with($result);
            }
        }
        /* ********** 更新 ********** */
        else{
            /* ********** 表单验证 ********** */
            $model=new User();
            $rules=[
                'oldpassword'=>'required',
                'password'=>'required|min:6|confirmed',
            ];
            $messages=[
                'oldpassword.required'=>'输入当前密码',
                'password.required'=>'输入新密码',
                'password.min'=>'新密码 长度至少 :min 位',
                'password.confirmed'=>'重复密码输入错误',
            ];

            $validator = Validator::make($request->all(),$rules,$messages,$model->columns);
            if($validator->fails()){
                $result=['code'=>'error','message'=>$validator->errors()->first(),'sdata'=>null,'edata'=>null,'url'=>null];
                return response()->json($result);
            }
            /* ********** 更新 ********** */
            DB::beginTransaction();
            try{
                /* ++++++++++ 锁定数据模型 ++++++++++ */
                $user=Companyuser::select(['id','password','secret'])->where('secret',session('com_user.secret'))->lockForUpdate()->first();
                if(blank($user)){
                    throw new \Exception('数据不存在',404404);
                }
                if($request->input('oldpassword') != decrypt($user->password)){
                    throw new \Exception('当前密码输入错误',404404);
                }
                if($request->input('password') == decrypt($user->password)){
                    throw new \Exception('新密码与当前密码不能相同',404404);
                }

                /* ++++++++++ 处理其他数据 ++++++++++ */
                $user->password=encrypt($request->input('password'));
                $user->save();
                if(blank($user)){
                    throw new \Exception('修改失败',404404);
                }

                $code='success';
                $msg='保存成功';
                $sdata=$user;
                $edata=null;
                $url=route('c_index');

                $request->session()->forget('com_user');

                DB::commit();
            }catch (\Exception $exception){
                $code='error';
                $msg=$exception->getCode()==404404?$exception->getMessage():'保存失败';
                $sdata=null;
                $edata=$user;
                $url=null;

                DB::rollBack();
            }
            /* ********** 结果 ********** */
            $result=['code'=>$code,'message'=>$msg,'sdata'=>$sdata,'edata'=>$edata,'url'=>$url];
            return response()->json($result);
        }
    }
}