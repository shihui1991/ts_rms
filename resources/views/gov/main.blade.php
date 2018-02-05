{{-- 继承布局 --}}
@extends('gov.layout')


{{-- 头部工具 --}}
@section('header_tools')

    <li>
        <a href="#">
            <i class="ace-icon fa fa-home"></i>
            首页
        </a>
    </li>

    <li>
        <a href="#">
            项目
        </a>
    </li>
    <li>
        <a href="#">
            房源
        </a>
    </li>
    <li>
        <a href="#">
            评估机构
        </a>
    </li>
    <li>
        <a href="#">
            基础资料
        </a>
    </li>
    <li>
        <a href="#">
            设置
        </a>
    </li>

@endsection


{{-- 导航头部提示 --}}
@section('shortcuts')

@endsection

{{-- 侧边导航 --}}
@section('nav')

    <ul class="nav nav-list">
        <li class="">
            <a href="{{route('g_home')}}">
                <i class="menu-icon fa fa-home"></i>
                <span class="menu-text"> 首页 </span>
            </a>

            <b class="arrow"></b>
        </li>

        <li class="active open">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-desktop"></i>
                <span class="menu-text"> 项目 </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li class="">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-caret-right"></i>

                        项目配置
                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="">
                            <a href="top-menu.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                项目概述
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="two-menu-1.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                项目信息
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="two-menu-2.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                项目进度
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="mobile-menu-1.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                项目人员
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="mobile-menu-2.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                项目规划
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="">
                            <a href="mobile-menu-3.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                初步预算
                            </a>

                            <b class="arrow"></b>
                        </li>
                        <li class="">
                            <a href="mobile-menu-3.html">
                                <i class="menu-icon fa fa-caret-right"></i>
                                项目控制
                            </a>

                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>

                <li class="">
                    <a href="typography.html">
                        <i class="menu-icon fa fa-caret-right"></i>
                        资金管理
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="active">
                    <a href="elements.html">
                        <i class="menu-icon fa fa-caret-right"></i>
                        房源管理
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="buttons.html">
                        <i class="menu-icon fa fa-caret-right"></i>
                        通知公告
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="content-slider.html">
                        <i class="menu-icon fa fa-caret-right"></i>
                        调查建档
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="treeview.html">
                        <i class="menu-icon fa fa-caret-right"></i>
                        入围机构
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="jquery-ui.html">
                        <i class="menu-icon fa fa-caret-right"></i>
                        征收决定
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="nestable-list.html">
                        <i class="menu-icon fa fa-caret-right"></i>
                        评估报告
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="nestable-list.html">
                        <i class="menu-icon fa fa-caret-right"></i>
                        协调协议
                    </a>

                    <b class="arrow"></b>
                </li>
                <li class="">
                    <a href="nestable-list.html">
                        <i class="menu-icon fa fa-caret-right"></i>
                        归档审计
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>

        <li class="">
            <a href="#">
                <i class="menu-icon fa fa-home"></i>
                <span class="menu-text"> 房源 </span>
            </a>

            <b class="arrow"></b>
        </li>
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-home"></i>
                <span class="menu-text"> 评估机构 </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="">
                    <a href="{{route('g_company')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        机构管理
                    </a>

                    <b class="arrow"></b>
                </li>
                <li class="">
                    <a href="{{route('g_companyuser')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        操作员管理
                    </a>

                    <b class="arrow"></b>
                </li>
                <li class="">
                    <a href="{{route('g_companyvaluer')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        评估师管理
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-home"></i>
                <span class="menu-text"> 基础资料 </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>

            <ul class="submenu">
                <li class="">
                    <a href="{{route('g_adminunit')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        公产单位
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="{{route('g_bank')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        银行管理
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="{{route('g_buildingstruct')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        建筑结构类型
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="{{route('g_buildinguse')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        建筑用途
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        <li class="">
            <a href="#">
                <i class="menu-icon fa fa-home"></i>
                <span class="menu-text"> 设置 </span>
            </a>

            <b class="arrow"></b>
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