{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')

    <div class="row">
        <div class="well well-sm">
            <a class="btn" href="{{route('g_household',['item'=>$sdata['item_id']])}}"><i class="ace-icon fa fa-arrow-left bigger-110"></i>返回</a>
            <a class="btn" href="{{route('g_household_edit',['id'=>$sdata->id,'item'=>$sdata->item_id])}}">
                <i class="ace-icon fa fa-pencil-square-o bigger-110"></i>
                修改基本信息
            </a>
            @if(blank($edata['household_detail']))
                <a class="btn" href="{{route('g_householddetail_add',['household_id'=>$sdata->id,'item'=>$sdata->item_id])}}">
                    添加详细信息
                </a>
                @else
                <a class="btn" href="{{route('g_householddetail_edit',['id'=>$edata['household_detail']->id,'item'=>$sdata->item_id])}}">
                    <i class="ace-icon fa fa-pencil-square-o bigger-110"></i>
                    修改详细信息
                </a>
            @endif

        </div>

        <div class="well-sm">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#itembuilding" aria-expanded="true">
                            <i class="green ace-icon fa fa-building bigger-120"></i>
                           基本信息
                        </a>
                    </li>

                    <li class="">
                        <a data-toggle="tab" href="#itempublic" aria-expanded="false">
                            <i class="green ace-icon fa fa-home bigger-120"></i>
                            详细信息
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="itembuilding" class="tab-pane fade active in">
                        <div class="profile-user-info profile-user-info-striped">

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 地块： </div>
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
                                <div class="profile-info-name"> 房产类型： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->type}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 用户名： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->username}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 描述： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->infos}}</span>
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
                    </div>

                    <div id="itempublic" class="tab-pane fade">
                        @if(isset($edata['household_detail']))
                        <div class="profile-user-info profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> 产权争议： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$edata['household_detail']->dispute}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 状态： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$edata['household_detail']->state}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 房屋产权证号： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$edata['household_detail']->register}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 登记套内面积： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$edata['household_detail']->reg_inner}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 登记建筑面积： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$edata['household_detail']->reg_outer}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 阳台面积： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$edata['household_detail']->balcony}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 批准用途： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$edata['household_detail']->defbuildinguse->name}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 实际用途： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$edata['household_detail']->realbuildinguse->name}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 资产评估： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$edata['household_detail']->has_assets}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 征收意见： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$edata['household_detail']->agree}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 补偿方式： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$edata['household_detail']->repay_way}}</span>
                                </div>
                            </div>

                            @if($edata['household_detail']->getOriginal('repay_way')==1)
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 产权调换意向<br/>-房源单价： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$edata['household_detail']->house_price}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 产权调换意向<br/>-房源面积： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$edata['household_detail']->house_area}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 产权调换意向<br/>-房源数量： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$edata['household_detail']->house_num}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 产权调换意向<br/>-房源地址： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$edata['household_detail']->house_addr}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 产权调换意向<br/>-增加面积单价： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$edata['household_detail']->more_price}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 产权调换意向<br/>-房源户型： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$edata['household_detail']->layout->name}}</span>
                                    </div>
                                </div>
                            @endif

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 其他意见： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$edata['household_detail']->opinion}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 收件人： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$edata['household_detail']->receive_man}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 收件电话： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$edata['household_detail']->receive_tel}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 收件地址： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$edata['household_detail']->receive_addr}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 房源户型图： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">
                                         <ul class="ace-thumbnails clearfix img-content viewer">
                                             @if(isset($edata['household_detail']->layout_img))
                                                 @foreach($edata['household_detail']->layout_img as $layoutpic)
                                                 <li>
                                                    <div>
                                                        <img width="120" height="120" src="{!! $layoutpic !!}" alt="加载失败">
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
                                <div class="profile-info-name"> 房屋证件： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">
                                         <ul class="ace-thumbnails clearfix img-content viewer">
                                              @if(isset($edata['household_detail']->picture))
                                              @foreach($edata['household_detail']->picture as $picturepic)
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
                                <div class="profile-info-name"> 房屋图片： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">
                                         <ul class="ace-thumbnails clearfix img-content viewer">
                                              @if(isset($edata['household_detail']->house_img))
                                              @foreach($edata['household_detail']->house_img as $housepic)
                                                 <li>
                                                <div>
                                                    <img width="120" height="120" src="{!! $housepic !!}" alt="加载失败">
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
                                                    <img width="120" height="120" src="{{$edata['household_detail']->sign}}" alt="加载失败">
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
                                    <span class="editable editable-click">{{$edata['household_detail']->created_at}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 更新时间： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$edata['household_detail']->updated_at}}</span>
                                </div>
                            </div>
                        </div>
                        @endif
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

