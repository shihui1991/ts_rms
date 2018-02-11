{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>

        <a class="btn" href="{{route('g_house_edit',['id'=>$sdata->id])}}">
            <i class="ace-icon fa fa-pencil-square-o bigger-110"></i>
            修改
        </a>
    </p>


    <div class="profile-user-info profile-user-info-striped">

        <div class="profile-info-row">
            <div class="profile-info-name"> 管理机构： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->housecompany->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 房源社区： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->housecommunity->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 房源户型： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->layout->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 房源户型图： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">
                     <ul class="ace-thumbnails clearfix img-content viewer">
                         <li>
                            <div>
                                <img width="120" height="120" src="{{$sdata->houselayoutimg->picture}}" alt="加载失败">
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
            <div class="profile-info-name"> 房源位置： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">
                    {{$sdata->unit?$sdata->unit.' 单元':''}}
                    {{$sdata->building?$sdata->building.' 栋':''}}
                    {{$sdata->floor?$sdata->floor.' 楼':''}}
                    {{$sdata->number?$sdata->number.' 号':''}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 房源面积： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->area}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 总楼层： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->total_floor}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 是否电梯房： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->lift}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 房源类型： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->is_real}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 购置状态： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->is_buy}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 可临时周转状况： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->is_transit}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 可项目共享状况： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->is_public}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 交付时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->delive_at}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 房源状态： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->state}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 房源图片： </div>
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
            <div class="profile-info-name"> 数据状态： </div>
            <div class="profile-info-value">
                <span class="editable editable-click"> @if($sdata->deleted_at) 已删除 @else 启用中 @endif</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 删除时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->deleted_at}}</span>
            </div>
        </div><br/>
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