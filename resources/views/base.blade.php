<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    {{--  csrf令牌 --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link href="{{asset('bootstrap-3.3.7/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('bootstrap-3.3.7/css/bootstrap-theme.min.css')}}" rel="stylesheet">

    <link href="{{asset('toastr/toastr.min.css')}}" rel="stylesheet">

    @yield('css')

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

@yield('js')

</body>
</html>