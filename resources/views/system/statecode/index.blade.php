{{-- 继承aceAdmin后台布局 --}}
@extends('system.home')

{{-- 页面内容 --}}
@section('content')

    <div class="well well-sm">
        <a href="{{route('sys_statecode_add')}}" class="btn">添加状态代码</a>
    </div>

    @if(filled($sdata))
        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>代码</th>
                <th>名称</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($sdata as $statecode)
                <tr>
                    <td>{{$statecode->code}}</td>
                    <td>{{$statecode->name}}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{route('sys_statecode_edit',['id'=>$statecode->id])}}" class="btn btn-xs">
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