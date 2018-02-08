{{-- 继承aceAdmin后台布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    @if($code=='success')

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
            {{$message}}
            &nbsp;&nbsp;&nbsp;
            <i class="fa fa-hand-o-right"></i>
            <a href="{{route('g_itemuser_add')}}">去配置</a>
            <br>
        </div>
    @endif

@endsection

{{-- 样式 --}}
@section('css')

    <link rel="stylesheet" href="{{asset('treetable/jquery.treetable.theme.default.css')}}">

@endsection

{{-- 插件 --}}
@section('js')

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