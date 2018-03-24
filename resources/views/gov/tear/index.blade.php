{{-- 继承aceAdmin后台布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    @if(filled($sdata['tear']))
    <div class="well">
        <a href="{{route('g_tear_detail_add',['item'=>$sdata['item']->id,'tear_id'=>$sdata['tear']->id])}}" class="btn">添加拆除记录</a>
    </div>

    <div class="widget-container-col ui-sortable">
        <div class="widget-box ui-sortable-handle">
            <div class="widget-header">
                <h5 class="widget-title">拆除委托</h5>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>

                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <div class="user-profile row">
                        <div class="profile-user-info profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> 委托时间： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['tear']->sign_at}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 状态： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['tear']->state->name}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 委托合同： </div>
                                <div class="profile-info-value">
                                    <ul class="ace-thumbnails clearfix img-content">
                                        @foreach($sdata['tear']->picture as $pic)
                                            <li>
                                                <div>
                                                    <img width="120" height="120" src="{{$pic}}" alt="加载失败">
                                                    <div class="text">
                                                        <div class="inner">
                                                            <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            @foreach($sdata['tear']->teardetails as $infos)
                <div class="col-xs-6 col-sm-3 pricing-box">
                    <div class="widget-box widget-color-dark">
                        <div class="widget-header">
                            <h5 class="widget-title bigger lighter">{{$infos->tear_at}}</h5>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main">
                                <ul class="ace-thumbnails clearfix img-content">
                                    @foreach($infos->picture as $pic)
                                        <li>
                                            <div>
                                                <img width="120" height="120" src="{{$pic}}" alt="加载失败">
                                                <div class="text">
                                                    <div class="inner">
                                                        <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @else

        <div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert">
                <i class="ace-icon fa fa-times"></i>
            </button>
            <strong>
                <i class="ace-icon fa fa-exclamation-circle"></i>
            </strong>
            <strong class="resp-error">
                注意：还未添加拆除委托！
                <i class="fa fa-hand-o-right"></i>
                <a href="{{route('g_tear_add',['item'=>$sdata['item']->id])}}">去添加</a>
            </strong>

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