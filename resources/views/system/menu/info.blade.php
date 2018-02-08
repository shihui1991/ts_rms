{{-- 继承布局 --}}
@extends('gov.layout')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>

        <a class="btn" href="{{route('sys_menu_edit',['id'=>$sdata->id])}}">
            <i class="ace-icon fa fa-pencil-square-o bigger-110"></i>
            修改
        </a>
    </p>


    <div class="profile-user-info profile-user-info-striped">

        <div class="profile-info-row">
            <div class="profile-info-name"> 上级菜单： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->father->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 名称： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 图标： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{!! $sdata->icon !!}{{$sdata->icon}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 模块： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->module}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 路由地址： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->url}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 限制请求方法： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->method}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 限制登录访问： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->login}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 限制操作权限： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->auth}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 显示状态： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->display}}</span>
            </div>
        </div>


        <div class="profile-info-row">
            <div class="profile-info-name"> 排序： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->sort}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 描述： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->infos}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 更新时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->updated_at}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 状态： </div>
            <div class="profile-info-value">
                <span class="editable editable-click"> @if($sdata->deleted_at) 已删除 @else 启用中 @endif</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 删除时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->deleted_at}}</span>
            </div>
        </div>

    </div>

@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')


@endsection