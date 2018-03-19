{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

        @if (filled($sdata))
            <div class="well well-sm">
                <a href="{{route('g_itemdraft_edit',['item'=>$sdata->item_id])}}" class="btn">修改征收意见稿</a>
                <a href="{{route('g_itemdraftreport',['item'=>$sdata->item_id])}}" class="btn">听证会意见</a>
            </div>

            <div class="widget-container-col ui-sortable" id="widget-container-col-1">
                <div class="widget-box ui-sortable-handle" id="widget-box-1">
                    <div class="widget-header">
                        <h5 class="widget-title">征收意见稿</h5>
                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="user-profile">
                                <div class="profile-user-info profile-user-info-striped">
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> 名称： </div>
                                        <div class="profile-info-value">
                                            <span class="editable editable-click">{{$sdata->name}}</span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> 内容： </div>
                                        <div class="profile-info-value">
                                            <textarea name="content" id="content" style="width:100%;min-height: 360px;">{{$sdata->content}}</textarea>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> 状态： </div>
                                        <div class="profile-info-value">
                                            <span class="editable editable-click">{{$sdata->state->name}}</span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> 添加时间： </div>
                                        <div class="profile-info-value">
                                            <span class="editable editable-click">{{$sdata->created_at}}</span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> 修改时间： </div>
                                        <div class="profile-info-value">
                                            <span class="editable editable-click">{{$sdata->updated_at}}</span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> 删除时间： </div>
                                        <div class="profile-info-value">
                                            <span class="editable editable-click">{{$sdata->deleted_at}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <div class="alert alert-warning">
                <strong>注意：</strong>
                还未添加征收意见稿！
                &nbsp;&nbsp;&nbsp;
                <i class="fa fa-hand-o-right"></i>
                <a href="{{route('g_itemdraft_add',['item'=>$edata['item_id']])}}">去添加</a>
                <br>
            </div>

        @endif
@endsection
{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')
    <script src="{{asset('ueditor/ueditor.config.js')}}"></script>
    <script src="{{asset('ueditor/ueditor.all.min.js')}}"></script>
    <script>
        var ue = UE.getEditor('content',{
            readonly:true
            ,toolbars:null
            ,wordCount:false
        });
    </script>
@endsection


