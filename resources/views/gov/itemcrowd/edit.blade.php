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


    <form class="form-horizontal" role="form" action="{{route('g_itemcrowd_edit')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$sdata->id}}">
        <input type="hidden" name="item" value="{{$sdata->item_id}}">
        <input type="hidden" name="crowd_id" value="{{$sdata->crowd_id}}">
        <input type="hidden" name="crowd_cate_id" value="{{$sdata->crowd_cate_id}}">

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="crowd_id"> 特殊人群： </label>
            <div class="col-sm-9">
                <input type="text" id="crowd_id" value="{{$sdata->crowd->name}}" class="col-xs-10 col-sm-5" readonly>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="crowd_cate_id"> 特殊人群分类： </label>
            <div class="col-sm-9">
                <input type="text"  id="crowd_cate_id"  value="{{$sdata->cate->name}}"  class="col-xs-10 col-sm-5" readonly>
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