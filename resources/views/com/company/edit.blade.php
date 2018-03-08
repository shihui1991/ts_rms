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


    <form class="form-horizontal" role="form" action="{{route('c_company_edit')}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="id" value="{{$sdata->id}}">
            <input type="hidden" name="type" id="type" value="{{$sdata->getOriginal('type')}}">
             <div class="form-group">
                 <div class="widget-main padding-8">
                    <div class="form-group img-box">
                        <label class="col-sm-3 control-label no-padding-right">
                            LOGO：<br>
                            <span class="btn btn-xs">
                                <span>上传图片</span>
                                <input type="file" accept="image/*" class="hidden" data-name="logo"  onchange="uplfile(this)">
                            </span>
                        </label>
                        <div class="col-sm-9">
                            <ul class="ace-thumbnails clearfix img-content viewer">
                                @if($sdata->logo)
                                <li>
                                    <div>
                                        <img width="120" height="120" src="{{$sdata->logo}}" alt="加载失败">
                                        <input type="hidden" name="logo" value="{{$sdata->logo}}">
                                        <div class="text">
                                            <div class="inner">
                                                <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                                <a onclick="removeimg(this)"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="space-4 header green"></div>
                </div>
             </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="name"> @if($sdata->getOriginal('type')==0)房产评估机构@else资产评估机构@endif名称： </label>
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

            <div class="widget-body">
            <div class="widget-main padding-8">

                <div class="form-group img-box">
                    <label class="col-sm-3 control-label no-padding-right">
                        图片：<br>
                        <span class="btn btn-xs">
                            <span>上传图片</span>
                            <input type="file" accept="image/*" class="hidden" data-name="picture[]" multiple  onchange="uplfile(this)">
                        </span>
                    </label>
                    <div class="col-sm-9">
                        <ul class="ace-thumbnails clearfix img-content viewer">
                            @if($sdata->picture)
                                @foreach($sdata->picture as $pic)
                                    <li>
                                        <div>
                                            <img width="120" height="120" src="{!! $pic !!}" alt="加载失败">
                                            <input type="hidden" name="picture[]" value="{!! $pic !!}">
                                            <div class="text">
                                                <div class="inner">
                                                    <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                                    <a onclick="removeimg(this)"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
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
    <script src="{{asset('js/func.js')}}"></script>
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script src="{{asset('js/func.js')}}"></script>
    <script>
        $('.img-content').viewer('update');
    </script>
@endsection