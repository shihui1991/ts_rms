{{-- 继承布局 --}}
@extends('household.home')


{{-- 页面内容 --}}
@section('content')
    <div class="well well-sm">

        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>

    </div>


@if(filled($sdata))

    <div class="profile-user-info profile-user-info-striped">

        <div class="profile-info-row">
            <div class="profile-info-name">被征户账号： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{session('household_user.user_name')}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">项目： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->item->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name">投票机构： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->company->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name">创建时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->created_at}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name">更新时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->updated_at}}</span>
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