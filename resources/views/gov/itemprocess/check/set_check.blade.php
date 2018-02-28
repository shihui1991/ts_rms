{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <div class="widget-box widget-color-red">
        <div class="widget-header">
            <h4 class="widget-title lighter smaller">项目配置审查意见</h4>
        </div>

        <div class="widget-body">
            <div class="widget-main padding-8">
                <form class="form-horizontal" role="form" action="{{route('g_itemprocess_csc',['item'=>$sdata['item']->id])}}" method="post">
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
                                            <a href="{{route('g_infos_info',['id'=>$worknotice->id])}}" title="查看详情">
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

    <div class="widget-box widget-color-blue2 collapsed">
        <div class="widget-header">
            <h4 class="widget-title lighter smaller">项目负责人：</h4>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-down"></i>
                    展开/关闭
                </a>
            </div>
        </div>
        <div class="widget-body">
            <div class="widget-main padding-8">

                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th></th>
                        <th>部门</th>
                        <th>角色</th>
                        <th>姓名</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($sdata['itemadmins'] as $itemadmin)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$itemadmin->dept->name}}</td>
                            <td>{{$itemadmin->role->name}}</td>
                            <td>{{$itemadmin->user->name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="widget-box widget-color-green2 collapsed">
        <div class="widget-header">
            <h4 class="widget-title lighter smaller">项目工作人员及时间规划：</h4>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-down"></i>
                    展开/关闭
                </a>
            </div>
        </div>
        <div class="widget-body">
            <div class="widget-main padding-8">

                <table class="table table-hover table-bordered treetable" id="tree-itemuser">
                    @foreach($sdata['itemtimes'] as $schedule)
                        <tr data-tt-id="schedule-{{$schedule->id}}" data-tt-parent-id="0">
                            <td>{{$schedule->name}} {{$schedule->itemtime->start_at}} - {{$schedule->itemtime->end_at}}</td>
                        </tr>
                        @foreach($schedule->processes as $process)
                            <tr data-tt-id="schedule-{{$schedule->id}}-process-{{$process->id}}" data-tt-parent-id="schedule-{{$schedule->id}}">
                                <td>{{$process->name}}</td>
                            </tr>
                            @foreach($sdata['itemusers'] as $user)
                                @if($schedule->id==$user->schedule_id && $process->id==$user->process_id)
                                    <tr data-tt-id="schedule-{{$schedule->id}}-process-{{$process->id}}-user-{{$user->user_id}}" data-tt-parent-id="schedule-{{$schedule->id}}-process-{{$process->id}}">
                                        <td>{{$user->dept->name}} - {{$user->role->name}} - {{$user->user->name}}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    @endforeach

                </table>

            </div>
        </div>
    </div>

@endsection

{{-- 样式 --}}
@section('css')

    <link rel="stylesheet" href="{{asset('treetable/jquery.treetable.theme.default.css')}}">

@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script src="{{asset('treetable/jquery.treetable.js')}}"></script>
    <script src="{{asset('js/func.js')}}"></script>

    <script>
        $("#tree-itemuser").treetable({
            expandable: true // 展示
            ,initialState :"collapsed"//默认打开所有节点
            ,stringCollapse:'关闭'
            ,stringExpand:'展开'
        });

        $('.img-content').viewer();
    </script>

@endsection