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


    <form class="form-horizontal" role="form" action="{{route('g_company_edit')}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="id" value="{{$sdata->id}}">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="type">类型：</label>
                <div class="col-sm-9 radio">
                    @foreach($edata->type as $key => $value)
                        <label>
                            <input name="type" type="radio" class="ace" value="{{$key}}" @if($key==$sdata->getOriginal('type')) checked @endif >
                            <span class="lbl">{{$value}}</span>
                        </label>
                    @endforeach
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
                <label class="col-sm-3 control-label no-padding-right" for="address"> 地址： </label>
                <div class="col-sm-9">
                    <input type="text" id="address" name="address" value="{{$sdata->address}}" class="col-xs-10 col-sm-5" required>
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
                <label class="col-sm-3 control-label no-padding-right" for="fax"> 传真： </label>
                <div class="col-sm-9">
                    <input type="text" id="fax" name="fax" value="{{$sdata->fax}}" class="col-xs-10 col-sm-5" required>
                </div>
            </div>
            <div class="space-4"></div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="contact_man"> 联系人： </label>
                <div class="col-sm-9">
                    <input type="text" id="contact_man" name="contact_man" value="{{$sdata->contact_man}}" class="col-xs-10 col-sm-5" required>
                </div>
            </div>
            <div class="space-4"></div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="contact_tel"> 手机号： </label>
                <div class="col-sm-9">
                    <input type="text" id="contact_tel" name="contact_tel" value="{{$sdata->contact_tel}}" class="col-xs-10 col-sm-5" required>
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

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="content">简介：</label>
                <div class="col-sm-9">
                    <textarea id="content" name="content" class="col-xs-10 col-sm-5">{{$sdata->content}}</textarea>
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