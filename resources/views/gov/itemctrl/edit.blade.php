{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')
    
    <div class="well well-sm">
        <a href="{{route('g_itemctrl',['item'=>$sdata['item']->id])}}" class="btn">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>
    </div>
    <form class="form-horizontal" role="form" action="{{route('g_itemctrl_edit',['item'=>$sdata['item']->id])}}" method="post">
        {{csrf_field()}}

        <input type="hidden" name="id" value="{{$sdata['itemctrl']->id}}">
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="cate_id"> 类别： </label>
            <div class="col-sm-9">
                <input type="text" id="cate_id" value="{{$sdata['itemctrl']->ctrlcate->name}}" class="col-xs-10 col-sm-5" readonly>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="serial"> 序列（轮次）： </label>
            <div class="col-sm-9">
                <input type="text" id="serial" name="serial" value="{{$sdata['itemctrl']->serial}}" class="col-xs-10 col-sm-5" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="start_at"> 开始时间： </label>
            <div class="col-sm-9">
                <input type="text" id="start_at" name="start_at" value="{{$sdata['itemctrl']->start_at}}" class="col-xs-10 col-sm-5 laydate" data-type="datetime" data-format="yyyy-MM-dd HH:mm:ss"  required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="end_at"> 开始时间： </label>
            <div class="col-sm-9">
                <input type="text" id="end_at" name="end_at" value="{{$sdata['itemctrl']->end_at}}" class="col-xs-10 col-sm-5 laydate" data-type="datetime" data-format="yyyy-MM-dd HH:mm:ss"  required>
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
    <script src="{{asset('laydate/laydate.js')}}"></script>
    
@endsection