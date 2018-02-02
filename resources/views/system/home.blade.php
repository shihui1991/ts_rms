{{-- 继承基础模板 --}}
@extends('system.public.base')

{{-- public_head --}}
@section('public_head')
    <script src="{{asset('system/js/htglxt.js')}}" type="text/javascript" charset="utf-8"></script>
@endsection

<body style="min-width: 1000px;">
<!--头部-->
<div class="header w_100 bg_black">
    <img class="h50 mt10 ml10" src="img/logo.png"/>
    <ul class="fr f12 nav">
        <li>
            <a href="index.html">
                <img src="img/n1.png"/>
                系统首页
            </a>
        </li>
        <li>
            <a href="javascript:void(0)">
                <img src="img/n7.png"/>
                快捷导航
            </a>
            <div class="navPopup bg_black">
                <i></i>
                <ul>
                    <li>
                        <img src="img/email_trace.png"/>
                        快捷导航
                    </li>
                    <li>
                        <img src="img/email_trace.png"/>
                        快捷导航
                    </li>
                    <li>
                        <img src="img/email_trace.png"/>
                        快捷导航
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <a href="javascript:void(0)">
                <img src="img/n3.png"/>
                帮助中心
            </a>
            <div class="navPopup bg_black">
                <i></i>
                <ul>
                    <li>
                        <img src="img/email_trace.png"/>
                        帮助中啊啊啊
                    </li>
                    <li>
                        <img src="img/email_trace.png"/>
                        快捷导航
                    </li>
                    <li>
                        <img src="img/email_trace.png"/>
                        快捷导航
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <a href="javascript:void(0)">
                <img src="img/n2.png"/>
                切换皮肤
            </a>
        </li>
        <li>
            <a href="javascript:void(0)">
                <img src="img/n5.png"/>
                个人中心
            </a>
        </li>
        <li>
            <a href="javascript:void(0)">
                <img src="img/n4.png"/>
                安全退出
            </a>
        </li>
    </ul>
</div>
<!--tab导航-->
<div class="tabHeader ov bg_f5">
    <div class="fl left f12 tc">2017年02月08日 12:22:36</div>
    <div class="ov h_100">
        <ul class="tabNav h30 mt5 f12 fl">
            <li class="on" data-tit="欢迎首页" onmousedown="tabManage(this,event)">
                <img src="img/house.png"/>
                欢迎首页
            </li>
        </ul>
        <ul class="clickRight bg_f">
            <li onclick="refreshIframe()">刷新当前</li>
            <li onclick="closeIframe()">关闭当前</li>
            <li onclick="closeIframeAll()">全部关闭</li>
            <li onclick="closeIframeAllOne()">除此之外全部关闭</li>
            <li onclick="close_clickRight()">退出</li>
        </ul>
    </div>
</div>
<!--主体内容-->
<div class="content bg_f5">
    <!--左边导航-->
    <div class="leftNav ov">
        <!--一级导航-->
        <ul class="leftNav_1 ov f12">
            <li class="open" onclick="leftNavToggle(this)">
                <div class="link">
                    <img src="img/widgets.png"/>
                    系统管理
                    <i></i>
                </div>
                <!--二级导航-->
                <ul class="leftNav_2 bg_f">
                    <li data-tit="系统日志" data-src="" onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            系统日志
                        </div>
                    </li>
                    <li data-tit="菜单管理" data-src="{{route('sys_menu_all')}}" onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            菜单管理
                        </div>
                    </li>
                    <li data-tit="表单样式" data-src="bdys" onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            表单样式
                        </div>
                    </li>
                    <li data-tit="测试页面3" data-src="iframe3" onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            测试页面3
                        </div>
                    </li>
                    <li data-tit="测试页面4" data-src="iframe4" onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            测试页面4
                        </div>
                    </li>
                </ul>
            </li>
            <li onclick="leftNavToggle(this)">
                <div class="link">
                    <img src="img/setting_tools.png"/>
                    基础资料
                    <i></i>
                </div>
                <ul class="leftNav_2 bg_f">
                    <li onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            二级导航
                        </div>
                    </li>
                    <li onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            基础资料
                        </div>
                    </li>
                    <li data-tit="测试页面6" data-src="iframe6" onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            测试页面6
                        </div>
                    </li>
                    <li onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            二级导航
                        </div>
                    </li>
                </ul>
            </li>
            <li onclick="leftNavToggle(this)">
                <div class="link">
                    <img src="img/add_on.png"/>
                    流程管理
                    <i></i>
                </div>
                <ul class="leftNav_2 bg_f">
                    <li data-tit="测试页面5" data-src="iframe5" onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            测试页面5
                        </div>
                    </li>
                    <li onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            二级导航
                        </div>
                    </li>
                    <li onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            流程管理
                        </div>
                    </li>
                    <li onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            二级导航
                        </div>
                    </li>
                </ul>
            </li>
            <li onclick="leftNavToggle(this)">
                <div class="link">
                    <img src="img/chart_bar_link.png"/>
                    业务报表
                    <i></i>
                </div>
                <ul class="leftNav_2 bg_f">
                    <li onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            二级导航
                        </div>
                    </li>
                    <li onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            业务报表
                        </div>
                    </li>
                    <li onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            二级导航
                        </div>
                    </li>
                    <li onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            二级导航
                        </div>
                    </li>
                </ul>
            </li>
            <li onclick="leftNavToggle(this)">
                <div class="link">
                    <img src="img/insert_element.png"/>
                    案例模块
                    <i></i>
                </div>
                <ul class="leftNav_2 bg_f">
                    <li onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            二级导航
                        </div>
                    </li>
                    <li onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            案例模块
                        </div>
                    </li>
                    <li onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            二级导航
                        </div>
                    </li>
                    <li onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            二级导航
                        </div>
                    </li>
                </ul>
            </li>
            <li onclick="leftNavToggle(this)">
                <div class="link">
                    <img src="img/small_business.png"/>
                    第三方控件整合
                    <i></i>
                </div>
                <ul class="leftNav_2 bg_f">
                    <li onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            第三方控件整合
                        </div>
                    </li>
                    <li onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            二级导航
                        </div>
                    </li>
                    <li onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            二级导航
                        </div>
                    </li>
                    <li onclick="leftSubNavManage(this,event)">
                        <div class="link">
                            <img src="img/monitor_window_3d.png"/>
                            二级导航
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!--iframe-->
    <div class="rightIframe">
        <div class="rightIframeCon">
            <iframe src="{{url('welcome')}}" class="iframe homeIframe on"></iframe>
        </div>
    </div>
</div>
<!--底部-->
<div class="footer f12 cr_f h25 lh25 w_100 bg_black ov">
    <div class="pd0_5">技术支持：步联科技有限公司</div>
    <div class="tc">CopyRight © 2010 - @php echo date('Y'); @endphp By Bulian</div>
    <div class="ov right">
        <a href="javascript:void(0)">
            <img src="img/bottom_icon_usergroup.png"/>
        </a>
        <a href="javascript:void(0)">
            <img src="img/youjian.png"/>
        </a>
        <a href="javascript:void(0)">
            <img src="img/bottom_icon_message.png"/>
        </a>
        <a href="javascript:void(0)">
            <img src="img/bottom_icon_userinfo.png"/>
        </a>
    </div>
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
    </script>
@endsection
</body>