{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')
    <div class="well well-sm">
        @if (blank($sdata['itemriskreport']))
            <a href="{{route('g_itemriskreport_add',['item'=>$sdata['item_id']])}}" class="btn">添加社会稳定风险评估报告</a>
        @else
            <a href="{{route('g_itemriskreport_edit',['item'=>$sdata['itemriskreport']->item_id])}}" class="btn">修改社会稳定风险评估报告</a>
        @endif
            <a href="{{route('g_itemrisk',['item'=>$sdata['item_id']])}}" class="btn">查看风险评估调查</a>
            <a href="{{route('g_itemtopic',['item'=>$sdata['item_id']])}}" class="btn">查看自定义调查话题</a>
    </div>

    <div class="widget-container-col ui-sortable">
        <div class="widget-box ui-sortable-handle">
            <div class="widget-header">
                <h5 class="widget-title">社会稳定风险评估报告</h5>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <div class="user-profile row">
                        @if (filled($sdata['itemriskreport']))

                            <div class="col-xs-12 col-sm-9">
                                <div class="profile-user-info profile-user-info-striped">
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> 名称： </div>
                                        <div class="profile-info-value">
                                            <span class="editable editable-click">{{$sdata['itemriskreport']->name}}</span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> 评估结论： </div>
                                        <div class="profile-info-value">
                                            <span class="editable editable-click">{{$sdata['itemriskreport']->agree}}</span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> 内容： </div>
                                        <div class="profile-info-value">
                                            <textarea name="content" id="content" style="width: 100%;min-height: 300px;">{{$sdata['itemriskreport']->content}}</textarea>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> 附件： </div>
                                        <div class="profile-info-value">
                                            <ul class="ace-thumbnails clearfix img-content viewer">
                                                @if(filled($sdata['itemriskreport']->picture))
                                                    @foreach($sdata['itemriskreport']->picture as $v)
                                                        <li>
                                                            <div>
                                                                <img width="120" height="120" src="{{$v}}" alt="加载失败">
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> 状态： </div>
                                        <div class="profile-info-value">
                                            <span class="editable editable-click">{{$sdata['itemriskreport']->state->name}}</span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> 添加时间： </div>
                                        <div class="profile-info-value">
                                            <span class="editable editable-click">{{$sdata['itemriskreport']->created_at}}</span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> 修改时间： </div>
                                        <div class="profile-info-value">
                                            <span class="editable editable-click">{{$sdata['itemriskreport']->updated_at}}</span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> 删除时间： </div>
                                        <div class="profile-info-value">
                                            <span class="editable editable-click">{{$sdata['itemriskreport']->deleted_at}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-xs-12 col-sm-3" style="min-width: 300px;min-height: 300px;" id="item-risk">

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
    <script src="{{asset('ueditor/ueditor.config.js')}}"></script>
    <script src="{{asset('ueditor/ueditor.all.min.js')}}"></script>
    <script src="{{asset('echarts/echarts.common.min.js')}}"></script>
    <script>
        var ue = UE.getEditor('content',{
            readonly:true
            ,toolbars:null
            ,wordCount:false
        });

        var item_risk_num=@json($sdata['item_risk_num']);
        items=[];
        values=[];
        $.each(item_risk_num,function (index,info) {
            items.push(info.agree);
            values.push({value:info.risk_num,name:info.agree});
        });
        echarts.init(document.getElementById('item-risk')).setOption({
            title:{
                text:'征收意见稿 - 调查结果'
                ,subtext:'总户数：{{number_format($sdata['household_num'])}}，当前调查：{{number_format($sdata['number'])}}'
                ,x:'center'
            }
            ,tooltip : {
                trigger: 'item',
                formatter: "{b}：<br/>{c} 户 <br/>({d}%)"
            }
            ,series : [
                {
                    name: null,
                    type: 'pie',
                    radius : '55%',
                    center: ['50%', '60%'],
                    data:values,
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        });
    </script>
@endsection