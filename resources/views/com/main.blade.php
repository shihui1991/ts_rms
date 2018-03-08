{{-- 继承布局 --}}
@extends('com.layout')


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

    @isset($item)
        {{$item->name}}
    @else
        <span id="timeshow"></span>
    @endisset

@endsection

{{-- 侧边导航 --}}
@section('nav')

    {!! $nav !!}

@endsection


{{-- 面包屑 --}}
@section('breadcrumbs')

    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-location-arrow home-icon"></i>
                <a href="{{route('c_home')}}">评估机构端</a>
            </li>


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

    @isset($item)

    @else
        <script>
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
    @endisset

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