{{-- 继承布局 --}}
@extends('household.layout')


{{-- 页面内容 --}}
@section('content')

    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <div class="widget-container-col ui-sortable">
                <div class="widget-box ui-sortable-handle">
                    <div class="widget-header">
                        <h5 class="widget-title">评估汇总</h5>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="profile-user-info profile-user-info-striped">

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 项目：</div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['item']->name}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 地址：</div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['household']->itemland->address}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 房号：</div>
                                    <div class="profile-info-value">
                                <span class="editable editable-click">
                                    {{$sdata['household']->itembuilding->building}}栋{{$sdata['household']->unit}}
                                    单元{{$sdata['household']->floor}}
                                    楼{{$sdata['household']->number}}@if(is_numeric($sdata['household']->floor))号@endif
                                </span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 类型：</div>
                                    <div class="profile-info-value">
                                    <span class="editable editable-click">
                                        @if($sdata['household']->getOriginal('type'))
                                            公产（{{$sdata['household']->itemland->adminunit->name}}）
                                        @else
                                            私产
                                        @endif
                                    </span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 资产评估总价：</div>
                                    <div class="profile-info-value">
                                    <span class="editable editable-click">
                                            {{$sdata['assess']->assets}}
                                    </span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 房产评估总价：</div>
                                    <div class="profile-info-value">
                                    <span class="editable editable-click">
                                       {{$sdata['assess']->estate}}
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="well well-sm">
        <a href="" class="btn">
            评估明细
        </a>
    </div>
    <div class="tabbable">
        <ul class="nav nav-tabs padding-12 tab-color-blue background-blue">
            <li class="active">
                <a data-toggle="tab" href="#pay_subject" aria-expanded="true">房产评估明细</a>
            </li>

            <li class="">
                <a data-toggle="tab" href="#pay_building" aria-expanded="false">资产评估明细</a>
            </li>

        </ul>

        <div class="tab-content">
            <div id="pay_subject" class="tab-pane active">

                <div class="widget-body">
                    <div class="widget-main">
                        <div class="profile-user-info profile-user-info-striped">

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 评估公司：</div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['estate']->company->name}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 主体建筑评估总价：</div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['estate']->main_total}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 附属物评估总价：</div>
                                <div class="profile-info-value">
                                <span class="editable editable-click">
                                    {{$sdata['estate']->tag_total}}
                                </span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 房产评估总价：</div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">
                                         {{$sdata['estate']->total}}
                                    </span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 状态：</div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">
                                            {{$sdata['estate']->state->name}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div id="pay_building" class="tab-pane">
                <div id="accordion" class="accordion-style1 panel-group">


                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="profile-user-info profile-user-info-striped">

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 评估公司：</div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['assets']->company->name}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 评估总价：</div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['assets']->total}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 状态：</div>
                                    <div class="profile-info-value">
                                <span class="editable editable-click">
                                    {{$sdata['assets']->state->name}}
                                </span>
                                    </div>
                                </div>


                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 图片：</div>
                                    <div class="profile-info-value">
                                        <div class="ace-thumbnails clearfix img-content">
                                            <ul class="ace-thumbnails clearfix img-content">
                                                @if(filled($sdata['estate']->picture))
                                                @foreach($sdata['estate']->picture as $pic)
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
                                                 @endif
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>

@endsection

{{-- 样式 --}}
@section('css')

    <link rel="stylesheet" href="{{asset('viewer/viewer.min.css')}}"/>

@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script src="{{asset('laydate/laydate.js')}}"></script>

@endsection