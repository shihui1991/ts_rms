{{-- 继承布局 --}}
@extends('gov.layout')


{{-- 页面内容 --}}
@section('content')

    <a class="btn" href="javascript:history.back()">
        <i class="ace-icon fa fa-arrow-left bigger-110"></i>
        返回
    </a>

    <form class="form-horizontal" role="form" action="{{route('g_dept_edit')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$sdata->id}}">
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="parent_id"> 上级部门： </label>
            <div class="col-sm-9">
                <input type="text" id="parent_id" value="{{$sdata->father->name}}" class="col-xs-10 col-sm-5" readonly>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="name"> 名称： </label>
            <div class="col-sm-9">
                <input type="text" id="name" name="name" value="{{$sdata->name}}" class="col-xs-10 col-sm-5" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="type">类型：</label>
            <div class="col-sm-9 radio">
                @foreach($edata->type as $key => $value)
                    <label>
                        <input name="type" type="radio" class="ace" value="{{$key}}" @if($value==$sdata->type) checked @endif >
                        <span class="lbl">{{$value}}</span>
                    </label>
                @endforeach
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

    @include('gov.alert')

    <div class="profile-user-info profile-user-info-striped">
        @if($sdata->deleted_at)
            <div class="profile-info-row">
                <div class="profile-info-name"> 状态： </div>
                <div class="profile-info-value">
                    <span class="editable editable-click">已删除</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> 删除时间： </div>
                <div class="profile-info-value">
                    <span class="editable editable-click">{{$sdata->deleted_at}}</span>
                </div>
            </div>
        @else
            <div class="profile-info-row">
                <div class="profile-info-name"> 状态： </div>
                <div class="profile-info-value">
                    <span class="editable editable-click">启用中</span>
                </div>
            </div>
        @endif

        <div class="profile-info-row">
            <div class="profile-info-name"> 创建时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->created_at}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 更新时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->updated_at}}</span>
            </div>
        </div>

    </div>

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