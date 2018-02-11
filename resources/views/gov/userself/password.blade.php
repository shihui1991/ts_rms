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


    <form class="form-horizontal" role="form" action="{{route('g_userself_pwd')}}" method="post">
        {{csrf_field()}}

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="oldpassword"> 当前密码： </label>
            <div class="col-sm-9">
                <input type="password" id="oldpassword" name="oldpassword" value="" class="col-xs-10 col-sm-5" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="password"> 新密码： </label>
            <div class="col-sm-9">
                <input type="password" id="password" name="password" value="" class="col-xs-10 col-sm-5" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="password_confirmation"> 重复新密码： </label>
            <div class="col-sm-9">
                <input type="password" id="password_confirmation" name="password_confirmation" value="" class="col-xs-10 col-sm-5" required>
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

    <div class="profile-user-info profile-user-info-striped">

        <div class="profile-info-row">
            <div class="profile-info-name"> 所在部门： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->dept->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 所属角色： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->role->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 用户名： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->username}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 姓名： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->name}}</span>
            </div>
        </div>
    </div>

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