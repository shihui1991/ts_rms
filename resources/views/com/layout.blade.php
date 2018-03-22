{{-- 继承aceAdmin后台布局 --}}
@extends('ace_admin')

{{-- 标题 --}}
@section('title')
    评估机构端
@endsection

{{-- 客户端 --}}
@section('client')
    评估机构端
@endsection


{{-- 头部工具 --}}
@section('header_tools')

    <li class="green">
        <a href="" title="消息提醒">
            <i class="ace-icon fa fa-bell icon-animated-bell"></i>
            <span class="badge badge-success" id="notice-num">0</span>
        </a>
    </li>

@endsection


{{-- 用户名 --}}
@section('username')

    {{session('com_user.name')}}

@endsection

{{-- 用户工具 --}}
@section('user_tools')

    <li class="divider"></li>

    <li>
        <a href="{{route('c_logout')}}">
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
        var updUrl='{!! route('c_upl') !!}';

    </script>
    <script src="{{asset('js/func.js')}}"></script>
@endsection