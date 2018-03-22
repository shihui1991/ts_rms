{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')

    @if(filled($sdata['households']))
        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>序号</th>
                <th>地址</th>
                <th>被征收户</th>
                <th>类型</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sdata['households'] as $household)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$household->itemland->address}}</td>
                    <td>{{$household->itembuilding->building}}栋{{$household->unit}}单元{{$household->floor}}楼{{$household->number}}@if(is_numeric($household->number))号@endif</td>
                    <td>{{$household->type}}</td>
                    <td>{{$household->state->name}}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{route('g_resettle_info',['item'=>$sdata['item']->id,'id'=>$household->id])}}" class="btn">查看详情</a>
                        </div>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="row">
            <div class="col-xs-6">
                <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">
                    共 {{ $sdata['households']->total() }} 条数据
                </div>
            </div>
            <div class="col-xs-6">
                <div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
                     {{ $sdata['households']->links() }}
                </div>
            </div>
        </div>
    @else

        <div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert">
                <i class="ace-icon fa fa-times"></i>
            </button>
            <strong>
                <i class="ace-icon fa fa-exclamation-circle"></i>
            </strong>
            <strong class="resp-error">
                注意：{{$message}}！
            </strong>

            <br>
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