{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')

    <div class="well well-sm">
        <a class="btn" href="{{route('g_house')}}">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回房源
        </a>
        <a href="{{route('g_housemanageprice_add',['house_id'=>$sdata['house_id']])}}" class="btn">添加管理费</a>
    </div>
    <div class="well well-sm">当前房源:
        {{$sdata['house_info']->housecommunity->name?'【'.$sdata['house_info']->housecommunity->name.'】':''}}
        {{$sdata['house_info']->building?$sdata['house_info']->building.'栋':''}}
        {{$sdata['house_info']->unit?$sdata['house_info']->unit.'单元':''}}
        {{$sdata['house_info']->floor?$sdata['house_info']->floor.'楼':''}}
        {{$sdata['house_info']->number?$sdata['house_info']->number.'号':''}}
    </div>
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>序号</th>
            <th>开始时间</th>
            <th>结束时间</th>
            <th>月管理费(元/月)</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            @if($code=='success')
                @foreach($sdata['housemanageprice'] as $infos)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$infos->start_at}}</td>
                        <td>{{$infos->end_at}}</td>
                        <td>{{$infos->manage_price}}</td>
                        <td>
                            <a href="{{route('g_housemanageprice_info',['id'=>$infos->id])}}" class="btn btn-sm">查看详情</a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="row">
        <div class="col-xs-6">
            <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">共 @if($code=='success') {{ count($sdata['housemanageprice']) }} @else 0 @endif 条数据</div>
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
    @parent

@endsection