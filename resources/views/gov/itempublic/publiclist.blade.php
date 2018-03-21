{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')


    <div class="well well-sm">
        <a href="{{route('g_public_landiist',['item'=>$edata['item_id']])}}" class="btn">返回</a>
    </div>

    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>序号</th>
            <th>类型</th>
            <th>楼栋号</th>
            <th>名称</th>
            <th>计量单位</th>
            <th>确认数量</th>
            <th>当前状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            @if($code=='success')
                @foreach($sdata as $infos)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>@if($infos->itembuilding->building>0)楼栋公共附属物@else 地块公共附属物 @endif</td>
                        <td>{{$infos->itembuilding->building?$infos->itembuilding->building.'栋':''}}</td>
                        <td>{{$infos->name}}</td>
                        <td>{{$infos->num_unit}}</td>
                        <td>{{$infos->number}}</td>
                        <td>@if(blank($infos->number))未确认@else已确认@endif</td>
                        <td>
                            <a href="{{route('g_publicinfo',['id'=>$infos->id,'item'=>$infos->item_id,'land_id'=>$infos->land_id])}}" class="btn btn-sm">确认详情</a>
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
    @parent
    <script>

    </script>

@endsection