{{-- 继承布局 --}}
@extends('com.main')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>
        <a class="btn" href="{{route('c_household_add',['household_id'=>$sdata->id,'item'=>$sdata->item_id])}}">
            <i class="ace-icon fa fa-pencil-square-o bigger-110"></i>
            添加@if($edata['type']==0)房产@else资产@endif信息
        </a>
    </p>

    <div class="well-sm">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#household" aria-expanded="true">
                        <i class="green ace-icon fa fa-building bigger-120"></i>
                        基本信息
                    </a>
                </li>
                @if($edata['type']==0)
                    <li class="">
                        <a data-toggle="tab" href="#householdbuilding" aria-expanded="false">
                            <i class="green ace-icon fa fa-home bigger-120"></i>
                            房产信息
                        </a>
                    </li>
                    @else
                    <li class="">
                        <a data-toggle="tab" href="#householdassets" aria-expanded="false">
                            <i class="green ace-icon fa fa-home bigger-120"></i>
                            资产信息
                        </a>
                    </li>
                 @endif
            </ul>
            <div class="tab-content">
                <div id="household" class="tab-pane fade active in">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-row">
                            <div class="profile-info-name"> 地块地址： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->itemland->address}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 楼栋： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->itembuilding->building}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 单元号： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->unit}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 楼层： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->floor}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 房号： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->number}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 描述： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->infos}}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if($edata['type']==0)
                    <div id="householdbuilding" class="tab-pane fade">

                    </div>
                @else
                    <div id="householdassets" class="tab-pane fade">

                    </div>
                @endif

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

@endsection