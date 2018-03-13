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

    <form class="form-horizontal" role="form" action="{{route('g_itemprogram_add')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="item" value="{{$sdata['item_id']}}">

        <div class="well-sm">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#base_info" aria-expanded="true">
                            <i class="green ace-icon fa fa-building bigger-120"></i>
                            基本信息
                        </a>
                    </li>

                    <li class="">
                        <a data-toggle="tab" href="#content_info" aria-expanded="false">
                            <i class="green ace-icon fa fa-home bigger-120"></i>
                            详细内容
                        </a>
                    </li>

                </ul>

                <div class="tab-content">
                    <div id="base_info" class="tab-pane fade active in">
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="name"> 名称： </label>
                            <div class="col-sm-9">
                                <input type="text" id="name" name="name" value="" class="col-xs-10 col-sm-5"  placeholder="请输入名称" required>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="item_end"> 项目期限： </label>
                            <div class="col-sm-9">
                                <input type="text" id="item_end" name="item_end" value="" class="col-xs-10 col-sm-5 laydate" data-type="date" data-format="yyyy-MM-dd"  required>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="portion_holder"> 被征收人比例（%）： </label>
                            <div class="col-sm-9">
                                <input type="number" id="portion_holder" name="portion_holder" value="" class="col-xs-10 col-sm-5"  placeholder="请输入被征收人比例（%）" required>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="portion_renter"> 承租人比例（%）： </label>
                            <div class="col-sm-9">
                                <input type="number" id="portion_renter" name="portion_renter" value="" class="col-xs-10 col-sm-5"  placeholder="请输入承租人比例（%）" required>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="move_base"> 搬迁补助-基本： </label>
                            <div class="col-sm-9">
                                <input type="number" id="move_base" name="move_base" value="" class="col-xs-10 col-sm-5"  placeholder="请输入搬迁补助-基本" required>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="move_house"> 搬迁补助单价-住宅： </label>
                            <div class="col-sm-9">
                                <input type="number" id="move_house" name="move_house" value=""  class="col-xs-10 col-sm-5"  placeholder="请搬迁补助单价-住宅" required>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="move_office"> 搬迁补助单价-办公： </label>
                            <div class="col-sm-9">
                                <input type="number" id="move_office" name="move_office" value="" class="col-xs-10 col-sm-5"  placeholder="请搬迁补助单价-办公" required>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="move_business"> 搬迁补助单价-商服： </label>
                            <div class="col-sm-9">
                                <input type="number" id="move_business" name="move_business" value="" class="col-xs-10 col-sm-5"  placeholder="请输入搬迁补助单价-商服" required>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="move_factory"> 搬迁补助单价-生产加工： </label>
                            <div class="col-sm-9">
                                <input type="number" id="move_factory" name="move_factory" value="" class="col-xs-10 col-sm-5"  placeholder="请输入搬迁补助单价-生产加工" required>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="transit_base"> 临时安置-基本： </label>
                            <div class="col-sm-9">
                                <input type="number" id="transit_base" name="transit_base" value="" class="col-xs-10 col-sm-5"  placeholder="请输入请临时安置-基本" required>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="transit_house"> 临时安置单价-住宅： </label>
                            <div class="col-sm-9">
                                <input type="number" id="transit_house" name="transit_house" value="" class="col-xs-10 col-sm-5"  placeholder="请输入请临时安置单价-住宅" required>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="transit_other"> 临时安置单价-非住宅： </label>
                            <div class="col-sm-9">
                                <input type="number" id="transit_other" name="transit_other" value="" class="col-xs-10 col-sm-5"  placeholder="请输入临时安置单价-非住宅" required>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="transit_real"> 临时安置时长（月）-现房： </label>
                            <div class="col-sm-9">
                                <input type="number" id="transit_real" name="transit_real" value="" class="col-xs-10 col-sm-5"  placeholder="请输入临时安置时长（月）-现房" required>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="transit_future"> 临时安置时长（月）-期房： </label>
                            <div class="col-sm-9">
                                <input type="number" id="transit_future" name="transit_future" value="" class="col-xs-10 col-sm-5"  placeholder="请输入临时安置时长（月）-期房" required>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="reward_house"> 签约奖励单价-住宅-货币补偿： </label>
                            <div class="col-sm-9">
                                <input type="number" id="reward_house" name="reward_house" value="" class="col-xs-10 col-sm-5"  placeholder="请输入签约奖励单价-住宅-货币补偿" required>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="reward_other"> 签约奖励比例（%）-非住宅-货币补偿： </label>
                            <div class="col-sm-9">
                                <input type="number" id="reward_other" name="reward_other" value="" class="col-xs-10 col-sm-5"  placeholder="请输入签约奖励比例（%）-非住宅-货币补偿" required>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="reward_real"> 房屋奖励单价： </label>
                            <div class="col-sm-9">
                                <input type="number" id="reward_real" name="reward_real" value="" class="col-xs-10 col-sm-5"  placeholder="请输入房屋奖励单价" required>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="reward_move"> 搬迁奖励： </label>
                            <div class="col-sm-9">
                                <input type="number" id="reward_move" name="reward_move" value="" class="col-xs-10 col-sm-5"  placeholder="请输入搬迁奖励" required>
                            </div>
                        </div>
                        <div class="space-4"></div>
                    </div>

                    <div id="content_info" class="tab-pane fade">
                        <div class="form-group">

                            <div class="col-sm-12">
                                <textarea  style="height:500px;" id="content" name="content"  placeholder="请输入内容" ></textarea>
                            </div>
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

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')
    <script src="{{asset('js/func.js')}}"></script>
    <script src="{{asset('laydate/laydate.js')}}"></script>
    <script src="{{asset('ueditor/ueditor.config.js')}}"></script>
    <script src="{{asset('ueditor/ueditor.all.min.js')}}"></script>
    <script>
        var ue = UE.getEditor('content');
    </script>

@endsection