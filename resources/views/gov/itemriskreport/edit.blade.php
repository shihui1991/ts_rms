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


    <form class="form-horizontal" role="form" action="{{route('g_itemriskreport_edit',['item'=>$sdata['item_id']])}}" method="post">
        {{csrf_field()}}

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="address"> 标题： </label>
            <div class="col-sm-9">
                <input type="text" id="name" name="name" value="{{$sdata['risk_report']->name}}" class="col-xs-10 col-sm-5"  placeholder="请输入标题" required>
            </div>
        </div>
        <div class="space-4"></div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="login">评估结论：</label>
            <div class="col-sm-9 radio">
                @foreach($edata->agree as $key => $value)
                    <label>
                        <input name="agree" type="radio" class="ace" value="{{$key}}" @if ($value==$sdata['risk_report']->agree) checked @endif/>
                        <span class="lbl">{{$value}}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <div class="space-4"></div>
        
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="content">内容：</label>
            <div class="col-sm-9"></div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <textarea id="content" name="content" class="col-xs-11 col-sm-11" style="min-height: 300px;">{{$sdata['risk_report']->content}}</textarea>
        </div>
        <div class="space-4"></div>


        <div class="widget-body">
            <div class="widget-main padding-8">

                <div class="form-group img-box">
                    <label class="col-sm-3 control-label no-padding-right">
                        评估报告：<br>
                        <span class="btn btn-xs">
                            <span>上传图片</span>
                            <input type="file" accept="image/*" class="hidden" data-name="picture[]" multiple  onchange="uplfile(this)">
                        </span>
                    </label>
                    <div class="col-sm-9">
                        <ul class="ace-thumbnails clearfix img-content viewer">
                            @if(filled($sdata['risk_report']->picture))
                                @foreach($sdata['risk_report']->picture as $pic)
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

                <div class="space-4 header green"></div>

            </div>
        </div>

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
    <script src="{{asset('js/func.js')}}"></script>
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script src="{{asset('ueditor/ueditor.config.js')}}"></script>
    <script src="{{asset('ueditor/ueditor.all.min.js')}}"></script>
    <script>
        var ue = UE.getEditor('content');
        $('.img-content').viewer();
    </script>

@endsection