<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
    <title>@yield('title')</title>

    {{--  csrf令牌 --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    {{--<link href="{{asset('bootstrap-3.3.7/css/bootstrap.min.css')}}" rel="stylesheet">--}}
    {{--<link href="{{asset('bootstrap-3.3.7/css/bootstrap-theme.min.css')}}" rel="stylesheet">--}}

    <link href="{{asset('toastr/toastr.min.css')}}" rel="stylesheet">
    <!-- css -->
    <link rel="stylesheet" type="text/css" href="{{asset('system/css/style.css')}}"/>
    @yield('public_head')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{asset('js/html5shiv.min.js')}}"></script>
    <script src="{{asset('js/respond.min.js')}}"></script>
    <![endif]-->
</head>
<body>
@yield('body')

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

<!--[if !IE]> -->
<script src="{{asset('js/jquery-2.1.4.min.js')}}"></script>

<!-- <![endif]-->

<!--[if IE]>
<script src="{{asset('js/jquery-1.11.3.min.js')}}"></script>
<![endif]-->

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{asset('bootstrap-3.3.7/js/bootstrap.min.js')}}"></script>

<script src="{{asset('toastr/toastr.min.js')}}"></script>
<script src="{{asset('js/chosen.jquery.min.js')}}"></script>
<script src="{{asset('js/common.js')}}"></script>

{{-- 核心文件 --}}
<script src="{{asset('system/layer/layer.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset('system/js/iframe.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset('system/js/htglxt.js')}}" type="text/javascript" charset="utf-8"></script>

<link rel="stylesheet" href="{{asset('system/css/chosen.css')}}" charset="utf-8">
<script src="{{asset('system/js/chosen.jquery.js')}}" type="text/javascript" charset="utf-8"></script>

<script src="{{asset('system/js/datejs/laydate.js')}}" type="text/javascript" charset="utf-8"></script>


<script>
    $(function () {
        /*----- 选择框 -----*/
        $('.chosen').chosen();
        /*----- 时间控件 -----*/
        laydate.skin('dahong');//切换皮肤，请查看skins下面皮肤库
        $('.laydate-icon').click(function () {
            var _this=$(this);
            var _time=_this.data('istime');
            var _format=_this.data('format');
            _time=_time?true:false;
            _format=_format?_format:'YYYY-MM-DD';
            laydate({
                istime: _time,
                format: _format
            });
        });
    });
</script>

@yield('js')

</body>
</html>