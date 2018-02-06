{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')


    <div class="well well-sm">
        <a href="{{route('g_housecompany_add')}}" class="btn">添加房源管理机构</a>
    </div>

    <table class="table table-hover table-bordered treetable" id="tree-dept">
        <thead>
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>地址</th>
            <th>电话</th>
            <th>联系人</th>
            <th>联系电话</th>
            <th>描述</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            @if($code=='success')
                @foreach($sdata as $infos)
                    <tr>
                        <td>{{$infos->id}}</td>
                        <td>{{$infos->name}}</td>
                        <td>{{$infos->address}}</td>
                        <td>{{$infos->phone}}</td>
                        <td>{{$infos->contact_man}}</td>
                        <td>{{$infos->contact_tel}}</td>
                        <td>{{$infos->infos}}</td>
                        <td>
                            <a href="{{route('g_housecompany_info',['id'=>$infos->id])}}" class="btn btn-sm">查看详情</a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="row">
        <div class="col-xs-6">
            <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">共 @if($code=='success') {{ $sdata->total() }} @else 0 @endif 条数据</div>
        </div>
        <div class="col-xs-6">
            <div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
                @if($code=='success') {{ $sdata->links() }} @endif
            </div>
        </div>
    </div>

@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')
    <script>

    </script>

@endsection