{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <div class="widget-box widget-color-grey collapsed">
        <div class="widget-header">
            <h4 class="widget-title lighter smaller">工作日志</h4>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-down"></i>
                    展开/关闭
                </a>
            </div>
        </div>
        <div class="widget-body">
            <div class="widget-main padding-8">

                <div class="timeline-container timeline-style2">

                    <div class="timeline-items">

                        @foreach($sdata['worknotices'] as $worknotice)

                            <div class="timeline-item clearfix">
                                <div class="timeline-info">
                                    <span class="timeline-date">{{$worknotice->updated_at}}</span>

                                    <i class="timeline-indicator btn btn-info no-hover"></i>
                                </div>

                                <div class="widget-box transparent">
                                    <div class="widget-body">
                                        <div class="widget-main no-padding">
                                            <span class="bigger-110">{{$worknotice->process->name}} 【{{$worknotice->state->name}}】</span>
                                            <br>
                                            <i class="ace-icon fa fa-user green bigger-125"></i>
                                            <span>{{$worknotice->dept->name}} - {{$worknotice->role->name}} - {{$worknotice->user->name}}</span>
                                            <br>
                                            <a href="{{route('g_infos',['id'=>$worknotice->id])}}" title="查看详情">
                                                <i class="ace-icon fa fa-info-circle blue bigger-125"></i>
                                                @if($worknotice->process->getOriginal('type')==2) 审查意见： @endif
                                            </a>
                                            <span>{{$worknotice->infos}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach

                    </div><!-- /.timeline-items -->
                </div><!-- /.timeline-container -->

            </div>
        </div>
    </div>

    <div class="widget-box widget-color-green2">
        <div class="widget-header">
            <h4 class="widget-title lighter smaller">资金明细：</h4>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                    展开/关闭
                </a>
            </div>
        </div>
        <div class="widget-body">
            <div class="widget-main padding-8">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>序号</th>
                        <th>凭证号</th>
                        <th>银行</th>
                        <th>账号</th>
                        <th>姓名</th>
                        <th>金额</th>
                        <th>到账时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $funds_total=0;@endphp
                    @if(filled($sdata['fundses']))
                    @foreach($sdata['fundses'] as $funds)
                        @php $funds_total+=$funds->amount;@endphp
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$funds->voucher}}</td>
                            <td>{{$funds->bank->name}}</td>
                            <td>{{$funds->account}}</td>
                            <td>{{$funds->name}}</td>
                            <td>{{number_format($funds->amount,2)}}</td>
                            <td>{{$funds->entry_at}}</td>
                        </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="widget-box widget-color-blue2">
        <div class="widget-header">
            <h4 class="widget-title lighter smaller">当前资金与初步预算：</h4>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                    展开/关闭
                </a>
            </div>
        </div>
        <div class="widget-body">
            <div class="widget-main padding-8">

                <div class="profile-user-info profile-user-info-striped">

                    <div class="profile-info-row">
                        <div class="profile-info-name"> 当前资金： </div>
                        <div class="profile-info-value">
                            <span class="editable editable-click">{{number_format($funds_total,2)}} 人民币（大写：）{{bigRMB($funds_total)}}</span>
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name"> 预算总金额： </div>
                        <div class="profile-info-value">
                            <span class="editable editable-click">
                                <strong>{{number_format($sdata['init_budget']->money,2)}} 人民币（大写：）{{bigRMB($sdata['init_budget']->money)}}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name"> 是否达到预算： </div>
                        <div class="profile-info-value">
                            <span class="editable editable-click">
                                @if($funds_total>=$sdata['init_budget']->money)
                                    达到

                                @else
                                    未达到
                                @endif
                                    <a class="btn btn-danger" onclick="btnAct(this)" data-url="{{route('g_ready_funds',['item'=>$sdata['item']->id])}}" data-method="post">
                                        <i class="ace-icon fa fa-check bigger-110"></i>
                                        提交准备完毕
                                    </a>
                                    <a class="btn" href="{{route('g_funds_add',['item'=>$sdata['item']->id])}}">继续录入项目资金</a>
                            </span>
                        </div>
                    </div>
                </div>

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