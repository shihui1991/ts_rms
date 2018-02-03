{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')


    <div class="well well-sm">
        <a href="{{route('g_user_add')}}" class="btn">添加人员</a>
    </div>

    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>序号</th>
            <th>用户名</th>
            <th>部门</th>
            <th>角色</th>
            <th>姓名</th>
            <th>电话</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>

        @if($code=='success')
            @foreach($sdata as $infos)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$infos->username}}</td>
                    <td>{{$infos->dept->name}}</td>
                    <td>{{$infos->role->name}}</td>
                    <td>{{$infos->name}}</td>
                    <td>{{$infos->phone}}</td>
                    <td>{{time()-strtotime($infos->action_at)<300?'在线':'离线'}}</td>
                    <td>
                        <a href="{{route('g_user_info',['id'=>$infos->id])}}" class="btn btn-sm">查看详情</a>
                    </td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>

    <p>
        @if($code=='success')
            {{$sdata->links()}}
        @endif
    </p>

@endsection

{{-- 样式 --}}
@section('css')


@endsection

{{-- 插件 --}}
@section('js')



@endsection