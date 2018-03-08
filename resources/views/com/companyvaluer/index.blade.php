{{-- 继承主体 --}}
@extends('com.main')

{{-- 页面内容 --}}
@section('content')


    <div class="well well-sm">
        <a href="{{route('c_companyvaluer_add')}}" class="btn">添加评估师</a>
    </div>

    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>序号</th>
            <th>名称</th>
            <th>电话</th>
            <th>注册号</th>
            <th>有效期</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            @if($code=='success')
                @foreach($sdata as $infos)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$infos->name}}</td>
                        <td>{{$infos->phone}}</td>
                        <td>{{$infos->register}}</td>
                        <td>{{$infos->valid_at}}</td>
                        <td>
                            <a href="{{route('c_companyvaluer_info',['id'=>$infos->id])}}" class="btn btn-sm">查看详情</a>
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