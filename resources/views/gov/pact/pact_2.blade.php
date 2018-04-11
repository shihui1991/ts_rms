<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<style type="text/css">
    * {
        margin: 0;
        padding: 0;
        font-size: 20px;
        font-weight: 100;
    }

    tr {
        height: 50px;
        page-break-after: always;
    }

    td {
        padding: 2px 10px;
        font-size: 16px !important;
    }

    h1 {
        text-align: center;
        font-size: 40px;
    }
    table{
        margin: 5px auto;
    }

    .center_text {
        text-align: center;
    }

    .wrap {
        width: 794px;
        height: 1158px;
        margin: auto;
    }

    .div1 {
        float: left;
        box-sizing: border-box;
        height: 40px;
    }

    .width380 {
        width: 380px;
    }

    .width520 {
        width: 520px;
    }

    .ov {
        overflow: hidden;
    }

    .lineheight50 {
        line-height: 50px;
    }

    .mt20px {
        margin-top: 20px;
    }

    .mb20px {
        margin-bottom: 20px;
    }

    .color66 {
        color: #333;
        font-weight: normal;
    }

    .f16 {
        font-size: 16px;
    }

    .text_indent50 {
        text-indent: 50px;
    }

    .div_border_bot {
        height: 36px;
        line-height: 36px;
        display: inline;
        border-bottom: 2px solid #000;
        box-sizing: border-box;
        padding:0 20px 5px 20px;
    }

    .width100 {
        min-width: 100px;
    }

    .width_100 {
        width: 100%;
    }

    .width200 {
        min-width: 200px;
    }

    .height40 {
        height: 40px;
    }

    .height36 {
        height: 36px;
        line-height: 36px;
    }

    .lineheight36 {
        line-height: 36px;
    }

    ul li {
        list-style: none;
    }

    .table_a td {
        text-align: center;
    }
</style>

<body>
<div id="tip" style="width: 794px;height: auto;margin: auto;">
    <!--占满一页-->
    <div class="wrap">
        <h1 style="padding-top: 50px;">{{$item->name}}</h1>
        <h1 style="margin-top: 10px;">房屋征收补偿安置协议书（二）</h1>
        <div class="center_text" style="margin-top: 300px; font-size: 30px;">
            征收单位：
            <span style="font-size: 30px;display: inline-block;width: 460px;height: 30px;border-bottom:3px solid #000;padding-bottom:10px;">秦州区房屋征收补偿管理局</span>
        </div>
        <div class="center_text" style="margin-top: 140px;font-size: 30px;">
            被征收人：
            <span style="font-size: 30px;display: inline-block;width: 460px;height: 30px;border-bottom:3px solid #000 ;padding-bottom: 10px;"> {{$holder->name}}</span>
        </div>
        <div class="center_text" style="margin-top: 200px;font-size: 30px;">秦州区房屋征收补偿管理局制</div>
        <div class="center_text" style="margin-top: 50px;font-size: 30px;">{{date('Y年m月d日',strtotime($sign_date))}}</div>
    </div>

    <div class="content" style="width: 794px;margin: auto;">
        <h1 class="center_text" style="line-height: 120px;">房屋征收补偿安置协议书(二)</h1>
        <div>
            <div class="ov lineheight50 mb20px color66">
                <div class="div1" style="width: 200px;">征收实施单位(甲方):</div>
                <div class="div1" style="width: 460px; padding: 0 15px;border-bottom: 2px solid black;">秦州区房屋征收补偿管理局</div>
            </div>
            <div class="ov lineheight50 color66">
                <div class="div1 mb20px " style="width: 200px;">被 征 收 人 (乙方)&nbsp;:</div>
                <div class="div1" style="width: 460px;padding: 0 15px;border-bottom: 2px solid black;">
                    {{$holder->name}}
                </div>
            </div>
        </div>

        <div class="color66" style="line-height: 50px;text-indent: 50px;">按照《天水市秦州区人民政府关于{{$item->name}}房屋征收补偿安置实施方案》及《{{$item->name}}房屋征收补偿安置协议书(一)》的规定，甲乙双方本着公平合理、平等协商的原则，就乙方的临时安置及搬迁奖励等达成如下协议。</div>
        <!--这里是协议内容-->
        <div>
            <h3 style="text-indent: 50px;line-height: 50px;"> 一、补偿明细</h3>
            <div class="text_indent50 lineheight50 color66">
                <div class="text_indent50 lineheight50 ">
                    乙方选择以下的<div class="div_border_bot">“{{$pay->transit_way}}”</div>临时安置方式
                </div>
                <ul>
                    <li class="lineheight50">1.货币过渡</li>
                    <li class="lineheight50">2.临时周转房</li>
                </ul>
                @if($pay->getOriginal('transit_way'))
                    @if(filled($pay_transits))
                        <div class="lineheight50 color66">乙方选择甲方提供的临时周转用房：</div>
                        @foreach($pay_transits as $transit)
                            <div class="lineheight50 color66">
                                ({{$loop->iteration}})
                                <div class="div_border_bot">{{$transit->house->housecommunity->name}}</div>小区 ，房号
                                <div class="div_border_bot">
                                    {{$transit->house->building}}-
                                    {{$transit->house->unit}}-
                                    {{$transit->house->floor}}-
                                    {{$transit->house->number}}
                                </div>
                                面积<div class="div_border_bot">{{$transit->house->area}}</div>㎡。
                            </div>
                        @endforeach
                    @endif
                @endif
            </div>
            @php $subject_total=0;@endphp
            @foreach($pay_subjects as $subject)
                @php $subject_total += $subject->total; @endphp
                <div>
                    <p class="text_indent50 lineheight50 color66">
                        {{$loop->iteration}}、{{$subject->subject->name}}：
                    </p>
                    @if($subject->itemsubject->info)
                        <p class="text_indent50 lineheight36 color66">
                            {{$subject->itemsubject->info}}
                        </p>
                    @endif
                    @switch($subject->subject_id)
                        {{-- 临时安置费 --}}
                        @case(13)
                        <div>
                            <div class="color66">临时安置费=被征收房屋合法建筑面积×{{$transit_price}}元/㎡×实际过渡月份（每月补偿不足{{$program->transit_base}}元的，按{{$program->transit_base}}元补偿）。选择自行过渡的临时安置费，自
                                <div class="div_border_bot">{{date('Y年m月d日',strtotime($sign_date))}}</div>（含当日）至
                                <div class="div_border_bot">{{date('Y年m月d日',strtotime($sign_date,'+ '.$transit_times.' month'))}}</div>（含当日）止，一次性发放；选择现房安置的，一次性发放{{$program->transit_real}}个月的临时安置费。</div>
                            <div class="color66">经核定，乙方应得临时安置费：
                                <div class="div_border_bot">{{number_format($legal->legal_area,2)}}</div>㎡×
                                <div class="div_border_bot">{{$transit_price}}</div>元/㎡×
                                <div class="div_border_bot">{{$transit_times}}</div>月（实际过渡月数）=
                                <div class="div_border_bot">{{number_format($subject->amount,2)}}</div>元（大写：
                                <div class="div_border_bot">{{bigRMB($subject->amount)}}</div>）。
                                @if($household->getOriginal('type'))
                                    公房单位承租人占{{$program->portion_renter}}%，乙方实际应得临时安置费：
                                    <div class="div_border_bot">{{number_format($subject->total,2)}}</div>元（大写：
                                    <div class="div_border_bot">{{bigRMB($subject->total)}}</div>）。
                                @endif
                            </div>
                        </div>
                        @break

                        {{-- 临时安置费特殊人群优惠补助 --}}
                        @case(14)
                        <table class="table_a color66" border="1" cellspacing="0" style="width: 100%;">
                            <tbody>
                            <tr>
                                <th>被征收人</th>
                                <th>类别</th>
                                <th>上浮率（%）</th>
                                <th>上浮金额 (元)</th>
                            </tr>

                            @if(filled($pay_crowds))
                                @foreach($pay_crowds as $crowd)
                                    <tr>
                                        <td>{{$crowd->membercrowd->member->name}}</td>
                                        <td>{{$crowd->crowd->name}}</td>
                                        <td>{{$crowd->rate}}</td>
                                        <td>{{number_format($crowd->amount,2)}}</td>
                                    </tr>
                                @endforeach

                            @else
                                <tr>
                                    <td>--</td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td>--</td>
                                </tr>
                            @endif

                            <tr>
                                <td style="font-size: 20px;">合计</td>
                                <td>--</td>
                                <td>--</td>
                                <td>{{number_format($subject->total,2)}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="text_indent50 lineheight50 color66">
                            经核定，乙方应得临时安置费特殊人群优惠补助共计<div class="div_border_bot">{{number_format($subject->total,2)}}</div> 元
                            （大写：<div class="div_border_bot">{{bigRMB($subject->total)}}</div>）。
                        </div>
                        @break

                        {{-- 按约搬迁奖励 --}}
                        @case(15)
                        <div class="text_indent50 lineheight50 color66">
                            经核定，乙方应得搬迁奖励共计<div class="div_border_bot">{{number_format($subject->total,2)}}</div> 元
                            （大写：<div class="div_border_bot">{{bigRMB($subject->total)}}</div>）。
                        </div>
                        @break

                        {{-- 房屋状况与登记相符的奖励 --}}
                        @case(16)
                        <div class="text_indent50 lineheight50 color66">
                            经核定，乙方合法房屋面积为
                            <div class="div_border_bot">{{number_format($legal->legal_area,2)}}</div> 平方米，
                            每平方米就得未新建、改建、扩建房屋奖励
                            <div class="div_border_bot">{{number_format($program->reward_real,2)}}</div> 元
                            乙方就得奖励
                            <div class="div_border_bot">{{number_format($subject->total,2)}}</div> 元
                            （大写：<div class="div_border_bot">{{bigRMB($subject->total)}}</div>）。
                        </div>
                        @break
                    @endswitch
                    <div class="text_indent50 lineheight50 color66">
                        综合以上所述，乙方应得补偿资金共计：<div class="div_border_bot">{{number_format($subject_total,2)}}</div> 元
                        （大写：<div class="div_border_bot">{{bigRMB($subject_total)}}</div>）。
                    </div>
                </div>
            @endforeach
        </div>

        <div>
            <h3 style="text-indent: 50px;line-height: 50px;">二、其他事项</h3>
            <div class="lineheight50 text_indent50 color66">乙方选择周转用房临时安置的，不得改变周转用房原貌、用途、转租，使用期间，因故意或过错造成房产及设施损坏，由乙方负责修复或赔偿；乙方自甲方交付产权调换房屋之日，将周转用房腾空移交给甲方。</div>
        </div>
        <div>
            <h3 style="text-indent: 50px;line-height: 50px;">三、兑付</h3>
            <div class="lineheight50 text_indent50 color66">本协议签订后，乙方在规定日期内向甲方办理完成交房手续，甲方将补偿资金足额兑付乙方。</div>
        </div>
        <div>
            <h3 style="text-indent: 50px;line-height: 50px;">四、协议生效及持有</h3>
            <div class="lineheight50 text_indent50 color66">本协议自签订之日起生效，甲方持五份，乙方持一份，具有同等法律效力。</div>
        </div>
    </div>

    <!--满一页的-->
    <div class="wrap ov" style="height: 1158px;">
        <div class="ov" style="width: 50%;font-size: 26px;margin-left: 5%; float: left;height: 160px;line-height: 160px;">甲&nbsp;&nbsp;&nbsp;&nbsp;方（盖章）：</div>
        <div class="ov" style="width: 45%;font-size: 26px; float: left;height: 160px;line-height: 160px;">甲&nbsp;&nbsp;&nbsp;&nbsp;方（盖章）：</div>
        <div class="ov" style="width: 50%;font-size: 26px;margin-left: 5%; float: left;height: 160px;line-height: 160px;">法定代表人（签字）：</div>
        <div class="ov" style="width: 45%;font-size: 26px; float: left;height: 160px;line-height: 160px;">乙方代表（签字）：</div>
        <div class="ov" style="width: 100%;font-size: 26px;margin-left: 5%; height: 160px;line-height: 160px;">分管领导（签字）：</div>
        <div class="ov" style="width: 50%;font-size: 26px;margin-left: 5%; float: left;height: 160px;line-height: 160px;">经 办 人（签字）：</div>
        <div class="ov" style="width: 45%;font-size: 26px; float: left;height: 160px;line-height: 160px;">受 委 托 人（签字）：</div>
        <div class="ov" style="width: 50%;font-size: 26px;margin-left: 5%; float: left;height: 160px;line-height: 160px;">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;年&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;月&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日
        </div>
        <div class="ov" style="width: 45%;font-size: 26px; float: left;height: 160px;line-height: 160px;">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;年&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;月&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日
        </div>
    </div>
</div>


</body>

</html>
<script src="{{asset('js/jquery-1.11.3.min.js')}}"></script>
<script type="text/javascript">
    var height_a = 1158;
    var content_obj=$(".content");
    for(var i = 0; i < content_obj.length; i++) {
        var num_a = Math.ceil(content_obj.eq(i).height() / height_a);
        content_obj.eq(i).css("height", height_a * num_a + "px");
    }
</script>