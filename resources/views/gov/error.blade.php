{{-- 继承aceAdmin后台布局 --}}
@extends('gov.layout')

{{-- 导航头部提示 --}}
@section('shortcuts')

    <span id="timeshow"></span>

@endsection


{{-- 页面内容 --}}
@section('content')

    <div class="error-container">
        <div class="well">
            <h1 class="grey lighter smaller">
                <span class="blue bigger-125">
                    <i class="fa fa-spinner fa-spin fa-pulse"></i>
                    404
                </span>
                抱歉：
            </h1>

            <hr />

            @if(count($errors))
                @foreach($errors->all() as $error)
                    <h3 class="lighter smaller">{{$error}}</h3>
                @endforeach
            @endif

            @if(session()->has('error'))
                <h3 class="lighter smaller">{{session()->get('error')}}</h3>
            @endif

            <hr />
            <div class="space"></div>

            <div class="center">
                <a href="javascript:history.back()" class="btn btn-grey">
                    <i class="ace-icon fa fa-arrow-left"></i>
                    返回
                </a>

                <a href="{{route('g_home')}}" class="btn btn-primary">
                    <i class="ace-icon fa fa-home"></i>
                    回到首页
                </a>
            </div>
        </div>
    </div>

@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')

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