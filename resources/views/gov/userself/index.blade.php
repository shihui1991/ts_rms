{{-- 继承布局 --}}
@extends('gov.layout')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>

        <a class="btn" href="{{route('g_userself_edit')}}">
            <i class="ace-icon fa fa-pencil-square-o bigger-110"></i>
            修改
        </a>

        <a class="btn" href="{{route('g_userself_pwd')}}">
            <i class="ace-icon fa fa-refresh bigger-110"></i>
            修改密码
        </a>
    </p>


    <div class="profile-user-info profile-user-info-striped">

        <div class="profile-info-row">
            <div class="profile-info-name"> 所在部门： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->dept->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 所属角色： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->role->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 用户名： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->username}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 姓名： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 电话： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->phone}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 邮箱： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->email}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 描述： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->infos}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 最近登录时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->login_at}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 最近登录IP： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->login_ip}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 最近操作时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->action_at}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 创建时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->created_at}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 更新时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->updated_at}}</span>
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