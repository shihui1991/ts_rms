<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            font-size: 30px;
            font-weight: 100;
        }

        tr {
            line-height: 80px;
        }

        td {
            padding: 5px 10px;
        }

        h1 {
            text-align: center;
            font-size: 40px;
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
            font-size: 24px;
        }

        .text_indent50 {
            text-indent: 50px;
        }

        .div_border_bot {
            height: 40px;
            display: inline-block;
            border-bottom: 2px solid #000;
        }

        .width100 {
            width: 100px;
        }

        .width_100 {
            width: 100%;
        }

        .width200 {
            width: 200px;
        }

        .height40 {
            height: 40px;
        }

        ul li {
            list-style: none;
        }

        .table_a td {
            text-align: center;
        }
    </style>
</head>


<body>
<!--占满一页-->
<div class="wrap">
    <h1 style="padding-top: 50px;">{{$item->name}}</h1>
    <h1 style="margin-top: 10px;">房屋征收补偿安置协议书（一）</h1>
    <div class="center_text" style="margin-top: 500px;">
        征收单位:
        <span style="display: inline-block;width: 460px;height: 30px;border-bottom:3px solid #000 ;">秦州区房屋征收补偿管理局</span>
    </div>
    <div class="center_text" style="margin-top: 140px;">
        被征收人:
        <span style="display: inline-block;width: 460px;height: 30px;border-bottom:3px solid #000 ;">
            {{$holder->name}}
        </span>
    </div>
    <div class="center_text" style="margin-top: 100px;">秦州区房屋征收补偿管理局制</div>
    <div class="center_text" style="margin-top: 50px;">{{date('Y年m月d日',strtotime($sign_date))}}</div>
</div>
<div class="content" style="width: 794px;margin: auto;">
    <h2 class="center_text" style="line-height: 120px;">房屋征收补偿安置协议书(一)</h2>
    <div>
        <div class="ov lineheight50 mb20px color66">
            <div class="div1" style="width: 300px;">征收实施单位(甲方):</div>
            <div class="div1" style="width: 460px; padding: 0 15px;border-bottom: 2px solid black;">秦州区房屋征收补偿管理局</div>
        </div>
        <div class="ov lineheight50 color66">
            <div class="div1 mb20px " style="width: 300px;">被 征 收 人 (乙方)&nbsp;:</div>
            <div class="div1" style="width: 460px;padding: 0 15px;border-bottom: 2px solid black;">
                {{$holder->name}}
            </div>
        </div>
    </div>

    <div class="color66" style="line-height: 50px;text-indent: 50px;">根据《国有土地上房屋征收与补偿条例》、《甘肃省实施
        &lt;国有土地上房屋征收与补偿条例&gt;若干规定》、《国有土地上房屋征收评估办法》及《天水市秦州区人民政府关于天水信号厂片区土地熟化项目二期房屋征收补偿安置实施方案》的规定，甲乙双方本着公平合理、平等协商的原则，就乙方位于该项目规划区域内房屋的征收补偿安置达成如下协议。</div>
    <!--这里是协议内容-->
    <div>
        <!--无列表样式-->
        <div>
            <h3 style="text-indent: 50px;line-height: 50px;"> 一、被征收房屋现状</h3>
            <div class="text_indent50 lineheight50 color66">
                房屋所在地<div class="width200 height40 div_border_bot">
                    {{$household->itemland->address}}
                    {{$household->itembuilding->building?$household->itembuilding->building.'栋':''}}
                    {{$household->unit?$household->unit.'单元':''}}
                    {{$household->floor?$household->floor.'楼':''}}
                    {{$household->number?$household->number.'号':''}}
                </div>
                ，证载建筑面积<div class="width200 height40 div_border_bot">{{number_format($household_detail->reg_outer,2)}}</div>平方米
                ，实测面积<div class="width200 height40 div_border_bot">{{number_format($real_area,2)}}</div>平方米
                ，房屋所有权人<div class="width200 height40 div_border_bot">
                    @if($household->getOriginal('type'))
                        {{$household->itemland->adminunit->name}}
                    @else
                        {{$holder->name}}
                    @endif
                </div>
                ，房屋产权证号<div class="width200 height40 div_border_bot">{{$household_detail->register}}</div>
                ，房屋的批准用途<div class="width200 height40 div_border_bot">{{$household_detail->defbuildinguse->name}} </div>
                ，房屋的实际用途<div class="width200 height40 div_border_bot">{{$household_detail->realbuildinguse->name}} </div>
                ，房屋的产权性质<div class="width200 height40 div_border_bot">{{$household->type}} </div>
                ，房屋的结构<div class="width200 height40 div_border_bot">{{$household->itembuilding->buildingstruct->name}}</div>
                ，房屋的总层数<div class="width100 height40 div_border_bot">{{$household->itembuilding->total_floor}}</div>
                ，房屋所在楼层<div class="width100 height40 div_border_bot">{{$main_building->floor}}</div>
                ，房屋朝向<div class="width100 height40 div_border_bot">{{$main_building->direct}}</div>。
            </div>
        </div>
        <div>
            <h3 style="text-indent: 50px;line-height: 50px;"> 二、补偿方式</h3>
            <div class="text_indent50 lineheight50 color66">
                <div class="text_indent50 lineheight50 ">
                    乙方选择以下的<div class="width100 height40 div_border_bot">“{{$pay->repay_way}}”</div>补偿方式
                </div>
                <ul>
                    <li class="lineheight50">1.货币补偿</li>
                    <li class="lineheight50">2.房屋产权调换</li>
                </ul>
            </div>
        </div>
        <div>
            <h3 style="text-indent: 50px;line-height: 50px;"> 三、乙方征收所得补偿的明细。</h3>
            @php $house_resettle=0; $subject_total=0;@endphp
            @foreach($pay_subjects as $subject)
                @php $subject_total += $subject->total; @endphp
                @if(in_array($subject->subject_id,[])) @php $house_resettle += $subject->total; @endphp @endif
                <div>
                    <p class="text_indent50 lineheight50 color66">
                        {{$loop->iteration}}、{{$subject->subject->name}}：
                    </p>
                    <p class="text_indent50 lineheight50 color66">
                        {{$subject->itemsubject->info}}
                    </p>
                    @switch($subject->subject_id)
                        {{-- 合法房屋及附属物 --}}
                        @case(1)
                        <table class="table_a color66" border="1" cellspacing="0" style="width: 100%;page-break-before: auto;">
                            <thead>
                            <tr style="line-height: 80px;">
                                <th style="line-height: 60px;">房屋类型</th>
                                <th style="line-height: 60px;">结构</th>
                                <th style="line-height: 60px;">朝向</th>
                                <th style="line-height: 60px;">面积(㎡)</th>
                                <th style="line-height: 60px;">评估单价 (元/㎡)</th>
                                <th style="line-height: 60px;">评估总价 (元)</th>
                                <th style="line-height: 60px;font-size: 20px;">
                                    补偿总价<br/>@if($household->getOriginal('type'))公房承租人占（{{$program->portion_renter}}）%@endif(元)
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(filled($register_buildings))
                                @foreach($register_buildings as $building)
                                    <tr>
                                        <td style="min-height: 80px;">{{$building->realuse->name}}</td>
                                        <td style="min-height: 80px;">{{$building->buildingstruct->name}}</td>
                                        <td style="min-height: 80px;">{{$building->direct}}</td>
                                        <td style="min-height: 80px;">{{number_format($building->real_outer,2)}}</td>
                                        <td style="min-height: 80px;">{{number_format($building->price,2)}}</td>
                                        <td style="min-height: 80px;">{{number_format($building->amount,2)}}</td>
                                        @if($household->getOriginal('type'))
                                            <td style="min-height: 80px;">{{number_format($building->amount*$program->portion_renter/100,2)}}</td>
                                        @else
                                            <td style="min-height: 80px;">{{number_format($building->amount,2)}}</td>
                                        @endif
                                    </tr>
                                @endforeach

                            @else
                                <tr>
                                    <td style="min-height: 80px;">--</td>
                                    <td style="min-height: 80px;">--</td>
                                    <td style="min-height: 80px;">--</td>
                                    <td style="min-height: 80px;">--</td>
                                    <td style="min-height: 80px;">--</td>
                                    <td style="min-height: 80px;">--</td>
                                    <td style="min-height: 80px;">--</td>
                                </tr>
                            @endif

                            <tr>
                                <td style="font-size: 20px;">合计</td>
                                <td>--</td>
                                <td>--</td>
                                <td>--</td>
                                <td>--</td>
                                <td>{{number_format($subject->amount,2)}}</td>
                                <td>{{number_format($subject->total,2)}}</td>
                            </tr>
                            </tbody>
                        </table>
                        @break
                        {{-- 合法临建 --}}
                        @case(2)
                        <table class="table_a color66" border="1" cellspacing="0" style="width: 100%;page-break-before: auto;">
                            <thead>
                            <tr style="line-height: 80px;">
                                <th style="line-height: 60px;">结构</th>
                                <th style="line-height: 60px;">修建时间</th>
                                <th style="line-height: 60px;">建筑面积(㎡)</th>
                                <th style="line-height: 60px;">评估单价 (元/㎡)</th>
                                <th style="line-height: 60px;">评估总价 (元)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(filled($legal_buildings))
                                @foreach($legal_buildings as $building)
                                    <tr>
                                        <td style="min-height: 80px;">{{$building->buildingstruct->name}}</td>
                                        <td style="min-height: 80px;">{{$building->householdbuilding->build_year}}</td>
                                        <td style="min-height: 80px;">{{number_format($building->real_outer,2)}}</td>
                                        <td style="min-height: 80px;">{{number_format($building->price,2)}}</td>
                                        <td style="min-height: 80px;">{{number_format($building->amount,2)}}</td>
                                    </tr>
                                @endforeach

                            @else
                                <tr>
                                    <td style="min-height: 80px;">--</td>
                                    <td style="min-height: 80px;">--</td>
                                    <td style="min-height: 80px;">--</td>
                                    <td style="min-height: 80px;">--</td>
                                    <td style="min-height: 80px;">--</td>
                                </tr>
                            @endif

                            <tr>
                                <td style="font-size: 20px;">合计</td>
                                <td>--</td>
                                <td>--</td>
                                <td>{{number_format($subject->amount,2)}}</td>
                                <td>{{number_format($subject->total,2)}}</td>
                            </tr>
                            </tbody>
                        </table>
                        @break
                        {{-- 违建自行拆除补助 --}}
                        @case(3)
                        <table class="table_a color66" border="1" cellspacing="0" style="width: 100%;page-break-before: auto;">
                            <thead>
                            <tr style="line-height: 80px;">
                                <th style="line-height: 60px;">结构</th>
                                <th style="line-height: 60px;">修建时间</th>
                                <th style="line-height: 60px;">建筑面积(㎡)</th>
                                <th style="line-height: 60px;">补助单价 (元/㎡)</th>
                                <th style="line-height: 60px;">补助总价 (元)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(filled($destroy_buildings))
                                @foreach($destroy_buildings as $building)
                                    <tr>
                                        <td style="min-height: 80px;">{{$building->buildingstruct->name}}</td>
                                        <td style="min-height: 80px;">{{$building->householdbuilding->build_year}}</td>
                                        <td style="min-height: 80px;">{{number_format($building->real_outer,2)}}</td>
                                        <td style="min-height: 80px;">{{number_format($building->price,2)}}</td>
                                        <td style="min-height: 80px;">{{number_format($building->amount,2)}}</td>
                                    </tr>
                                @endforeach

                            @else
                                <tr>
                                    <td style="min-height: 80px;">--</td>
                                    <td style="min-height: 80px;">--</td>
                                    <td style="min-height: 80px;">--</td>
                                    <td style="min-height: 80px;">--</td>
                                    <td style="min-height: 80px;">--</td>
                                </tr>
                            @endif

                            <tr>
                                <td style="font-size: 20px;">合计</td>
                                <td>--</td>
                                <td>--</td>
                                <td>{{number_format($subject->amount,2)}}</td>
                                <td>{{number_format($subject->total,2)}}</td>
                            </tr>
                            </tbody>
                        </table>
                        @break
                        {{-- 公共附属物 --}}
                        @case(4)
                        <table class="table_a color66" border="1" cellspacing="0" style="width: 100%;page-break-before: auto;">
                            <thead>
                            <tr style="line-height: 80px;">
                                <th style="line-height: 60px;">名称</th>
                                <th style="line-height: 60px;">计量</th>
                                <th style="line-height: 60px;">补偿单价</th>
                                <th style="line-height: 60px;">补偿总价 (元)</th>
                                <th style="line-height: 60px;">平分户数</th>
                                <th style="line-height: 60px;">每户补偿 (元)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(filled($public_buildings))
                                @foreach($public_buildings as $public_building)
                                    <tr>
                                        <td style="min-height: 80px;">{{$public_building->name}}</td>
                                        <td style="min-height: 80px;">{{number_format($public_building->number,2)}} {{$public_building->num_unit}}</td>
                                        <td style="min-height: 80px;">{{number_format($public_building->price,2)}}</td>
                                        <td style="min-height: 80px;">{{number_format($public_building->amount,2)}}</td>
                                        <td style="min-height: 80px;">{{number_format($public_building->household)}}</td>
                                        <td style="min-height: 80px;">{{number_format($public_building->avg,2)}}</td>
                                    </tr>
                                @endforeach

                            @else
                                <tr>
                                    <td style="min-height: 80px;">--</td>
                                    <td style="min-height: 80px;">--</td>
                                    <td style="min-height: 80px;">--</td>
                                    <td style="min-height: 80px;">--</td>
                                    <td style="min-height: 80px;">--</td>
                                    <td style="min-height: 80px;">--</td>
                                </tr>
                            @endif

                            <tr>
                                <td style="font-size: 20px;">合计</td>
                                <td>--</td>
                                <td>--</td>
                                <td>{{number_format($public_buildings->sum('amount'),2)}}</td>
                                <td>--</td>
                                <td>{{number_format($subject->total,2)}}</td>
                            </tr>
                            </tbody>
                        </table>
                        @break
                        {{-- 其他补偿事项 --}}
                        @case(5)
                        <table class="table_a color66" border="1" cellspacing="0" style="width: 100%;page-break-before: auto;">
                            <thead>
                            <tr style="line-height: 80px;">
                                <th style="line-height: 60px;">名称</th>
                                <th style="line-height: 60px;">计量单位</th>
                                <th style="line-height: 60px;">数量</th>
                                <th style="line-height: 60px;">补偿单价</th>
                                <th style="line-height: 60px;">补偿总价 (元)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(filled($pay_objects))
                                @foreach($pay_objects as $object)
                                    <tr>
                                        <td style="min-height: 80px;">{{$object->name}}</td>
                                        <td style="min-height: 80px;">{{$object->num_unit}}</td>
                                        <td style="min-height: 80px;">{{number_format($object->number,2)}}</td>
                                        <td style="min-height: 80px;">{{number_format($object->price,2)}}</td>
                                        <td style="min-height: 80px;">{{number_format($object->amount,2)}}</td>
                                    </tr>
                                @endforeach

                            @else
                                <tr>
                                    <td style="min-height: 80px;">--</td>
                                    <td style="min-height: 80px;">--</td>
                                    <td style="min-height: 80px;">--</td>
                                    <td style="min-height: 80px;">--</td>
                                    <td style="min-height: 80px;">--</td>
                                </tr>
                            @endif

                            <tr>
                                <td style="font-size: 20px;">合计</td>
                                <td>--</td>
                                <td>--</td>
                                <td>--</td>
                                <td>{{number_format($subject->total,2)}}</td>
                            </tr>
                            </tbody>
                        </table>
                        @break
                    @endswitch
                    <div class="text_indent50 lineheight50 color66">
                        经核定，乙方应得征收补偿款共计<div class="width200 height40 div_border_bot">{{number_format($subject->total,2)}}</div> 元
                        （大写：<div class="width200 height40 div_border_bot">{{bigRMB($subject->total)}}</div>）。
                    </div>
                </div>
            @endforeach
            <div class="text_indent50 lineheight50 color66">
                综合以上所述，乙方应得补偿资金共计：<div class="width200 height40 div_border_bot">{{number_format($subject_total,2)}}</div> 元
                （大写：<div class="width200 height40 div_border_bot">{{bigRMB($subject_total)}}</div>）。
            </div>
        </div>
        <div>
            <h3 style="text-indent: 50px;line-height: 50px;"> 四、乙方产权调换房屋安置情况（以下简称安置房）</h3>
            <ul>
                <li class="lineheight50 text_indent50 color66">1.产权调换标准安置面积。被征收人以其合法房屋的评估补偿总价加奖励资金，以安置价购买产权调换安置房屋，所能购买到的最大产权调换安置房面积，即为该户的产权调换标准安置面积。具体计算方式为：产权调换标准安置面积﹦（评估补偿总价＋奖励资金）÷产权调换安置房屋的安置价。</li>
                <li class="lineheight50 text_indent50 color66">2.产权调换安置办法。以被征收人产权调换标准安置面积为依据，在实际安置过程中以可供选择的产权调换房屋的实有面积为标准，互找差价：①在产权调换标准安置面积以内的部分，以产权调换安置房屋的安置优惠价结算。②超出产权调换标准安置面积的部分，在产权调换安置优惠价的基础上分别按不同等次逐段上浮：</li>
            </ul>
            <table class="table_a color66" border="1" cellspacing="0" style="width: 100%;page-break-before: auto;">
                <thead>
                <tr style="line-height: 80px;">
                    <th style="line-height: 60px;">段次</th>
                    <th style="line-height: 60px;">起始面积（不包含）（㎡）</th>
                    <th style="line-height: 60px;">截止面积（包含）（㎡）</th>
                    <th style="line-height: 60px;">上浮比例（%）</th>
                </tr>
                </thead>
                <tbody>
                @if(filled($house_rates))
                    @foreach($house_rates as $rate)
                        @if($rate->end_area==0 || $rate->rate==0)
                            <tr>
                                <td style="min-height: 80px;">{{$loop->iteration}}</td>
                                <td style="min-height: 80px;">{{$rate->start_area}}</td>
                                <td style="min-height: 80px;" colspan="2">（超出部门按评估市场价结算）</td>
                            </tr>
                        @else
                            <tr>
                                <td style="min-height: 80px;">{{$loop->iteration}}</td>
                                <td style="min-height: 80px;">{{$rate->start_area}}</td>
                                <td style="min-height: 80px;">{{$rate->end_area}}</td>
                                <td style="min-height: 80px;">{{$rate->rate}}</td>
                            </tr>
                        @endif

                    @endforeach

                @endif
                </tbody>
            </table>
            <div class="text_indent50 lineheight50 color66">3.产权调换房屋及上浮计算明细。</div>
            @if($pay->getOriginal('repay_way'))
            <div class="text_indent50 lineheight50 color66">
                乙方所得补偿资金之中，可调换安置房面积的资金 = 合法房屋及附属物 + 合法临建 + 公共附属物 + 签约奖励，共计：
                <div class="width200 height40 div_border_bot">{{number_format($house_resettle,2)}}</div> 元
                （大写：<div class="width200 height40 div_border_bot">{{bigRMB($house_resettle)}}</div>）
            </div>
            <table class="table_a color66" border="1" cellspacing="0" style="width: 100%;page-break-before: auto;">
                <thead>
                <tr style="line-height: 80px;">
                    <th style="line-height: 60px;">房号</th>
                    <th style="line-height: 60px;">面积（㎡）</th>
                    <th style="line-height: 60px;">安置单价（元/㎡）</th>
                    <th style="line-height: 60px;">安置总价（元）</th>
                    <th style="line-height: 60px;">上浮面积（㎡）</th>
                    <th style="line-height: 60px;">上浮房款（元）</th>
                    <th style="line-height: 60px;">房屋总价（元）</th>
                </tr>
                </thead>
                <tbody>
                @php $house_total =0; @endphp
                @if(filled($pay_houses))
                    @foreach($pay_houses as $house)
                        @php $house_total += $house->total; @endphp
                        <tr>
                            <td style="min-height: 80px;">
                                {{$house->house->building}}-
                                {{$house->house->unit}}-
                                {{$house->house->floor}}-
                                {{$house->house->number}}
                            </td>
                            <td style="min-height: 80px;">{{number_format($house->area,2)}}</td>
                            <td style="min-height: 80px;">{{number_format($house->price,2)}}</td>
                            <td style="min-height: 80px;">{{number_format($house->amount,2)}}</td>
                            <td style="min-height: 80px;">{{number_format($house->housepluses->sum('area'),2)}}</td>
                            <td style="min-height: 80px;">{{number_format($house->amount_plus,2)}}</td>
                            <td style="min-height: 80px;">{{number_format($house->total,2)}}</td>
                        </tr>
                        @if(filled($house->housepluses))
                            <tr>
                                <td colspan="7">
                                    <table class="table_a color66" border="1" cellspacing="0" style="width: 100%;page-break-before: auto;">
                                        <caption>上浮房款计算明细</caption>
                                        <thead>
                                        <tr>
                                            <th>上浮面积（㎡）</th>
                                            <th>评估市场价（元/㎡）</th>
                                            <th>安置优惠价（元/㎡）</th>
                                            <th>上浮比例（%）</th>
                                            <th>上浮金额（元）</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($house->housepluses as $plus)
                                        <tr>
                                            <td>{{number_format($plus->area,2)}}</td>
                                            <td>{{number_format($plus->market,2)}}</td>
                                            <td>{{number_format($plus->price,2)}}</td>
                                            <td>{{$plus->rate?$plus->rate:'--'}}</td>
                                            <td>{{number_format($plus->amount,2)}}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endif
                    @endforeach

                @endif
                </tbody>
            </table>
                <div class="text_indent50 lineheight50 color66">
                    综合以上统计，乙方须交纳房款共计
                    <div class="width200 height40 div_border_bot">{{number_format($house_total,2)}}</div> 元
                    （大写：<div class="width200 height40 div_border_bot">{{bigRMB($house_total)}}</div>）。
                    @php $last = $subject_total-$house_total;@endphp
                    上述房款和上浮款在乙方应得补偿资金中直接抵扣，抵扣后
                    @if($last>=0)
                        甲方付给乙方补偿资金
                        <div class="width200 height40 div_border_bot">{{number_format($last,2)}}</div> 元
                        （大写：<div class="width200 height40 div_border_bot">{{bigRMB($last)}}</div>）。
                    @elseif($last<0)
                        乙方须向甲方补交
                        <div class="width200 height40 div_border_bot">{{number_format(abs($last),2)}}</div> 元
                        （大写：<div class="width200 height40 div_border_bot">{{bigRMB(abs($last))}}</div>）。
                    @endif
                </div>
            @else
                <div class="text_indent50 lineheight50 color66">
                    乙方选择“货币补偿”的补偿方式，甲方应付乙方补偿资金
                    <div class="width200 height40 div_border_bot">{{number_format($subject_total,2)}}</div> 元
                    （大写：<div class="width200 height40 div_border_bot">{{bigRMB($subject_total)}}</div>）。
                </div>
            @endif
        </div>
        <!--乙方内容-->
        <div>
            <h3 style="text-indent: 50px;line-height: 50px;"> 五、乙方的保证</h3>
            <ul>
                <li class="lineheight50 text_indent50 color66">1.向甲方提供的所有产权书证材料及其他相关证明材料，均属客观、真实，否则，乙方愿承担一切法律责任。</li>
                <li class="lineheight50 text_indent50 color66">2.不隐瞒被征收房屋的产权纠纷或抵押担保等状况，隐瞒或提供材料不实产生的法律责任由乙方承担。</li>
            </ul>
        </div>
        <div>
            <h3 style="text-indent: 50px;line-height: 50px;"> 六、违约责任</h3>
            <div class="lineheight50 text_indent50 color66">本协议生效后，双方应共同遵守，如有一方违约或造成对方损失者，必须赔偿损失和承担违约责任。</div>
            <ul>
                <li class="lineheight50 text_indent50 color66">
                    1.因甲方的原因（不可抗拒因素除外）未按协议约定向乙方支付征收补偿款的，甲方应当承担逾期支付的民事责任，按未支付金额每日万分之<div class="width100 height40 div_border_bot ">三</div>的比例支付违约金。
                </li>
                <li class="lineheight50 text_indent50 color66">2.乙方未按期向甲方缴纳（结清）产权调换房屋差价或未在约定的期限内完成搬迁并移交房屋及房屋权属证等，乙方应当承担违约责任，甲方有权在乙方的征收补偿所得中按照每日万分之<div class="div_border_bot height40 width100">三</div>的比例扣除。
                </li>
            </ul>
        </div>
        <div>
            <h3 style="text-indent: 50px;line-height: 50px;"> 七、其它条款</h3>
            <ul>
                <li class="lineheight50 text_indent50 color66">自本协议签订后，乙方须在 <div class="div_border_bot height40 width100">15日</div>内将被征收房屋及宅院内的财物搬出，并及时将所有的建筑物、构筑物及地上附着物移交给甲方，乙方不得擅自拆除。如乙方擅自拆除，甲方有权从乙方补偿款中作价扣除，并由乙方自行承担擅自拆除造成的一切后果：纠纷、违约、安全问题等。</li>
                <li class="lineheight50 text_indent50 color66">2.乙方搬迁结束后，经甲方验收合格，一次性向乙方兑付征收补偿资金。</li>
                <li class="lineheight50 text_indent50 color66">3.被征收房屋交付前产生的水费、电费、物业费、电话费、有线电视费等相关费用由乙方自行承担，并负责结清所产生的相关费用。</li>
                <li class="lineheight50 text_indent50 color66">4.本协议签订之日，乙方须将被征收房屋产权证原件等相关证明材料交付给甲方，由甲方统一到房屋登记等部门办理房屋产权证的登记注销手续。如乙方不及时交付或拒绝交付，造成后续产权无法办理或产生的一切责任，均由乙方自行承担。</li>
                <li class="lineheight50 text_indent50 color66">5.房款的交纳及安置房屋入住手续的办理。甲乙双方结清以上各项费用后，甲方为乙方出具相关入住证明，并协助乙方办理有关入住手续。</li>
            </ul>
        </div>
        <div>
            <h3 style="text-indent: 50px;line-height: 50px;"> 八、争议的处理</h3>
            <div class="lineheight50 text_indent50 color66">本协议在履行过程中如发生争议，双方应先行协商解决，协商不成，可向有管辖权的人民法院提起诉讼。</div>
        </div>
        <div>
            <h3 style="text-indent: 50px;line-height: 50px;">九、协议生效及持有</h3>
            <div class="lineheight50 text_indent50 color66">本协议自甲乙双方签订之日起生效。本协议一式六份，甲方执五份，乙方执一份，具有同等法律效力。</div>
        </div>
        <div>
            <h3 style="text-indent: 50px;line-height: 50px;"> 十、未尽事宜</h3>
            <div class="lineheight50 text_indent50 color66">本协议未尽事宜按照国有土地上房屋征收相关法律法规执行，未作出明确规定的，由甲、乙双方另行协商后签订补充协议，补充协议与本协议具有同等法律效力。</div>
        </div>
        <div>
            <h3 style="text-indent: 50px;line-height: 50px;"> 十一、缴款账号</h3>
            <div class="lineheight50 text_indent50 color66">户&nbsp;&nbsp;&nbsp;&nbsp;名：天水市秦州区房屋征收补偿管理局</div>
            <div class="lineheight50 text_indent50 color66">开户行：兰州银行天水分行营业部</div>
            <div class="lineheight50 text_indent50 color66">账&nbsp;&nbsp;&nbsp;&nbsp;号：101822000392832</div>
        </div>
        <div style="margin-top: 100px;">
            <div class="lineheight50 text_indent50 color66">附件：1.房屋征收补偿兑付表</div>
            <div class="lineheight50 text_indent50 color66">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.房地产价格评估分户表</div>
            @if($household_detail->getOriginal('has_assets'))
            <div class="lineheight50 text_indent50 color66">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.资产评估报告</div>
            @endif
        </div>
    </div>
</div>
<!--满一页的-->
<div class="wrap ov" style="height: 1158px;background: tan;">
    <div class="ov" style="width: 50%;margin-left: 5%; float: left;height: 160px;line-height: 160px;">甲&nbsp;&nbsp;&nbsp;&nbsp;方（盖章）：</div>
    <div class="ov" style="width: 45%; float: left;height: 160px;line-height: 160px;">甲&nbsp;&nbsp;&nbsp;&nbsp;方（盖章）：</div>
    <div class="ov" style="width: 50%;margin-left: 5%; float: left;height: 160px;line-height: 160px;">法定代表人（签字）：</div>
    <div class="ov" style="width: 45%; float: left;height: 160px;line-height: 160px;">乙方代表（签字）：</div>
    <div class="ov" style="width: 100%;margin-left: 5%; height: 160px;line-height: 160px;">分管领导（签字）：</div>
    <div class="ov" style="width: 50%;margin-left: 5%; float: left;height: 160px;line-height: 160px;">经 办 人（签字）：</div>
    <div class="ov" style="width: 45%; float: left;height: 160px;line-height: 160px;">受 委 托 人（签字）：</div>
    <div class="ov" style="width: 50%;margin-left: 5%; float: left;height: 160px;line-height: 160px;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;年&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;月&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日
    </div>
    <div class="ov" style="width: 45%; float: left;height: 160px;line-height: 160px;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;年&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;月&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日
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