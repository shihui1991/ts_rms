{{-- 继承主体 --}}
@extends('com.main')

{{-- 页面内容 --}}
@section('content')
    <div class="well well-sm">
        <a href="{{route('c_compublic_add',['item'=>$edata['item_id']])}}" class="btn">评估公共附属物</a>
    </div>
    <div class="row">
        <div class="col-xs-12">
            @if($code=='success')
                @foreach($sdata as $infos)
                    <div class="col-xs-6 col-sm-3 pricing-box">
                        <div class="widget-box widget-color-dark">
                            <div class="widget-header">
                                <h5 class="widget-title bigger lighter">{{$infos->company->name}}</h5>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">

                                    <div class="profile-user-info profile-user-info-striped">

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 评估总价： </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{$infos->total}}</span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 评估报告： </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">
                                                    <ul class="ace-thumbnails clearfix img-content viewer">
                                                          @if(isset($infos->picture))
                                                            @foreach($infos->picture as $pic)
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
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div>
                                    <a href="{{route('c_compublic_edit',['id'=>$infos->id,'item'=>$infos->item_id])}}" class="btn btn-block btn-inverse">
                                        <span>评估详情</span>
                                        <i class="ace-icon fa fa-chevron-circle-right bigger-110"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @endif
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