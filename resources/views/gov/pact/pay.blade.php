<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
    }
</style>

<body style="position: relative;">
<!--2480*3508-->
<div id="one-a4" style="width: 1000px;min-height:1158px;margin: auto;text-align: center;">
    <h2>{{$item->name}} 房屋征收补偿款兑付到户表</h2>
    <div class="title" style="width: 1000px;display: inline-block;height: auto;margin-top: 20px;">
        <p style="float: left;">泰州区房屋征收补偿管理局</p>
        <p style="float: right;">{{date('Y年m月d日',strtotime($sign_date))}}</p>
    </div>
    <div id="title" style="display: block;width: 1000px;height: auto;margin-top: 20px;">
        <table border="1" cellspacing="0" style="width: 100%;line-height: 32px;" id="old-table">
            <thead>
            <tr>
                <th colspan="2">被征收人</th>
                <th colspan="2">{{$holder->name}}</th>
                <th>身份证号</th>
                <th colspan="3">{{$holder->card_num}}</th>
            </tr>
            </thead>
            <tbody>
            @php $house_amount=0; @endphp
            @foreach($pay_subjects as $subject)
                @switch($subject->subject_id)
                    @case(1)
                    <td rowspan="{{$register_buildings->count()+1}}" id="one-ele">
                        {{$loop->iteration}}.{{$subject->subject->name}}
                    </td>
                    <td>房屋类型</td>
                    <td>房屋结构</td>
                    <td>面积（㎡）</td>
                    <td>评估单价<br/>（元/㎡）</td>
                    <td>评估总价（元）</td>
                    <td>补偿金额（元）</td>
                    <td>补偿小计 <br/>@if($household->getOriginal('type')==1)（公房承租人占{{$program->portion_renter}}%）@endif（元）</td>
                    @foreach($register_buildings as $register_building)
                        <tr>
                            <td>{{$register_building->realuse->name}}</td>
                            <td>{{$register_building->buildingstruct->name}}</td>
                            <td>{{number_format($register_building->real_outer,2)}}</td>
                            <td>{{number_format($register_building->price,2)}}</td>
                            <td>{{number_format($register_building->amount,2)}}</td>
                            <td>
                                @if($household->getOriginal('type')==1)
                                    {{number_format($register_building->amount*$program->portion_renter/100,2)}}
                                @else
                                    {{number_format($register_building->amount,2)}}
                                @endif
                            </td>
                            @if($loop->iteration==1)
                            <td rowspan="{{$register_buildings->count()}}">
                                @php $register_sum=$subject->total;$house_amount+=$register_sum; @endphp
                                {{number_format($subject->total,2)}}
                            </td>
                            @endif
                        </tr>
                    @endforeach
                    @break

                    @case(2)
                    <tr class="one-big-title">
                        <td rowspan="{{$legal_buildings->count()+1}}">
                            {{$loop->iteration}}.{{$subject->subject->name}}
                        </td>
                        <td>结构</td>
                        <td>修建时间</td>
                        <td>建筑面积（㎡>）</td>
                        <td>补偿单价<br/>（元/㎡>）</td>
                        <td>补偿金额（元）</td>
                        <td colspan="2">补偿小计（元）</td>
                    </tr>
                    @foreach($legal_buildings as $legal_building)
                        <tr>
                            <td>{{$legal_building->buildingstruct->name}}</td>
                            <td>{{$legal_building->householdbuilding->build_year}}</td>
                            <td>{{number_format($legal_building->real_outer,2)}}</td>
                            <td>{{number_format($legal_building->price,2)}}</td>
                            <td>{{number_format($legal_building->amount,2)}}</td>
                            @if($loop->iteration==1)
                                <td rowspan="{{$legal_buildings->count()}}" colspan="2">
                                    @php $legal_sum=$subject->total; $house_amount+=$legal_sum;@endphp
                                    {{number_format($subject->total,2)}}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    @break

                    @case(3)
                    <tr class="one-big-title">
                        <td rowspan="{{$destroy_buildings->count()+1}}">
                            {{$loop->iteration}}.{{$subject->subject->name}}
                        </td>
                        <td>结构</td>
                        <td>修建时间</td>
                        <td>建筑面积（㎡>）</td>
                        <td>补助单价<br/>（元/㎡>）</td>
                        <td>补助金额（元）</td>
                        <td colspan="2">补助小计（元）</td>
                    </tr>
                    @foreach($destroy_buildings as $destroy_building)
                        <tr>
                            <td>{{$destroy_building->buildingstruct->name}}</td>
                            <td>{{$destroy_building->householdbuilding->build_year}}</td>
                            <td>{{number_format($destroy_building->real_outer,2)}}</td>
                            <td>{{number_format($destroy_building->price,2)}}</td>
                            <td>{{number_format($destroy_building->amount,2)}}</td>
                            @if($loop->iteration==1)
                                <td rowspan="{{$destroy_buildings->count()}}" colspan="2">
                                    @php $destroy_sum=$subject->total; @endphp
                                    {{number_format($subject->total,2)}}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    @break
                    
                    @case(4)
                    <tr class="one-big-title">
                        <td rowspan="{{$public_buildings->count()+1}}">
                            {{$loop->iteration}}.{{$subject->subject->name}}
                        </td>
                        <td>名称</td>
                        <td>计量</td>
                        <td>补偿单价</td>
                        <td>补偿总价（元）</td>
                        <td>平分户数</td>
                        <td>每户补偿（元）</td>
                        <td>补偿小计（元）</td>
                    </tr>
                    @foreach($public_buildings as $public_building)
                        <tr>
                            <td>{{$public_building->name}}</td>
                            <td>{{number_format($public_building->number,2)}}{{$public_building->num_unit}}</td>
                            <td>{{number_format($public_building->price,2)}}</td>
                            <td>{{number_format($public_building->amount,2)}}</td>
                            <td>{{number_format($public_building->household)}}</td>
                            <td>{{number_format($public_building->avg,2)}}</td>
                            @if($loop->iteration==1)
                                <td rowspan="{{$public_buildings->count()}}">
                                    @php $public_sum=$subject->total; $house_amount+=$public_sum;@endphp
                                    {{number_format($subject->total,2)}}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    @break

                    @case(5)
                    <tr class="one-big-title">
                        <td rowspan="{{$pay_objects->count()+1}}">
                            {{$loop->iteration}}.{{$subject->subject->name}}
                        </td>
                        <td>名称</td>
                        <td>计量单位</td>
                        <td>数量</td>
                        <td>补偿单价</td>
                        <td>补偿总价（元）</td>
                        <td colspan="2">补偿小计（元）</td>
                    </tr>
                    @foreach($pay_objects as $pay_object)
                        <tr>
                            <td>{{$pay_object->name}}</td>
                            <td>{{$pay_object->num_unit}}</td>
                            <td>{{number_format($pay_object->number,2)}}</td>
                            <td>{{number_format($pay_object->price,2)}}</td>
                            <td>{{number_format($pay_object->amount,2)}}</td>
                            @if($loop->iteration==1)
                                <td rowspan="{{$pay_objects->count()}}" colspan="2">
                                    @php $object_sum=$subject->total; @endphp
                                    {{number_format($subject->total,2)}}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    @break

                    @case(6)
                    @case(7)
                    @case(10)
                    <tr class="one-big-title">
                        <td>{{$loop->iteration}}.{{$subject->subject->name}}</td>
                        <td colspan="2">补偿金额（元）</td>
                        <td colspan="5">{{number_format($subject->total,2)}}</td>
                    </tr>
                    @break

                    @case(8)
                    <tr class="one-big-title">
                        <td>{{$loop->iteration}}.{{$subject->subject->name}}</td>
                        <td>经营类别</td>
                        <td colspan="2">{{$business_type}}</td>
                        <td colspan="2">补偿金额（元）</td>
                        <td colspan="2">{{number_format($subject->total,2)}}</td>
                    </tr>
                    @break

                    @case(9)
                    <tr class="one-big-title">
                        <td rowspan="2" colspan="2">
                            {{$loop->iteration}}.{{$subject->subject->name}}
                        </td>
                        <td>合法房屋面积<br/>（㎡）</td>
                        <td>补助单价<br/>（元/㎡）</td>
                        <td>补助次数</td>
                        <td>补助金额（元）</td>
                        <td colspan="2">补助小计@if($household->getOriginal('type')==1)（公房承租人占{{$program->portion_renter}}%）@endif（元）</td>
                    </tr>
                    <tr>
                        <td>{{number_format($legal_area,2)}}</td>
                        <td>{{number_format($move_price,2)}}</td>
                        <td>{{$move_times}}</td>
                        <td>{{number_format($subject->amount,2)}}</td>
                        <td colspan="2">{{number_format($subject->total,2)}}</td>
                    </tr>
                    @break

                    @case(11)
                    <tr class="one-big-title">
                        <td rowspan="2">
                            {{$loop->iteration}}.{{$subject->subject->name}}
                        </td>
                        <td colspan="1">合法面积（㎡）</td>
                        <td colspan="1">奖励单价（元/㎡）</td>
                        <td colspan="2">奖励金额（元）</td>
                        <td colspan="3">奖励小计@if($household->getOriginal('type')==1)（公房承租人占{{$program->portion_renter}}%）@endif（元）</td>
                    </tr>
                    <tr>
                        <td colspan="1">{{number_format($legal_area,2)}}</td>
                        <td colspan="1">{{number_format($reward_price,2)}}</td>
                        <td colspan="2">{{number_format($subject->amount,2)}}</td>
                        <td colspan="3">{{number_format($subject->total,2)}}</td>
                    </tr>
                    @php $house_amount+=$subject->total; @endphp
                    @break
                    @case(12)
                    <tr class="one-big-title">
                        <td rowspan="2">
                            {{$loop->iteration}}.{{$subject->subject->name}}
                        </td>
                        <td colspan="2">合法房屋补偿总价</td>
                        <td>奖励比例（%）</td>
                        <td colspan="2">奖励金额（元）</td>
                        <td colspan="2">奖励小计<br/>@if($household->getOriginal('type')==1)（公房承租人占{{$program->portion_renter}}%）@endif（元）</td>
                    </tr>
                    <tr>
                        <td colspan="2">{{number_format($legal_amount,2)}}</td>
                        <td>{{number_format($reward_rate,2)}}</td>
                        <td colspan="2">{{number_format($subject->amount,2)}}</td>
                        <td colspan="2">{{number_format($subject->total,2)}}</td>
                    </tr>
                    @php $house_amount+=$subject->total; @endphp
                    @break
                @endswitch
                
            @endforeach

            <tr class="one-big-title">
                <td colspan="2">以上补偿总价（元）</td>
                <td colspan="2">
                    @php $pay_total=$pay_subjects->sum('total'); @endphp
                    {{number_format($pay_total,2)}}
                </td>
                <td colspan="4">大写：{{bigRMB($pay_total)}}</td>
            </tr>
            @if($pay->getOriginal('repay_way')==1)
                <tr>
                    <td colspan="2">其中可产权调换总价：</td>
                    <td colspan="2">{{number_format($house_amount,2)}}</td>
                    <td colspan="4">大写：{{bigRMB($house_amount)}}</td>
                </tr>

                <tr>
                    <td rowspan="{{$pay_houses->count()+1}}">安置房</td>
                    <td>房号</td>
                    <td>面积（㎡）</td>
                    <td>安置单价（元/㎡）</td>
                    <td>安置总价（元）</td>
                    <td>上浮面积（㎡）</td>
                    <td>上浮房款（元）</td>
                    <td>房屋总价（元）</td>
                </tr>
                @php $house_total =0; @endphp
                @foreach($pay_houses as $house)
                    @php $house_total += $house->total; @endphp
                    <tr>
                        <td>{{$house->house->number}}</td>
                        <td>{{number_format($house->area,2)}}</td>
                        <td>{{number_format($house->price,2)}}</td>
                        <td>{{number_format($house->amount,2)}}</td>
                        <td>{{number_format($house->housepluses->sum('area'),2)}}</td>
                        <td>{{number_format($house->amount_plus,2)}}</td>
                        <td>{{number_format($house->total,2)}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td>合计：</td>
                    <td>安置总价（元）</td>
                    <td colspan="3">{{number_format($house_total,2)}}</td>
                    <td colspan="4">大写：{{bigRMB($house_total)}}</td>
                </tr>
                @php $last=$pay_total-$house_total; @endphp
                <tr>
                    <td colspan="2">安置后结余：</td>
                    <td colspan="3">{{number_format($last,2)}}</td>
                    <td colspan="4">@if($last<0) 负 @endif{{bigRMB(abs($last))}}</td>
                </tr>
            @endif
            <tr class="one-big-title">
                <td colspan="8">
                    <span style="text-align: left;display: block;width: 30%;float: left;">分管领导签字：</span>
                    <span style="text-align: left;display: block;width: 30%;float: left;">征收股负责人：</span>
                    <span style="text-align: left;display: block;width: 30%;float: left;">安置股负责人：</span>
                </td>
            </tr>
            <tr class="one-big-title">
                <td colspan="8">
                    <span style="text-align: left;display: block;width: 25%;float: left;">社稳办负责人：</span>
                    <span style="text-align: left;display: block;width: 25%;float: left;">复核人：</span>
                    <span style="text-align: left;display: block;width: 25%;float: left;">经办人：</span>
                    <span style="text-align: left;display: block;width: 25%;float: left;">被征收人：</span>
                </td>
            </tr>

            </tbody>
        </table>
    </div>
</div>

</body>

</html>