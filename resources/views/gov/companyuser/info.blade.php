{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>

    </p>


    <div class="profile-user-info profile-user-info-striped">
        <div class="profile-info-row">
            <div class="profile-info-name"> 机构类型： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->company->type}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 机构名称： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->company->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 是否为管理员： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">@if($sdata->id == $sdata->company->user_id) 是@else 否@endif</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 操作员名称： </div>
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
            <div class="profile-info-name"> 用户名： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->username}}</span>
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