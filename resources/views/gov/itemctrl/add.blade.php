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
    <form class="form-horizontal" role="form" action="{{route('g_itemctrl_add',['item'=>$sdata['item']->id])}}" method="post">
        {{csrf_field()}}

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="cate_id"> 类别： </label>
            <div class="col-sm-9">
                <select name="cate_id" id="cate_id" class="col-xs-10 col-sm-5">
                    <option value="">请选择类别</option>
                    @foreach($sdata['ctrlcates'] as $ctrlcate)
                        <option value="{{$ctrlcate->id}}">{{$ctrlcate->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="serial"> 序列（轮次）： </label>
            <div class="col-sm-9">
                <input type="text" id="serial" name="serial" value="{{old('serial')}}" class="col-xs-10 col-sm-5" placeholder="如：A，B，C，……" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="start_at"> 开始时间： </label>
            <div class="col-sm-9">
                <input type="text" id="start_at" name="start_at" value="{{old('start_at')}}" class="col-xs-10 col-sm-5 laydate" data-type="datetime" data-format="yyyy-MM-dd HH:mm:ss"  required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="end_at"> 结束时间： </label>
            <div class="col-sm-9">
                <input type="text" id="end_at" name="end_at" value="{{old('end_at')}}" class="col-xs-10 col-sm-5 laydate" data-type="datetime" data-format="yyyy-MM-dd HH:mm:ss"  required>
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