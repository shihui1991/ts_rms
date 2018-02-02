{{-- 继承aceAdmin登录布局 --}}
@extends('ace_login')


{{-- 标题 --}}
@section('title')
    征收管理端
@endsection


{{-- 客户端 --}}
@section('client')
    征收管理端
@endsection


{{-- 登录地址 --}}
@section('login_url')

    {{route('g_login')}}

@endsection


{{-- 样式 --}}
@section('css')



@endsection


{{-- 插件 --}}
@section('js')

    <script>
        function login(obj) {
            ajaxFormSub(obj);
            if(ajaxResp.code=='success'){
                toastr.success(ajaxResp.message);
                setTimeout(function () {
                    location.href=ajaxResp.url;
                },1000);
            }else{
                toastr.error(ajaxResp.message);
                $('#username').focus();
            }
            return false;
        }
    </script>

@endsection