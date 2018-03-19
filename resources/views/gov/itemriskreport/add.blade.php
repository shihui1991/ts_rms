{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>
    </p>

    <form class="form-horizontal" role="form" action="{{route('g_itemriskreport_add',['item'=>$sdata['item_id']])}}" method="post">
        {{csrf_field()}}
        <div class="row">
            <div class="col-xs-12 col-sm-9">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="address"> 标题： </label>
                    <div class="col-sm-9">
                        <input type="text" id="name" name="name" value="" class="col-xs-10 col-sm-5"  placeholder="请输入标题" required>
                    </div>
                </div>
                <div class="space-4"></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="login">评估结论：</label>
                    <div class="col-sm-9 radio">
                        @foreach($edata->agree as $key => $value)
                            <label>
                                <input name="agree" type="radio" class="ace" value="{{$key}}" @if($key==1) checked @endif/>
                                <span class="lbl">{{$value}}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="space-4"></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="content">内容：</label>
                    <div class="col-sm-9"></div>
                </div>
                <div class="space-4"></div>

                <div class="form-group">
                    <textarea id="content" name="content" class="col-xs-11 col-sm-11" style="min-height: 300px;"></textarea>
                </div>
                <div class="space-4"></div>


                <div class="widget-body">
                    <div class="widget-main padding-8">

                        <div class="form-group img-box">
                            <label class="col-sm-3 control-label no-padding-right">
                                附件：<br>
                                <span class="btn btn-xs">
                            <span>上传图片</span>
                            <input type="file" accept="image/*" class="hidden" data-name="picture[]" multiple  onchange="uplfile(this)">
                        </span>
                            </label>
                            <div class="col-sm-9">
                                <ul class="ace-thumbnails clearfix img-content viewer">


                                </ul>
                            </div>
                        </div>

                        <div class="space-4 header green"></div>

                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-3" style="min-width: 300px;min-height: 300px;" id="item-risk"></div>
        </div>

        <div class="clearfix form-actions">
            <div class="col-md-offset-3 col-md-9">
                <button class="btn btn-info" type="button" onclick="sub(this)">
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    保存
                </button>
                &nbsp;&nbsp;&nbsp;
                <button class="btn" type="reset">
                    <i class="ace-icon fa fa-undo bigger-110"></i>
                    重置
                </button>
            </div>
        </div>
    </form>


@endsection

{{-- 样式 --}}
@section('css')
    <link rel="stylesheet" href="{{asset('viewer/viewer.min.css')}}" />
@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script src="{{asset('js/func.js')}}"></script>
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script src="{{asset('ueditor/ueditor.config.js')}}"></script>
    <script src="{{asset('ueditor/ueditor.all.min.js')}}"></script>
    <script>
        var ue = UE.getEditor('content');
    </script>
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