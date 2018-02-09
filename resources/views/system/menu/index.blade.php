{{-- 继承aceAdmin后台布局 --}}
@extends('system.home')

{{-- 页面内容 --}}
@section('content')

    <div class="well well-sm">
        <a href="{{route('sys_menu_add')}}" class="btn">添加菜单</a>
    </div>

    @if(filled($sdata))
        <table class="table table-hover table-bordered treetable">
            <thead>
            <tr>
                <th>名称</th>
                <th>模块</th>
                <th>路由地址</th>
                <th>请求方法</th>
                <th>限制登陆访问</th>
                <th>限制操作访问</th>
                <th>状态</th>
                <th>ID</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sdata as $menu)
                <tr data-tt-id="{{$menu->id}}" data-tt-parent-id="{{$menu->parent_id}}" @if($menu->childs_count)data-tt-branch="true" @else data-tt-branch="false"@endif>
                    <td>{{$menu->name}}</td>
                    <td>{{$menu->module}}</td>
                    <td>{{$menu->url}}</td>
                    <td>{{$menu->method}}</td>
                    <td>{{$menu->login}}</td>
                    <td>{{$menu->auth}}</td>
                    <td>{{$menu->display}}</td>
                    <td>{{$menu->id}}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{route('sys_menu_add',['id'=>$menu->id])}}" class="btn btn-xs">
                                添加下级
                            </a>
                            <a href="{{route('sys_menu_info',['id'=>$menu->id])}}" class="btn btn-xs">
                                查看详情
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
                ajaxAct("{{route('sys_menu')}}",{"id":node.id},'get');
                if(ajaxResp.error){

                }else{
                    if(ajaxResp.sdata.length){
                        var childs='';
                        $.each(ajaxResp.sdata,function (index,info) {
                            childs +='<tr data-tt-id="'+info.id+'" data-tt-parent-id="'+info.parent_id+'" data-tt-branch="'+(info.childs_count?'true':'false')+'">';
                            childs +='<td>'+info.name+'</td>';
                            childs +='<td>'+info.module+'</td>';
                            childs +='<td>'+info.url+'</td>';
                            childs +='<td>'+(info.method || '')+'</td>';
                            childs +='<td>'+info.login+'</td>';
                            childs +='<td>'+info.auth+'</td>';
                            childs +='<td>'+info.display+'</td>';
                            childs +='<td>'+info.id+'</td>';
                            childs +='<td><div class="btn-group">' +
                                '    <a href="{{route('sys_menu_add')}}?id='+info.id+'" class="btn btn-xs">' +
                                '        添加下级' +
                                '    </a>' +
                                '    <a href="{{route('sys_menu_info')}}?id='+info.id+'" class="btn btn-xs">' +
                                '       查看详情' +
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