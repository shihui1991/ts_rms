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
    @parent

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

@endsection