{{-- 继承aceAdmin后台布局 --}}
@extends('household.layout')



{{-- 页面内容 --}}
@section('content')
    <h3 class="header smaller lighter blue">
        <i class="ace-icon fa fa-bullhorn"></i>
        通知公告
    </h3>
    @if(filled($sdata))
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <div class="widget-container-col ui-sortable">


                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>编号</th>
                            <th>标题</th>
                            <th>发布时间</th>
                            <th>关键词</th>
                            <th>摘要</th>
                            <th>类型</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($sdata as $object)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$object->name}}</td>
                                <td>{{$object->release_at}}</td>
                                <td>{{$object->key}}</td>
                                <td>{{$object->infos}}</td>
                                <td>{{$object->newscate->name}}</td>
                                <td>
                                    <a href="{{route('h_news_info',['id'=>$object->id])}}"
                                       class="btn btn-sm">查看详情</a>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert">
                <i class="ace-icon fa fa-times"></i>
            </button>
            <strong>
                <i class="ace-icon fa fa-exclamation-circle"></i>
            </strong>
            <strong class="resp-error">暂无相关通知公告</strong>

            <br>
        </div>
    @endif
@endsection



