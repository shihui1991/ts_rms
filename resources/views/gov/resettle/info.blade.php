{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <div class="widget-container-col ui-sortable">
        <div class="widget-box ui-sortable-handle">
            <div class="widget-header">
                <h5 class="widget-title">被征收户</h5>
            </div>

            <div class="widget-body">
                <div class="widget-main row">
                    <div class="col-sm-6 col-xs-12">
                        <div class="profile-user-info profile-user-info-striped">

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 项目： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['item']->name}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 地址： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['household']->itemland->address}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 房号： </div>
                                <div class="profile-info-value">
                                <span class="editable editable-click">
                                    {{$sdata['household']->itembuilding->building}}栋{{$sdata['household']->unit}}单元{{$sdata['household']->floor}}楼{{$sdata['household']->number}}@if(is_numeric($sdata['household']->floor))号@endif
                                </span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 类型： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">
                                        {{$sdata['household']->type}}
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-6 col-xs-12">
                        <div class="profile-user-info profile-user-info-striped">

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 状态： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['household']->state->name}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 补偿方式： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['household']->pay->repay_way}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 过渡方式： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['household']->pay->transit_way}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 搬迁方式： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['household']->pay->move_way}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="tabbable">
        <ul class="nav nav-tabs padding-12 tab-color-blue background-blue">
            <li class="active">
                <a data-toggle="tab" href="#house_resettle" aria-expanded="true">产权调换记录</a>
            </li>

            <li class="">
                <a data-toggle="tab" href="#pay_house" aria-expanded="false">协议产权调换用房</a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="house_resettle" class="tab-pane active">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>序号</th>
                        <th>房源管理</th>
                        <th>小区</th>
                        <th>房号</th>
                        <th>户型</th>
                        <th>面积</th>
                        <th>有无电梯</th>
                        <th>类型</th>
                        <th>房源状态</th>
                        <th>安置日期</th>
                        <th>产权调换日期</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(filled($sdata['house_resettles']))
                        @foreach($sdata['house_resettles'] as $house_resettle)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$house_resettle->house->housecompany->name}}</td>
                                <td>{{$house_resettle->house->housecommunity->address}} {{$house_resettle->house->housecommunity->name}}</td>
                                <td>{{$house_resettle->house->building}}栋{{$house_resettle->house->unit}}单元{{$house_resettle->house->floor}}楼{{$house_resettle->house->number}}号</td>
                                <td>{{$house_resettle->house->layout->name}}</td>
                                <td>{{$house_resettle->house->area}}</td>
                                <td>{{$house_resettle->house->lift}}</td>
                                <td>{{$house_resettle->house->is_real}}</td>
                                <td>{{$house_resettle->house->state->name}}</td>
                                <td>{{$house_resettle->settle_at}}</td>
                                <td>{{$house_resettle->hold_at}}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{route('g_resettle_edit',['id'=>$house_resettle->id,'item'=>$sdata['item']->id])}}" class="btn btn-sm">更新</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>

            <div id="pay_house" class="tab-pane">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>序号</th>
                        <th>房源管理</th>
                        <th>小区</th>
                        <th>房号</th>
                        <th>户型</th>
                        <th>面积</th>
                        <th>有无电梯</th>
                        <th>类型</th>
                        <th>房源状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(filled($sdata['pay_houses']))
                        @foreach($sdata['pay_houses'] as $pay_house)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$pay_house->house->housecompany->name}}</td>
                                <td>{{$pay_house->house->housecommunity->address}} {{$pay_house->house->housecommunity->name}}</td>
                                <td>{{$pay_house->house->building}}栋{{$pay_house->house->unit}}单元{{$pay_house->house->floor}}楼{{$pay_house->house->number}}号</td>
                                <td>{{$pay_house->house->layout->name}}</td>
                                <td>{{$pay_house->house->area}}</td>
                                <td>{{$pay_house->house->lift}}</td>
                                <td>{{$pay_house->house->is_real}}</td>
                                <td>{{$pay_house->house->state->name}}</td>
                                <td>
                                    @if(blank($pay_house->houseresettle))
                                        <div class="btn-group">
                                            <a href="{{route('g_resettle_add',['id'=>$pay_house->id,'item'=>$sdata['item']->id])}}" class="btn btn-sm">开始安置</a>
                                        </div>
                                    @else
                                        已操作
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

{{-- 样式 --}}
@section('css')


@endsection

{{-- 插件 --}}
@section('js')
    @parent
    
@endsection