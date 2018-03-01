{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')


    <div class="well well-sm">
        <a href="{{route('g_company')}}" class="btn"><i class="ace-icon fa fa-arrow-left bigger-110"></i>返回评估机构</a>
    </div>

    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>序号</th>
            <th>【类型】评估机构</th>
            <th>是否为管理账号</th>
            <th>名称</th>
            <th>电话</th>
            <th>用户名</th>
            <th>最近操作时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            @if($code=='success')
                @foreach($sdata as $infos)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>【{{$infos->company->type}}】{{$infos->company->name}}</td>
                        <td>@if($infos->id == $infos->company->user_id) 是@else 否@endif</td>
                        <td>{{$infos->name}}</td>
                        <td>{{$infos->phone}}</td>
                        <td>{{$infos->username}}</td>
                        <td>{{$infos->action_at}}</td>
                        <td>
                            <a href="{{route('g_companyuser_info',['id'=>$infos->id])}}" class="btn btn-sm">查看详情</a>
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