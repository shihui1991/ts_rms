{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <div class="well well-sm">
        <a href="javascript:history.back();" class="btn">返回</a>
    </div>

    <form class="form-horizontal" role="form" action="{{route('g_paysubject_edit',['item'=>$sdata['item']->id])}}" method="post">
        {{csrf_field()}}

        <input type="hidden" name="id" value="{{$sdata['pay_subject']->id}}">
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="subject_id"> 补偿科目： </label>
            <div class="col-sm-9">
                <input class="col-xs-10 col-sm-5" type="text" id="subject_id" value="{{$sdata['pay_subject']->subject->name}}" readonly>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="infos"> 补偿说明： </label>
            <div class="col-sm-9 radio">
                <textarea id="infos" readonly class="col-xs-10 col-sm-5">{{$sdata['pay_subject']->itemsubject->infos}}</textarea>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="calculate"> 补偿计算公式： </label>
            <div class="col-sm-9 radio">
                <textarea name="calculate" id="calculate" class="col-xs-10 col-sm-5">{{$sdata['pay_subject']->calculate}}</textarea>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="amount"> 补偿小计： </label>
            <div class="col-sm-9 radio">
                <input type="number" min="0" step="0.01" name="amount" id="amount" class="col-xs-10 col-sm-5" value="{{$sdata['pay_subject']->amount}}">
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


@endsection

{{-- 插件 --}}
@section('js')
    @parent


@endsection