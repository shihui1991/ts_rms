{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>

        <a class="btn" href="{{route('g_itemcompany_edit',['id'=>$sdata->id,'item'=>$sdata->item_id])}}">
            <i class="ace-icon fa fa-pencil-square-o bigger-110"></i>
            修改
        </a>
    </p>


    <div class="profile-user-info profile-user-info-striped">

        <div class="profile-info-row">
            <div class="profile-info-name"> 类型： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->type}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 评估机构： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->company->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 评估委托书： </div>
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
            <div class="profile-info-name"> 【征收范围】 &nbsp;<br/>【被征收户】： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>序号</th>
                                <th>地块</th>
                                <th>楼栋</th>
                                <th>位置</th>
                                <th>房产类型</th>
                                <th>是否需要资产评估</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($edata['companyhousehold'] as $info)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$info->household->itemland->address}}</td>
                                <td>{{$info->household->itembuilding->building}}</td>
                                <td>{{$info->household->unit?$info->household->unit.'单元':''}}
                                    {{$info->household->floor?$info->household->floor.'楼':''}}
                                    {{$info->household->number?$info->household->number.'号':''}}</td>
                                <td>{{$info->household->type}}</td>
                                <td>{{$info->household->householddetail->has_assets}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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