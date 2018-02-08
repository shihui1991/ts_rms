{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')

    <div class="well well-sm">
        <a class="btn" href="{{route('g_landsource',['prop_id'=>$sdata['prop_id']])}}">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回土地来源
        </a>
        <a href="{{route('g_landstate_add',['prop_id'=>$sdata['prop_id'],'source_id'=>$sdata['source_id']])}}" class="btn">添加土地权益状况</a>
    </div>
    <div class="well well-sm">土地性质:{{$sdata['landprop']['name']?:''}}<br/>土地来源:{{$sdata['landsource']['name']?:''}}</div>
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>描述</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            @if($code=='success')
                @foreach($sdata['landstate'] as $infos)
                    <tr>
                        <td>{{$infos->id}}</td>
                        <td>{{$infos->name}}</td>
                        <td>{{$infos->infos}}</td>
                        <td>
                            <a href="{{route('g_landstate_info',['id'=>$infos->id])}}" class="btn btn-sm">查看详情</a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="row">
        <div class="col-xs-6">
            <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">共 @if($code=='success') {{ count($sdata['landstate']) }} @else 0 @endif 条数据</div>
        </div>
        <div class="col-xs-6">
            <div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">

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