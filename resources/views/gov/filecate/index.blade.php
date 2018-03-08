{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')


    <div class="tabbable">
        <ul class="nav nav-tabs padding-12 tab-color-blue background-blue">
            
            @foreach($sdata as $filetable)
                <li class="@if($loop->index==0) active @endif">
                    <a data-toggle="tab" href="#filetable-{{$filetable->name}}" aria-expanded="@if($loop->index==0) true @endif">{{$filetable->infos}}</a>
                </li>
            @endforeach

        </ul>

        <div class="tab-content">

            @foreach($sdata as $filetable)
                <div id="filetable-{{$filetable->name}}" class="tab-pane @if($loop->index==0) active @endif">

                    <p>
                        <a href="{{route('g_filecate_add',['file_table_id'=>$filetable->id])}}" class="btn">添加【{{$filetable->infos}}】分类</a>
                    </p>
                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>文件名称</th>
                            <th>数据名称（英文）</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($filetable->filecates as $filecate)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$filecate->name}}</td>
                                <td>{{$filecate->filename}}</td>
                                <td>
                                    <a href="{{route('g_filecate_edit',['id'=>$filecate->id])}}" class="btn btn-sm">修改</a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                </div>
            @endforeach

        </div>
    </div>

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