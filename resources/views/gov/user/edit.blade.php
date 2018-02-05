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


    <form class="form-horizontal" role="form" action="{{route('g_user_edit')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$sdata->id}}">

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="dept_id"> 所在部门： </label>
            <div class="col-sm-9">
                <select name="dept_id" id="dept_id" class="col-xs-10 col-sm-5 chosen-select" required>
                    <option value="">请选择部门</option>
                    @foreach($sdata['depts'] as $dept)
                        <option value="{{$dept->id}}" @if($dept->id == $sdata->dept_id) selected @endif>{{$dept->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="role_id"> 所属角色： </label>
            <div class="col-sm-9">
                <select name="role_id" id="role_id" class="col-xs-10 col-sm-5 chosen-select" required>
                    <option value="">请选择角色</option>
                    @foreach($sdata['roles'] as $role)
                        <option value="{{$role->id}}" @if($role->id == $sdata->role_id) selected @endif>{{$role->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="username"> 用户名： </label>
            <div class="col-sm-9">
                <input type="text" id="username" name="username" value="{{$sdata->username}}" class="col-xs-10 col-sm-5" required>
            </div>
        </div>
        <div class="space-4"></div>


        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="name"> 姓名： </label>
            <div class="col-sm-9">
                <input type="text" id="name" name="name" value="{{$sdata->name}}" class="col-xs-10 col-sm-5" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="phone"> 电话： </label>
            <div class="col-sm-9">
                <input type="text" id="phone" name="phone" value="{{$sdata->phone}}" class="col-xs-10 col-sm-5" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="email"> 邮箱： </label>
            <div class="col-sm-9">
                <input type="text" id="email" name="email" value="{{$sdata->email}}" class="col-xs-10 col-sm-5" required>
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

    <script src="{{asset('js/func.js')}}"></script>
    <script>
        $('#name').focus();
    </script>

    <script src="{{asset('chosen/chosen.jquery.min.js')}}"></script>

@endsection