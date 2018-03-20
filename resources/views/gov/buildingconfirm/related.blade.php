{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')
    <div class="well well-sm">
        <a class="btn" href="{{route('g_buildingconfirm',['item'=>$edata['item']->id])}}">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>
    </div>

    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>序号</th>
            <th>名称</th>
            <th>地块</th>
            <th>楼栋</th>
            <th>楼层</th>
            <th>朝向</th>
            <th>结构</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @if($code=='success')
            @foreach($sdata as $infos)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$infos->name}}</td>
                    <td>{{$infos->itemland->address}}</td>
                    <td>{{$infos->itembuilding->building}}</td>
                    <td>{{$infos->floor}}</td>
                    <td>{{$infos->direct}}</td>
                    <td>{{$infos->buildingstruct->name}}</td>
                    <td>{{$infos->state->name}}</td>
                    <td>
                        @if(filled($infos->estatebuilding->id))
                            <a href="{{route('g_relatedcom_info',['id'=>$infos->id,'item'=>$infos->item_id,'household_id'=>$infos->household_id])}}" class="btn btn-sm">已关联详情</a>
                            @else
                            <a href="{{route('g_buildingrelated_com',['id'=>$infos->id,'item'=>$infos->item_id,'household_id'=>$infos->household_id])}}" class="btn btn-sm">关联评估数据</a>
                        @endif

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