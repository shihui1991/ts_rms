{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <div class="modal-content">
        <div id="modal-wizard-container">
            <div class="modal-header">
                <ul class="steps">
                    @foreach($sdata['schedules'] as $schedule)

                        <li data-step="{{$schedule->id}}" @if($item->schedule_id>$schedule->id) class="complete" @elseif($item->schedule_id==$schedule->id) class="active"@else class="" @endif style="cursor: pointer;">
                            <span class="step">{{$loop->iteration}}</span>
                            <span class="title">{{$schedule->name}}</span>
                        </li>

                    @endforeach

                </ul>
            </div>

            <div class="modal-body step-content">
                @foreach($sdata['schedules'] as $schedule)

                    <div data-step="{{$schedule->id}}" @if($item->schedule_id==$schedule->id) class="step-pane active"@else class="step-pane" @endif>
                        <div class="center">
                            <h4 class="blue">{{$schedule->name}}</h4>
                        </div>
                        <p>
                            @foreach($schedule->processes as $process)
                            <span class="label label-lg arrowed-in arrowed-right">{{$process->name}}</span>
                            @endforeach
                        </p>
                        <div class="widget-box widget-color-blue2">
                            <div class="widget-header">
                                <h4 class="widget-title lighter smaller">待做事项</h4>
                            </div>
                            <div class="widget-body">
                                <div class="widget-main padding-8">

                                    @foreach($sdata['worknotices'] as $work)
                                        @if($work->schedule_id==$schedule->id)
                                            <p>
                                                {{$loop->iteration}}、{{$work->created_at}}，【{{$work->process->name}}】。
                                                <a href="{{$work->url}}">前往处理 &nbsp;<i class="ace-icon fa fa-angle-double-right"></i></a>
                                            </p>
                                        @endif

                                    @endforeach

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

                                            @foreach($schedule->worknotices as $worknotice)

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
                    </div>

                @endforeach

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

    <script src="{{asset('js/func.js')}}"></script>
    <script>

        $('li[data-step]').on('click',function () {
            var step=$(this).data('step');
            var step_content=$('div.step-content');
            step_content.find('div.step-pane').removeClass('active');
            step_content.find('div[data-step='+step+']').addClass('active');
        });

    </script>

@endsection