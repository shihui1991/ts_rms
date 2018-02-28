{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')

    <div class="well well-sm">
        <a class="btn" href="{{route('g_landprop')}}">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回土地性质
        </a>
        <a href="{{route('g_landsource_add',['prop_id'=>$sdata['prop_id']])}}" class="btn">添加土地来源</a>
    </div>
    <div class="well well-sm">土地性质:{{$sdata['landprop']['name']?:''}}</div>
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>序号</th>
            <th>名称</th>
            <th>描述</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            @if($code=='success')
                @foreach($sdata['landsource'] as $infos)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$infos->name}}</td>
                        <td>{{$infos->infos}}</td>
                        <td>
                            <a href="{{route('g_landsource_info',['id'=>$infos->id])}}" class="btn btn-sm">查看详情</a>
                            <a href="{{route('g_landstate',['prop_id'=>$sdata['prop_id'],'source_id'=>$infos->id])}}" class="btn btn-sm">土地权益状况</a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="row">
        <div class="col-xs-6">
            <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">共 @if($code=='success') {{ count($sdata['landsource']) }} @else 0 @endif 条数据</div>
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