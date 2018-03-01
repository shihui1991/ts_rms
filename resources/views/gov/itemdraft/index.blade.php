{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

        <div class="well well-sm">
            @if (blank($sdata))
            <a href="{{route('g_itemdraft_add',['item'=>$edata['item_id']])}}" class="btn">添加征收意见稿</a>
            @else
            <a href="{{route('g_itemdraft_edit',['id'=>$sdata->id,'item'=>$sdata->item_id])}}" class="btn">修改征收意见稿</a>
            @endif
        </div>

        @if (!blank($sdata))
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
                            <div class="user-profile row">
                                <div class="col-xs-12 col-sm-9">
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
                                                <div>
                                                    {{htmlspecialchars_decode($sdata->content)}}
                                                </div>
                                               {{-- <span class="editable editable-click">{{html_entity_decode($sdata->content)}}</span>--}}
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 状态码： </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{$sdata->code}}</span>
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
            </div>
        @endif
@endsection



