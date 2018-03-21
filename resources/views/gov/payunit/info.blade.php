{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <div class="widget-container-col ui-sortable">
                <div class="widget-box ui-sortable-handle">
                    <div class="widget-header">
                        <h5 class="widget-title">公房单位</h5>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="profile-user-info profile-user-info-striped">

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 名称： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['admin_unit']->name}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 地址： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['admin_unit']->address}}</span>
                                    </div>
                                </div>
                                
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 电话： </div>
                                    <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['admin_unit']->phone}}</span>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xs-12">
            <div class="widget-container-col ui-sortable">
                <div class="widget-box ui-sortable-handle">
                    <div class="widget-header">
                        <h5 class="widget-title">补偿概述</h5>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="profile-user-info profile-user-info-striped">

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 联系人： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['admin_unit']->contact_man}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 联系电话： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['admin_unit']->contact_tel}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 补偿总额： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">
                                            <strong>{{number_format($sdata['total']->total,2)}}</strong>
                                            人民币（大写）{{bigRMB($sdata['total']->total)}}
                                        </span>
                                    </div>
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
                <a data-toggle="tab" href="#pay_unit" aria-expanded="true">补偿明细</a>
            </li>
            
            <li class="">
                <a data-toggle="tab" href="#pay_unit_pact" aria-expanded="false">协议</a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="pay_unit" class="tab-pane active">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>序号</th>
                        <th>被征收户</th>
                        <th>计算公式</th>
                        <th>补偿小计</th>
                        <th>状态</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(filled($sdata['pay_units']))
                        @foreach($sdata['pay_units'] as $pay_unit)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$pay_unit->itemland->address}}{{$pay_unit->household->itembuilding->building}}栋{{$pay_unit->household->unit}}单元{{$pay_unit->household->floor}}楼{{$pay_unit->household->number}}号</td>
                                <td>{{$pay_unit->calculate}}</td>
                                <td>{{number_format($pay_unit->amount,2)}}</td>
                                <td>{{$pay_unit->state->name}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                @if(filled($sdata['pay_units']))
                <div class="row">
                    <div class="col-xs-6">
                        <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">
                            共{{ $sdata['pay_units']->total() }}条数据
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
                           {{ $sdata['pay_units']->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div id="pay_unit_pact" class="tab-pane">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>序号</th>
                        <th>类别</th>
                        <th>签约时间</th>
                        <th>协议金额</th>
                        <th>状态</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(filled($sdata['unit_pacts']))
                        @foreach($sdata['unit_pacts'] as $pact)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$pact->pactcate->name}}</td>
                                <td>{{$pact->sign_at}}</td>
                                <td>{{number_format($pact->payunits->sum('amount'),2)}}</td>
                                <td>{{$pact->state->name}} | {{$pact->status}}</td>
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

    <link rel="stylesheet" href="{{asset('viewer/viewer.min.css')}}" />
    <link rel="stylesheet" href="{{asset('treetable/jquery.treetable.theme.default.css')}}">

@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script src="{{asset('treetable/jquery.treetable.js')}}"></script>

    <script>
        $('.img-content').viewer();
        $(".treetable").treetable({
            expandable: true // 展示
            ,initialState :"collapsed"//默认打开所有节点
            ,stringCollapse:'关闭'
            ,stringExpand:'展开'});
    </script>

@endsection