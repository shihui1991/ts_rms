{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')


    <div class="well well-sm">
        <a href="javascript:history.back();" class="btn">返回</a>
        <a href="{{route('g_itemcrowd_add',['item'=>$edata['item_id']])}}" class="btn">添加特殊人群优惠</a>
    </div>

    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>特殊人群</th>
            <th>所属分类</th>
            <th>优惠上浮率</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            @if($code=='success')
                @foreach($sdata as $infos)
                    <tr>
                        <td>{{$infos->crowd->name}}</td>
                        <td>{{$infos->cate->name}}</td>
                        <td>{{$infos->rate}} %</td>
                        <td>
                            <a href="{{route('g_itemcrowd_info',['id'=>$infos->id,'item'=>$infos->item_id])}}" class="btn btn-sm">查看详情</a>
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