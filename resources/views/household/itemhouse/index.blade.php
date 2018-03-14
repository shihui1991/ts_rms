{{-- 继承主体 --}}
@extends('household.home')

{{-- 页面内容 --}}
@section('content')
    @if($code=='success')
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
        </tr>
        </thead>
        <tbody>

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
                        <td>{{$infos->house->is_real}}|{{$infos->house->is_transit}}</td>
                        <td>{{$infos->house->delive_at}}</td>
                    </tr>
                @endforeach

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