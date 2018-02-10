{{-- 继承布局 --}}
@extends('gov.layout')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>
    </p>


    <form class="form-horizontal" role="form" action="{{route('g_itemprogram_edit')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$sdata->id}}">
        <input type="hidden" name="item_id" value="{{$sdata->item_id}}">

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="name"> 名称： </label>
            <div class="col-sm-9">
                <input type="text" id="name" name="name" value="{{$sdata->name}}" class="col-xs-10 col-sm-5"  placeholder="请输入名称" required>
            </div>
        </div>
        <div class="space-4"></div>


        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="content">内容：</label>
            <div class="col-sm-9">
                <textarea id="content" name="content" class="col-xs-10 col-sm-5" placeholder="请输入内容" >{{$sdata->content}}</textarea>
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
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script src="{{asset('js/func.js')}}"></script>
    <script>
        $('.img-content').viewer('update');
    </script>

@endsection