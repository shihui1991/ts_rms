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


    <form class="form-horizontal" role="form" action="{{route('g_houseprice_add')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="house_id" value="{{$edata['house_id']}}">
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="start_at"> 开始时间： </label>
            <div class="col-sm-9">
                <input type="text" id="start_at" name="start_at" value="{{old('start_at')}}" class="col-xs-10 col-sm-5 laydate"  placeholder="请输入开始时间" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="end_at"> 结束时间： </label>
            <div class="col-sm-9">
                <input type="text" id="end_at" name="end_at" value="{{old('end_at')}}" class="col-xs-10 col-sm-5 laydate"  placeholder="请输入结束时间" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="market"> 评估市场价： </label>
            <div class="col-sm-9">
                <input type="text" id="market" name="market" value="{{old('market')}}" class="col-xs-10 col-sm-5"  placeholder="请输入评估市场价" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="price"> 安置优惠价： </label>
            <div class="col-sm-9">
                <input type="text" id="price" name="price" value="{{old('price')}}" class="col-xs-10 col-sm-5"  placeholder="请输入安置优惠价" required>
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
    <script src="{{asset('js/func.js')}}"></script>
    <script src="{{asset('laydate/laydate.js')}}"></script>
    <script>
        $('#name').focus();
    </script>

@endsection