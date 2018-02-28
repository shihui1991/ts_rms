{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')


    <div class="well well-sm">
        <a href="{{route('g_itemhouse_add',['item'=>$edata['item_id']])}}" class="btn">添加项目房源</a>
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
            <th>添加时期</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            @if($code=='success')
                @foreach($sdata as $infos)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$infos->house->housecompany->name}}</td>
                        <td>{{$infos->house->housecommunity->name}}</td>
                        <td>{{$infos->house->layout->name}}</td>
                        <td>
                            {{$infos->house->unit?$infos->unit.'单元':''}}
                            {{$infos->house->building?$infos->building.'楼':''}}
                            {{$infos->house->floor?$infos->floor.'层':''}}
                            {{$infos->house->number?$infos->number.'号':''}}
                        </td>
                        <td>{{$infos->house->area}}</td>
                        <td>{{$infos->house->total_floor}}</td>
                        <td>{{$infos->house->lift}}</td>
                        <td>{{$infos->house->is_real}}|{{$infos->house->is_buy}}|{{$infos->house->is_transit}}|{{$infos->house->is_public}}</td>
                        <td>{{$infos->house->delive_at}}</td>
                        <td>{{$infos->house->state}}</td>
                        <td>{{$infos->type}}</td>
                        <td>
                            <a href="{{route('g_itemhouse_info',['id'=>$infos->id,'item'=>$infos->item_id])}}" class="btn btn-sm">查看详情</a>
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