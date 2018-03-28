{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>

    </p>


    <h3 class="header smaller lighter blue">
        <i class="ace-icon fa fa-bullhorn"></i>
        地块户型-测绘报告详情
    </h3>

    <div class="profile-user-info profile-user-info-striped">
        <div class="profile-info-row">
            <div class="profile-info-name"> 【摸底详情】 </div>
            <div class="profile-info-value">

            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name"> 地块： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata['landlayout']->itemland->address}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name"> 名称： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata['landlayout']->name}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name"> 征收端-户型图： </div>
            <div class="profile-info-value">
                <ul class="ace-thumbnails clearfix img-content viewer">
                    @if(filled($sdata['landlayout']->gov_img))
                        @foreach($sdata['landlayout']->gov_img as $pic)
                            <li>
                                <div>
                                    <img width="120" height="120" src="{!! $pic !!}" alt="加载失败">
                                    <div class="text">
                                        <div class="inner">
                                            <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name"> 评估端-户型图： </div>
            <div class="profile-info-value">
                <ul class="ace-thumbnails clearfix img-content viewer">
                    @if(filled($sdata['landlayout']->com_img))
                        @foreach($sdata['landlayout']->com_img as $pics)
                            <li>
                                <div>
                                    <img width="120" height="120" src="{!! $pics !!}" alt="加载失败">
                                    <div class="text">
                                        <div class="inner">
                                            <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name"> 创建时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata['landlayout']->created_at}}</span>
            </div>
        </div>
        <br/>

        <div class="profile-info-row">
            <div class="profile-info-name"> 【报告详情】 </div>
            <div class="profile-info-value">

            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name"> 面积： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata['landlayout']->area}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name"> 测绘报告： </div>
            <div class="profile-info-value">
                <ul class="ace-thumbnails clearfix img-content viewer">
                    @if(filled($sdata['landlayout']->picture))
                        @foreach($sdata['landlayout']->picture as $pic)
                            <li>
                                <div>
                                    <img width="120" height="120" src="{!! $pic !!}" alt="加载失败">
                                    <div class="text">
                                        <div class="inner">
                                            <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 更新时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata['landlayout']->updated_at}}</span>
            </div>
        </div>

    </div>

@endsection

{{-- 样式 --}}
@section('css')
    <link rel="stylesheet" href="{{asset('viewer/viewer.min.css')}}" />
@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script src="{{asset('js/func.js')}}"></script>
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script>
        $('.img-content').viewer('update');
    </script>
@endsection