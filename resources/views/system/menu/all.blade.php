{{-- 继承aceAdmin后台布局 --}}
@extends('system.home')

{{-- 页面内容 --}}
@section('content')

    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>模块</th>
            <th>菜单名称</th>
            <th>应用URL</th>
            <th>限制登录访问</th>
            <th>限制操作访问</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($menus as $menu)
            <tr data-tt-id="{{$menu->id}}" data-tt-parent-id="{{$menu->parent_id}}" >
                <td>{{$menu->id}}</td>
                <td>{{$menu->module}}</td>
                <td>{!! $menu->icon !!} @if($menu->deleted_at)<del>{{$menu->name}}</del>@else{{$menu->name}}@endif</td>
                <td>@if($menu->deleted_at)<del>{{$menu->url}}</del>@else{{$menu->url}}@endif</td>
                <td>{{$menu->login}}</td>
                <td>{{$menu->auth}}</td>
                <td>{{$menu->display}}</td>
                <td>
                    <button type="button" class="btn" onclick="layerIfWindow('添加菜单','{{route('sys_menu_add',['id'=>$menu->id,'module'=>$menu->getOriginal('module'),'sub_type'=>'all'])}}','','335')" >添加子菜单</button>
                    <button type="button" class="btn" onclick="layerIfWindow('菜单信息','{{route('sys_menu_info',['id'=>$menu->id,'sub_type'=>'all'])}}','','400')" >详细信息</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script>

    </script>

@endsection