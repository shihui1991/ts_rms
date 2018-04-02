{{-- 继承布局 --}}
@extends('gov.main')


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
                                        <span class="editable editable-click">{{$sdata['pay_household']->itemland->address}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 房号： </div>
                                    <div class="profile-info-value">
                                <span class="editable editable-click">
                                    {{$sdata['pay_household']->itembuilding->building}}栋{{$sdata['pay_household']->household->unit}}单元{{$sdata['pay_household']->household->floor}}楼{{$sdata['pay_household']->household->number}}@if(is_numeric($sdata['pay_household']->household->floor))号@endif
                                </span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 类型： </div>
                                    <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['pay_household']->household->type}}</span>
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
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="profile-user-info profile-user-info-striped">

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 补偿方式： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['pay_household']->repay_way}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 过渡方式： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['pay_household']->transit_way}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 搬迁方式： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['pay_household']->move_way}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 补偿总额： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">
                                            <strong>{{number_format($sdata['pay_household']->total,2)}}</strong>
                                            人民币（大写）{{bigRMB($sdata['pay_household']->total)}}
                                            @if($sdata['pay_household']->household->getOriginal('type'))
                                                <br>
                                                其中：
                                                【{{$sdata['holder']->name}}（承租人）】所得补偿款：
                                                <strong>{{number_format($sdata['household_total'],2)}}</strong>
                                                人民币（大写）{{bigRMB($sdata['household_total'])}}
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
                @if(filled($sdata['pacts']))
                    @foreach($sdata['pacts'] as $pact)
                        @php $total=$pact->paysubjects->sum('total'); @endphp
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
                                                        @if($pact->cate_id==1)
                                                            @if($sdata['pay_household']->gerOriginal('repay_way')==1)
                                                                @php $total -= $sdata['pay_house_total']; @endphp
                                                            @endif

                                                        @endif
                                                        {{number_format($total,2)}}
                                                    </span>
                                                </div>
                                            </div>

                                        </div>

                                        <hr>
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th>序号</th>
                                                <th>名称</th>
                                                <th>计算公式</th>
                                                <th>补偿金额</th>
                                                <th>被征收户补偿比例（%）</th>
                                                <th>被征收户补偿金额</th>
                                                <th>状态</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(filled($pact->paysubjects))
                                                @php $total=0; @endphp
                                                @foreach($pact->paysubjects as $paysubject)
                                                    @php $total += $paysubject->total; @endphp
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$paysubject->subject->name}}</td>
                                                        <td>{{$paysubject->calculate}}</td>
                                                        <td>{{number_format($paysubject->amount,2)}}</td>
                                                        <td>{{number_format($paysubject->portion,2)}}</td>
                                                        <td>{{number_format($paysubject->total,2)}}</td>
                                                        <td>{{$paysubject->state->name}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                            @if($pact->cate_id==1)
                                                <tfoot>
                                                <tr>
                                                    <th>注：</th>
                                                    <th colspan="4">
                                                        被征收户所得：{{number_format($total,2)}}
                                                        @if($sdata['pay_household']->gerOriginal('repay_way')==1)
                                                            ，产权调换房总价：{{number_format($sdata['pay_house_total'],2)}}，产权调换后结余：
                                                            {{number_format($total-$sdata['pay_house_total'],2)}}
                                                        @endif
                                                    </th>
                                                </tr>
                                                </tfoot>
                                            @endif

                                        </table>
                                    </div>
                                    @if($pact->code=='173' && $pact->getOriginal('status')==1)
                                        <div>
                                            <a class="btn btn-danger" onclick="btnAct(this)" data-url="{{route('g_funds_pay_total',['item'=>$pact->item_id,'pact_id'=>$pact->id])}}" data-method="post">
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