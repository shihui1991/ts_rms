{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')


    <div class="well well-sm">
    </div>

    <table class="table table-hover table-bordered treetable" id="tree-crowd">
        <thead>
        <tr>
            <th>ID</th>
            <th>表名</th>
            <th>名称</th>
            <th>文件名称</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>

        @if($code=='success')
            @foreach($sdata as $infos)
                <tr>
                    <td>{{$infos->id}}</td>
                    <td>{{$infos->filetable->name}}</td>
                    <td>{{$infos->name}}</td>
                    <td>{{$infos->filename}}</td>
                    <td>
                        <a href="{{route('g_filecate_info',['id'=>$infos->id])}}" class="btn btn-sm">查看详情</a>
                    </td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>

@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')
    <script>

    </script>

@endsection