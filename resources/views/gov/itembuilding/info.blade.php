{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')

    <div class="row">
        <div class="well well-sm">
            <a class="btn" href="{{route('g_itemland_info',['id'=>$sdata['land_id'],'item'=>$sdata['item_id']])}}"><i class="ace-icon fa fa-arrow-left bigger-110"></i>返回</a>
            <a href="{{route('g_itembuilding_edit',['id'=>$sdata['itembuilding']->id,'item'=>$sdata['item_id'],'land_id'=>$sdata['land_id']])}}" class="btn">修改楼栋信息</a>
            <a href="{{route('g_itempublic_add',['item'=>$sdata['item_id'],'land_id'=>$sdata['land_id'],'building_id'=>$sdata['itembuilding']->id,'building'=>'buildingpublic'])}}" class="btn">添加公共附属物信息</a>
        </div>

        <div class="well-sm">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#itembuilding" aria-expanded="true">
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
                    <div id="itembuilding" class="tab-pane fade active in">
                        <div class="profile-user-info profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> 楼栋号： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['itembuilding']->building}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 总楼层： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['itembuilding']->total_floor}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 占地面积： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['itembuilding']->area}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 建造年份： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['itembuilding']->build_year}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 结构类型： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['itembuilding']->buildingstruct->name}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 描述： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['itembuilding']->infos}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 图片： </div>
                                <div class="profile-info-value">
                <span class="editable editable-click">
                    <ul class="ace-thumbnails clearfix img-content viewer">
                          @if(isset($sdata['itembuilding']->picture))
                            @foreach($sdata['itembuilding']->picture as $pic)
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
                                    <span class="editable editable-click">{{$sdata['itembuilding']->created_at}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 更新时间： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['itembuilding']->updated_at}}</span>
                                </div>
                            </div>

                        </div>
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
                                            <a href="{{route('g_itempublic_info',['id'=>$publicinfo->id,'land_id'=>$sdata['land_id'],'item'=>$sdata['item_id'],'building'=>'buildingpublic','building_id'=>$sdata['itembuilding']->id])}}" class="btn btn-sm">查看详情</a>
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



