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
    <ul class="nav nav-list" style="top: 0px;">
        <li class="active open">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-desktop"></i>
                <span class="menu-text">
								系统管理
							</span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li class="">
                    <a href="{{route('sys_menu_all')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        所有菜单
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="">
                    <a href="{{route('sys_menu')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        树形菜单
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="open">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-caret-right"></i>
                        菜单操作
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>
                    <ul class="submenu nav-show" style="display: block;">
                        <li class="">
                            <a href="{{route('sys_menu_add')}}">
                                <i class="menu-icon fa fa-leaf green"></i>
                               添加
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="">
                            <a href="{{route('sys_menu_info')}}">
                                <i class="menu-icon fa fa-leaf green"></i>
                                修改
                            </a>
                            <b class="arrow"></b>
                        </li>

                    </ul>
                </li>


                <li class="">
                    <a href="{{route('sys_schedule')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        项目进度
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>

    </ul>
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