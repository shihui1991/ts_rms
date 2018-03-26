{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')

    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>序号</th>
            <th>地址</th>
            <th>被征收户</th>
            <th>类型</th>
            <th>资产评估总价</th>
            <th>房产评估总价</th>
            <th>评估总价</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @if(filled($sdata['assesses']))
            @foreach($sdata['assesses'] as $assess)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$assess->itemland->address}}</td>
                    <td>{{$assess->itembuilding->building}}栋{{$assess->unit}}单元{{$assess->floor}}楼{{$assess->number}}@if(is_numeric($assess->number))号@endif</td>
                    <td>{{$assess->type}}</td>
                    <td>{{number_format($assess->assets,2)}}</td>
                    <td>{{number_format($assess->estate,2)}}</td>
                    <td>{{number_format($assess->assets+$assess->estate,2)}}</td>
                    <td>{{$assess->state->name}}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{route('g_assess_info',['item'=>$sdata['item']->id,'id'=>$assess->id])}}" class="btn">查看详情</a>
                        </div>

                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    @if(filled($sdata['assesses']))
        <div class="row">
            <div class="col-xs-6">
                <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">
                    共 {{ $sdata['assesses']->total() }} 条数据
                </div>
            </div>
            <div class="col-xs-6">
                <div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
                    {{ $sdata['assesses']->links() }}
                </div>
            </div>
        </div>

    @endif

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