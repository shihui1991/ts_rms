{{-- 继承aceAdmin后台布局 --}}
@extends('ace_admin')

{{-- 标题 --}}
@section('title')
    征收管理端
@endsection

{{-- 客户端 --}}
@section('client')
    征收管理端
@endsection


{{-- 头部工具 --}}
@section('header_tools')

    <li class="green">
        <a href="{{route('g_home')}}" title="消息提醒">
            <i class="ace-icon fa fa-bell icon-animated-bell"></i>
            <span class="badge badge-success" id="notice-num">0</span>
        </a>
    </li>

@endsection


{{-- 用户名 --}}
@section('username')

    {{session('gov_user.name')}}

@endsection

{{-- 用户工具 --}}
@section('user_tools')

    <li class="divider"></li>

    <li>
        <a href="{{route('g_logout')}}">
            <i class="ace-icon fa fa-power-off"></i>
            退出登录
        </a>
    </li>

@endsection

{{-- 导航头部提示 --}}
@section('shortcuts')

@endsection

{{-- 侧边导航 --}}
@section('nav')

@endsection

{{-- 面包屑 --}}
@section('breadcrumbs')

@endsection

{{-- 页面头部 --}}
@section('page_header')

@endsection

{{-- 页面内容 --}}
@section('content')

@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')
    @isset($code)
        @switch($code)
            @case('error')
            <script>
                toastr.error('{{$message}}');
            </script>
            @break

            @case('success')
            <script>
                toastr.success('{{$message}}');
            </script>
            @break

            @case('info')
            <script>
                toastr.info('{{$message}}');
            </script>
            @break

            @case('warning')
            <script>
                toastr.warning('{{$message}}');
            </script>
            @break

        @endswitch
    @endisset

    <script>
        var updUrl='{!! route('g_upl') !!}';
        var noticeNumUrl='{!! route('g_noticenum') !!}';
        noticenum();
        function noticenum() {
            $.get(noticeNumUrl,function (resp) {
                if(resp.code=='success'){
                    $('#notice-num').html(resp.sdata);
                }else{
                    toastr.error(resp.message);
                    if(resp.url){
                        setTimeout(function () {
                            location.href=resp.url;
                        },2000);
                        return false;
                    }
                }
            },'json');

            setTimeout(noticenum,60000);
        }
    </script>
    <script src="{{asset('js/func.js')}}"></script>

@endsection