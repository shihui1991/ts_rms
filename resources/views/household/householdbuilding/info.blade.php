{{-- 继承布局 --}}
@extends('household.layout')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>

    </p>


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
            <div class="profile-info-name"> 楼层： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->floor}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 朝向： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->direct}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 结构： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->buildingstruct->name}}</span>
            </div>
        </div>


        <div class="profile-info-row">
            <div class="profile-info-name"> 状态： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->state->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 登记套内面积： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->reg_inner}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 登记建筑面积： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->reg_outer}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 阳台面积： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->balcony}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 面积争议： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->dispute}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 实际套内面积： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->real_inner}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 实际建筑面积： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->real_outer}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 批准用途： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->defbuildinguse->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 实际用途： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->realbuildinguse->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 平面图形： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">
                    <ul class="ace-thumbnails clearfix img-content viewer">
                          @if(isset($sdata->layout_img))
                            @foreach($sdata->layout_img as $pics)
                                <li>
                                    <div>
                                        <img width="120" height="120" src="{!! $pics !!}" alt="加载失败">
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
            <div class="profile-info-name"> 图片及证件： </div>
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

        <div class="profile-info-row">
            <div class="profile-info-name"> 状态： </div>
            <div class="profile-info-value">
                <span class="editable editable-click"> @if($sdata->deleted_at) 已删除 @else 启用中 @endif</span>
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
        $('.img-content').viewer('update');
    </script>
@endsection