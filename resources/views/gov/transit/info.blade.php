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
                <a data-toggle="tab" href="#house_transit" aria-expanded="true">临时周转记录</a>
            </li>

            <li class="">
                <a data-toggle="tab" href="#pay_transit" aria-expanded="false">协议临时周转用房</a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="house_transit" class="tab-pane active">
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
                        <th>房源状态</th>
                        <th>过渡日期</th>
                        <th>预计结束日期</th>
                        <th>结束日期</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(filled($sdata['house_transits']))
                        @foreach($sdata['house_transits'] as $house_transit)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$house_transit->house->housecompany->name}}</td>
                                <td>{{$house_transit->house->housecommunity->address}} {{$house_transit->house->housecommunity->name}}</td>
                                <td>{{$house_transit->house->building}}栋{{$house_transit->house->unit}}单元{{$house_transit->house->floor}}楼{{$house_transit->house->number}}号</td>
                                <td>{{$house_transit->house->layout->name}}</td>
                                <td>{{$house_transit->house->area}}</td>
                                <td>{{$house_transit->house->lift}}</td>
                                <td>{{$house_transit->house->state->name}}</td>
                                <td>{{$house_transit->start_at}}</td>
                                <td>{{$house_transit->exp_end}}</td>
                                <td>{{$house_transit->end_at}}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{route('g_transit_edit',['id'=>$house_transit->id,'item'=>$sdata['item']->id])}}" class="btn btn-sm">过渡结束</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>

            <div id="pay_transit" class="tab-pane">
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
                        <th>房源状态</th>
                        <th>协议类型</th>
                        <th>协议状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(filled($sdata['pay_transits']))
                        @foreach($sdata['pay_transits'] as $pay_transit)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$pay_transit->house->housecompany->name}}</td>
                                <td>{{$pay_transit->house->housecommunity->address}} {{$pay_transit->house->housecommunity->name}}</td>
                                <td>{{$pay_transit->house->building}}栋{{$pay_transit->house->unit}}单元{{$pay_transit->house->floor}}楼{{$pay_transit->house->number}}号</td>
                                <td>{{$pay_transit->house->layout->name}}</td>
                                <td>{{$pay_transit->house->area}}</td>
                                <td>{{$pay_transit->house->lift}}</td>
                                <td>{{$pay_transit->house->state->name}}</td>
                                <td>{{$pay_transit->pact->pactcate->name}}</td>
                                <td>{{$pay_transit->pact->state->name}}</td>
                                <td>
                                    @if(blank($pay_transit->housetransit))
                                        <div class="btn-group">
                                            <a href="{{route('g_transit_add',['id'=>$pay_transit->id,'item'=>$sdata['item']->id])}}" class="btn btn-sm">开始过渡</a>
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