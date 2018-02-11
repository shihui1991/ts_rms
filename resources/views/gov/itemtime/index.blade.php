{{-- 继承aceAdmin后台布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1">
            <div class="timeline-container timeline-style2">

                <div class="timeline-items">
                    <div class="timeline-item clearfix">
                        <div class="timeline-info">
                            <span class="timeline-date">{{$edata['created_at']}}</span>

                            <i class="timeline-indicator btn btn-info no-hover"></i>
                        </div>

                        <div class="widget-box transparent">
                            <div class="widget-body">
                                <div class="widget-main no-padding">
									<span class="bigger-110">
										新建项目
									</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @foreach($sdata as $itemtime)
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
                                        <span class="bigger-110">{{$itemtime->name}}</span>
                                        <br>
                                        <i class="ace-icon fa fa-info-circle green bigger-125"></i>
                                        <span>{{$itemtime->infos}}</span>
                                        <br>
                                        <i class="ace-icon fa fa-link blue"></i>
                                        <a href="{{route('g_itemtime_edit',['id'=>$itemtime->itemtime->id])}}">修改</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach


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