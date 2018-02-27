{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')


    <div class="well well-sm">
        <a href="{{route('g_crowd_add')}}" class="btn">添加特殊人群</a>
    </div>

    <table class="table table-hover table-bordered treetable" id="tree-crowd">
        <thead>
        <tr>
            <th>名称</th>
            <th>描述</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>

        @if($code=='success')
            @foreach($sdata as $infos)
                <tr data-tt-id="{{$infos->id}}" data-tt-parent-id="{{$infos->parent_id}}" @if($infos->childs_count) data-tt-branch="true" @endif>
                    <td>【分类】{{$infos->name}}</td>
                    <td>{{$infos->infos}}</td>
                    <td>
                        <a href="{{route('g_crowd_add',['id'=>$infos->id])}}" class="btn btn-sm">添加下级</a>
                        <a href="{{route('g_crowd_info',['id'=>$infos->id])}}" class="btn btn-sm">查看详情</a>
                    </td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>

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
        $("#tree-crowd").treetable({
            expandable: true // 展示
            ,initialState :"collapsed"//默认打开所有节点
            ,stringCollapse:'关闭'
            ,stringExpand:'展开'
            ,onNodeExpand: function() {// 分支展开时的回调函数
                var treeObj=$("#tree-crowd");
                var node = this;
                var childSize = treeObj.find("[data-tt-parent-id='" + node.id + "']").length;
                if (childSize > 0) {
                    return;
                }
                ajaxAct("{{route('g_crowd')}}",{"id":node.id},'get');
                if(ajaxResp.code=='error'){
                    toastr.error(ajaxResp.message);
                }else{
                    if(ajaxResp.sdata.length){
                        var childs='';
                        $.each(ajaxResp.sdata,function (index,info) {
                            var infos =info.infos?info.infos:'';
                             childs +='<tr data-tt-id="'+info.id+'" data-tt-parent-id="'+info.parent_id+'" data-tt-branch="'+(info.childs_count?'true':'false')+'">';
                            childs +='<td>'+info.name+'</td>';
                            childs +='<td>'+infos+'</td>';
                            childs +='<td><a href="{{route('g_crowd_info')}}?id='+info.id+'" class="btn btn-sm">查看详情</a></td>';
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