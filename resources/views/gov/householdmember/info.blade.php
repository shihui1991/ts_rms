{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')

    <div class="row">
        <div class="well well-sm">
            <p>
                <a class="btn" href="{{route('g_householddetail_info',['item'=>$sdata->item_id,'id'=>$sdata->household_id])}}">
                    <i class="ace-icon fa fa-arrow-left bigger-110"></i>
                    返回被征户信息
                </a>

                <a class="btn" href="{{route('g_householdmember',['item'=>$sdata->item_id,'household_id'=>$sdata->household_id])}}">
                    <i class="ace-icon fa fa-arrow-left bigger-110"></i>
                    返回家庭成员
                </a>

                <a class="btn" href="{{route('g_householdmember_edit',['item'=>$sdata->item_id,'id'=>$sdata->id,'household_id'=>$sdata->household_id])}}">
                    <i class="ace-icon fa fa-pencil-square-o bigger-110"></i>
                    修改家庭成员详情
                </a>
                @if($sdata->getOriginal('crowd')==1)
                <a class="btn" href="{{route('g_householdmembercrowd_add',['item'=>$sdata->item_id,'household_id'=>$sdata->household_id,'member_id'=>$sdata->id])}}">
                    添加特殊人群信息
                </a>
                @endif
            </p>

        </div>

        <div class="well-sm">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#itembuilding" aria-expanded="true">
                            <i class="green ace-icon fa fa-building bigger-120"></i>
                            家庭成员详情
                        </a>
                    </li>
                    @if($sdata->getOriginal('crowd')==1)
                        <li class="">
                            <a data-toggle="tab" href="#itempublic" aria-expanded="false">
                                <i class="green ace-icon fa fa-home bigger-120"></i>
                                特殊人群信息
                            </a>
                        </li>
                    @endif
                </ul>

                <div class="tab-content">
                    <div id="itembuilding" class="tab-pane fade active in">
                        <div class="profile-user-info profile-user-info-striped">

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 姓名： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->name}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 与户主关系： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->relation}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 身份证： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->card_num}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 电话： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->phone}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 民族： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->nation->name}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 性别： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->sex}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 年龄： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->age}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 是否享受特殊人群优惠： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->crowd}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 权属类型： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->holder}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 权属分配比例： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->portion}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 身份证,户口本页： </div>
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
                    </div>

                    @if($sdata->getOriginal('crowd')==1)
                    <div id="itempublic" class="tab-pane fade">
                        <div class="col-xs-12">
                            @foreach($edata as $crowd)
                                <div class="col-xs-6 col-sm-3 pricing-box">
                                    <div class="widget-box widget-color-dark">
                                        <div class="widget-header">
                                            <h5 class="widget-title bigger lighter">{{$crowd->crowd->name}}</h5>
                                            <div class="widget-toolbar">
                                                <a href="{{route('g_householdmembercrowd_edit',['item'=>$crowd->item_id,'id'=>$crowd->id,'household_id'=>$crowd->household_id])}}" class="orange2">
                                                    <i class="ace-icon fa fa-edit"></i>
                                                    编辑
                                                </a>
                                            </div>
                                        </div>

                                        <div class="widget-body">
                                            <div class="widget-main">

                                                <div class="profile-user-info profile-user-info-striped">
                                                    <div class="profile-info-row">
                                                        <div class="profile-info-name"> 证件： </div>
                                                        <div class="profile-info-value">
                                                                <span class="editable editable-click">
                                                                    <ul class="ace-thumbnails clearfix img-content viewer">
                                                                          @if($crowd->picture)
                                                                            @foreach($crowd->picture as $pic)
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
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
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