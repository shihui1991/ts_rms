{{-- 继承aceAdmin后台布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>排名</th>
            <th>名称</th>
            <th>票数</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @if(filled($sdata['companys']))
            @foreach($sdata['companys'] as $company)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$company->name}}</td>
                    <td>{{$company->companyvotes_count}}</td>
                    <td>
                        @if($company->companyvotes_count)
                            <div class="btn-group">
                                <a href="{{route('g_companyvote_info',['company_id'=>$company->id,'item'=>$sdata['item']->id])}}" class="btn btn-xs">查看详情</a>
                            </div>
                        @endif

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

@endsection