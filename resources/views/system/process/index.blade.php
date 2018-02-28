{{-- 继承aceAdmin后台布局 --}}
@extends('system.home')

{{-- 页面内容 --}}
@section('content')

    <div class="well well-sm">
        <a href="{{route('sys_process_add')}}" class="btn">添加流程</a>
    </div>

    @if(filled($sdata))
        <table class="table table-hover table-bordered treetable">
            <thead>
            <tr>
                <th>名称 - 排序</th>
                <th>项目进度</th>
                <th>类型 - 限制人数</th>
                <th>菜单ID - 菜单名称</th>
                <th>地址</th>
                <th>ID</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sdata as $process)
                <tr data-tt-id="{{$process->id}}" data-tt-parent-id="{{$process->parent_id}}" @if($process->childs_count)data-tt-branch="true" @else data-tt-branch="false"@endif>
                    <td>{{$process->name}} - {{$process->sort}}</td>
                    <td>{{$process->schedule->name}}</td>
                    <td>{{$process->type}} - {{$process->number}}</td>
                    <td>{{$process->menu->id}} - {{$process->menu->name}}</td>
                    <td>{{$process->menu->url}}</td>
                    <td>{{$process->id}}</td>
                    <td>
                        <div class="btn-group">
                            @if($process->parent_id==0)
                            <a href="{{route('sys_process_add',['id'=>$process->id])}}" class="btn btn-xs">
                                添加下级
                            </a>
                            @endif
                            <a href="{{route('sys_process_edit',['id'=>$process->id])}}" class="btn btn-xs">
                                修改
                            </a>
                        </div>
                    </td>

                </tr>
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
                ajaxAct("{{route('sys_process')}}",{"id":node.id},'get');
                if(ajaxResp.error){

                }else{
                    if(ajaxResp.sdata.length){
                        var childs='';
                        $.each(ajaxResp.sdata,function (index,info) {
                            childs +='<tr data-tt-id="'+info.id+'" data-tt-parent-id="'+info.parent_id+'">';
                            childs +='<td>'+info.name+' - '+info.sort+'</td>';
                            childs +='<td>'+info.schedule.name+'</td>';
                            childs +='<td>'+info.type+' - '+info.number+'</td>';
                            childs +='<td>'+info.menu.id+' - '+info.menu.name+'</td>';
                            childs +='<td>'+info.menu.url+'</td>';
                            childs +='<td>'+info.id+'</td>';
                            childs +='<td><div class="btn-group">' +
                                '    <a href="{{route('sys_process_edit')}}?id='+info.id+'" class="btn btn-xs">' +
                                '       修改' +
                                '    </a>' +
                                '</div></td>';
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