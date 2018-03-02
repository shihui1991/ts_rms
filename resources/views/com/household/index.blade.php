{{-- 继承主体 --}}
@extends('com.main')

{{-- 页面内容 --}}
@section('content')


    <div class="well well-sm">

    </div>

    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>序号</th>
            <th>产权争议</th>
            <th>地块</th>
            <th>楼栋</th>
            <th>位置</th>
            <th>类型</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            @if($code=='success')
                @foreach($sdata as $infos)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$infos->household->householddetail->dispute}}</td>
                        <td>{{$infos->household->itemland->address}}</td>
                        <td>{{$infos->household->itembuilding->building}}</td>
                        <td>{{$infos->household->unit?$infos->household->unit.'单元':''}}
                            {{$infos->household->floor?$infos->household->floor.'楼':''}}
                            {{$infos->household->number?$infos->household->number.'号':''}}
                        </td>
                        <td>{{$infos->household->type}}</td>
                        <td>
                            <a href="{{route('g_bank_info',['id'=>$infos->id])}}" class="btn btn-sm">入户摸底</a>
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