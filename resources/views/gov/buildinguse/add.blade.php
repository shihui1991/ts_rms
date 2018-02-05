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


    <form class="form-horizontal" role="form" action="{{route('g_buildinguse_add')}}" method="post">
        {{csrf_field()}}
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="name"> 名称： </label>
            <div class="col-sm-9">
                <input type="text" id="name" name="name" value="{{old('name')}}" class="col-xs-10 col-sm-5" placeholder="请输入名称" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="infos">描述：</label>
            <div class="col-sm-9">
                <textarea id="infos" name="infos" class="col-xs-10 col-sm-5" placeholder="请输入描述" >{{old('infos')}}</textarea>
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
        $('#name').focus();
    </script>

@endsection