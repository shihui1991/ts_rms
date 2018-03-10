{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')
    <div class="well well-sm">
        <a href="{{route('g_itemland_add',['item'=>$edata['item_id']])}}" class="btn">添加项目地块</a>
    </div>
    <div class="row">
        <div class="col-xs-12">
            @if($code=='success')
                @foreach($sdata as $infos)
                    <div class="col-xs-6 col-sm-3 pricing-box">
                        <div class="widget-box widget-color-dark">
                            <div class="widget-header">
                                <h5 class="widget-title bigger lighter">{{$infos->address}}</h5>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">

                                    <div class="profile-user-info profile-user-info-striped">

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 土地性质： </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{$infos->landprop->name}}</span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 土地来源： </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{$infos->landsource->name}}</span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 土地权益状况： </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{$infos->landstate->name}}</span>
                                            </div>
                                        </div>

                                        @if($infos->adminunit->name)
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 公房单位： </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{$infos->adminunit->name}}</span>
                                            </div>
                                        </div>
                                            @else
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> 类型： </div>
                                                <div class="profile-info-value">
                                                    <span class="editable editable-click">私产单位</span>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 面积： </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{$infos->area}}</span>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div>
                                    <a href="{{route('g_itemland_info',['id'=>$infos->id,'item'=>$infos->item_id])}}" class="btn btn-block btn-inverse">
                                        <span>进入地块</span>
                                        <i class="ace-icon fa fa-chevron-circle-right bigger-110"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="row">
            <div class="col-xs-6">
                <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">共 @if($code=='success') {{ $sdata->total() }} @else 0 @endif 条数据</div>
            </div>
            <div class="col-xs-6">
                <div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
                    @if($code=='success') {{ $sdata->links() }} @endif
                </div>
            </div>
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