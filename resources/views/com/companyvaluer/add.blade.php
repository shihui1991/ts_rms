{{-- 继承布局 --}}
@extends('com.main')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>
    </p>


    <form class="form-horizontal" role="form" action="{{route('c_companyvaluer_add')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="company_id" id="company_id" value="{{session('com_user.company_id')}}" >

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="name"> 名称： </label>
            <div class="col-sm-9">
                <input type="text" id="name" name="name" value="{{old('name')}}" class="col-xs-10 col-sm-5"  placeholder="请输入名称" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="phone"> 电话： </label>
            <div class="col-sm-9">
                <input type="text" id="phone" name="phone" value="{{old('phone')}}" class="col-xs-10 col-sm-5"  placeholder="请输入电话" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="register"> 注册号： </label>
            <div class="col-sm-9">
                <input type="text" id="register" name="register" value="{{old('register')}}" class="col-xs-10 col-sm-5"  placeholder="请输入注册号" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="valid_at"> 有效期： </label>
            <div class="col-sm-9">
                <input type="text" id="valid_at" name="valid_at" value="{{old('valid_at')}}" class="col-xs-10 col-sm-5 laydate"  placeholder="请输入有效期" required>
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
    <script src="{{asset('laydate/laydate.js')}}"></script>
    <script>
        $('#name').focus();
    </script>

@endsection