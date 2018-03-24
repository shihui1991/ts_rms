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


    <form class="form-horizontal" role="form" action="{{route('g_resettle_edit',['item'=>$sdata['item']->id])}}" method="post">
        {{csrf_field()}}

        <input type="hidden" name="id" value="{{$sdata['house_resettle']->id}}">
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="settle_at"> 安置日期： </label>
            <div class="col-sm-9">
                <input type="text" id="settle_at" name="settle_at" value="{{$sdata['house_resettle']->settle_at}}" class="col-xs-10 col-sm-5 laydate"  required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="hold_at"> 产权调换日期： </label>
            <div class="col-sm-9">
                <input type="text" id="hold_at" name="hold_at" value="{{$sdata['house_resettle']->hold_at}}" class="col-xs-10 col-sm-5 laydate">
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="end_at"> 完成日期： </label>
            <div class="col-sm-9">
                <input type="text" id="end_at" name="end_at" value="{{$sdata['house_resettle']->end_at}}" class="col-xs-10 col-sm-5 laydate">
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="register"> 新证件号： </label>
            <div class="col-sm-9">
                <input type="text" id="register" name="register" value="{{$sdata['house_resettle']->register}}" class="col-xs-10 col-sm-5">
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group img-box">
            <label class="col-sm-3 control-label no-padding-right">
                证件：<br>
                <span class="btn btn-xs">
                    <span>上传图片</span>
                    <input type="file" accept="image/*" class="hidden" data-name="picture[]" multiple onchange="uplfile(this)">
                </span>
            </label>
            <div class="col-sm-9">
                <ul class="ace-thumbnails clearfix img-content">
                    @if(filled($sdata['house_resettle']->picture))
                    @foreach($sdata['house_resettle']->picture as $pic)
                        <li>
                            <div>
                                <img width="120" height="120" src="{{$pic}}" alt="加载失败">
                                <input type="hidden" name="picture[]" value="{{$pic}}">
                                <div class="text">
                                    <div class="inner">
                                        <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                        <a onclick="removeimg(this)"><i class="fa fa-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                        </li>

                    @endforeach
                    @endif

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

    <div class="widget-container-col ui-sortable">
        <div class="widget-box ui-sortable-handle">
            <div class="widget-header">
                <h5 class="widget-title">房源信息</h5>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <div class="profile-user-info profile-user-info-striped">

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 房源管理： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata['house_resettle']->house->housecompany->name}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 小区： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">
                                    {{$sdata['house_resettle']->house->housecommunity->address}}
                                    {{$sdata['house_resettle']->house->housecommunity->name}}
                                </span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 房号： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">
                                    {{$sdata['house_resettle']->house->building}}栋
                                    {{$sdata['house_resettle']->house->unit}}单元
                                    {{$sdata['house_resettle']->house->floor}}楼
                                    {{$sdata['house_resettle']->house->number}}号
                                </span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 户型： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">
                                    {{$sdata['house_resettle']->house->layout->name}}
                                </span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 面积： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">
                                    {{$sdata['house_resettle']->house->area}}
                                </span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 有无电梯： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">
                                    {{$sdata['house_resettle']->house->lift}}
                                </span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 类型： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">
                                    {{$sdata['house_resettle']->house->is_real}}
                                </span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 房源状态： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">
                                    {{$sdata['house_resettle']->house->state->name}}
                                </span>
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

    <link rel="stylesheet" href="{{asset('viewer/viewer.min.css')}}" />
@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script src="{{asset('laydate/laydate.js')}}"></script>
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script>
        $('.img-content').viewer();
    </script>

@endsection