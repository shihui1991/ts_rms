{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <form class="form-horizontal" role="form" action="{{route('g_funds_add',['item'=>$sdata['item']->id])}}" method="post">
        {{csrf_field()}}

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="voucher"> 转账凭证号： </label>
            <div class="col-sm-9">
                <input type="text" id="voucher" name="voucher" value="{{old('voucher')}}" class="col-xs-10 col-sm-5"  required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="amount"> 转账金额： </label>
            <div class="col-sm-9">
                <input type="number" min="0.01" id="amount" name="amount" value="{{old('amount')}}" class="col-xs-10 col-sm-5"  required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="bank_id"> 转账银行： </label>
            <div class="col-sm-9">
                <select name="bank_id" id="bank_id" class="col-xs-10 col-sm-5" >
                    @foreach($sdata['banks'] as $bank)
                        <option value="{{$bank->id}}">{{$bank->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="account"> 银行账号： </label>
            <div class="col-sm-9">
                <input type="text" id="account" name="account" value="{{old('account')}}" class="col-xs-10 col-sm-5"  required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="name"> 账户姓名： </label>
            <div class="col-sm-9">
                <input type="text" id="name" name="name" value="{{old('name')}}" class="col-xs-10 col-sm-5"  required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="entry_at"> 到账时间： </label>
            <div class="col-sm-9">
                <input type="text" id="entry_at" name="entry_at" value="{{old('entry_at')}}" class="col-xs-10 col-sm-5 laydate" data-type="datetime" data-format="yyyy-MM-dd HH:mm:ss"  required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="infos">款项说明：</label>
            <div class="col-sm-9">
                <textarea id="infos" name="infos" class="col-xs-10 col-sm-5">{{old('infos')}}</textarea>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group img-box">
            <label class="col-sm-3 control-label no-padding-right">
                转账凭证<br>
                <span class="btn btn-xs">
                    <span>上传图片</span>
                    <input type="file" accept="image/*" class="hidden" data-name="picture[]" multiple onchange="uplfile(this)">
                </span>
            </label>
            <div class="col-sm-9">
                <ul class="ace-thumbnails clearfix img-content">


                </ul>
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
    @parent
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script src="{{asset('laydate/laydate.js')}}"></script>
    <script src="{{asset('js/func.js')}}"></script>
    <script>
        $('#name').focus();
    </script>

@endsection