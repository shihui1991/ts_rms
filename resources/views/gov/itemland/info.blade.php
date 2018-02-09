{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')

    <div class="row">
        <div class="well well-sm">
            <a class="btn" href="{{route('g_itemland')}}">
                <i class="ace-icon fa fa-arrow-left bigger-110"></i>
                返回
            </a>
            <a href="{{route('g_itemland_edit',['id'=>$sdata['itemland']->id])}}" class="btn">修改地块信息</a>
            <a href="{{route('g_itembuilding_add',['item_id'=>$sdata['item_id'],'land_id'=>$sdata['itemland']->id])}}" class="btn">添加楼栋信息</a>
            <a href="{{route('g_itempublic_add',['item_id'=>$sdata['item_id'],'land_id'=>$sdata['itemland']->id,'building'=>'landpublic'])}}" class="btn">添加公共附属物信息</a>
        </div>

        <div class="well-sm">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#itemland" aria-expanded="true">
                            <i class="green ace-icon fa fa-building bigger-120"></i>
                            地块信息
                        </a>
                    </li>

                    <li class="">
                        <a data-toggle="tab" href="#itembuilding" aria-expanded="false">
                            <i class="green ace-icon fa fa-building bigger-120"></i>
                            楼栋信息
                        </a>
                    </li>

                    <li class="">
                        <a data-toggle="tab" href="#itempublic" aria-expanded="false">
                            <i class="green ace-icon fa fa-home bigger-120"></i>
                            公共附属物信息
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="itemland" class="tab-pane fade active in">
                        <div class="profile-user-info profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> 地址： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['itemland']->address}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 土地性质： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['itemland']->landprop->name}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 土地来源： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['itemland']->landsource->name}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 土地权益状况： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['itemland']->landstate->name}}</span>
                                </div>
                            </div>
                            @if($sdata['itemland']->adminunit->name != 0)
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 公产单位： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['itemland']->adminunit->name}}</span>
                                    </div>
                                </div>
                            @else
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 类型： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">私产单位</span>
                                    </div>
                                </div>
                            @endif

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 面积： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['itemland']->area}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 描述： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['itemland']->infos}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 图片： </div>
                                <div class="profile-info-value">
                            <span class="editable editable-click">
                                <ul class="ace-thumbnails clearfix img-content viewer">
                                      @if(isset($sdata['itemland']->picture))
                                        @foreach($sdata['itemland']->picture as $pic)
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
                                    <span class="editable editable-click">{{$sdata['itemland']->created_at}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 更新时间： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['itemland']->updated_at}}</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div id="itembuilding" class="tab-pane fade">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>楼栋号</th>
                                <th>总楼层</th>
                                <th>占地面积</th>
                                <th>建造年份</th>
                                <th>结构类型</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($code=='success')
                                @foreach($sdata['itembuilding'] as $info)
                                    <tr>
                                        <td>{{$info->id}}</td>
                                        <td>{{$info->building}}</td>
                                        <td>{{$info->total_floor}}</td>
                                        <td>{{$info->area}}</td>
                                        <td>{{$info->build_year}}</td>
                                        <td>{{$info->buildingstruct->name}}</td>
                                        <td>
                                            <a href="{{route('g_itembuilding_info',['id'=>$info->id,'land_id'=>$sdata['itemland']->id,'item_id'=>$sdata['item_id']])}}" class="btn btn-sm">查看详情</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>

                    <div id="itempublic" class="tab-pane fade">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>名称</th>
                                <th>计量单位</th>
                                <th>数量</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($code=='success')
                                @foreach($sdata['itempublic'] as $publicinfo)
                                    <tr>
                                        <td>{{$publicinfo->id}}</td>
                                        <td>{{$publicinfo->name}}</td>
                                        <td>{{$publicinfo->num_unit}}</td>
                                        <td>{{$publicinfo->number}}</td>
                                        <td>
                                            <a href="{{route('g_itempublic_info',['id'=>$publicinfo->id,'land_id'=>$sdata['itemland']->id,'item_id'=>$sdata['item_id'],'building'=>'landpublic'])}}" class="btn btn-sm">查看详情</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
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


