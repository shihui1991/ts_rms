{{-- 继承aceAdmin后台布局 --}}
@extends('system.home')

{{-- 页面内容 --}}
@section('content')

    <div class="well well-sm">
        <a href="{{route('sys_subject_add')}}" class="btn">添加重要补偿科目</a>
    </div>

    @if(filled($sdata))
        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>名称</th>
                <th>固定科目</th>
                <th>说明</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($sdata as $subject)
                <tr>
                    <td>{{$subject->id}}</td>
                    <td>{{$subject->name}}</td>
                    <td>{{$subject->main}}</td>
                    <td>{{str_limit($subject->infos,50)}}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{route('sys_subject_edit',['id'=>$subject->id])}}" class="btn btn-xs">
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