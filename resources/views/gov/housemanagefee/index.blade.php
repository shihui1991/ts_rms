{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')

    <div class="well well-sm">
        <form class="form-inline" role="form" action="{{route('g_housemanagefee_add')}}" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <label for="year">计算年份：</label>
                <select class="form-control" name="year" id="year">
                    @for($year=date('Y');$year>(date('Y')-10);$year--)
                        <option value="{{$year}}">{{$year}}</option>
                    @endfor
                </select>
            </div>
            <button type="button" class="btn btn-info btn-sm" onclick="sub(this)">开始计算</button>
        </form>
    </div>
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th></th>
            <th>地址</th>
            <th>小区</th>
            <th>房号</th>
            <th>管理月</th>
            <th>管理费</th>
        </tr>
        </thead>
        <tbody>
            @if(filled($sdata['manage_fees']))
                @foreach($sdata['manage_fees'] as $infos)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$infos->house->housecommunity->address}}</td>
                        <td>{{$infos->house->housecommunity->name}}</td>
                        <td>
                            {{$infos->house->building}}栋
                            {{$infos->house->unit}}单元
                            {{$infos->house->floor}}楼
                            {{$infos->house->number}}号
                        </td>
                        <td>{{$infos->manage_at}}</td>
                        <td>{{$infos->manage_fee}}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    @if(filled($sdata['manage_fees']))
    <div class="row">
        <div class="col-xs-6">
            <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">
                共 {{$sdata['manage_fees']->total()}} 条数据
            </div>
        </div>
        <div class="col-xs-6">
            <div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
                {{$sdata['manage_fees']->links()}}
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

@endsection