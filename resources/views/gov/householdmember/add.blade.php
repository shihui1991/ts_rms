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


    <form class="form-horizontal" role="form" action="{{route('g_householdmember_add')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="item" value="{{$sdata['household']->item_id}}">
        <input type="hidden" name="household_id" value="{{$sdata['household']->id}}">
        <input type="hidden" name="land_id" value="{{$sdata['household']->land_id}}">
        <input type="hidden" name="building_id" value="{{$sdata['household']->building_id}}">
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="name"> 姓名： </label>
            <div class="col-sm-9">
                <input type="text" id="name" name="name" value="{{old('name')}}" class="col-xs-10 col-sm-5"  placeholder="请输入姓名" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="relation"> 与户主关系： </label>
            <div class="col-sm-9">
                <input type="text" id="relation" name="relation" value="{{old('relation')}}" class="col-xs-10 col-sm-5"  placeholder="请输入与户主关系" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="card_num"> 身份证： </label>
            <div class="col-sm-9">
                <input type="text" id="card_num" name="card_num" value="{{old('card_num')}}" class="col-xs-10 col-sm-5"  placeholder="请输入身份证" required>
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
            <label class="col-sm-3 control-label no-padding-right" for="nation_id"> 民族： </label>
            <div class="col-sm-9">
                <select class="col-xs-5 col-sm-5" name="nation_id" id="nation_id">
                    <option value="">--请选择--</option>
                    @if($sdata['nation'])
                        @foreach($sdata['nation'] as $nation)
                            <option value="{{$nation->id}}">{{$nation->name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="sex"> 性别： </label>
            <div class="col-sm-9 radio">
                @foreach($edata->sex as $key => $value)
                    <label>
                        <input name="sex" type="radio" class="ace" value="{{$key}}" @if($key==0) checked @endif >
                        <span class="lbl">{{$value}}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="age"> 年龄： </label>
            <div class="col-sm-9">
                <input type="text" id="age" name="age" value="{{old('age')}}" class="col-xs-10 col-sm-5"  placeholder="请输入年龄" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="crowd"> 是否享受特殊人群优惠： </label>
            <div class="col-sm-9 radio">
                @foreach($edata->crowd as $key => $value)
                    <label>
                        <input name="crowd" type="radio" class="ace" value="{{$key}}" @if($key==0) checked @endif >
                        <span class="lbl">{{$value}}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="holder"> 权属类型： </label>
            <div class="col-sm-9 radio">
                @if($sdata['household']->getOriginal('type') == 1)
                    <label>
                        <input name="holder" type="radio" class="ace" value="0" checked >
                        <span class="lbl">非权属人</span>
                    </label>
                    <label>
                        <input name="holder" type="radio" class="ace" value="2"  >
                        <span class="lbl">承租人</span>
                    </label>
                    @else
                    <label>
                        <input name="holder" type="radio" class="ace" value="0" checked >
                        <span class="lbl">非权属人</span>
                    </label>
                    <label>
                        <input name="holder" type="radio" class="ace" value="1"  >
                        <span class="lbl">产权人</span>
                    </label>
                @endif
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="portion"> 权属分配比例： </label>
            <div class="col-sm-9">
                <input type="text" id="portion" name="portion" value="{{old('portion')}}" class="col-xs-10 col-sm-2"  placeholder="请输入权属分配比例" required>
                &nbsp;<span class="col-sm-" style="font-size: revert;line-height: 30px;">%</span>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <div class="widget-main padding-8">

                <div class="form-group img-box">
                    <label class="col-sm-3 control-label no-padding-right">
                        身份证，户口本页：<br>
                        <span class="btn btn-xs">
                            <span>上传图片</span>
                            <input type="file" accept="image/*" class="hidden" data-name="picture[]" multiple  onchange="uplfile(this)">
                        </span>
                    </label>
                    <div class="col-sm-9">
                        <ul class="ace-thumbnails clearfix img-content viewer">
                        </ul>
                    </div>
                </div>

                <div class="space-4 header green"></div>

            </div>
        </div>

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
    <script src="{{asset('js/func.js')}}"></script>
    <script>

    </script>
@endsection