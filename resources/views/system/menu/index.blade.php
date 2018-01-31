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

    <header>

    </header>

    <section>
        <nav>
            <ul id="nav-menu" class="ztree">

            </ul>
        </nav>

        <div class="content">
            @yield('content')
        </div>

    </section>

    <footer>
        ffff
    </footer>
@endsection


{{-- js --}}
@section('js')
    <script src="{{asset('ztree/jquery.ztree.core.min.js')}}"></script>
    <script>
        $.ajax({
            type:'post',
            url:'/api/gov/dept_add',
            data:'',
            dataType:'json',
            success:function (rs) {
                console.log(rs);
            }
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
                {{-- 树形菜单配置 --}}
        var setting = {
                view: {
                    selectedMulti: false
                    ,nameIsHTML:true
                    ,showIcon:false
                    ,showLine: true
                    ,showTitle:false
                    ,dblClickExpand:false
                }
                ,async: {
                    enable: true
                    ,url:window.location.href
                    ,autoParam:["id"]
                    ,otherParam:{"method":"ajax"}
                    ,dataFilter: filter
                }
                ,callback: {
                    beforeAsync:zTreeBeforeAsync
                    ,onAsyncError: zTreeOnAsyncError
                    ,onClick:zTreeOnClick
                }
            };
                {{-- 树形菜单根目录数据 --}}
                @php
                    $top_menus=[];
                    if(!blank($menus)){
                        foreach($menus as $menu){
                            $top_menus[]=[
                                'id'=>$menu->id
                                ,'pId'=>$menu->parent_id
                                ,'name'=>$menu->icon.' '.$menu->name
                                ,'isParent'=>$menu->childs_count?true:false
                                ,'data_url'=>$menu->url
                            ];
                        }
                    }
                @endphp
        var zNodes =@json($top_menus);
        {{-- 树形菜单异步数据处理 --}}
        function filter(treeId, parentNode, childNodes) {
            if (!childNodes || !childNodes.data || !childNodes.data.length) return null;
            var nodes=[];
            for (var i=0, l=childNodes.data.length; i<l; i++) {
                nodes[i] = {
                    id:childNodes.data[i].id
                    ,pId:childNodes.data[i].parent_id
                    ,name:childNodes.data[i].icon+' '+childNodes.data[i].name
                    ,isParent:(childNodes.data[i].childs_count?true:false)
                    ,data_url:childNodes.data[i].url
                };
            }
            return nodes;
        }
        {{-- 树形菜单异步获取前判断 --}}
        function zTreeBeforeAsync(treeId,treeNode) {
            if(treeNode){
                return treeNode.isParent;
            }else{
                return true;
            }
        }
        {{-- 树形菜单异步获取失败处理 --}}
        function zTreeOnAsyncError(event, treeId, treeNode, XMLHttpRequest, textStatus, errorThrown) {
            toastr.error('网络错误！请稍候重试……');
        }
        {{-- 树形菜单点击事件 --}}
        function zTreeOnClick(event, treeId, treeNode) {
            if(treeNode.data_url && treeNode.data_url !='#'){

            }
            if(treeNode.isParent){
                var zTree = $.fn.zTree.getZTreeObj("nav-menu");
                zTree.expandNode(treeNode, null, null, null, true);
            }
        }
        $(function(){
            $.fn.zTree.init($("#nav-menu"), setting,zNodes);
        });
    </script>

@endsection