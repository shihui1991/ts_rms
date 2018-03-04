{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')

    <div class="widget-container-col ui-sortable">
        <div class="widget-box ui-sortable-handle">
            <div class="widget-header">
                <h5 class="widget-title">资金汇总</h5>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>

                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <div class="user-profile row">
                        <div class="col-xs-12 col-sm-9">
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>资金类型</th>
                                    <th>进出总额</th>
                                    <th>收入/支出</th>
                                </tr>
                                </thead>
                                @if(filled($sdata['funds_details']))
                                    <tbody>
                                    @php $total=0; @endphp
                                    @foreach($sdata['funds_details'] as $fundscate)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$fundscate->name}}</td>
                                            <td>{{number_format(abs($fundscate->total),2)}}</td>
                                            <td>@if($fundscate->total>0) 收入 @elseif($fundscate->total<0) 支出 @endif</td>
                                        </tr>
                                        @php $total += $fundscate->total; @endphp
                                    @endforeach

                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <th colspan="4">资金结余：{{number_format($total,2)}} &nbsp; 人民币（大写）：{{bigRMB(abs($total))}}</th>
                                    </tr>
                                    </tfoot>
                                @endif

                            </table>

                        </div>
                        <div class="col-xs-12 col-sm-3">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h3 class="header smaller lighter blue">
        <i class="ace-icon fa fa-book"></i>
        资金流水
    </h3>
    <div class="tabbable">
        <ul class="nav nav-tabs padding-12 tab-color-blue background-blue">

            @if(filled($sdata['funds_details']))
                @foreach($sdata['funds_details'] as $fundscate)
                    <li @if($loop->iteration==1) class="active" @endif>
                        <a data-toggle="tab" href="#fundscate{{$fundscate->id}}" aria-expanded="false">{{$fundscate->name}}</a>
                    </li>
                @endforeach
            @endif

        </ul>

        <div class="tab-content">

            @if(filled($sdata['funds_details']))
                @foreach($sdata['funds_details'] as $fundscate)
                    <div id="fundscate{{$fundscate->id}}" @if($loop->iteration==1) class="tab-pane active" @else class="tab-pane" @endif>
                        <table class="table table-hover table-bordered">
                            <caption>当前总额：{{number_format(abs($fundscate->total),2)}}</caption>
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>凭证号</th>
                                <th>银行</th>
                                <th>账号</th>
                                <th>姓名</th>
                                <th>金额</th>
                                <th>到账时间</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($fundscate->fundses as $funds)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$funds->voucher}}</td>
                                    <td>{{$funds->bank->name}}</td>
                                    <td>{{$funds->account}}</td>
                                    <td>{{$funds->name}}</td>
                                    <td>{{number_format(abs($funds->amount),2)}}</td>
                                    <td>{{$funds->entry_at}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{route('g_funds_info',['item'=>$sdata['item']->id,'id'=>$funds->id])}}" class="btn btn-xs">详情</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                @endforeach
            @endif
        </div>
    </div>

@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script>

    </script>

@endsection