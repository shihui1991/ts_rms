{{-- 继承基础模板 --}}
@extends('system.public.base')

{{-- public_head --}}
@section('public_head')

@endsection

{{-- 布局 --}}
<body class="login" style="min-width: 1000px;background-color: #2e3e4e;">
    <div class="logo" style="color: white;font-size: 36px;letter-spacing: 10px;">
        <img  src="{{asset('system/img/logo_nobg1.png')}}"/><span style="width: 20px;height: 60px;display: inline-block;"></span>房屋征收管理系统
    </div>
    <div class="con">
        <form action="{{route('sys_login')}}" method="post">
        <div class="input">
            <div class="item">
                账户<input type="text" name="username"  value="" placeholder="请输入用户名" />
            </div>
            <div class="item">
                密码<input type="password" name="password"  value="" placeholder="请输入密码"  />
            </div>
            <a class="btn js-ajax-login" onclick="login(this)"></a>
        </div>
        </form>
    </div>
    <p class="cr_f tc">适用浏览器：IE9以上、360、FireFox、Chrome、Safari、Opera、傲游、搜狗、世界之窗.</p>
    <div class="foot">
        重庆步联科技有限公司出品
        <br>
        官方网站：http://www.bulian.cn/
    </div>

{{-- js --}}
@section('js')
    <script type="text/javascript" src="{{asset('js/common.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function login(obj) {
            ajaxFormSub(obj);
            console.log(ajaxResp);
            if(ajaxResp.code == 'success'){
                toastr.success(ajaxResp.message);
                location.href=ajaxResp.url;
            }
            if(ajaxResp.code == 'error'){
                toastr.error(ajaxResp.message);
            }

        }
        if (window.parent !== window.self) {
            document.write = '';
            window.parent.location.href = window.self.location.href;
            setTimeout(function () {
                document.body.innerHTML = '';
            },0);
        }
        $('#username').focus();
        $(document).on('keydown',function (e) {
            if (!e) e = window.event; //火狐中是 window.event
            if ((e.keyCode || e.which) == 13) {
                $('.js-ajax-login').click();
            }
        });
    </script>
@endsection
</body>