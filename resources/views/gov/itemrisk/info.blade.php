{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>
    </p>

    @if(filled($sdata))
        <div class="row">
            <div class="well-sm">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#itemrisk" aria-expanded="false">
                            <i class="green ace-icon fa fa-home bigger-120"></i>
                            意见调查
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#itemtopic" aria-expanded="false">
                            <i class="green ace-icon fa fa-home bigger-120"></i>
                            自选话题
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="itemrisk" class="tab-pane fade active in">
                        <div class="profile-user-info profile-user-info-striped">

                            <div class="profile-info-row">
                                <div class="profile-info-name">被征收户： </div>
                                <div class="profile-info-value">
                <span class="editable editable-click">
                {{$sdata->household->itemland->address}}{{$sdata->household->itembuilding->building}}栋{{$sdata->household->unit}}单元{{$sdata->household->floor}}楼{{$sdata->household->number}}号
                </span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">意见： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->agree}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">补偿方式： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->repay_way}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">房源单价： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->house_price}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">房源面积： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->house_area}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">房源数量： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->house_num}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">房源地址： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->house_addr}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">增加面积单价： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->more_price}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">户型： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->layout->name}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">过渡度方式： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->transit_way}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">搬迁方式： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->move_way}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">搬迁补偿： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->move_fee}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">装修补偿： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->decoration}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">设备拆迁费： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->device}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">停产停业损失补偿： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->business}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">创建时间： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->created_at}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">更新时间： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->updated_at}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">删除时间： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->deleted_at}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="itemtopic" class="tab-pane fade">
                        @if(filled($sdata['topic']))
                            @foreach($sdata['topic'] as $key=>$value)
                                <div class="space-4"></div>
                                <div >
                                    <label>{{$value['topic']['name']}}：</label>
                                    <textarea class="form-control" placeholder="请输入你的看法" readonly >{{$value->answer}}</textarea>
                                </div>
                                <div class="space-4"></div>
                                <hr>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

    @endif



@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')
    @parent

@endsection