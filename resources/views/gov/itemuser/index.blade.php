{{-- 继承aceAdmin后台布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')


    <div class="row">
        <div class="col-sm-6">
            <div class="widget-box widget-color-blue2">
                <div class="widget-header">
                    <h4 class="widget-title lighter smaller">项目负责人：</h4>
                    <div class="widget-toolbar">

                        <a href="{{route('g_itemadmin')}}" class="orange2">
                            <i class="ace-icon fa fa-edit"></i>
                            编辑
                        </a>
                    </div>

                </div>
                <div class="widget-body">
                    <div class="widget-main padding-8">

                        @if(filled($edata))

                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>姓名</th>
                                    <th>部门</th>
                                    <th>角色</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($edata as $itemadmin)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$itemadmin->user->name}}</td>
                                        <td>{{$itemadmin->dept->name}}</td>
                                        <td>{{$itemadmin->role->name}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        @else

                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="widget-box widget-color-green2">
                <div class="widget-header">
                    <h4 class="widget-title lighter smaller">项目工作人员：</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main padding-8">

                        @if(filled($sdata))

                            <table class="table table-hover table-bordered treetable" id="tree-itemuser">
                                @foreach($sdata as $schedule)
                                    <tr data-tt-id="schedule-{{$schedule->schedule_id}}" data-tt-parent-id="0">
                                        <td colspan="2">{{$schedule->schedule->name}}</td>
                                    </tr>
                                    @foreach($schedule->processes as $process)
                                        <tr data-tt-id="schedule-{{$schedule->schedule_id}}-process-{{$process->process_id}}" data-tt-parent-id="schedule-{{$schedule->schedule_id}}">
                                            <td>
                                                {{$process->process->name}}
                                            </td>
                                            <td><a class="btn btn-xs" href="{{route('g_itemuser_edit',['process_id'=>$process->process_id])}}">调整</a></td>
                                        </tr>

                                        @foreach($process->depts as $dept)
                                            @if($dept->item_id==$schedule->item_id && $dept->process_id==$process->process_id)
                                                <tr data-tt-id="schedule-{{$schedule->schedule_id}}-process-{{$process->process_id}}-dept-{{$dept->dept_id}}" data-tt-parent-id="schedule-{{$schedule->schedule_id}}-process-{{$process->process_id}}">
                                                    <td colspan="2">{{$dept->dept->name}}</td>
                                                </tr>

                                                @foreach($dept->users as $user)
                                                    @if($user->item_id==$schedule->item_id && $user->process_id==$process->process_id && $user->dept_id==$dept->dept_id )
                                                        <tr data-tt-id="user-{{$user->user_id}}" data-tt-parent-id="schedule-{{$schedule->schedule_id}}-process-{{$process->process_id}}-dept-{{$dept->dept_id}}">
                                                            <td colspan="2">{{$user->user->name}}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </table>
                        @else

                            <div class="alert alert-warning">
                                <strong>注意：</strong>
                                还未配置项目工作人员！
                                &nbsp;&nbsp;&nbsp;
                                <i class="fa fa-hand-o-right"></i>
                                <a href="{{route('g_itemuser_add')}}">去配置</a>
                                <br>
                            </div>
                        @endif

                    </div>
                </div>
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
    <script src="{{asset('treetable/jquery.treetable.js')}}"></script>

    <script>
        $("#tree-itemuser").treetable({
            expandable: true // 展示
            ,initialState :"collapsed"//默认打开所有节点
            ,stringCollapse:'关闭'
            ,stringExpand:'展开'
        });

    </script>

@endsection