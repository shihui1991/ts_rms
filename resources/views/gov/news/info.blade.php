{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <div class="well well-sm">
        <a href="{{route('g_news',['item'=>$sdata['item']->id])}}" class="btn">
            返回
        </a>

        <a href="{{route('g_news_edit',['item'=>$sdata['item']->id,'id'=>$sdata['news']->id])}}" class="btn">
            修改
        </a>
    </div>
    <div class="row">
        <div class="col-sm-5 col-xs-12">
            <div class="widget-container-col ui-sortable">
                <div class="widget-box ui-sortable-handle">
                    <div class="widget-header">
                        <h5 class="widget-title">基本信息</h5>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">

                            <div class="profile-user-info profile-user-info-striped">

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 项目： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['item']->name}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 分类： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['news']->newscate->name}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 名称： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['news']->name}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 发布时间： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['news']->release_at}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 关键词： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['news']->keys}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 摘要： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['news']->infos}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 附件： </div>
                                    <div class="profile-info-value">
                                        <ul class="ace-thumbnails clearfix img-content">
                                            @foreach($sdata['news']->picture as $pic)
                                                <li>
                                                    <div>
                                                        <img width="120" height="120" src="{{$pic}}" alt="{{$pic}}">
                                                        <div class="text">
                                                            <div class="inner">
                                                                <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 是否置顶： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['news']->is_top}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 状态： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['news']->state->name}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 创建时间： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['news']->created_at}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 更新时间： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['news']->updated_at}}</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-7 col-xs-12">
            <div class="widget-container-col ui-sortable">
                <div class="widget-box ui-sortable-handle">
                    <div class="widget-header">
                        <h5 class="widget-title">具体内容</h5>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <textarea id="content" name="content" style="min-height: 360px;">{{$sdata['news']->content}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

{{-- 样式 --}}
@section('css')

    <link rel="stylesheet" href="{{asset('viewer/viewer.min.css')}}" />

@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script src="{{asset('laydate/laydate.js')}}"></script>
    <script src="{{asset('ueditor/ueditor.config.js')}}"></script>
    <script src="{{asset('ueditor/ueditor.all.min.js')}}"></script>
    <script>
        var ue = UE.getEditor('content',
            {
                readonly:true
                ,toolbars:null
                ,wordCount:false
            });
        $('.img-content').viewer();
    </script>

@endsection