{{-- 继承布局 --}}
@extends('com.main')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="{{route('c_company_edit')}}">
            <i class="ace-icon fa fa-pencil-square-o bigger-110"></i>
            修改简介
        </a>
    </p>


    <div class="profile-user-info profile-user-info-striped">
        <div class="profile-info-row">
            <div class="profile-info-name"> LOGO： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">
                    <ul class="ace-thumbnails clearfix img-content viewer">
                        @if($sdata->logo)
                        <li>
                            <div>
                                <img width="120" height="120" src="{{$sdata->logo}}" alt="加载失败">
                                <div class="text">
                                    <div class="inner">
                                        <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endif
                    </ul>
                </span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 名称： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 地址： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->address}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 电话： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->phone}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 传真 </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->fax}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 联系人 </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->contact_man}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 联系电话 </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->contact_tel}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 描述 </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->infos}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 简介 </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->content}}</span>
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
    @parent
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script src="{{asset('js/func.js')}}"></script>
    <script>
        $('.img-content').viewer('update');
    </script>
@endsection