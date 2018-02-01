{{-- 继承基础模板 --}}
@extends('base')

{{-- css --}}
@section('css')
    <link href="{{asset('ztree/css/zTreeStyle/zTreeStyle.css')}}" rel="stylesheet">

    <style>
        header{
            margin: 0;
            padding-left: 0;
            padding-right: 0;
            border-width: 0;
            border-radius: 0;
            -webkit-box-shadow: none;
            box-shadow: none;
            min-height: 45px;
            background: #438EB9;
        }
        nav{
            width: 200px;
            float: left;
            position: static;
            padding-left: 0;
            padding-right: 0;
        }
        .content{
            margin-left: 200px;
            min-height: 100%;
        }


    </style>

@endsection

{{-- 布局 --}}
@section('body')
    <h4>菜单管理</h4>
    <div class="toolsBar">
        <!--fgf为工具栏分隔符，刷新没有，离开都有。中间工具每一类第一个添加fgf-->
        <ul>
            <li>
                <a href="{{route('sys_menu_all')}}">
                    <img src="{{asset('system/img/web_disk.png')}}"/>
                    所有菜单</a>
            </li>
            <li class="fgf">
                <a href="{:url('index')}">
                    <img src="{{asset('system/img/arrow_refresh.png')}}"/>
                    重置</a>
            </li>
            <li class="fgf" onclick="layerIfWindow('添加菜单','{:url('add')}','','335')">
                <img src="{{asset('system/img/add.png')}}"/>
                添加
            </li>
            <li class="fgf js-ajax-form-btn" data-form="js-ajax-form">
                <img src="{{asset('system/img/text_list_numbers.png')}}"/>
                排序
            </li>
            <li class="fgf js-ajax-form-btn" data-form="js-ajax-form" data-action="{:url('show',array('display'=>'1'))}">
                <img src="{{asset('system/img/monitor_window_3d.png')}}"/>
                显示
            </li>
            <li class="fgf js-ajax-form-btn" data-form="js-ajax-form" data-action="{:url('show',array('display'=>'0'))}">
                <img src="{{asset('system/img/insert_element.png')}}"/>
                隐藏
            </li>
            <li class="fgf js-ajax-form-btn" data-form="js-ajax-form" data-action="{:url('status',array('status'=>'1'))}">
                <img src="{{asset('system/img/checked.png')}}"/>
                启用
            </li>
            <li class="fgf js-ajax-form-btn" data-form="js-ajax-form" data-action="{:url('status',array('status'=>'0'))}">
                <img src="{{asset('system/img/disabled.png')}}"/>
                禁用
            </li>
            <li class="fgf js-ajax-form-btn" data-form="js-ajax-form" data-action="{:url('delete')}">
                <img src="{{asset('system/img/broom.png')}}"/>
                删除
            </li>
        </ul>
    </div>
    <form action="{:url('sort')}" method="post" id="js-ajax-form">
        <div class="tableCon">
            <em class="xian"></em>
            <table id="example-advanced" class="table treetable" border="0" >
                <tbody>
                <tr class="noSelect">
                    <th class="tc" width="35px">
                        <input class="va_m" type="checkbox" name="" id="allCheck" value="" data-falg="allCheck" onclick="checkBoxOp(this)"/>
                    </th>
                    <th>排序</th>
                    <th>ID</th>
                    <th>菜单名称</th>
                    <th>应用URL</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
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