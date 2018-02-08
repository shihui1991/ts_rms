{{-- 继承布局 --}}
@extends('gov.layout')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>

        <a class="btn" href="{{route('g_itembuilding_edit',['id'=>$sdata->id,'item_id'=>$edata['item_id']])}}">
            <i class="ace-icon fa fa-pencil-square-o bigger-110"></i>
            修改
        </a>
    </p>


    <div class="profile-user-info profile-user-info-striped">

        <div class="profile-info-row">
            <div class="profile-info-name"> 项目： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->item->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 地址： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->itemland->address}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 楼栋号： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->building}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 总楼层： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->total_floor}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 占地面积： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->area}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 建造年份： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->build_year}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 结构类型： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->buildingstruct->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 描述： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->infos}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 图片： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">
                    <ul class="ace-thumbnails clearfix img-content viewer">
                          @if(isset($sdata->picture))
                            @foreach($sdata->picture as $pic)
                                <li>
                                    <div>
                                        <img width="120" height="120" src="{!! $pic !!}" alt="加载失败">
                                        <div class="text">
                                            <div class="inner">
                                                <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </span>
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