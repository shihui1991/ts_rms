{{-- 继承布局 --}}
@extends('household.layout')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>
    </p>


    <form class="form-horizontal" role="form" action="{{route('h_itemrisk_add')}}" method="post">
        {{csrf_field()}}
        <div class="well-sm">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#risk" aria-expanded="true">
                            <i class="green ace-icon fa fa-building bigger-120"></i>
                            意见调查
                        </a>
                    </li>

                    <li class="">
                        <a data-toggle="tab" href="#topic" aria-expanded="false">
                            <i class="green ace-icon fa fa-home bigger-120"></i>
                            自选话题调查
                        </a>
                    </li>

                </ul>

                <div class="tab-content">
                    <div id="risk" class="tab-pane fade active in">
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="name">项目名称：</label>
                            <div class="col-sm-9">
                                <input type="text" id="item_name" name="item_name" value="{{$sdata['risk']->item->name}}" class="col-xs-10 col-sm-5" readonly>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        {{--<div class="form-group">--}}
                            {{--<label class="col-sm-3 control-label no-padding-right" for="land_id">地块：</label>--}}
                            {{--<div class="col-sm-9">--}}
                                {{--<input type="text" id="land_name" name="land_name" value="{{$sdata->itemland->address}}" class="col-xs-10 col-sm-5" readonly>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="space-4"></div>--}}

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="land_id">被征户地址：</label>
                            <div class="col-sm-9">
                                <input type="text" id="building_name" name="building_name" value=" {{$sdata['risk']->itemland->address}}{{$sdata['risk']->itembuilding->building}}栋{{$sdata['risk']->unit}}单元{{$sdata['risk']->floor}}楼{{$sdata['risk']->number}}号" class="col-xs-10 col-sm-5" readonly>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="agree"> 征收意见稿态度：</label>
                            <div class="col-sm-9">
                                @foreach($edata->agree as $key => $value)
                                    <label>
                                        <input name="agree" type="radio" class="ace" value="{{$key}}"  checked/>
                                        <span class="lbl">{{$value}}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="repay_way"> 补偿方式：</label>
                            <div class="col-sm-9">
                                @foreach($edata->repay_way as $key => $value)
                                    <label>
                                        <input name="repay_way" type="radio" class="ace repay-val" value="{{$key}}" checked/>
                                        <span class="lbl">{{$value}}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group house-repay">
                            <label class="col-sm-3 control-label no-padding-right" for="house_price"> 房源单价：</label>
                            <div class="col-sm-9">
                                <input type="number" step="0.01"  id="house_price" name="house_price" value="" class="col-xs-10 col-sm-5" required>
                            </div>
                        </div>
                        <div class="space-4 house-repay"></div>

                        <div class="form-group house-repay">
                            <label class="col-sm-3 control-label no-padding-right" for="house_area"> 房源面积：</label>
                            <div class="col-sm-9">
                                <input type="number" step="0.01"  id="house_area" name="house_area" value="" class="col-xs-10 col-sm-5" required>
                            </div>
                        </div>
                        <div class="space-4 house-repay"></div>

                        <div class="form-group house-repay">
                            <label class="col-sm-3 control-label no-padding-right" for="house_num"> 房源数量：</label>
                            <div class="col-sm-9">
                                <input type="number"  id="house_num" name="house_num" value="" class="col-xs-10 col-sm-5" required>
                            </div>
                        </div>
                        <div class="space-4 house-repay"></div>

                        <div class="form-group house-repay">
                            <label class="col-sm-3 control-label no-padding-right" for="house_addr"> 房源地址：</label>
                            <div class="col-sm-9">
                                <input type="text"  id="house_addr" name="house_addr" value="" class="col-xs-10 col-sm-5" required>
                            </div>
                        </div>
                        <div class="space-4 house-repay"></div>

                        <div class="form-group house-repay">
                            <label class="col-sm-3 control-label no-padding-right" for="more_price"> 增加面积单价：</label>
                            <div class="col-sm-9">
                                <input type="number" step="0.01"  id="more_price" name="more_price" value="" class="col-xs-10 col-sm-5" required>
                            </div>
                        </div>
                        <div class="space-4 house-repay"></div>

                        <div class="form-group house-repay">
                            <label class="col-sm-3 control-label no-padding-right" for="layout_id">房源户型：</label>
                            <div class="col-sm-9 radio">
                                <select name="layout_id" id="layout_id" class="col-xs-10 col-sm-5">
                                    @foreach($sdata['risk']->layout as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="space-4 house-repay"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="transit_way">过渡方式：</label>
                            <div class="col-sm-9">
                                @foreach($edata->transit_way as $key => $value)
                                    <label>
                                        <input name="transit_way" type="radio" class="ace" value="{{$key}}" checked/>
                                        <span class="lbl">{{$value}}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="move_way">搬迁方式：</label>
                            <div class="col-sm-9">
                                @foreach($edata->move_way as $key => $value)
                                    <label>
                                        <input name="move_way" type="radio" class="ace" value="{{$key}}" checked/>
                                        <span class="lbl">{{$value}}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="move_fee"> 搬迁补偿：</label>
                            <div class="col-sm-9">
                                <input type="number" step="0.01"  id="move_fee" name="move_fee" value="" class="col-xs-10 col-sm-5" checked required>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="decoration">装修补偿：</label>
                            <div class="col-sm-9">
                                <input type="number" step="0.01"  id="decoration" name="decoration" value="" class="col-xs-10 col-sm-5" checked required>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="device">设备拆移费：</label>
                            <div class="col-sm-9">
                                <input type="number" step="0.01" id="device" name="device" value="" class="col-xs-10 col-sm-5" required>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="business">停产停业损失补偿：</label>
                            <div class="col-sm-9">
                                <input type="number" step="0.01" id="business" name="business" value="" class="col-xs-10 col-sm-5" required>
                            </div>
                        </div>
                        <div class="space-4"></div>

                    </div>

                    <div id="topic" class="tab-pane fade">
                        <div class="form-group">
                        @foreach($sdata['topic'] as $key=>$value)
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="business">{{$value['topic']['name']}}：</label>
                                    <div class="col-sm-9">
                                        <textarea class="col-xs-12 col-sm-5" name="topic[{{$value['topic']['id']}}]" required>

                                        </textarea>

                                    </div>
                                </div>
                                <div class="space-4"></div>
                        @endforeach
                        </div>
                        <div class="space-4"></div>
                    </div>

                </div>
            </div>
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


{{-- 插件 --}}
@section('js')
    @parent
    <script src="{{asset('js/func.js')}}"></script>
    <script>
        $(function(){
            show_hid();
            $(".repay-val").change(function () {
                show_hid();
            });
        });
        function show_hid() {
            var repay_way=$("input[name='repay_way']:checked").val();
            if (repay_way=='1'){
                $('.house-repay').css("display",'block');
            }else {
                $('.house-repay').css("display",'none');
            }
        }
    </script>

@endsection
