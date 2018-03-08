{{-- 继承aceAdmin后台布局 --}}
@extends('household.home')


{{-- 页面内容 --}}
@section('content')


    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>排名</th>
            <th>名称</th>
            <th>类型</th>
            <th>基本信息</th>
            <th>得票数</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($sdata as $value)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$value->company->name}}</td>
                <td>{{$value->company->type}}</td>
                <td>{{$value->company->infos}}</td>
                <td>{{$value->companyvotes_count}}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{route('h_company_info',['id'=>$value->company_id])}}" class="btn btn-xs">查看详情</a>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script src="{{asset('js/func.js')}}"></script>
    <script>


    </script>
@endsection