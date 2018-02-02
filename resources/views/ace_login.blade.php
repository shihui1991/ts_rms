<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>@yield('title') - 房屋征收管理系统</title>
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
    <meta name="description" content="房屋征收管理系统" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    {{--  csrf令牌 --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="{{asset('bootstrap-3.3.7/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('font-awesome-4.7.0/css/font-awesome.min.css')}}" />

    <!-- page specific plugin styles -->

    <!-- text fonts -->
    <link rel="stylesheet" href="{{asset('aceadmin/css/fonts.googleapis.com.css')}}" />

    <!-- ace styles -->
    <link rel="stylesheet" href="{{asset('aceadmin/css/ace.min.css')}}" class="ace-main-stylesheet" id="main-ace-style" />

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="{{asset('aceadmin/css/ace-part2.min.css')}}" class="ace-main-stylesheet" />
    <![endif]-->
    <link rel="stylesheet" href="{{asset('aceadmin/css/ace-skins.min.css')}}" />
    <link rel="stylesheet" href="{{asset('aceadmin/css/ace-rtl.min.css')}}" />

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="{{asset('aceadmin/css/ace-ie.min.css')}}" />
    <![endif]-->

    <!-- inline styles related to this page -->
    <link rel="stylesheet" href="{{asset('toastr/toastr.min.css')}}" />
    @yield('css')

    <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

    <!--[if lte IE 8]>
    <script src="{{asset('js/html5shiv.min.js')}}"></script>
    <script src="{{asset('js/respond.min.js')}}"></script>
    <![endif]-->
</head>

<body class="login-layout blur-login">
<div class="main-container">
    <div class="main-content">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="login-container">
                    <div class="center">
                        <h1>
                            <img src="{{asset('img/logo_47.png')}}">
                            <span class="white" id="id-text2">@yield('client')</span>
                        </h1>
                        <h4 class="light-blue" id="id-company-text">&copy; 房屋征收管理系统</h4>
                    </div>

                    <div class="space-6"></div>

                    <div class="position-relative">
                        <div id="login-box" class="login-box visible widget-box no-border">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <h4 class="header blue lighter bigger">
                                        <i class="ace-icon fa fa-coffee green"></i>
                                        请登录
                                    </h4>

                                    <div class="space-6"></div>

                                    <form action="@yield('login_url')" method="post" >
                                        {{csrf_field()}}
                                        <fieldset>
                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="text" class="form-control" placeholder="用户名" name="username" id="username" />
                                                    <i class="ace-icon fa fa-user"></i>
                                                </span>
                                            </label>

                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="password" class="form-control" placeholder="密码" name="password" />
                                                    <i class="ace-icon fa fa-lock"></i>
                                                </span>
                                            </label>

                                            @yield('more_field')

                                            <div class="space"></div>

                                            <div class="clearfix">
                                                <button type="button" class="width-35 pull-right btn btn-sm btn-primary" onclick="login(this)">
                                                    <i class="ace-icon fa fa-key"></i>
                                                    <span class="bigger-110">立即登录</span>
                                                </button>
                                            </div>

                                            <div class="space-4"></div>
                                        </fieldset>
                                    </form>
                                    <div class="space-6"></div>
                                </div><!-- /.widget-main -->

                            </div><!-- /.widget-body -->
                        </div><!-- /.login-box -->
                    </div><!-- /.position-relative -->

                    <div class="navbar-fixed-top align-right">
                        <br />
                        &nbsp;
                        <a id="btn-login-dark" href="#">科技黑</a>
                        &nbsp;
                        <span class="blue">/</span>
                        &nbsp;
                        <a id="btn-login-blur" href="#">夜光蓝</a>
                        &nbsp;
                        <span class="blue">/</span>
                        &nbsp;
                        <a id="btn-login-light" href="#">明亮白</a>
                        &nbsp; &nbsp; &nbsp;
                    </div>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.main-content -->
</div><!-- /.main-container -->

<!-- basic scripts -->

<!--[if !IE]> -->
<script src="{{asset('js/jquery-2.1.4.min.js')}}"></script>

<!-- <![endif]-->

<!--[if IE]>
<script src="{{asset('js/jquery-1.11.3.min.js')}}"></script>
<![endif]-->
<script type="text/javascript">
    if('ontouchstart' in document.documentElement) document.write("<script src='{{asset('js/jquery.mobile.custom.min.js')}}'>"+"<"+"/script>");
</script>
<script src="{{asset('bootstrap-3.3.7/js/bootstrap.min.js')}}"></script>

<!-- inline scripts related to this page -->
<script src="{{asset('toastr/toastr.min.js')}}"></script>
<script src="{{asset('js/common.js')}}"></script>
<script src="{{asset('js/config.js')}}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //you don't need this, just used for changing background
    jQuery(function($) {
        $('#btn-login-dark').on('click', function(e) {
            $('body').attr('class', 'login-layout');
            $('#id-text2').attr('class', 'white');
            $('#id-company-text').attr('class', 'blue');

            e.preventDefault();
        });
        $('#btn-login-light').on('click', function(e) {
            $('body').attr('class', 'login-layout light-login');
            $('#id-text2').attr('class', 'grey');
            $('#id-company-text').attr('class', 'blue');

            e.preventDefault();
        });
        $('#btn-login-blur').on('click', function(e) {
            $('body').attr('class', 'login-layout blur-login');
            $('#id-text2').attr('class', 'white');
            $('#id-company-text').attr('class', 'light-blue');

            e.preventDefault();
        });

    });


    if (window.parent !== window.self) {
        document.write = '';
        window.parent.location.href = window.self.location.href;
        setTimeout(function () {
            document.body.innerHTML = '';
        },0);
    }
    $('#username').focus();

</script>


@yield('js')
</body>
</html>
