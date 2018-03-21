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


    <form class="form-horizontal" role="form" action="{{route('g_itemreward_add',['item'=>$sdata['item']->id])}}" method="post">
        {{csrf_field()}}

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="start_at"> 起始日期： </label>
            <div class="col-sm-9">
                <input type="text" id="start_at" name="start_at" value="{{old('start_at')}}" class="col-xs-10 col-sm-5 laydate"  required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="end_at"> 截止日期： </label>
            <div class="col-sm-9">
                <input type="text" id="end_at" name="end_at" value="{{old('end_at')}}" class="col-xs-10 col-sm-5 laydate"  required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="price"> 奖励单价（住宅）： </label>
            <div class="col-sm-9">
                <div class="input-group col-xs-10 col-sm-5 ">
                    <input type="number" min="0" step="0.01" id="price" name="price" value="" class="form-control input-mask-product" required>
                    <div class="input-group-addon">元/㎡</div>
                </div>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="portion"> 奖励比例（非住宅）： </label>
            <div class="col-sm-9">
                <div class="input-group col-xs-10 col-sm-5 ">
                    <input type="number" min="0" max="100" step="0.01" id="portion" name="portion" value="" class="form-control input-mask-product" required>
                    <div class="input-group-addon">%</div>
                </div>
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