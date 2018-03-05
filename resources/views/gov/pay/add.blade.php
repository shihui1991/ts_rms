{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <div class="widget-container-col ui-sortable">
        <div class="widget-box ui-sortable-handle">
            <div class="widget-header">
                <h5 class="widget-title">被征收户</h5>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <div class="profile-user-info profile-user-info-striped">

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 项目： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata['item']->name}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 地址： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata['household']->itemland->address}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 房号： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">
                                    {{$sdata['household']->itembuilding->building}}栋{{$sdata['household']->unit}}单元{{$sdata['household']->floor}}楼{{$sdata['household']->number}}@if(is_numeric($sdata['household']->floor))号@endif
                                </span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 类型： </div>
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

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="widget-container-col ui-sortable">
        <div class="widget-box ui-sortable-handle">
            <div class="widget-header">
                <h5 class="widget-title">补偿决定</h5>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    <form class="form-horizontal" role="form" action="{{route('g_pay_add',['item'=>$sdata['item']->id])}}" method="post">
                        {{csrf_field()}}

                        <input type="hidden" name="household_id" value="{{$sdata['household']->id}}">
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="repay_way"> 补偿方式： </label>
                            <div class="col-sm-9 radio">
                                @foreach($edata->repay_way as $key => $value)
                                    <label>
                                        <input name="repay_way" type="radio" class="ace" value="{{$key}}" @if($key==0) checked @endif >
                                        <span class="lbl">{{$value}}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="transit_way"> 过渡方式： </label>
                            <div class="col-sm-9 radio">
                                @foreach($edata->transit_way as $key => $value)
                                    <label>
                                        <input name="transit_way" type="radio" class="ace" value="{{$key}}" @if($key==0) checked @endif >
                                        <span class="lbl">{{$value}}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="move_way"> 搬迁方式： </label>
                            <div class="col-sm-9 radio">
                                @foreach($edata->move_way as $key => $value)
                                    <label>
                                        <input name="move_way" type="radio" class="ace" value="{{$key}}" @if($key==0) checked @endif >
                                        <span class="lbl">{{$value}}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group img-box">
                            <label class="col-sm-3 control-label no-padding-right">
                                征收决定<br>
                                <span class="btn btn-xs">
                                            <span>上传图片</span>
                                            <input type="file" accept="image/*" class="hidden" data-name="picture[]" multiple onchange="uplfile(this)">
                                        </span>
                            </label>
                            <div class="col-sm-9">
                                <ul class="ace-thumbnails clearfix img-content">


                                </ul>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn btn-info" type="button" onclick="sub(this)">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    保存
                                </button>
                                &nbsp;&nbsp;&nbsp;
                                <button class="btn" type="reset">
                                    <i class="ace-icon fa fa-undo bigger-110"></i>
                                    重置
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
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
    <script src="{{asset('viewer/viewer.min.js')}}"></script>

@endsection