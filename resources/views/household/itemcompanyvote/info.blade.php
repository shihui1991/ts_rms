{{-- 继承布局 --}}
@extends('household.home')


{{-- 页面内容 --}}
@section('content')


    <div class="well well-sm">
        @if (blank($sdata))
            <a href="{{route('h_itemcompanyvote_add')}}" class="btn">添加评估机构投票</a>
        @else
            <a href="{{route('h_itemcompanyvote_edit',['id'=>$sdata->id])}}" class="btn">修改评估机构投票</a>
        @endif

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
            <div class="profile-info-name">评估机构： </div>
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
    </div>
@endif
@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')


@endsection