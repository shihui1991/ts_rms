{{-- 继承aceAdmin后台布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    @if(filled($sdata['init_budget']))

        <div class="profile-user-info profile-user-info-striped">

            <div class="profile-info-row">
                <div class="profile-info-name"> 征收范围： </div>
                <div class="profile-info-value">
                    <span class="editable editable-click">{{$sdata['item']->place}}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> 预计户数： </div>
                <div class="profile-info-value">
                    <span class="editable editable-click">{{number_format($sdata['init_budget']->holder)}}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> 预算总金额： </div>
                <div class="profile-info-value">
                    <span class="editable editable-click">{{number_format($sdata['init_budget']->money,2)}}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> 预备房源数： </div>
                <div class="profile-info-value">
                    <span class="editable editable-click">{{number_format($sdata['init_budget']->house)}}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> 预算报告： </div>
                <div class="profile-info-value">
                <p class="editable editable-click">
                <ul class="ace-thumbnails clearfix img-content">
                    @foreach($sdata['init_budget']->picture as $pic)
                        <li>
                        <div>
                            <img width="120" height="120" src="{{$pic}}" alt="{{$pic}}">
                            <div class="text">
                                <div class="inner">
                                    <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                </div>
                            </div>
                        </div>
                        </li>

                    @endforeach

                </ul>
                </p>
                </div>
            </div>

            @if(filled($sdata['item_notice']))
                <div class="profile-info-row">
                    <div class="profile-info-name"> 摘要： </div>
                    <div class="profile-info-value">
                        <span class="editable editable-click">{{$sdata['item_notice']->infos}}</span>
                    </div>
                </div>

                <div class="profile-info-row">
                    <div class="profile-info-name"> 预算通知： </div>
                    <div class="profile-info-value">
                        <p class="editable editable-click">
                        <ul class="ace-thumbnails clearfix img-content">
                            @foreach($sdata['item_notice']->picture as $pic)
                                <li>
                                    <div>
                                        <img width="120" height="120" src="{{$pic}}" alt="{{$pic}}">
                                        <div class="text">
                                            <div class="inner">
                                                <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                            @endforeach

                        </ul>
                        </p>
                    </div>
                </div>
            @else

                <div class="alert alert-warning">
                    <strong>注意：</strong>
                    还未提交房屋征收补偿资金总额预算通知！
                    &nbsp;&nbsp;&nbsp;
                    <i class="fa fa-hand-o-right"></i>
                    <a href="{{route('g_initbudget_add',['item'=>$sdata['item']->id])}}">去添加</a>
                    <br>
                </div>
            @endif


        </div>

    @else

        <div class="alert alert-warning">
            <strong>注意：</strong>
            还未提交预算报告！
            &nbsp;&nbsp;&nbsp;
            <i class="fa fa-hand-o-right"></i>
            <a href="{{route('g_initbudget_add',['item'=>$sdata['item']->id])}}">去添加</a>
            <br>
        </div>

    @endif



@endsection

{{-- 样式 --}}
@section('css')

    <link rel="stylesheet" href="{{asset('viewer/viewer.min.css')}}" />

@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script>
        $('.img-content').viewer();
    </script>

@endsection