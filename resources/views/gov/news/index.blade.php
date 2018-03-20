{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')


    <div class="well well-sm">
        <a href="{{route('g_news_add',['item'=>$sdata['item']->id])}}" class="btn">添加征收范围公告</a>
        <a href="{{route('g_draft_notice_add',['item'=>$sdata['item']->id])}}" class="btn">添加征收意见稿公告</a>
        <a href="{{route('g_program_notice_add',['item'=>$sdata['item']->id])}}" class="btn">添加征收决定公告</a>
    </div>

    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>序号</th>
            <th>分类</th>
            <th>名称</th>
            <th>发布时间</th>
            <th>关键词</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            @if(filled($sdata['newses']))
                @foreach($sdata['newses'] as $news)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$news->newscate->name}}</td>
                        <td>{{$news->name}}</td>
                        <td>{{$news->release_at}}</td>
                        <td>{{$news->keys}}</td>
                        <td>{{$news->is_top}} | {{$news->state->name}}</td>
                        <td>
                            <a href="{{route('g_news_info',['id'=>$news->id,'item'=>$sdata['item']->id])}}" class="btn btn-sm">查看详情</a>
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