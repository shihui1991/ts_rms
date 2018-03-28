{{-- 继承aceAdmin后台布局 --}}
@extends('ace_admin')

{{-- 标题 --}}
@section('title')
    被征收户端
@endsection

{{-- 客户端 --}}
@section('client')
    被征收户端
@endsection


{{-- 头部工具 --}}
@section('header_tools')

@endsection


{{-- 用户名 --}}
@section('username')

    {{session('household_user.user_name')}}

@endsection

{{-- 用户工具 --}}
@section('user_tools')

    <li class="divider"></li>

    <li>
        <a href="{{route('h_logout')}}">
            <i class="ace-icon fa fa-power-off"></i>
            退出登录
        </a>
    </li>

@endsection

{{-- 导航头部提示 --}}
@section('shortcuts')
    <span id="timeshow"></span>
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
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{route('h_home')}}">被征户端</a>
            </li>

            @if(count($parents_menus))
                @foreach($parents_menus as $parents_menu)
                    <li>
                        <a href="{{$parents_menu->url}}">{{$parents_menu->name}}</a>
                    </li>
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
    @isset($code)
        @switch($code)
            @case('error')
            <script>
                toastr.error('{{$message}}');
            </script>
            @break

            @case('success')
            <script>
                toastr.success('{{$message}}');
            </script>
            @break

            @case('info')
            <script>
                toastr.info('{{$message}}');
            </script>
            @break

            @case('warning')
            <script>
                toastr.warning('{{$message}}');
            </script>
            @break

        @endswitch
    @endisset
    <script>


        // 导航栏 调整
        var nav_li_list = $('ul.nav.nav-list').find('li.active.open');
        if (nav_li_list.length > 0) {
            $.each(nav_li_list, function (index, nav_obj) {
                var child_li_list = $(nav_obj).find('li');
                if (child_li_list.length == 0) {
                    $(nav_obj).removeClass('open');
                }
            })
        }

        timeshow();

        function timeshow() {
            dt = new Date();
            var year = dt.getFullYear(),
                month = dt.getMonth() + 1,
                day = dt.getDate(),
                hour = dt.getHours(),
                min = dt.getMinutes(),
                second = dt.getSeconds();
            String(month).length < 2 ? (month = '0' + month) : month;
            String(day).length < 2 ? (day = '0' + day) : day;
            String(hour).length < 2 ? (hour = '0' + hour) : hour;
            String(min).length < 2 ? (min = '0' + min) : min;
            String(second).length < 2 ? (second = '0' + second) : second;

            document.getElementById("timeshow").innerHTML = year + "年" + month + '月' + day + '日 ' + hour + ":" + min + ":" + second;
            setTimeout(timeshow, 1000); //设定定时器，循环执行
        }
    </script>
@endsection