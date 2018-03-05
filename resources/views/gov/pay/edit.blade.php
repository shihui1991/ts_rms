{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <form class="form-horizontal" role="form" action="{{route('g_pay_edit',['item'=>$sdata['item']->id])}}" method="post">
        {{csrf_field()}}

        <input type="hidden" name="id" value="{{$sdata['pay']->id}}">
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="repay_way"> 补偿方式： </label>
            <div class="col-sm-9 radio">
                @foreach($edata->repay_way as $key => $value)
                    <label>
                        <input name="repay_way" type="radio" class="ace" value="{{$key}}" @if($value==$sdata['pay']->repay_way) checked @endif >
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
                        <input name="transit_way" type="radio" class="ace" value="{{$key}}" @if($value==$sdata['pay']->transit_way) checked @endif >
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
                        <input name="move_way" type="radio" class="ace" value="{{$key}}" @if($value==$sdata['pay']->move_way) checked @endif >
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
                    @foreach($sdata['pay']->picture as $pic)
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