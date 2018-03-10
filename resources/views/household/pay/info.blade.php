{{-- 继承布局 --}}
@extends('household.home')


{{-- 页面内容 --}}
@section('content')

    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <div class="widget-container-col ui-sortable">
                <div class="widget-box ui-sortable-handle">
                    <div class="widget-header">
                        <h5 class="widget-title">被征收户</h5>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
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
                                        @if($sdata['household']->getOriginal('type'))
                                            公产（{{$sdata['household']->itemland->adminunit->name}}）
                                        @else
                                            私产
                                        @endif
                                    </span>
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
                        <h5 class="widget-title">兑付汇总</h5>
                        <div class="widget-toolbar">

                        </div>

                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="profile-user-info profile-user-info-striped">

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 补偿方式： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['pay']->repay_way}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 过渡方式： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['pay']->transit_way}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 搬迁方式： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['pay']->move_way}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 补偿总额： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">
                                            <strong>{{number_format($sdata['pay']->total,2)}}</strong>
                                            人民币（大写）{{bigRMB($sdata['pay']->total)}}
                                            @if($sdata['household']->getOriginal('type'))
                                                <br>
                                                其中：
                                                <br>
                                                【{{$sdata['household']->itemland->adminunit->name}}（公产单位）】所得补偿款：
                                                <strong>{{number_format($sdata['pay_unit']->amount,2)}}</strong>
                                                人民币（大写）{{bigRMB($sdata['pay_unit']->amount)}}
                                                <br>
                                                【{{$sdata['holder']->name}}（承租人）】所得补偿款：
                                                <strong>{{number_format($sdata['pay']->total-$sdata['pay_unit']->amount,2)}}</strong>
                                                人民币（大写）{{bigRMB($sdata['pay']->total-$sdata['pay_unit']->amount)}}
                                            @endif
                                           
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
    
    <div class="well well-sm">
        <a href="" class="btn">
            补偿科目明细
        </a>
    </div>

    <div class="tabbable">
        <ul class="nav nav-tabs padding-12 tab-color-blue background-blue">
            <li class="active">
                <a data-toggle="tab" href="#pay_subject" aria-expanded="true">补偿科目</a>
            </li>

            <li class="">
                <a data-toggle="tab" href="#pay_building" aria-expanded="false">房屋建筑</a>
            </li>

            <li class="">
                <a data-toggle="tab" href="#pay_object" aria-expanded="false">其他补偿事项</a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="pay_subject" class="tab-pane active">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>序号</th>
                        <th>名称</th>
                        <th>计算公式</th>
                        <th>补偿小计</th>
                        <th>状态</th>

                    </tr>
                    </thead>
                    <tbody>
                    @if(filled($sdata['subjects']))
                        @foreach($sdata['subjects'] as $subject)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$subject->subject->name}}</td>
                                <td>{{$subject->calculate}}</td>
                                <td>{{number_format($subject->amount,2)}}</td>
                                <td>{{$subject->state->name}}</td>

                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>

            <div id="pay_building" class="tab-pane">

                <div id="accordion" class="accordion-style1 panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#register">
                                    <i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                    &nbsp;合法房屋及附属物
                                </a>
                            </h4>
                        </div>

                        <div class="panel-collapse collapse in" id="register">
                            <div class="panel-body">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th>用途</th>
                                        <th>结构</th>
                                        <th>朝向</th>
                                        <th>面积</th>
                                        <th>补偿单价</th>
                                        <th>补偿总价</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(filled($sdata['buildings']))
                                        @foreach($sdata['buildings'] as $building)
                                            @if($building->getOriginal('state') == 0)
                                            <tr>
                                                <td>{{$building->realuse->name}}</td>
                                                <td>{{$building->buildingstruct->name}}</td>
                                                <td>{{$building->direct}}</td>
                                                <td>{{number_format($building->real_outer,2)}}</td>
                                                <td>{{number_format($building->price,2)}}</td>
                                                <td>{{number_format($building->amount,2)}}</td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#legal">
                                    <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                    &nbsp;合法临建
                                </a>
                            </h4>
                        </div>

                        <div class="panel-collapse collapse" id="legal">
                            <div class="panel-body">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th>用途</th>
                                        <th>结构</th>
                                        <th>朝向</th>
                                        <th>面积</th>
                                        <th>补偿单价</th>
                                        <th>补偿总价</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(filled($sdata['buildings']))
                                        @foreach($sdata['buildings'] as $building)
                                            @if(in_array($building->getOriginal('state'),[2,5]))
                                                <tr>
                                                    <td>{{$building->realuse->name}}</td>
                                                    <td>{{$building->buildingstruct->name}}</td>
                                                    <td>{{$building->direct}}</td>
                                                    <td>{{number_format($building->real_outer,2)}}</td>
                                                    <td>{{number_format($building->price,2)}}</td>
                                                    <td>{{number_format($building->amount,2)}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#destroy">
                                    <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                    &nbsp;自行拆除补助
                                </a>
                            </h4>
                        </div>

                        <div class="panel-collapse collapse" id="destroy">
                            <div class="panel-body">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th>用途</th>
                                        <th>结构</th>
                                        <th>朝向</th>
                                        <th>面积</th>
                                        <th>补偿单价</th>
                                        <th>补偿总价</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(filled($sdata['buildings']))
                                        @foreach($sdata['buildings'] as $building)
                                            @if($building->getOriginal('state') == 4)
                                                <tr>
                                                    <td>{{$building->realuse->name}}</td>
                                                    <td>{{$building->buildingstruct->name}}</td>
                                                    <td>{{$building->direct}}</td>
                                                    <td>{{number_format($building->real_outer,2)}}</td>
                                                    <td>{{number_format($building->price,2)}}</td>
                                                    <td>{{number_format($building->amount,2)}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#public">
                                    <i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                    &nbsp;公共附属物
                                </a>
                            </h4>
                        </div>

                        <div class="panel-collapse collapse" id="public">
                            <div class="panel-body">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th>名称</th>
                                        <th>计量单位</th>
                                        <th>数量</th>
                                        <th>补偿单价</th>
                                        <th>补偿总价</th>
                                        <th>平分户数</th>
                                        <th>平均补偿</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(filled($sdata['publics']))
                                        @foreach($sdata['publics'] as $public)
                                            <tr>
                                                <td>{{$public->name}}</td>
                                                <td>{{$public->num_unit}}</td>
                                                <td>{{number_format($public->number,2)}}</td>
                                                <td>{{number_format($public->price,2)}}</td>
                                                <td>{{number_format($public->amount,2)}}</td>
                                                <td>{{number_format($public->household)}}</td>
                                                <td>{{number_format($public->avg,2)}}</td>
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

            <div id="pay_object" class="tab-pane">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>序号</th>
                        <th>名称</th>
                        <th>计量单位</th>
                        <th>数量</th>
                        <th>补偿单价</th>
                        <th>补偿总价</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(filled($sdata['objects']))
                        @foreach($sdata['objects'] as $object)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$object->name}}</td>
                                <td>{{$object->num_unit}}</td>
                                <td>{{number_format($object->number)}}</td>
                                <td>{{number_format($object->price,2)}}</td>
                                <td>{{number_format($object->amount,2)}}</td>
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

@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script src="{{asset('laydate/laydate.js')}}"></script>

@endsection