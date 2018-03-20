{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')


    <div class="well well-sm">
        <a href="javascript:history.back();" class="btn">返回</a>
        <a href="{{route('g_itemreward_add',['item'=>$sdata['item']->id])}}" class="btn">添加奖励方案</a>
    </div>

    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>起始日期</th>
            <th>截止日期</th>
            <th>奖励单价（住宅）</th>
            <th>奖励比例（非住宅）</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            @if(filled($sdata['item_rewards']))
                @foreach($sdata['item_rewards'] as $infos)
                    <tr>
                        <td>{{$infos->start_at}}</td>
                        <td>{{$infos->end_at}}</td>
                        <td>{{$infos->price}} 元/㎡</td>
                        <td>{{$infos->portion}} %</td>
                        <td>
                            <a href="{{route('g_itemreward_edit',['id'=>$infos->id,'item'=>$infos->item_id])}}" class="btn btn-sm">修改</a>
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