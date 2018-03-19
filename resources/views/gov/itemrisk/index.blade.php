{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')
    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>
    </p>
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>被征收户</th>
            <th>账号</th>
            <th>意见</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @if(filled($sdata))
            @foreach($sdata as $infos)
                <tr>
                    <td>{{$infos->household->itemland->address}}{{$infos->household->itembuilding->building}}栋{{$infos->household->unit}}单元{{$infos->household->floor}}楼{{$infos->household->number}}号</td>
                    <td>{{$infos->household->username}}</td>
                    <td>{{$infos->agree}}</td>
                    <td>
                        <a href="{{route('g_itemrisk_info',['id'=>$infos->id,'item'=>$infos->item_id])}}" class="btn btn-sm">查看详情</a>
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