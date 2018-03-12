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


    <form class="form-horizontal" role="form" action="{{route('g_itemprogram_edit')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$sdata->id}}">
        <input type="hidden" name="item" value="{{$sdata->item_id}}">

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="name"> 名称： </label>
            <div class="col-sm-9">
                <input type="text" id="name" name="name" value="{{$sdata->name}}" class="col-xs-10 col-sm-5"  placeholder="请输入名称" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="portion_holder"> 被征收人比例（%）： </label>
            <div class="col-sm-9">
                <input type="number" id="portion_holder" name="portion_holder" value="{{$sdata->portion_holder}}" class="col-xs-10 col-sm-5"  placeholder="请输入被征收人比例（%）" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="portion_renter"> 承租人比例（%）： </label>
            <div class="col-sm-9">
                <input type="number" id="portion_renter" name="portion_renter" value="{{$sdata->portion_renter}}" class="col-xs-10 col-sm-5"  placeholder="请输入承租人比例（%）" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="move_base"> 搬迁补助-基本： </label>
            <div class="col-sm-9">
                <input type="number" id="move_base" name="move_base" value="{{$sdata->move_base}}" class="col-xs-10 col-sm-5"  placeholder="请输入搬迁补助-基本" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="move_house"> 搬迁补助单价-住宅： </label>
            <div class="col-sm-9">
                <input type="number" id="move_house" name="move_house" value="{{$sdata->move_house}}"  class="col-xs-10 col-sm-5"  placeholder="请搬迁补助单价-住宅" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="move_office"> 搬迁补助单价-办公： </label>
            <div class="col-sm-9">
                <input type="number" id="move_office" name="move_office" value="{{$sdata->move_office}}" class="col-xs-10 col-sm-5"  placeholder="请搬迁补助单价-办公" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="move_business"> 搬迁补助单价-商服： </label>
            <div class="col-sm-9">
                <input type="number" id="move_business" name="move_business" value="{{$sdata->move_office}}" class="col-xs-10 col-sm-5"  placeholder="请输入搬迁补助单价-商服" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="move_factory"> 搬迁补助单价-生产加工： </label>
            <div class="col-sm-9">
                <input type="number" id="move_factory" name="move_factory" value="{{$sdata->move_factory}}" class="col-xs-10 col-sm-5"  placeholder="请输入搬迁补助单价-生产加工" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="transit_base"> 临时安置-基本： </label>
            <div class="col-sm-9">
                <input type="number" id="transit_base" name="transit_base" value="{{$sdata->transit_base}}" class="col-xs-10 col-sm-5"  placeholder="请输入请临时安置-基本" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="transit_house"> 临时安置单价-住宅： </label>
            <div class="col-sm-9">
                <input type="number" id="transit_house" name="transit_house" value="{{$sdata->transit_house}}" class="col-xs-10 col-sm-5"  placeholder="请输入请临时安置单价-住宅" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="transit_other"> 临时安置单价-非住宅： </label>
            <div class="col-sm-9">
                <input type="number" id="transit_other" name="transit_other" value="{{$sdata->transit_other}}" class="col-xs-10 col-sm-5"  placeholder="请输入临时安置单价-非住宅" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="transit_real"> 临时安置时长（月）-现房： </label>
            <div class="col-sm-9">
                <input type="number" id="transit_real" name="transit_real" value="{{$sdata->transit_real}}" class="col-xs-10 col-sm-5"  placeholder="请输入临时安置时长（月）-现房" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="transit_future"> 临时安置时长（月）-期房： </label>
            <div class="col-sm-9">
                <input type="number" id="transit_future" name="transit_future" value="{{$sdata->transit_future}}" class="col-xs-10 col-sm-5"  placeholder="请输入临时安置时长（月）-期房" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="reward_house"> 签约奖励单价-住宅-货币补偿： </label>
            <div class="col-sm-9">
                <input type="number" id="reward_house" name="reward_house" value="{{$sdata->reward_house}}" class="col-xs-10 col-sm-5"  placeholder="请输入签约奖励单价-住宅-货币补偿" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="reward_other"> 签约奖励比例（%）-非住宅-货币补偿： </label>
            <div class="col-sm-9">
                <input type="number" id="reward_other" name="reward_other" value="{{$sdata->reward_other}}" class="col-xs-10 col-sm-5"  placeholder="请输入签约奖励比例（%）-非住宅-货币补偿" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="reward_real"> 房屋奖励单价： </label>
            <div class="col-sm-9">
                <input type="number" id="reward_real" name="reward_real" value="{{$sdata->reward_real}}" class="col-xs-10 col-sm-5"  placeholder="请输入房屋奖励单价" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="reward_move"> 搬迁奖励： </label>
            <div class="col-sm-9">
                <input type="number" id="reward_move" name="reward_move" value="{{$sdata->reward_move}}" class="col-xs-10 col-sm-5"  placeholder="请输入搬迁奖励" required>
            </div>
        </div>
        <div class="space-4"></div>


        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="content"> 内容：</label>
            <div class="col-sm-9">
                <textarea  style="width:90%;height:500px;" id="content" name="content"  placeholder="请输入内容" >{{$sdata->content}}</textarea>
            </div>
        </div>
        <div class="space-4"></div>

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
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script src="{{asset('js/func.js')}}"></script>
    <script src="{{asset('ueditor/ueditor.config.js')}}"></script>
    <script src="{{asset('ueditor/ueditor.all.min.js')}}"></script>
    <script>
        var ue = UE.getEditor('content');
    </script>


@endsection