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

@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')
    @parent

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

@endsection