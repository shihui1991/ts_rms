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


    <form class="form-horizontal" role="form" action="{{route('g_itemhouserate_edit')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$sdata->id}}">
        <input type="hidden" name="item" value="{{$sdata->item_id}}">

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="start_area"> 起始面积（超出）： </label>
            <div class="col-sm-9">
                <input type="number" min="0" max="100" step="0.01" id="start_area" name="start_area" value="{{$sdata->start_area}}" class="col-xs-10 col-sm-5"  placeholder="请输入起始面积（超出）" required>&nbsp;&nbsp;<label class="control-label ">㎡</label>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="end_area"> 截止面积（超出）： </label>
            <div class="col-sm-9">
                <input type="number" min="0" max="100" step="0.01" id="end_area" name="end_area" value="{{$sdata->end_area}}" class="col-xs-10 col-sm-5"  placeholder="请输入截止面积（超出）" required>&nbsp;&nbsp;<label  class="control-label ">㎡</label>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="rate"> 优惠上浮率： </label>
            <div class="col-sm-9">
                <input type="number" min="0" max="100" step="0.1" id="rate" name="rate" value="{{$sdata->rate}}" class="col-xs-10 col-sm-5"  placeholder="请输入优惠上浮率" required>&nbsp;&nbsp;<label style="font-weight: bold" class="control-label ">%</label>
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
    <script src="{{asset('js/func.js')}}"></script>
    <script>

    </script>

@endsection