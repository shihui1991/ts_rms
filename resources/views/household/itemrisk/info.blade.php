{{-- 继承布局 --}}
@extends('household.layout')


{{-- 页面内容 --}}
@section('content')


    <div class="well well-sm">
        @if (blank($sdata))
            <a href="{{route('h_itemrisk_add')}}" class="btn">添加社会稳定风险评估</a>
        @else
            <a href="{{route('h_itemrisk_edit',['id'=>$sdata['risk']->id])}}" class="btn">修改社会稳定风险评估</a>
        @endif
    </div>
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
                            <div class="profile-info-name">被征户账号： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{session('household_user.user_name')}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name">征收态度： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata['risk']->agree}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name">项目地块： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata['risk']->land->address}}</span>
                            </div>
                        </div>


                        <div class="profile-info-row">
                            <div class="profile-info-name">楼栋： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata['risk']->building->building}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">补偿方式： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata['risk']->repay_way}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">房源单价： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata['risk']->house_price}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">房源面积： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata['risk']->house_area}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">房源户型： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata['risk']->layout->name}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">房源数量： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata['risk']->house_num}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">房源地址： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata['risk']->house_addr}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">增加面积单价： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata['risk']->more_price}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">过度方式： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata['risk']->transit_way}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">搬迁方式： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata['risk']->move_way}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">搬迁补偿： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata['risk']->move_fee}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">装修补偿： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata['risk']->decoration}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">设备拆迁费： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata['risk']->device}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">停产停业损失补偿： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata['risk']->business}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">创建时间： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata['risk']->created_at}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">更新时间： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata['risk']->updated_at}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">删除时间： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata['risk']->deleted_at}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="itemtopic" class="tab-pane fade">
                    @foreach($sdata['topic'] as $key=>$value)
                        <div class="space-4"></div>
                        <div >
                            <label>{{$value['topic']['name']}}：</label>
                            <textarea class="form-control" placeholder="请输入你的看法" readonly >{{$value->answer}}</textarea>
                        </div>
                        <div class="space-4"></div>
                        <hr>
                    @endforeach
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