{{-- 继承布局 --}}
@extends('household.layout')


{{-- 页面内容 --}}
@section('content')

    @if(filled($sdata))
    <div class="well well-sm">
        <a href="{{route('h_householddetail_info',['id'=>$sdata->id])}}" class="btn btn-sm">查看详情</a>
    </div>
    @endif

@if(filled($sdata))

    <div class="profile-user-info profile-user-info-striped">

        <div class="profile-info-row">
            <div class="profile-info-name">用户名： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{session('household_user.user_name')}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name">项目地块： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->itemland->address}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name">楼栋： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->itembuilding->building}}</span>
            </div>
        </div>


        <div class="profile-info-row">
            <div class="profile-info-name">位置： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->unit?$sdata->unit.'单元':''}}{{$sdata->floor?$sdata->floor.'楼':''}}{{$sdata->number?$sdata->number.'号':''}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">房产类型： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->type}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">状态： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->state}}</span>
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
        <div class="profile-info-row">
            <div class="profile-info-name">删除时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->deleted_at}}</span>
            </div>
        </div>
    </div>
    @else
    <div class="profile-user-info profile-user-info-striped">

        <div class="profile-info-row">
            <div class="profile-info-name">暂无数据 </div>

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