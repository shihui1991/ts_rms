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
            <th>补偿总额</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            @if(filled($sdata['households']))
                @foreach($sdata['households'] as $household)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$household->itemland->address}}</td>
                        <td>{{$household->itembuilding->building}}栋{{$household->unit}}单元{{$household->floor}}楼{{$household->number}}@if(is_numeric($household->number))号@endif</td>
                        <td>{{$household->type}}</td>
                        <td>{{number_format($household->pay->total,2)}}</td>
                        <td>{{$household->state->name}}</td>
                        <td>
                            <div class="btn-group">
                                @if($household->pay->id)
                                    <a href="{{route('g_pay_info',['id'=>$household->pay->id,'item'=>$sdata['item']->id])}}" class="btn btn-sm">补偿详情</a>
                                @else
                                    <a href="{{route('g_pay_add',['household_id'=>$household->id,'item'=>$sdata['item']->id])}}" class="btn btn-sm">补偿决定</a>
                                @endif

                            </div>

                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    @if(filled($sdata['households']))
    <div class="row">
        <div class="col-xs-6">
            <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">
                共  {{ $sdata['households']->total() }} 条数据
            </div>
        </div>
        <div class="col-xs-6">
            <div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
                 {{ $sdata['households']->links() }}
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