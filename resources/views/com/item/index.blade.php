{{-- 继承aceAdmin后台布局 --}}
@extends('com.main')


{{-- 页面内容 --}}
@section('content')

    <div class="row">
        <div class="col-xs-12">
            @if($code=='success')
                @foreach($sdata as $infos)
                    <div class="col-xs-6 col-sm-3 pricing-box">
                        <div class="widget-box widget-color-dark">
                            <div class="widget-header">
                                <h5 class="widget-title bigger lighter">{{$infos->item->name}}</h5>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">

                                    <div class="profile-user-info profile-user-info-striped">

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 征收范围： </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{str_limit($infos->item->place,50)}}</span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 项目描述： </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{str_limit($infos->item->infos,50)}}</span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 项目负责人： </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">
                                                    {{$infos->item->itemadmins->implode('name','、')}}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 项目进度： </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">
                                                    {{$infos->item->schedule->name}} - {{$infos->item->process->name}}({{$infos->item->state->name}})
                                                </span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 总户数： </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{number_format($infos->item->households_count)}}</span>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div>
                                    <a href="{{route('c_household',['item'=>$infos->item_id])}}" class="btn btn-block btn-inverse">
                                        <span>进入项目</span>
                                        <i class="ace-icon fa fa-chevron-circle-right bigger-110"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">共 {{$sdata->total()}} 条数据</div>
        </div>
        <div class="col-xs-6">
            <div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
                {{ $sdata->links() }}
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
            <strong class="resp-error">{{$message}}</strong>

            <br>
        </div>

    @endif

@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')
    @parent
@endsection