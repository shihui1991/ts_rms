{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')

    @if(filled($sdata['itemctrl']))

        <div class="well">
            <p>
                第{{$sdata['itemctrl']->serial}}轮选房，开始时间：{{$sdata['itemctrl']->start_at}} ，结束时间：{{$sdata['itemctrl']->end_at}}
            </p>
        </div>
    @else
        <div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert">
                <i class="ace-icon fa fa-times"></i>
            </button>
            <strong>
                <i class="ace-icon fa fa-exclamation-circle"></i>
            </strong>
            <strong class="resp-error">{{$message}}</strong>

            <br>
        </div>
    @endif
    
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>序号</th>
            <th>地址</th>
            <th>被征收户</th>
            <th>补偿总额</th>
            <th>预约号</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            @if(filled($sdata['reserves']))
                @foreach($sdata['reserves'] as $reserve)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$reserve->household->itemland->address}}</td>
                        <td>{{$reserve->household->itembuilding->building}}栋{{$reserve->household->unit}}单元{{$reserve->household->floor}}楼{{$reserve->household->number}}@if(is_numeric($reserve->household->number))号@endif</td>
                        <td>{{number_format($reserve->household->pay->total,2)}}</td>
                        <td>{{$reserve->serial}}{{$reserve->number}}</td>
                        <td>{{$reserve->state}}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{route('g_payreserve_house',['item'=>$sdata['item']->id,'reserve_id'=>$reserve->id])}}" class="btn btn-xs">开始选房</a>
                            </div>

                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div class="row">
        <div class="col-xs-6">
            <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">共 @if(filled($sdata['reserves'])) {{ $sdata['reserves']->total() }} @else 0 @endif 条数据</div>
        </div>
        <div class="col-xs-6">
            <div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
                @if(filled($sdata['reserves'])) {{ $sdata['reserves']->links() }} @endif
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