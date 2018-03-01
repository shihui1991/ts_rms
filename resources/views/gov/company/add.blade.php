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


    <form class="form-horizontal" role="form" action="{{route('g_company_add')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="type" id="type" value="{{$sdata['type']}}">

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="name"> @if($sdata['type']==0)房产评估机构@else资产评估机构@endif名称： </label>
            <div class="col-sm-9">
                <input type="text" id="name" name="name" value="{{old('name')}}" class="col-xs-10 col-sm-5" placeholder="请输入名称" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="address"> 地址： </label>
            <div class="col-sm-9">
                <input type="text" id="address" name="address" value="{{old('address')}}" class="col-xs-10 col-sm-5" placeholder="请输入地址" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="phone"> 电话： </label>
            <div class="col-sm-9">
                <input type="text" id="phone" name="phone" value="{{old('phone')}}" class="col-xs-10 col-sm-5" placeholder="请输入电话" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="fax"> 传真： </label>
            <div class="col-sm-9">
                <input type="text" id="fax" name="fax" value="{{old('fax')}}" class="col-xs-10 col-sm-5" placeholder="请输入传真" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="contact_man"> 联系人： </label>
            <div class="col-sm-9">
                <input type="text" id="contact_man" name="contact_man" value="{{old('contact_man')}}" class="col-xs-10 col-sm-5" placeholder="请输入联系人" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="contact_tel"> 手机号： </label>
            <div class="col-sm-9">
                <input type="text" id="contact_tel" name="contact_tel" value="{{old('contact_tel')}}" class="col-xs-10 col-sm-5" placeholder="请输入手机号" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="infos">描述：</label>
            <div class="col-sm-9">
                <textarea id="infos" name="infos" class="col-xs-10 col-sm-5"  placeholder="请输入描述">{{old('infos')}}</textarea>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="content">简介：</label>
        <div class="col-sm-9">
            <textarea id="content" name="content" class="col-xs-10 col-sm-5" placeholder="请输入简介">{{old('content')}}</textarea>
        </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="contact_tel"> 【创建评估机构账号】 </label>
            <div class="col-sm-9">
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="username"> 登陆账号： </label>
            <div class="col-sm-9">
                <input type="text" id="username" name="username" value="{{old('username')}}" class="col-xs-10 col-sm-5" placeholder="请输入登陆账号" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="password"> 登陆密码： </label>
            <div class="col-sm-9">
                <input type="password" id="password" name="password" value="{{old('password')}}" class="col-xs-10 col-sm-5" placeholder="请输入登陆密码" required>
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
    @parent
    <script src="{{asset('js/func.js')}}"></script>
    <script>
        $('#name').focus();
    </script>

@endsection