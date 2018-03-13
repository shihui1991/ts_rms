{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')


    <div class="well well-sm">
        <a class="btn" href="javascript:history.back()"><i class="ace-icon fa fa-arrow-left bigger-110"></i>返回</a>
        <a href="{{route('g_householdassets_add',['item'=>$edata['item_id'],'household_id'=>$edata['household_id']])}}" class="btn">添加资产</a>
    </div>

    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>序号</th>
            <th>名称</th>
            <th>计量单位</th>
            <th>数量</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            @if($code=='success')
                @foreach($sdata as $infos)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$infos->name}}</td>
                        <td>{{$infos->num_unit}}</td>
                        <td>{{$infos->gov_num}}</td>
                        <td>
                            <a href="{{route('g_householdassets_info',['id'=>$infos->id,'item'=>$infos->item_id,'household_id'=>$infos->household_id])}}" class="btn btn-sm">查看详情</a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="row">
        <div class="col-xs-6">
            <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">共 @if($code=='success') {{ count($sdata) }} @else 0 @endif 条数据</div>
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