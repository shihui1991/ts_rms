{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')


    <form class="form-horizontal" role="form" action="{{route('g_initbudget_edit',['item'=>$sdata['item']->id])}}" method="post">
        {{csrf_field()}}

        <div class="row">
            <div class="col-sm-6">
                <div class="widget-box widget-color-blue2">
                    <div class="widget-header">
                        <h4 class="widget-title lighter smaller">初步预算</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main padding-8">

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="item"> 项目名称： </label>
                                <div class="col-sm-9">
                                    <input type="text" id="item" value="{{$sdata['item']->name}}" class="col-xs-10 col-sm-10" readonly>
                                </div>
                            </div>
                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="holder"> 预计户数： </label>
                                <div class="col-sm-9">
                                    <input type="number" min="0" id="holder" name="budget[holder]" value="{{$sdata['init_budget']->holder}}" class="col-xs-10 col-sm-10" required>
                                </div>
                            </div>
                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="money"> 预算总金额： </label>
                                <div class="col-sm-9">
                                    <input type="number" min="0" id="money" name="budget[money]" value="{{$sdata['init_budget']->money}}" class="col-xs-10 col-sm-10" required>
                                </div>
                            </div>
                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="house"> 预备房源数： </label>
                                <div class="col-sm-9">
                                    <input type="number" min="0" id="house" name="budget[house]" value="{{$sdata['init_budget']->house}}" class="col-xs-10 col-sm-10" required>
                                </div>
                            </div>
                            <div class="space-4"></div>

                            <div class="form-group img-box">
                                <label class="col-sm-3 control-label no-padding-right">
                                    预算报告<br>
                                    <span class="btn btn-xs">
                                        <span>上传图片</span>
                                        <input type="file" accept="image/*" class="hidden" data-name="budget[picture][]" multiple onchange="uplfile(this)">
                                    </span>
                                </label>
                                <div class="col-sm-9">
                                    <ul class="ace-thumbnails clearfix img-content">
                                        @foreach($sdata['init_budget']->picture as $pic)
                                            <li>
                                                <div>
                                                    <img width="120" height="120" src="{{$pic}}" alt="加载失败">
                                                    <input type="hidden" name="budget[picture][]" value="{{$pic}}">
                                                    <div class="text">
                                                        <div class="inner">
                                                            <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                                            <a onclick="removeimg(this)"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                            <div class="space-4"></div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="widget-box widget-color-green2">
                    <div class="widget-header">
                        <h4 class="widget-title lighter smaller">
                            预算通知
                        </h4>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main padding-8">

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="infos"> 摘要： </label>
                                <div class="col-sm-9">
                                    <textarea name="notice[infos]" id="infos" class="col-xs-10 col-sm-10">{{$sdata['item_notice']->infos}}</textarea>
                                </div>
                            </div>
                            <div class="space-4"></div>

                            <div class="form-group img-box">
                                <label class="col-sm-3 control-label no-padding-right">
                                    预算通知<br>
                                    <span class="btn btn-xs">
                                        <span>上传图片</span>
                                        <input type="file" accept="image/*" class="hidden" data-name="notice[picture][]" multiple onchange="uplfile(this)">
                                    </span>
                                </label>
                                <div class="col-sm-9">
                                    <ul class="ace-thumbnails clearfix img-content">
                                        @foreach($sdata['item_notice']->picture as $pic)
                                            <li>
                                                <div>
                                                    <img width="120" height="120" src="{{$pic}}" alt="加载失败">
                                                    <input type="hidden" name="notice[picture][]" value="{{$pic}}">
                                                    <div class="text">
                                                        <div class="inner">
                                                            <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                                            <a onclick="removeimg(this)"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                            <div class="space-4"></div>

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

    <script src="{{asset('js/func.js')}}"></script>
    <script>
        $('#name').focus();
    </script>

@endsection