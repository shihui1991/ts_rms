{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')


    <div class="well well-sm">
        <a href="{{route('g_itemsubject_add',['item'=>$edata['item_id']])}}" class="btn">添加项目重要补偿事项</a>
    </div>

    <table class="table table-hover table-bordered treetable" id="tree-dept">
        <thead>
        <tr>
            <th>ID</th>
            <th>重要补偿科目</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            @if($code=='success')
                @foreach($sdata as $infos)
                    <tr>
                        <td>{{$infos->id}}</td>
                        <td>{{$infos->subject->name}}</td>
                        <td>
                            <a href="{{route('g_itemsubject_info',['id'=>$infos->id,'item'=>$infos->item_id])}}" class="btn btn-sm">查看详情</a>
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
    <script>

    </script>

@endsection