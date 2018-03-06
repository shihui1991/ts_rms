{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')

    <div class="well well-sm">
        <a href="{{route('g_itemctrl_add',['item'=>$sdata['item']->id])}}" class="btn">添加操作</a>
    </div>
    
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>序号</th>
            <th>类别</th>
            <th>序列（轮次）</th>
            <th>开始时间</th>
            <th>结束时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            @if(filled($sdata['itemctrls']))
                @foreach($sdata['itemctrls'] as $itemctrl)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$itemctrl->ctrlcate->name}}</td>
                        <td>{{$itemctrl->serial}}</td>
                        <td>{{$itemctrl->start_at}}</td>
                        <td>{{$itemctrl->end_at}}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{route('g_itemctrl_edit',['item'=>$sdata['item']->id,'id'=>$itemctrl->id])}}" class="btn btn-xs">修改</a>
                            </div>

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
    @parent
    <script>

    </script>

@endsection