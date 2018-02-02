{{-- 继承基础模板 --}}
@extends('system.public.base')

{{-- 布局 --}}
@section('body')
    <h4>菜单管理</h4>
    <div class="toolsBar">
        <!--fgf为工具栏分隔符，刷新没有，离开都有。中间工具每一类第一个添加fgf-->
        <ul>
            <li>
                <a href="{{route('sys_menu')}}">
                    <img src="{{asset('system/img/web_disk.png')}}"/>
                    树形菜单</a>
            </li>
            <li class="fgf">
                <a href="{{route('sys_menu_all')}}">
                    <img src="{{asset('system/img/arrow_refresh.png')}}"/>
                    重置</a>
            </li>
            <li class="fgf" onclick="layerIfWindow('添加菜单','{{route('sys_menu_add','0')}}','','500',true)">
                <img src="{{asset('system/img/add.png')}}"/>
                添加
            </li>
        </ul>
    </div>
    <form action="{{route('sys_menu_sort')}}" method="post" id="js-ajax-form">
        <div class="tableCon">
            <em class="xian"></em>
            <table class="table" border="0" >
                <tbody>
                <tr class="noSelect">
                    <th class="tc" width="35px">
                        <input class="va_m" type="checkbox" name="" id="allCheck" value="" data-falg="allCheck" onclick="checkBoxOp(this)"/>
                    </th>
                    <th>ID</th>
                    <th>模块</th>
                    <th>菜单名称</th>
                    <th>应用URL</th>
                    <th>限制登录访问</th>
                    <th>限制操作访问</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>

                @foreach($menus as $menu)
                <tr data-tt-id="{{$menu->id}}" data-tt-parent-id="{{$menu->parent_id}}" >
                    <td>
                        <input class="va_m" type="checkbox" name="ids[]" value="{{$menu->id}}" onclick="checkBoxOp(this)" id="check-{{$menu->id}}"/>
                    </td>
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
        </div>
    </form>
@endsection

{{-- js --}}
@section('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

@endsection