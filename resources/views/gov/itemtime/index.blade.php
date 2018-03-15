{{-- 继承aceAdmin后台布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    @if(filled($sdata['itemtimes'][0]->itemtime) && $sdata['item']->schedule_id==1 && $sdata['item']->process_id==8 && $sdata['item']->code=='1')
        <p>
            <a class="btn" href="{{route('g_itemtime_edit',['item'=>$sdata['item']->id])}}">
                <i class="ace-icon fa fa-edit bigger-110"></i>
                修改
            </a>

            <a class="btn btn-danger" onclick="btnAct(this)" data-url="{{route('g_check_set_itemtime',['item'=>$sdata['item']->id])}}" data-method="post">
                <i class="ace-icon fa fa-check-circle bigger-110"></i>
                提交配置
            </a>
        </p>
    @endif

    <div class="row">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1">
            <div class="timeline-container timeline-style2">

                <div class="timeline-items">
                    <div class="timeline-item clearfix">
                        <div class="timeline-info">
                            <span class="timeline-date">{{$sdata['item']->created_at}}</span>

                            <i class="timeline-indicator btn btn-info no-hover"></i>
                        </div>

                        <div class="widget-box transparent">
                            <div class="widget-body">
                                <div class="widget-main no-padding">
									<strong class="bigger-110">新建项目</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(filled($sdata['itemtimes'][0]->itemtime))

                        @foreach($sdata['itemtimes'] as $itemtime)
                            <div class="timeline-item clearfix">
                                <div class="timeline-info">
                                <span class="timeline-date">
                                    {{$itemtime->itemtime->start_at}}
                                    <br>
                                    {{$itemtime->itemtime->end_at}}
                                </span>

                                    <i class="timeline-indicator btn btn-info no-hover"></i>
                                </div>

                                <div class="widget-box transparent">
                                    <div class="widget-body">
                                        <div class="widget-main no-padding">
                                            <strong class="bigger-110">{{$itemtime->name}}</strong>
                                            <br>
                                            <i class="ace-icon fa fa-info-circle green bigger-125"></i>
                                            <span>{{$itemtime->infos}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    @else

                        <div class="alert alert-warning">
                            <strong>注意：</strong>
                            还未添加项目时间规划！
                            &nbsp;&nbsp;&nbsp;
                            <i class="fa fa-hand-o-right"></i>
                            <a href="{{route('g_itemtime_add',['item'=>$sdata['item']->id])}}">去添加</a>
                            <br>
                        </div>

                    @endif

                </div><!-- /.timeline-items -->
            </div><!-- /.timeline-container -->

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