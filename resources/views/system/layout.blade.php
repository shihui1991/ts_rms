{{-- 继承aceAdmin后台布局 --}}
@extends('ace_admin')

{{-- 标题 --}}
@section('title')
    后台管理端
@endsection

{{-- 客户端 --}}
@section('client')
    后台管理端
@endsection


{{-- 头部工具 --}}
@section('header_tools')

@endsection


{{-- 用户名 --}}
@section('username')

    {{session('sys_user.name')}}

@endsection

{{-- 用户工具 --}}
@section('user_tools')

    <li class="divider"></li>

    <li>
        <a href="{{route('sys_logout')}}">
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

    {!! $nav !!}

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

@endsection