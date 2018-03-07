{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')

    <div class="row">
        <div class="well well-sm">
            <a class="btn" href="{{route('g_household',['item'=>$sdata['item_id']])}}"><i class="ace-icon fa fa-arrow-left bigger-110"></i>返回</a>
            <a class="btn" href="{{route('g_household_edit',['id'=>$sdata->id,'item'=>$sdata->item_id])}}">
                <i class="ace-icon fa fa-pencil-square-o bigger-110"></i>
                修改
            </a>
        </div>

        <div id="itembuilding" class="tab-pane fade active in">
            <div class="profile-user-info profile-user-info-striped">

                <div class="profile-info-row">
                    <div class="profile-info-name"> 地块： </div>
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
                    <div class="profile-info-name"> 房产类型： </div>
                    <div class="profile-info-value">
                        <span class="editable editable-click">{{$sdata->type}}</span>
                    </div>
                </div>

                <div class="profile-info-row">
                    <div class="profile-info-name"> 用户名： </div>
                    <div class="profile-info-value">
                        <span class="editable editable-click">{{$sdata->username}}</span>
                    </div>
                </div>

                <div class="profile-info-row">
                    <div class="profile-info-name"> 描述： </div>
                    <div class="profile-info-value">
                        <span class="editable editable-click">{{$sdata->infos}}</span>
                    </div>
                </div>

                <div class="profile-info-row">
                    <div class="profile-info-name"> 创建时间： </div>
                    <div class="profile-info-value">
                        <span class="editable editable-click">{{$sdata->created_at}}</span>
                    </div>
                </div>

                <div class="profile-info-row">
                    <div class="profile-info-name"> 更新时间： </div>
                    <div class="profile-info-value">
                        <span class="editable editable-click">{{$sdata->updated_at}}</span>
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
    <script src="{{asset('js/func.js')}}"></script>
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script>
        $('.img-content').viewer('update');
    </script>
@endsection


