{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <form class="form-horizontal" role="form" action="{{route('g_itemprocess_retry',['item'=>$sdata['item']->id])}}" method="post">
        {{csrf_field()}}

        <div class="row">
            <div class="col-sm-6">
                <div class="widget-box widget-color-blue2">
                    <div class="widget-header">
                        <h4 class="widget-title lighter smaller">基本信息</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main padding-8">

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="name"> 名称： </label>
                                <div class="col-sm-9">
                                    <input type="text" id="name" name="name" value="{{$sdata['item']->name}}" class="col-xs-10 col-sm-10" required>
                                </div>
                            </div>
                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="place">征收范围：</label>
                                <div class="col-sm-9">
                                    <textarea id="place" name="place" class="col-xs-10 col-sm-10" >{{$sdata['item']->place}}</textarea>
                                </div>
                            </div>
                            <div class="space-4"></div>

                            <div class="form-group img-box">
                                <label class="col-sm-3 control-label no-padding-right">
                                    征收范围红线地图<br>
                                    <span class="btn btn-xs">
                                        <span>上传图片</span>
                                        <input type="file" accept="image/*" class="hidden" data-name="map" onchange="uplfile(this)">
                                    </span>
                                </label>
                                <div class="col-sm-9">
                                    <ul class="ace-thumbnails clearfix img-content">
                                        <li>
                                            <div>
                                                <img width="120" height="120" src="{{$sdata['item']->map}}" alt="{{$sdata['item']->map}}">
                                                <input type="hidden" name="map" value="{{$sdata['item']->map}}">
                                                <div class="text">
                                                    <div class="inner">
                                                        <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                                        <a onclick="removeimg(this)"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="infos">描述：</label>
                                <div class="col-sm-9">
                                    <textarea id="infos" name="infos" class="col-xs-10 col-sm-10" >{{$sdata['item']->infos}}</textarea>
                                </div>
                            </div>
                            <div class="space-4"></div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="widget-box widget-color-green2">
                    <div class="widget-header">
                        <h4 class="widget-title lighter smaller">
                            审查资料
                        </h4>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main padding-8">

                            @foreach($sdata['file_cates'] as $filecate)
                                <div class="form-group img-box">
                                    <label class="col-sm-3 control-label no-padding-right">
                                        {{$filecate->name}}<br>
                                        <span class="btn btn-xs">
                                        <span>上传图片</span>
                                        <input type="file" accept="image/*" class="hidden" data-name="picture[{{$filecate->filename}}][]" multiple onchange="uplfile(this)">
                                    </span>
                                    </label>
                                    <div class="col-sm-9">
                                        <ul class="ace-thumbnails clearfix img-content">
                                            @foreach($sdata['item']->picture[$filecate->filename] as $pic)
                                                <li>
                                                    <div>
                                                        <img width="120" height="120" src="{{$pic}}" alt="{{$pic}}">
                                                        <input type="hidden" name="picture[{{$filecate->filename}}][]" value="{{$pic}}">
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
                                <div class="space-4 header green"></div>
                            @endforeach

                        </div>
                    </div>
                </div>
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

    <div class="widget-box widget-color-grey collapsed">
        <div class="widget-header">
            <h4 class="widget-title lighter smaller">工作日志</h4>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-down"></i>
                    展开/关闭
                </a>
            </div>
        </div>
        <div class="widget-body">
            <div class="widget-main padding-8">

                <div class="timeline-container timeline-style2">

                    <div class="timeline-items">

                        @foreach($sdata['worknotices'] as $worknotice)

                            <div class="timeline-item clearfix">
                                <div class="timeline-info">
                                    <span class="timeline-date">{{$worknotice->updated_at}}</span>

                                    <i class="timeline-indicator btn btn-info no-hover"></i>
                                </div>

                                <div class="widget-box transparent">
                                    <div class="widget-body">
                                        <div class="widget-main no-padding">
                                            <span class="bigger-110">{{$worknotice->process->name}} 【{{$worknotice->state->name}}】</span>
                                            <br>
                                            <i class="ace-icon fa fa-user green bigger-125"></i>
                                            <span>{{$worknotice->dept->name}} - {{$worknotice->role->name}} - {{$worknotice->user->name}}</span>
                                            <br>
                                            <a href="{{route('g_infos',['id'=>$worknotice->id])}}" title="查看详情">
                                                <i class="ace-icon fa fa-info-circle blue bigger-125"></i>
                                                @if($worknotice->process->getOriginal('type')==2) 审查意见： @endif
                                            </a>
                                            <span>{{$worknotice->infos}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach

                    </div><!-- /.timeline-items -->
                </div><!-- /.timeline-container -->

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
    <script src="{{asset('js/func.js')}}"></script>
    <script>
        $('#name').focus();
        $('.img-content').viewer();
    </script>

@endsection