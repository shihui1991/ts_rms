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


    <form class="form-horizontal" role="form" action="{{route('g_audit_add',['item'=>$sdata['item']->id])}}" method="post">
        {{csrf_field()}}

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="infos"> 审计结论： </label>
            <div class="col-sm-9">
                <textarea name="infos" id="infos" class="col-xs-10 col-sm-5"></textarea>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group img-box">
            <label class="col-sm-3 control-label no-padding-right">
                审计报告：<br>
                <span class="btn btn-xs">
                    <span>上传图片</span>
                    <input type="file" accept="image/*" class="hidden" data-name="picture[]" multiple onchange="uplfile(this)">
                </span>
            </label>
            <div class="col-sm-9">
                <ul class="ace-thumbnails clearfix img-content">


                </ul>
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
    @parent
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script src="{{asset('laydate/laydate.js')}}"></script>

@endsection