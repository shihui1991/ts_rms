{{-- 继承布局 --}}
@extends('household.home')


{{-- 页面内容 --}}
@section('content')


    <div class="well well-sm">
        <p>
            <a class="btn" href="javascript:history.back()">
                <i class="ace-icon fa fa-arrow-left bigger-110"></i>
                返回
            </a>
        </p>

    </div>

@if(filled($sdata))

    <div class="profile-user-info profile-user-info-striped">

        <div class="profile-info-row">
            <div class="profile-info-name">评估机构名称： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name">机构类型： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->type}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name">地址： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->address}}</span>
            </div>
        </div>


        <div class="profile-info-row">
            <div class="profile-info-name">电话： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->phone}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">传真： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->fax}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">联系人： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->contact_man}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">联系电话： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->contact_tel}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">机构详情： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->infos}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name">操作人员： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->companyuser->name}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">操作人员联系方式： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->companyuser->phone}}</span>
            </div>
        </div>
    </div>
@endif
@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')


@endsection