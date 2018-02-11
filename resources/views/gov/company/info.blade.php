{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>

        <a class="btn" href="{{route('g_company_edit',['id'=>$sdata->id])}}">
            <i class="ace-icon fa fa-pencil-square-o bigger-110"></i>
            修改
        </a>
    </p>


    <div class="profile-user-info profile-user-info-striped">

        <div class="profile-info-row">
            <div class="profile-info-name"> 机构状态： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->state}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 类型： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->type}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 名称： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 地址： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->address}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 电话： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->phone}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 传真： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->fax}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 联系人： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->contact_man}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 手机号： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->contact_tel}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 描述： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->infos}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 简介： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->content}}</span>
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
            <div class="profile-info-name"> 数据状态： </div>
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
        <br/>
        <div class="profile-info-row">
            <div class="profile-info-name"> 操作人员姓名： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->companyuser->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 操作人员电话： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->companyuser->phone}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 操作人员账号： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->companyuser->username}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 最近操作时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->companyuser->action_at}}</span>
            </div>
        </div>

    </div>

@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')
    @parent

@endsection