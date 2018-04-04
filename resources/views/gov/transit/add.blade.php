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


    <form class="form-horizontal" role="form" action="{{route('g_transit_add',['item'=>$sdata['item']->id])}}" method="post">
        {{csrf_field()}}

        <input type="hidden" name="id" value="{{$sdata['pay_transit']->id}}">
        <input type="hidden" name="household_id" value="{{$sdata['pay_transit']->household_id}}">
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="start_at"> 开始日期： </label>
            <div class="col-sm-9">
                <input type="text" id="start_at" name="start_at" value="{{old('start_at')}}" class="col-xs-10 col-sm-5 laydate"  required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="exp_end"> 预计结束日期： </label>
            <div class="col-sm-9">
                <input type="text" id="exp_end" name="exp_end" value="{{old('exp_end')}}" class="col-xs-10 col-sm-5 laydate"  required>
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

    <div class="widget-container-col ui-sortable">
        <div class="widget-box ui-sortable-handle">
            <div class="widget-header">
                <h5 class="widget-title">房源信息</h5>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <div class="profile-user-info profile-user-info-striped">

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 房源管理： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata['pay_transit']->house->housecompany->name}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 小区： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">
                                    {{$sdata['pay_transit']->house->housecommunity->address}}
                                    {{$sdata['pay_transit']->house->housecommunity->name}}
                                </span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 房号： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">
                                    {{$sdata['pay_transit']->house->building}}栋
                                    {{$sdata['pay_transit']->house->unit}}单元
                                    {{$sdata['pay_transit']->house->floor}}楼
                                    {{$sdata['pay_transit']->house->number}}号
                                </span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 户型： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">
                                    {{$sdata['pay_transit']->house->layout->name}}
                                </span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 面积： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">
                                    {{$sdata['pay_transit']->house->area}}
                                </span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 有无电梯： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">
                                    {{$sdata['pay_transit']->house->lift}}
                                </span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 房源状态： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">
                                    {{$sdata['pay_transit']->house->state->name}}
                                </span>
                            </div>
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
    @parent
    <script src="{{asset('laydate/laydate.js')}}"></script>

@endsection