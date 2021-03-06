{{-- 继承aceAdmin登录布局 --}}
@extends('ace_login')


{{-- 标题 --}}
@section('title')
    被征户端
@endsection


{{-- 客户端 --}}
@section('client')
    被征户端
@endsection


{{-- 登录地址 --}}
@section('login_url')

    {{route('h_login')}}

@endsection





{{-- 样式 --}}
@section('css')


@endsection


{{-- 插件 --}}
@section('js')

    <script>
        $(document).on('keydown',function (e) {
            if (!e) e = window.event; //火狐中是 window.event
            if ((e.keyCode || e.which) == 13) {
                $('.bigger-110').click();
            }
        });
        function login(obj) {
            ajaxFormSub(obj);
            console.log(ajaxResp);
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