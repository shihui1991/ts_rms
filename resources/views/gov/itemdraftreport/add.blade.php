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


    <form class="form-horizontal" role="form" action="{{route('g_itemdraftreport_add')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="item" value="{{$sdata['item_id']}}">


        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="name">标题：</label>
            <div class="col-sm-9">
                <input type="text" id="name" name="name" value="" class="col-xs-10 col-sm-5" required>
            </div>
        </div>
        <div class="space-4"></div>


        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="content">内容：</label>
            <div class="col-sm-9">
               {{-- <textarea id="content" name="content" class="col-xs-10 col-sm-5" ></textarea>--}}
                <script id="content" name="content" type="text/plain" style="width:90%;height:500px;"></script></div>
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


{{-- 插件 --}}
@section('js')
    @parent
    <script src="{{asset('ueditor/ueditor.config.js')}}"></script>
    <script src="{{asset('ueditor/ueditor.all.min.js')}}"></script>
    <script>
        var ue = UE.getEditor('content');
    </script>

@endsection