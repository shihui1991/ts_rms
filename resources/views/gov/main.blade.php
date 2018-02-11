{{-- 继承布局 --}}
@extends('gov.layout')


{{-- 头部工具 --}}
@section('header_tools')

    @foreach($top_menus as $top_menu)
        <li>
            <a href="{{$top_menu->url}}">
                @if($loop->iteration ==1) {!! $top_menu->icon !!} @endif
                {{$top_menu->name}}
            </a>
        </li>
    @endforeach

    @parent

@endsection


{{-- 导航头部提示 --}}
@section('shortcuts')

@endsection

{{-- 侧边导航 --}}
@section('nav')

   {!! $nav_menus !!}

@endsection

{{-- 面包屑 --}}
@section('breadcrumbs')

    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-location-arrow home-icon"></i>
                <a href="{{route('g_home')}}">征收管理端</a>
            </li>

            @if(count($parents_menus))
                @foreach($parents_menus as $parents_menu)
                    <li>{{$parents_menu->name}}</li>
                @endforeach
            @endif

            <li class="active">{{$current_menu->name}}</li>
        </ul><!-- /.breadcrumb -->

    </div>


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
    @parent

    <script>
        // 导航栏 调整
        var nav_li_list=$('ul.nav.nav-list').find('li.active.open');
        if(nav_li_list.length>0){
            $.each(nav_li_list,function (index,nav_obj) {
                var child_li_list=$(nav_obj).find('li');
                if(child_li_list.length==0){
                    $(nav_obj).removeClass('open');
                }
            })
        }
    </script>

@endsection