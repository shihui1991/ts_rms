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

    <div class="widget-box widget-color-red">
        <div class="widget-header">
            <h4 class="widget-title lighter smaller">协议</h4>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                    展开/关闭
                </a>
            </div>
        </div>

        <div class="widget-body">
            <div class="widget-main padding-8 row">
                @if(filled($sdata['unit_pacts']))
                    @foreach($sdata['unit_pacts'] as $pact)
                        <div class="col-xs-6 col-sm-6 pricing-box">
                            <div class="widget-box widget-color-red3">
                                <div class="widget-header">
                                    <h5 class="widget-title bigger lighter">{{$pact->pactcate->name}}</h5>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="profile-user-info profile-user-info-striped">

                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> 有效状态： </div>
                                                <div class="profile-info-value">
                                                    <span class="editable editable-click">{{$pact->status}}</span>
                                                </div>
                                            </div>
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> 兑付状态： </div>
                                                <div class="profile-info-value">
                                                    <span class="editable editable-click">{{$pact->state->name}}</span>
                                                </div>
                                            </div>
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> 协议金额： </div>
                                                <div class="profile-info-value">
                                                    <span class="editable editable-click">
                                                        {{number_format($pact->payunits->sum('amount'),2)}}
                                                    </span>
                                                </div>
                                            </div>

                                        </div>

                                        <hr>
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th>序号</th>
                                                <th>被征收户</th>
                                                <th>计算公式</th>
                                                <th>金额</th>
                                                <th>状态</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(filled($pact->payunits))
                                                @php $total=0; @endphp
                                                @foreach($pact->payunits as $payunit)
                                                    @php $total += $payunit->amount; @endphp
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$payunit->household->itemland->address}}{{$payunit->household->itembuilding->building}}栋{{$payunit->household->unit}}单元{{$payunit->household->floor}}楼{{$payunit->household->number}}号</td>
                                                        <td>{{$payunit->calculate}}</td>
                                                        <td>{{number_format($payunit->amount,2)}}</td>
                                                        <td>{{$payunit->state->name}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    @if($pact->code=='111' && $pact->getOriginal('status')==1)
                                        <div>
                                            <a class="btn btn-danger" onclick="btnAct(this)" data-url="{{route('g_funds_unit_total',['item'=>$pact->item_id,'pact_id'=>$pact->id])}}" data-method="post">
                                                <i class="ace-icon fa fa-check-square-o bigger-110"></i>
                                                <span>开始支付</span>
                                            </a>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="widget-box widget-color-grey">
        <div class="widget-header">
            <h4 class="widget-title lighter smaller">支付</h4>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                    展开/关闭
                </a>
            </div>
        </div>
        <div class="widget-body">
            <div class="widget-main padding-8">
                @if(filled($sdata['funds_totals']))
                <table class="table table-hover table-bordered treetable">
                    <thead>
                    <tr>
                        <th></th>
                        <th colspan="2">类别</th>
                        <th>金额</th>
                        <th>状态</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sdata['funds_totals'] as $funds_total)
                    <tr data-tt-id="funds_total-{{$funds_total->id}}" data-tt-parent-id="0">
                        <td>{{$loop->iteration}}</td>
                        <td colspan="2">{{$funds_total->fundscate->name}}</td>
                        <td>{{number_format($funds_total->amount,2)}}</td>
                        <td>{{$funds_total->state->name}}</td>
                        <td>
                            @if($funds_total->code=='112')
                                <a href="{{route('g_funds_pay_total_funds',['item'=>$funds_total->item_id,'total_id'=>$funds_total->id])}}" class="btn btn-sm">继续支付</a>
                            @endif
                        </td>
                    </tr>
                        @if(filled($funds_total->funds))
                            @foreach($funds_total->funds as $funds)@endforeach
                            <tr data-tt-id="funds_total-{{$funds_total->id}}-funds-{{$funds->id}}" data-tt-parent-id="funds_total-{{$funds_total->id}}">
                                <td>{{$funds->voucher}}</td>
                                <td>{{$funds->bank->name}}</td>
                                <td>{{$funds->account}}</td>
                                <td>{{$funds->name}}</td>
                                <td>{{number_format(abs($funds->amount),2)}}</td>
                                <td>{{$funds->entry_at}}</td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td>注：</td>
                        <td  colspan="2">金额为正表示收入，为负表示支出。</td>
                    </tr>
                    </tfoot>
                </table>
                @endif
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