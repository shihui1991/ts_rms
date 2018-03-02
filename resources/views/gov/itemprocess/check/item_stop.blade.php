{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <div class="widget-box widget-color-blue2">
        <div class="widget-header">
            <h4 class="widget-title lighter smaller">不予受理通知</h4>
        </div>
        <div class="widget-body">
            <div class="widget-main padding-8">

                <form class="form-horizontal" role="form" action="{{route('g_itemprocess_stop',['item'=>$sdata['item']->id])}}" method="post">
                    {{csrf_field()}}

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="infos">通知摘要：</label>
                    <div class="col-sm-9">
                        <textarea id="infos" name="infos" class="col-xs-10 col-sm-10" >{{$sdata['item']->infos}}</textarea>
                    </div>
                </div>
                <div class="space-4"></div>

                <div class="form-group img-box">
                    <label class="col-sm-3 control-label no-padding-right">
                        通知文件：<br>
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

    <div class="widget-box widget-color-grey">
        <div class="widget-header">
            <h4 class="widget-title lighter smaller">工作日志</h4>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
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