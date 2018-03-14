{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')

    <div class="well well-sm">
        <a class="btn" href="{{route('g_house')}}">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回房源
        </a>
        <a href="{{route('g_houseprice_add',['house_id'=>$sdata['house_id']])}}" class="btn">添加评估价格</a>
    </div>
    <div class="well well-sm">当前房源:
        {{$sdata['house_info']->housecommunity->name?'【'.$sdata['house_info']->housecommunity->name.'】':''}}
        {{$sdata['house_info']->unit?$sdata['house_info']->unit.'单元':''}}
        {{$sdata['house_info']->building?$sdata['house_info']->building.'栋':''}}
        {{$sdata['house_info']->floor?$sdata['house_info']->floor.'楼':''}}
        {{$sdata['house_info']->number?$sdata['house_info']->number.'号':''}}
    </div>
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>开始时间</th>
            <th>结束时间</th>
            <th>评估市场价</th>
            <th>安置优惠价</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            @if($code=='success')
                @foreach($sdata['houseprice'] as $infos)
                    <tr>
                        <td>{{$infos->id}}</td>
                        <td>{{$infos->start_at}}</td>
                        <td>{{$infos->end_at}}</td>
                        <td>{{$infos->market}}</td>
                        <td>{{$infos->price}}</td>
                        <td>
                            <a href="{{route('g_houseprice_info',['id'=>$infos->id])}}" class="btn btn-sm">查看详情</a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="row">
        <div class="col-xs-6">
            <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">共 @if($code=='success') {{ count($sdata['houseprice']) }} @else 0 @endif 条数据</div>
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
    <script>

    </script>

@endsection