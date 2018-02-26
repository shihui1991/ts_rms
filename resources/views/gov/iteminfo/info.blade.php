{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')


        @if($sdata->schedule_id==1 && $sdata->process_id==1 && $sdata->code=='2')
        <p>
            <a class="btn" href="{{route('g_iteminfo_edit',['item'=>$sdata->id])}}">
                <i class="ace-icon fa fa-pencil-square-o bigger-110"></i>
                修改
            </a>

            <a class="btn" onclick="btnAct(this)" data-url="{{route('g_itemprocess_c2dc',['item'=>$sdata->id])}}">
                <i class="ace-icon fa fa-cloud-upload bigger-110"></i>
                提交部门审查
            </a>

        </p>

        @elseif($sdata->schedule_id==1 && $sdata->process_id==4 && $sdata->code=='2')
            <p><a class="btn" onclick="btnAct(this)" data-url="{{route('g_itemprocess_c2dc',['item'=>$sdata->id])}}">
                <i class="ace-icon fa fa-cloud-upload bigger-110"></i>
                提交部门审查
            </a></p>

        @elseif($sdata->schedule_id==1 && $sdata->process_id==3 && $sdata->code=='22')
            <p><a class="btn" onclick="btnAct(this)" data-url="{{route('g_itemprocess_c2gc',['item'=>$sdata->id])}}">
                    <i class="ace-icon fa fa-cloud-upload bigger-110"></i>
                    提交区政府审查
                </a></p>
        @endif



    <div class="profile-user-info profile-user-info-striped">

        <div class="profile-info-row">
            <div class="profile-info-name"> 名称： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 征收范围： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->place}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 征收范围红线地图： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">
                <ul class="ace-thumbnails clearfix img-content">
                    <li>
                        <div>
                            <img width="120" height="120" src="{{$sdata->map}}" alt="{{$sdata->map}}">
                            <div class="text">
                                <div class="inner">
                                    <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                </span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 描述： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->infos}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 状态： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">
                    {{$sdata->schedule->name}} - {{$sdata->process->name}} ({{$sdata->state->name}})
                </span>
            </div>
        </div>

        @foreach($sdata->picture as $name=>$pictures)
            <div class="profile-info-row">
                <div class="profile-info-name"> {{$edata[$name]}}： </div>
                <div class="profile-info-value">
                <span class="editable editable-click">
                    <ul class="ace-thumbnails clearfix img-content">
                        @foreach($pictures as $pic)
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
                </span>
                </div>
            </div>
        @endforeach

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

        <div class="profile-info-row">
            <div class="profile-info-name"> 删除时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->deleted_at}}</span>
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

    <script src="{{asset('js/func.js')}}"></script>

    <script>
        $('.img-content').viewer();
    </script>

@endsection