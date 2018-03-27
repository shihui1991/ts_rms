{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <div class="widget-box widget-color-red">
        <div class="widget-header">
            <h4 class="widget-title lighter smaller">项目筹备审查意见</h4>
        </div>

        <div class="widget-body">
            <div class="widget-main padding-8">
                <form class="form-horizontal" role="form" action="{{route('g_ready_prepare_check',['item'=>$sdata['item']->id])}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="code">审查结果：</label>
                        <div class="col-sm-9 radio">
                            <label>
                                <input name="code" type="radio" class="ace" value="22" checked >
                                <span class="lbl">审查通过</span>
                            </label>

                            <label>
                                <input name="code" type="radio" class="ace" value="23" >
                                <span class="lbl">审查驳回</span>
                            </label>
                        </div>
                    </div>
                    <div class="space-4"></div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="infos">审查意见：</label>
                        <div class="col-sm-9">
                            <textarea id="infos" name="infos" class="col-xs-10 col-sm-8" ></textarea>
                        </div>
                    </div>
                    <div class="space-4"></div>

                    <div class="form-group img-box">
                        <label class="col-sm-3 control-label no-padding-right">
                            附件<br>
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

    <div class="widget-box widget-color-blue2">
        <div class="widget-header">
            <h4 class="widget-title lighter smaller">项目准备情况与初步预算：</h4>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                    展开/关闭
                </a>
            </div>
        </div>
        <div class="widget-body">
            <div class="widget-main padding-8">

                <div class="profile-user-info profile-user-info-striped">

                    <div class="profile-info-row">
                        <div class="profile-info-name"> 预计户数： </div>
                        <div class="profile-info-value">
                            <span class="editable editable-click">{{number_format($sdata['init_budget']->holder)}}</span>
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name"> 预算总金额： </div>
                        <div class="profile-info-value">
                            <span class="editable editable-click">
                                <strong>{{number_format($sdata['init_budget']->money,2)}}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name"> 当前项目资金： </div>
                        <div class="profile-info-value">
                            <span class="editable editable-click">
                                <strong>{{number_format($sdata['funds_amount'],2)}} （达到预算）</strong>
                            </span>
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name"> 预备房源数： </div>
                        <div class="profile-info-value">
                            <span class="editable editable-click">{{number_format($sdata['init_budget']->house)}}</span>
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name"> 当前冻结房源： </div>
                        <div class="profile-info-value">
                            <span class="editable editable-click">
                                <strong>{{number_format($sdata['house_count'])}} （达到预算）</strong>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

{{-- 样式 --}}
@section('css')


@endsection

{{-- 插件 --}}
@section('js')
    @parent


@endsection