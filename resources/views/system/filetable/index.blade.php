{{-- 继承aceAdmin后台布局 --}}
@extends('system.home')

{{-- 页面内容 --}}
@section('content')

    <div class="well well-sm">
        <a href="{{route('sys_filetable_add')}}" class="btn">添加附件数据表</a>
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

            @foreach($sdata as $filetable)
                <tr>
                    <td>{{$filetable->id}}</td>
                    <td>{{$filetable->name}}</td>
                    <td>{{str_limit($filetable->infos,50)}}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{route('sys_filetable_edit',['id'=>$filetable->id])}}" class="btn btn-xs">
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