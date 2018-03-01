{{-- 继承布局 --}}
@extends('gov.layout')


{{-- 导航头部提示 --}}
@section('shortcuts')
    <span id="timeshow"></span>
@endsection

{{-- 侧边导航 --}}
@section('nav')

    <ul class="nav nav-list">

        @foreach($top_menus as $top_menu)
            <li @if($loop->iteration ==1) class="active" @endif>
                <a href="{{$top_menu->url}}">
                    {!! $top_menu->icon !!}
                    <span class="menu-text"> {{$top_menu->name}} </span>
                </a>
                <b class="arrow"></b>
            </li>
        @endforeach

    </ul>

@endsection


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back();">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>
    </p>

    <div class="profile-user-info profile-user-info-striped">

        <div class="profile-info-row">
            <div class="profile-info-name"> 项目名称： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->item->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 项目进度： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->schedule->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 项目流程： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->process->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 功能菜单： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->menu->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 部门： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->dept->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 角色： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->role->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 人员： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->user->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 结果： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->state->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 意见： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->infos}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 附件： </div>
            <div class="profile-info-value">
                <ul class="ace-thumbnails clearfix img-content">
                    @if(filled($sdata->picture))
                        @foreach($sdata->picture as $pic)
                            <li>
                                <div>
                                    <img width="120" height="120" src="{{$pic}}" alt="{{$pic}}">
                                    <div class="text">
                                        <div class="inner">
                                            <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
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
            <div class="profile-info-name"> 删除时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->deleted_at}}</span>
            </div>
        </div>

    </div>

@endsection

{{-- 样式 --}}
@section('css')

    <link rel="stylesheet" href="{{asset('viewer/viewer.min.css')}}" />

@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script src="{{asset('viewer/viewer.min.js')}}"></script>

    <script>
        $('.img-content').viewer();

        timeshow();
        function timeshow()
        {
            dt = new Date();
            var year=dt.getFullYear(),
                month=dt.getMonth()+1,
                day= dt.getDate(),
                hour=dt.getHours(),
                min=dt.getMinutes(),
                second=dt.getSeconds();
            String(month).length<2?(month='0'+month):month;
            String(day).length<2?(day='0'+day):day;
            String(hour).length<2?(hour='0'+hour):hour;
            String(min).length<2?(min='0'+min):min;
            String(second).length<2?(second='0'+second):second;

            document.getElementById("timeshow").innerHTML =  year+"年"+month+'月'+day+'日 '+hour+":"+min+":"+second;
            setTimeout(timeshow,1000); //设定定时器，循环执行
        }
    </script>

@endsection