{{-- 继承aceAdmin后台布局 --}}
@extends('system.home')

{{-- 页面内容 --}}
@section('content')

    <table class="table table-hover table-bordered treetable"  id="treetable">
        <thead>
        <tr>
            <th>进度名称</th>
            <th>进度说明</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($schedules as $info)
            <tr data-tt-id="{{$info->id}}" data-tt-parent-id="" @if($info->process_count)data-tt-branch="true" @else data-tt-branch="false"@endif>
                <td>{{$info->name}}</td>
                <td>{{$info->module}}</td>
                <td>
                    <div class="hidden-sm hidden-xs btn-group">
                        <a href="{{route('sys_menu_add',['id'=>$info->id,'module'=>$info->getOriginal('module')])}}">
                            <button class="btn btn-xs btn-success">
                                <i class="ace-icon fa fa-check bigger-120"></i>
                            </button>
                        </a>
                        <a href="{{route('sys_menu_info',['id'=>$info->id])}}">
                            <button class="btn btn-xs btn-info">
                                <i class="ace-icon fa fa-pencil bigger-120"></i>
                            </button>
                        </a>
                        <a href="{{route('sys_menu_delete',['id'=>$info->id])}}">
                        <button class="btn btn-xs btn-danger">
                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                        </button>
                        </a>
                    </div>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

{{-- 样式 --}}
@section('css')
    <link rel="stylesheet" href="{{asset('treetable/jquery.treetable.theme.default.css')}}" />
@endsection

{{-- 插件 --}}
@section('js')
    <script src="{{asset('treetable/jquery.treetable.js')}}"></script>
    @parent
    <script>
        $("#treetable").treetable({
            expandable: true // 展示
            ,initialState :"collapsed"//默认打开所有节点
            ,stringCollapse:'关闭'
            ,stringExpand:'展开'
            ,onNodeExpand: function() {// 分支展开时的回调函数
                var treeObj=$("#treetable");
                var node = this;
                var childSize = treeObj.find("[data-tt-parent-id='" + node.id + "']").length;
                if (childSize > 0) {
                    return;
                }
                ajaxAct("{{route('sys_menu')}}",{"id":node.id},'get');
                if(ajaxResp.error){

                }else{
                    if(ajaxResp.sdata.length){
                        var childs='';
                        $.each(ajaxResp.sdata,function (index,info) {
                            var module = '';
                            childs +='<tr data-tt-id="'+info.id+'" data-tt-parent-id="'+info.parent_id+'" data-tt-branch="'+(info.childs_count?'true':'false')+'">';
                            childs +='<td>'+info.name+'</td>';
                            childs +='<td>'+info.module+'</td>';
                            childs +='<td>'+info.url+'</td>';
                            childs +='<td>'+info.method+'</td>';
                            childs +='<td>'+info.login+'</td>';
                            childs +='<td>'+info.auth+'</td>';
                            childs +='<td>'+info.display+'</td>';
                            childs +='<td>'+info.id+'</td>';
                            childs +='<td>'+info.sort+'</td>';
                            childs +='<td>' +
                                ' <a href="{{route('sys_menu_add')}}?id='+info.id+'&module='+module+'">' +
                                '                            <button class="btn btn-xs btn-success">\n' +
                                '                                <i class="ace-icon fa fa-check bigger-120"></i>\n' +
                                '                            </button>\n' +
                                '                        </a>\n' +
                                '                        <a href="{{route('sys_menu_info')}}?id="'+info.id+'>\n' +
                                '                            <button class="btn btn-xs btn-info">\n' +
                                '                                <i class="ace-icon fa fa-pencil bigger-120"></i>\n' +
                                '                            </button>\n' +
                                '                        </a>\n' +
                                '                        <a href="{{route('sys_menu_delete')}}?id="'+info.id+'>\n' +
                                '                        <button class="btn btn-xs btn-danger">\n' +
                                '                            <i class="ace-icon fa fa-trash-o bigger-120"></i>\n' +
                                '                        </button>\n' +
                                '                        </a>' +
                                '</td>';
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