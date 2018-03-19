{{-- 继承布局 --}}
@extends('household.home')


{{-- 页面内容 --}}
@section('content')
    <div class="well well-sm">

        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>

    </div>


    @if(filled($sdata))

        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name"> 价格走势：</div>
                <div class="profile-info-value" id="price-line" style="width: 600px;height:400px;">

                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> 房屋图片：</div>
                <div class="profile-info-value">
                        <span class="editable editable-click">
                             <ul class="ace-thumbnails clearfix img-content viewer">
                                  @if(isset($sdata['picture']))
                                     @foreach($sdata['picture'] as $pic)
                                         <li>
                                    <div>
                                        <img width="120" height="120" src="{!! $pic !!}" alt="加载失败">
                                        <div class="text">
                                            <div class="inner">
                                                <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                     @endforeach
                                 @endif
                            </ul>
                        </span>
                </div>
            </div>
        </div>
    @endif
@endsection

{{-- 样式 --}}
@section('css')
    <link rel="stylesheet" href="{{asset('viewer/viewer.min.css')}}" />
@endsection

{{-- 插件 --}}
@section('js')
    <script src="{{asset('js/func.js')}}"></script>
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script src="{{asset('echarts/echarts.common.min.js')}}"></script>
    <script>
        $('.img-content').viewer('update');
        var myChart = echarts.init(document.getElementById('price-line'));
        var option = {
            title: {
                text: '安置房价格曲线图'
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data:['市场评估价','安置优惠价']
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            toolbox: {
                feature: {
                    saveAsImage: {}
                }
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data:@json($sdata->date)
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    name:'市场评估价',
                    type:'line',
                    step: 'end',
                    data:@json($sdata->market)
                },
                {
                    name:'安置优惠价',
                    type:'line',
                    step: 'end',
                    data:@json($sdata->price)
                }
            ]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    </script>
@endsection