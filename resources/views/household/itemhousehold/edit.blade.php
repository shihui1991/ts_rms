{{-- 继承布局 --}}
@extends('household.layout')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>
    </p>


    <form class="form-horizontal" role="form" action="{{route('h_itemhousehold_edit')}}" method="post">
        {{csrf_field()}}

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="dept"> 项目地块： </label>
            <div class="col-sm-9">
                <input type="text" id="dept" name="dept" value="{{$sdata->itemland->address}}" class="col-xs-10 col-sm-5" readonly>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="role"> 家庭住址： </label>
            <div class="col-sm-9">
                <input type="text" id="role" name="role" value=" {{$sdata->itembuilding->building}}栋{{$sdata->unit}}单元{{$sdata->floor}}楼{{$sdata->number}}@if(is_numeric($sdata->floor))号@endif" class="col-xs-10 col-sm-5" readonly>
            </div>
        </div>
        <div class="space-4"></div>


        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="username"> 账号： </label>
            <div class="col-sm-9">
                <input type="text" id="username" name="username" value="{{$sdata->username}}" class="col-xs-10 col-sm-5" required>
            </div>
        </div>
        <div class="space-4"></div>


        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="infos">描述：</label>
            <div class="col-sm-9">
                <textarea id="infos" name="infos" class="col-xs-10 col-sm-5" >{{$sdata->infos}}</textarea>
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

    <link rel="stylesheet" href="{{asset('chosen/chosen.min.css')}}">

@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script src="{{asset('js/func.js')}}"></script>
    <script>
        $('#name').focus();
    </script>

    <script src="{{asset('chosen/chosen.jquery.min.js')}}"></script>

@endsection