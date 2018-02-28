{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')


    <div class="well well-sm">
        <a href="{{route('g_house_add')}}" class="btn">添加房源</a>
    </div>

    <table class="table table-hover table-bordered treetable" id="tree-dept">
        <thead>
        <tr>
            <th>序号</th>
            <th>管理机构</th>
            <th>房源社区</th>
            <th>户型</th>
            <th>位置</th>
            <th>面积</th>
            <th>总楼层</th>
            <th>是否电梯房</th>
            <th>类型</th>
            <th>交付日期</th>
            <th>房源状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            @if($code=='success')
                @foreach($sdata as $infos)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$infos->housecompany->name}}</td>
                        <td>{{$infos->housecommunity->name}}</td>
                        <td>{{$infos->layout->name}}</td>
                        <td>
                            {{$infos->unit?$infos->unit.'单元':''}}
                            {{$infos->building?$infos->building.'楼':''}}
                            {{$infos->floor?$infos->floor.'层':''}}
                            {{$infos->number?$infos->number.'号':''}}
                        </td>
                        <td>{{$infos->area}}</td>
                        <td>{{$infos->total_floor}}</td>
                        <td>{{$infos->lift}}</td>
                        <td>{{$infos->is_real}}|{{$infos->is_buy}}|{{$infos->is_transit}}|{{$infos->is_public}}</td>
                        <td>{{$infos->delive_at}}</td>
                        <td>{{$infos->state}}</td>
                        <td>
                            <a href="{{route('g_house_info',['id'=>$infos->id])}}" class="btn btn-sm">查看详情</a>
                            <a href="{{route('g_houseprice',['house_id'=>$infos->id])}}" class="btn btn-sm">价格趋势</a>
                            <a href="{{route('g_housemanageprice',['house_id'=>$infos->id])}}" class="btn btn-sm">管理费用</a>
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