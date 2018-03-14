{{-- 继承布局 --}}
@extends('com.main')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="{{route('c_household',['item'=>$sdata['item_id']])}}">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>
        @if($edata['type']==0)
            @if(filled($edata['estate']))
                <a class="btn" href="{{route('c_household_edit',['id'=>$edata['estate']->id,'household_id'=>$sdata->id,'item'=>$sdata->item_id])}}">
                    <i class="ace-icon fa fa-pencil-square-o bigger-110"></i>
                    修改房产信息
                </a>
             @else
                <a class="btn" href="{{route('c_household_add',['household_id'=>$sdata->id,'item'=>$sdata->item_id])}}">
                    <i class="ace-icon fa fa-pencil-square-o bigger-110"></i>
                    添加房产信息
                </a>
            @endif
        @else
            <a class="btn" href="{{route('c_household_add',['household_id'=>$sdata->id,'item'=>$sdata->item_id])}}">
                <i class="ace-icon fa fa-pencil-square-o bigger-110"></i>
                添加资产信息
            </a>
        @endif
    </p>

    <div class="well-sm">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#household" aria-expanded="true">
                        <i class="green ace-icon fa fa-building bigger-120"></i>
                        基本信息
                    </a>
                </li>
                @if($edata['type']==0)
                    <li class="">
                        <a data-toggle="tab" href="#householdbuilding" aria-expanded="false">
                            <i class="green ace-icon fa fa-home bigger-120"></i>
                            房产信息
                        </a>
                    </li>
                    @else
                    <li class="">
                        <a data-toggle="tab" href="#householdassets" aria-expanded="false">
                            <i class="green ace-icon fa fa-home bigger-120"></i>
                            资产信息
                        </a>
                    </li>
                 @endif
            </ul>
            <div class="tab-content">
                <div id="household" class="tab-pane fade active in">
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
                            <div class="profile-info-name"> 描述： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->infos}}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if($edata['type']==0)
                    <div id="householdbuilding" class="tab-pane fade">
                        @if(filled($edata['estate']))
                            <div class="profile-user-info profile-user-info-striped">
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 产权争议： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$edata['estate']->dispute}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 面积争议： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$edata['estate']->area_dispute}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 房屋状态： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$edata['estate']->status}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 房屋产权证号： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$edata['estate']->register}}</span>
                                    </div>
                                </div>


                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 建筑面积： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$edata['estate']->reg_outer}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 阳台面积： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$edata['estate']->balcony}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 批准用途： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$edata['estate']->defbuildinguse->name}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 实际用途： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$edata['estate']->realbuildinguse->name}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 经营项目： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$edata['estate']->business}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 资产评估： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$edata['estate']->has_assets}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 房屋证件，户型图，房屋图片： </div>
                                    <div class="profile-info-value">
                                    <span class="editable editable-click">
                                         <ul class="ace-thumbnails clearfix img-content viewer">
                                              @if(isset($edata['estate']->house_pic))
                                                 @foreach($edata['estate']->house_pic as $picturepic)
                                                 <li>
                                                    <div>
                                                        <img width="120" height="120" src="{!! $picturepic !!}" alt="加载失败">
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
                                    <div class="profile-info-name"> 被征收人签名： </div>
                                    <div class="profile-info-value">
                                    <span class="editable editable-click">
                                         <ul class="ace-thumbnails clearfix img-content viewer">
                                                 <li>
                                                <div>
                                                    <img width="120" height="120" src="{{$edata['estate']->sign}}" alt="加载失败">
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
                                    <div class="profile-info-name"> 创建时间： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$edata['estate']->created_at}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 更新时间： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$edata['estate']->updated_at}}</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="profile-user-info profile-user-info-striped">
                                <span>暂无房产信息</span>
                            </div>
                        @endif
                    </div>
                @else
                    <div id="householdassets" class="tab-pane fade">
                        @if(filled($edata['householdassets']))
                            <div class="col-xs-12">
                                @foreach($edata['householdassets'] as $info)
                                    <div class="col-xs-6 col-sm-3 pricing-box">
                                        <div class="widget-box widget-color-dark">
                                            <div class="widget-header">
                                                <h5 class="widget-title bigger lighter">{{$info->name}}</h5>
                                                <div class="widget-toolbar">
                                                    <a href="{{route('c_household_edit',['item'=>$info->item_id,'id'=>$info->id,'household_id'=>$info->household_id])}}" class="orange2">
                                                        <i class="ace-icon fa fa-edit"></i>
                                                        编辑
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="widget-body">
                                                <div class="widget-main">

                                                    <div class="profile-user-info profile-user-info-striped">

                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name"> 数量： </div>
                                                            <div class="profile-info-value">
                                                                <span class="editable editable-click">{{$info->com_num}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name"> 计量单位： </div>
                                                            <div class="profile-info-value">
                                                                <span class="editable editable-click">{{$info->num_unit}}</span>
                                                            </div>
                                                        </div>

                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name"> 图片： </div>
                                                            <div class="profile-info-value">
                                                                <span class="editable editable-click">
                                                                    <ul class="ace-thumbnails clearfix img-content viewer">
                                                                          @if($info->com_pic)
                                                                            @foreach($info->com_pic as $pic)
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
                        @else
                            <div class="profile-user-info profile-user-info-striped">
                                <span>暂无数据</span>
                            </div>
                        @endif

                    </div>
                @endif

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
    <script src="{{asset('js/func.js')}}"></script>
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script>
        $('.img-content').viewer('update');
    </script>
@endsection