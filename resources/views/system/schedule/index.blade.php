{{-- 继承aceAdmin后台布局 --}}
@extends('system.home')

{{-- 页面内容 --}}
@section('content')

    <div class="well well-sm">
        <a href="{{route('sys_schedule_add')}}" class="btn">添加进度</a>
    </div>

    @if(filled($sdata))
        <table class="table table-hover table-bordered treetable">
            <thead>
            <tr>
                <th>进度 > 流程 > 子流程</th>
                <th>说明</th>
                <th>进度ID | 流程ID</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($sdata as $schedule)
                <tr data-tt-id="schedule-{{$schedule->id}}" @if(count($schedule->processes)) data-tt-branch="true" @else data-tt-branch="false"@endif>
                    <td>{{$schedule->name}}</td>
                    <td>{{str_limit($schedule->infos,50)}}</td>
                    <td>{{$schedule->id}}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{route('sys_schedule_edit',['id'=>$schedule->id])}}" class="btn btn-xs">
                                修改
                            </a>
                        </div>
                    </td>
                </tr>

                @if(count($schedule->processes))
                    @foreach($schedule->processes as $process)
                        <tr data-tt-id="{{$process->id}}" data-tt-parent-id="schedule-{{$schedule->id}}" @if($process->childs_count) data-tt-branch="true" @else data-tt-branch="false"@endif>
                            <td>{{$process->name}}</td>
                            <td>{{$process->menu->name}} - {{$process->menu->url}}</td>
                            <td>{{$process->id}}</td>
                            <td></td>
                        </tr>

                    @endforeach
                @endif
            @endforeach

            </tbody>
        </table>
    @endif

@endsection

{{-- 样式 --}}
@section('css')
    <link rel="stylesheet" href="{{asset('treetable/jquery.treetable.theme.default.css')}}" />
@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script src="{{asset('treetable/jquery.treetable.js')}}"></script>
    <script>
        $(".treetable").treetable({
            expandable: true // 展示
            ,initialState :"collapsed"//默认打开所有节点
            ,stringCollapse:'关闭'
            ,stringExpand:'展开'
            ,onNodeExpand: function() {// 分支展开时的回调函数
                var node = this;
                var treeObj=$('tr[data-tt-id='+node.id+']').parents('table.treetable:first');
                var childSize = treeObj.find("[data-tt-parent-id='" + node.id + "']").length;
                if (childSize > 0) {
                    return;
                }
                if(parseInt(node.id) == 0){
                    return;
                }
                ajaxAct("{{route('sys_process')}}",{"id":node.id},'get');
                if(ajaxResp.error){

                }else{
                    if(ajaxResp.sdata.length){
                        var childs='';
                        $.each(ajaxResp.sdata,function (index,info) {
                            childs +='<tr data-tt-id="'+info.id+'" data-tt-parent-id="'+info.parent_id+'" data-tt-branch="'+(info.childs_count?'true':'false')+'">';
                            childs +='<td>'+info.name+'</td>';
                            childs +='<td>'+info.menu.name+' - '+info.menu.url+'</td>';
                            childs +='<td>'+info.id+'</td>';
                            childs +='<td></td>';
                            childs +='</tr>';
                        });
                        treeObj.treetable("loadBranch", node, childs);// 插入子节点
                        treeObj.treetable("expandNode", node.id);// 展开子节点
                    }else{
                        var tr = treeObj.find("[data-tt-id='" + node.id + "']");
                        tr.data("tt-branch","false");
                        tr.find("span.indenter").html("");
                    }
                }
            }
        });
    </script>

@endsection