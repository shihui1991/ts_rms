{{-- 继承aceAdmin后台布局 --}}
@extends('system.home')

{{-- 页面内容 --}}
@section('content')

    <div class="well well-sm">
        <a href="{{route('sys_pactcate_add')}}" class="btn">添加协议类型</a>
    </div>

    @if(filled($sdata))
        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>名称</th>
                <th>说明</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($sdata as $pactcate)
                <tr>
                    <td>{{$pactcate->id}}</td>
                    <td>{{$pactcate->name}}</td>
                    <td>{{str_limit($pactcate->infos,50)}}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{route('sys_pactcate_edit',['id'=>$pactcate->id])}}" class="btn btn-xs">
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