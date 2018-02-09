{{-- 继承aceAdmin后台布局 --}}
@extends('system.home')

{{-- 页面内容 --}}
@section('content')

    <div class="well well-sm">
        <a href="{{route('sys_fundscate_add')}}" class="btn">添加进出类型</a>
    </div>

    @if(filled($sdata))
        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>表名</th>
                <th>说明</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($sdata as $fundscate)
                <tr>
                    <td>{{$fundscate->id}}</td>
                    <td>{{$fundscate->name}}</td>
                    <td>{{str_limit($fundscate->infos,50)}}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{route('sys_fundscate_edit',['id'=>$fundscate->id])}}" class="btn btn-xs">
                                修改
                            </a>
                        </div>
                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>
    @endif

@endsection

{{-- 样式 --}}
@section('css')
    
@endsection

{{-- 插件 --}}
@section('js')
    @parent
    
@endsection