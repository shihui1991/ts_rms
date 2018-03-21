{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <form class="form-horizontal" role="form" action="{{route('g_assess_report_add',['item'=>$sdata['item']->id])}}" method="post">
        {{csrf_field()}}

        <div class="row">
            <div class="col-sm-5 col-xs-12">
                <div class="widget-container-col ui-sortable">
                    <div class="widget-box ui-sortable-handle">
                        <div class="widget-header">
                            <h5 class="widget-title">基本信息</h5>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main">

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="item"> 项目： </label>
                                    <div class="col-sm-9">
                                        <input type="text" id="item" value="{{$sdata['item']->name}}" class="col-xs-10 col-sm-10"  readonly>
                                    </div>
                                </div>
                                <div class="space-4"></div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="cate"> 分类： </label>
                                    <div class="col-sm-9">
                                        <input type="text" id="cate" value="评估报告" class="col-xs-10 col-sm-10"  readonly>
                                    </div>
                                </div>
                                <div class="space-4"></div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="name"> 名称： </label>
                                    <div class="col-sm-9">
                                        <input type="text" id="name" name="name" value="{{old('name')}}" class="col-xs-10 col-sm-10"  required>
                                    </div>
                                </div>
                                <div class="space-4"></div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="release_at"> 发布时间： </label>
                                    <div class="col-sm-9">
                                        <input type="text" id="release_at" name="release_at" value="{{old('release_at')}}" class="col-xs-10 col-sm-10 laydate"  required>
                                    </div>
                                </div>
                                <div class="space-4"></div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="keys"> 关键词： </label>
                                    <div class="col-sm-9">
                                        <input type="text" id="keys" name="keys" value="{{old('keys')}}" class="col-xs-10 col-sm-10"  required>
                                    </div>
                                </div>
                                <div class="space-4"></div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="infos">摘要：</label>
                                    <div class="col-sm-9">
                                        <textarea id="infos" name="infos" class="col-xs-10 col-sm-10">{{old('infos')}}</textarea>
                                    </div>
                                </div>
                                <div class="space-4"></div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="is_top">是否置顶：</label>
                                    <div class="col-sm-9 radio">
                                        @foreach($edata->is_top as $key => $value)
                                            <label>
                                                <input name="is_top" type="radio" class="ace" value="{{$key}}" @if($key==0) checked @endif >
                                                <span class="lbl">{{$value}}</span>
                                            </label>
                                        @endforeach
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

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-7 col-xs-12">
                <div class="widget-container-col ui-sortable">
                    <div class="widget-box ui-sortable-handle">
                        <div class="widget-header">
                            <h5 class="widget-title">具体内容</h5>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main">
                                <textarea id="content" name="content" style="width:100%;min-height: 360px;">{{old('content')}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
    <script src="{{asset('ueditor/ueditor.config.js')}}"></script>
    <script src="{{asset('ueditor/ueditor.all.min.js')}}"></script>
    <script>
        var ue = UE.getEditor('content');
        $('#name').focus();
    </script>

@endsection