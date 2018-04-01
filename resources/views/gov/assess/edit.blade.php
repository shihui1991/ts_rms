{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')
    <div class="well well-sm">
        <a href="javascript:history.back();" class="btn">返回</a>
    </div>
    <div class="widget-box widget-color-red">
        <div class="widget-header">
            <h4 class="widget-title lighter smaller">评估报告审查意见</h4>
        </div>

        <div class="widget-body">
            <div class="widget-main padding-8">
                <form class="form-horizontal" role="form" action="{{route('g_assess_check',['item'=>$sdata['item']->id,'id'=>$sdata['assess']->id])}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="code">审查结果：</label>
                        <div class="col-sm-9 radio">
                            <label>
                                <input name="code" type="radio" class="ace" value="133" checked >
                                <span class="lbl">审查通过</span>
                            </label>

                            <label>
                                <input name="code" type="radio" class="ace" value="134" >
                                <span class="lbl">审查驳回</span>
                            </label>
                        </div>
                    </div>
                    <div class="space-4"></div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="infos">审查意见：</label>
                        <div class="col-sm-9">
                            <textarea id="infos" name="infos" class="col-xs-10 col-sm-8" ></textarea>
                        </div>
                    </div>
                    <div class="space-4"></div>

                    <div class="form-group img-box">
                        <label class="col-sm-3 control-label no-padding-right">
                            附件<br>
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
            </div>
        </div>
    </div>

@endsection

{{-- 样式 --}}
@section('css')

    <link rel="stylesheet" href="{{asset('viewer/viewer.min.css')}}" />

@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script src="{{asset('viewer/viewer.min.js')}}"></script>

    <script>

        $('.img-content').viewer();
    </script>

@endsection