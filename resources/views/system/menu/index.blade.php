{{-- 继承基础模板 --}}
@extends('system.public.base')

{{-- css --}}
@section('css')
    <link href="{{asset('ztree/css/zTreeStyle/zTreeStyle.css')}}" rel="stylesheet">
@endsection

{{-- 布局 --}}
@section('body')
    <h4>菜单管理</h4>
    <div class="toolsBar">
        <!--fgf为工具栏分隔符，刷新没有，离开都有。中间工具每一类第一个添加fgf-->
        <ul>
            <li>
                <a href="{{route('sys_menu_all')}}">
                    <img src="/system/img/web_disk.png"/>
                    所有菜单</a>
            </li>
            <li class="fgf">
                <a href="{{route('sys_menu')}}">
                    <img src="/system/img/arrow_refresh.png"/>
                    重置</a>
            </li>
            <li class="fgf" onclick="layerIfWindow('添加菜单','{{route('sys_menu_add')}}','','335')">
                <img src="{{asset('system/img/add.png')}}"/>
                添加
            </li>
        </ul>
    </div>
    <form action="{{route('sys_menu_sort')}}" method="post" id="js-ajax-form">
        <div class="tableCon">
            <em class="xian"></em>
            <table id="example-advanced" class="table treetable" border="0" >
                <tbody>
                <tr class="noSelect">
                    <th><input type="checkbox" title="选择" lay-ignore> 模块</th>
                    <th>菜单名称</th>
                    <th>路由地址</th>
                    <th>请求方式</th>
                    <th>登陆限制</th>
                    <th>操作限制</th>
                    <th>状态</th>
                    <th>ID</th>
                    <th width="50">排序</th>
                    <th>操作</th>
                </tr>
                @foreach($menus as $menu)
                    <tr data-tt-id="{{$menu->id}}" data-tt-parent-id="{{$menu->parent_id}}" @if($menu->childs_count) data-tt-branch="true" @endif>
                        <td style="white-space:nowrap;"><input type="checkbox" name="ids[]" value="{{$menu->id}}">{{$menu->module}}</td>
                        <td style="white-space:nowrap;">{!! $menu->icon !!} {{$menu->name}}</td>
                        <td style="white-space:nowrap;">{{$menu->url}}</td>
                        <td>{{$menu->method}}</td>
                        <td>{{$menu->login}}</td>
                        <td>{{$menu->auth}}</td>
                        <td>{{$menu->display}}</td>
                        <td>{{$menu->id}}</td>
                        <td><input class="layui-input" type="number" min="0" name="sorts[{{$menu->id}}]" value="{{$menu->sort}}"></td>
                        <td>
                            <button type="button" class="btn" onclick="layerIfWindow('添加菜单','{{route('sys_menu_add',['id'=>$menu->id,'module'=>$menu->getOriginal('module'),'sub_type'=>'all'])}}','','335')" >添加子菜单</button>
                            <button type="button" class="btn" onclick="layerIfWindow('菜单信息','{{route('sys_menu_info',['id'=>$menu->id,'sub_type'=>'all'])}}','','400')" >详细信息</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </form>
@endsection


{{-- js --}}
@section('js')
    <script src="{{asset('system/js/jquery.treetable.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
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
                    layui.use('layer', function(){
                        var layer = layui.layer;
                        layer.msg(ajaxResp.message,{icon:2,time:1500},function () {});
                    });
                }else{
                    console.log();
                    if(ajaxResp.data.length){
                        var childs='';
                        $.each(ajaxResp.data,function (index,info) {
                            childs +='<tr data-tt-id="'+info.id+'" data-tt-parent-id="'+info.parent_id+'" data-tt-branch="'+(info.childs_count?'true':'false')+'">';
                            childs +='<td style="white-space:nowrap;"><input type="checkbox" name="ids[]" value="'+info.id+'"> '+(info.icon || '')+' '+info.name+'</td>';
                            childs +='<td style="white-space:nowrap;" class="layui-hide-xs layui-show-md">'+info.url+'</td>';
                            childs +='<td class="layui-hide-xs layui-show-md">'+(info.method || '')+'</td>';
                            childs +='<td class="layui-hide-xs layui-show-md">'+info.auth+'</td>';
                            childs +='<td>'+(info.deleted_at?'已删除':info.display)+'</td>';
                            childs +='<td>'+info.id+'</td>';
                            childs +='<td><input class="layui-input" type="number" min="0" name="sorts['+info.id+']" value="'+info.sort+'"></td>';
                            childs +='<td><a class="layui-btn layui-btn-xs btn-action" onclick="add('+info.id+')" title="添加下级"><i class="layui-icon">&#xe654;</i></a>' +
                                '<a class="layui-btn layui-btn-xs btn-action" onclick="info('+info.id+')" title="查看详情"><i class="layui-icon">&#xe60b;</i></a>'+
                                '<a class="layui-btn layui-btn-xs btn-action" onclick="modify('+info.id+')" title="修改"><i class="layui-icon">&#xe642;</i></a></td>';
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