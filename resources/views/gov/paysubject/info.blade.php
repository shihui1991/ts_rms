{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <div class="well well-sm">
        <a href="javascript:history.back();" class="btn">返回</a>

        @if(in_array($sdata['pay_subject']->subject_id,[7,8,10]) && $sdata['pay_subject']->code=='110')
            <a href="{{route('g_paysubject_edit',['item'=>$sdata['item']->id,'id'=>$sdata['pay_subject']->id])}}" class="btn">修改补偿</a>
        @endif
    </div>

    <div class="profile-user-info profile-user-info-striped">

        <div class="profile-info-row">
            <div class="profile-info-name"> 补偿科目： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata['pay_subject']->subject->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 补偿说明： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata['pay_subject']->itemsubject->infos}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 补偿计算： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata['pay_subject']->calculate}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 补偿金额： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">
                    <strong>{{number_format($sdata['pay_subject']->amount,2)}}</strong>
                    人民币（大写）：
                    {{bigRMB($sdata['pay_subject']->amount)}}
                </span>
            </div>
        </div>

        @if($sdata['pay_subject']->household->getOriginal('type'))

            <div class="profile-info-row">
                <div class="profile-info-name"> 被征收户补偿比例： </div>
                <div class="profile-info-value">
                <span class="editable editable-click">
                    <strong>{{number_format($sdata['pay_subject']->portion,2)}}</strong> %
                </span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> 被征收户补偿金额： </div>
                <div class="profile-info-value">
                <span class="editable editable-click">
                    <strong>{{number_format($sdata['pay_subject']->total,2)}}</strong>
                    人民币（大写）：
                    {{bigRMB($sdata['pay_subject']->total)}}
                </span>
                </div>
            </div>

        @endif

        <div class="profile-info-row">
            <div class="profile-info-name"> 状态： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata['pay_subject']->state->name}}</span>
            </div>
        </div>

    </div>

    @if(in_array($sdata['pay_subject']->subject_id,[1,2,3,4,5,6,14,18]))
        <div class="widget-container-col ui-sortable">
            <div class="widget-box ui-sortable-handle">
                <div class="widget-header">
                    <h5 class="widget-title">补偿明细</h5>
                </div>

                <div class="widget-body">
                    <div class="widget-main">
                        @switch($sdata['pay_subject']->subject_id)
                            @case(1)
                            @case(2)
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>名称</th>
                                    <th>实际用途</th>
                                    <th>结构</th>
                                    <th>朝向</th>
                                    <th>所在楼层</th>
                                    <th>实际面积</th>
                                    <th>评估单价</th>
                                    <th>评估总价</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sdata['pay_buildings'] as $building)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$building->householdbuilding->name}}</td>
                                        <td>{{$building->realuse->name}}</td>
                                        <td>{{$building->buildingstruct->name}}</td>
                                        <td>{{$building->direct}}</td>
                                        <td>{{$building->floor}}</td>
                                        <td>{{number_format($building->real_outer,2)}}</td>
                                        <td>{{number_format($building->price,2)}}</td>
                                        <td>{{number_format($building->amount,2)}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @break

                            @case(3)
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>名称</th>
                                    <th>实际用途</th>
                                    <th>结构</th>
                                    <th>朝向</th>
                                    <th>所在楼层</th>
                                    <th>实际面积</th>
                                    <th>补助单价</th>
                                    <th>补助总价</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sdata['pay_buildings'] as $building)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$building->householdbuilding->name}}</td>
                                        <td>{{$building->realuse->name}}</td>
                                        <td>{{$building->buildingstruct->name}}</td>
                                        <td>{{$building->direct}}</td>
                                        <td>{{$building->floor}}</td>
                                        <td>{{number_format($building->real_outer,2)}}</td>
                                        <td>{{number_format($building->price,2)}}</td>
                                        <td>{{number_format($building->amount,2)}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @break

                            @case(4)
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>名称</th>
                                    <th>计量单位</th>
                                    <th>数量</th>
                                    <th>评估单价</th>
                                    <th>评估总价</th>
                                    <th>平分户数</th>
                                    <th>每户补偿</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sdata['pay_publics'] as $public)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$public->name}}</td>
                                        <td>{{$public->num_unit}}</td>
                                        <td>{{number_format($public->number,2)}}</td>
                                        <td>{{number_format($public->price,2)}}</td>
                                        <td>{{number_format($public->amount,2)}}</td>
                                        <td>{{number_format($public->household)}}</td>
                                        <td>{{number_format($public->avg,2)}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @break

                            @case(5)
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>名称</th>
                                    <th>计量单位</th>
                                    <th>数量</th>
                                    <th>补偿单价</th>
                                    <th>补偿总价</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sdata['pay_objects'] as $object)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$object->name}}</td>
                                        <td>{{$object->num_unit}}</td>
                                        <td>{{number_format($object->number)}}</td>
                                        <td>{{number_format($object->price,2)}}</td>
                                        <td>{{number_format($object->amount,2)}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @break

                            @case(6)
                            <h4 class="">评估报告</h4>
                            <ul class="ace-thumbnails clearfix img-content">
                                @foreach($sdata['assets']->picture as $pic)
                                    <li>
                                        <div>
                                            <img width="120" height="120" src="{{$pic}}" alt="加载失败">
                                            <div class="text">
                                                <div class="inner">
                                                    <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach

                            </ul>
                            @break

                            @case(14)
                            @case(18)
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>类别</th>
                                    <th>特殊人群</th>
                                    <th>临时安置费</th>
                                    <th>上浮比例（%）</th>
                                    <th>上浮优惠</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sdata['pay_crowds'] as $crowd)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$crowd->crowdcate->name}}</td>
                                        <td>{{$crowd->crowd->name}}</td>
                                        <td>{{number_format($crowd->transit,2)}}</td>
                                        <td>{{number_format($crowd->rate,2)}}</td>
                                        <td>{{number_format($crowd->amount,2)}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @break

                        @endswitch
                    </div>
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
    @parent
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script>
        $('.img-content').viewer();
    </script>

@endsection