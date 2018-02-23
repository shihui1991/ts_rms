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

    <h3 class="header smaller lighter blue">
        <i class="ace-icon fa fa-bullhorn"></i>
        工作提醒
    </h3>
    <div class="tabbable">
        <ul class="nav nav-tabs padding-12 tab-color-blue background-blue">
            <li class="active">
                <a data-toggle="tab" href="#new" aria-expanded="true">最新提醒</a>
            </li>

            @foreach($sdata['schedules'] as $schedule)
                <li class="">
                    <a data-toggle="tab" href="#schedule{{$schedule->id}}" aria-expanded="false">{{$schedule->name}}</a>
                </li>
            @endforeach

        </ul>

        <div class="tab-content">
            <div id="new" class="tab-pane active">
                @foreach($sdata['worknotices'] as $worknotice)
                    <p>
                        {{$loop->iteration}}、{{$worknotice->created_at}}，【{{$worknotice->item->name}}】 【{{$worknotice->schedule->name}}】 【{{$worknotice->process->name}}】。
                        <a href="{{$worknotice->url}}">前往处理 &nbsp;<i class="ace-icon fa fa-angle-double-right"></i></a>
                    </p>
                @endforeach
            </div>

            @foreach($sdata['schedules'] as $schedule)
                <div id="schedule{{$schedule->id}}" class="tab-pane">
                    @foreach($sdata['worknotices'] as $worknotice)
                        @if($worknotice->schedule_id==$schedule->id)
                            <p>
                                {{$loop->iteration}}、{{$worknotice->created_at}}，【{{$worknotice->item->name}}】 【{{$worknotice->schedule->name}}】 【{{$worknotice->process->name}}】。
                                <a href="{{$worknotice->url}}">前往处理 &nbsp;<i class="ace-icon fa fa-angle-double-right"></i></a>
                            </p>
                        @endif

                    @endforeach
                </div>
            @endforeach

        </div>
    </div>

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