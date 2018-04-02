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

    <h3 class="header smaller lighter blue">
        <i class="ace-icon fa fa-bullhorn"></i>
        @if($sdata['itempublic']->building_id) 楼栋公共附属物 @else 地块公共附属物 @endif
    </h3>
    <form class="form-horizontal" role="form" action="{{route('g_itempublic_edit',['item'=>$sdata['item']->id])}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$sdata['itempublic']->id}}">

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="itemland"> 地块： </label>
            <div class="col-sm-9">
                <input type="text" id="itemland" value="{{$sdata['itempublic']->itemland->address}}" class="col-xs-10 col-sm-5"  readonly>
            </div>
        </div>
        <div class="space-4"></div>

        @if($sdata['itempublic']->building_id)
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="itembuilding"> 楼栋号： </label>
                <div class="col-sm-9">
                    <input type="text" id="itembuilding" value="{{$sdata['itempublic']->itembuilding->building}}" class="col-xs-10 col-sm-5"  readonly>
                </div>
            </div>
            <div class="space-4"></div>
        @endif
        
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="name"> 名称： </label>
            <div class="col-sm-9">
                <input type="text" id="name" name="name" value="{{$sdata['itempublic']->name}}" class="col-xs-10 col-sm-5"  placeholder="请输入名称" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="num_unit"> 计量单位： </label>
            <div class="col-sm-9">
                <input type="text" id="num_unit" name="num_unit" value="{{$sdata['itempublic']->num_unit}}" class="col-xs-10 col-sm-5"  placeholder="请输入计量单位" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="gov_num"> 数量： </label>
            <div class="col-sm-9">
                <input type="number" id="gov_num" name="gov_num" value="{{$sdata['itempublic']->gov_num}}" class="col-xs-10 col-sm-5"  placeholder="请输入数量" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="infos">描述：</label>
            <div class="col-sm-9">
                <textarea id="infos" name="infos" class="col-xs-10 col-sm-5" placeholder="请输入描述" >{{$sdata['itempublic']->infos}}</textarea>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <div class="widget-main padding-8">
                <div class="form-group img-box">
                    <label class="col-sm-3 control-label no-padding-right">
                        相关图片：<br>
                        <span class="btn btn-xs">
                            <span>上传图片</span>
                            <input type="file" accept="image/*" class="hidden" data-name="gov_pic[]" multiple  onchange="uplfile(this)">
                         </span>
                    </label>
                    <div class="col-sm-9">
                        <ul class="ace-thumbnails clearfix img-content viewer">
                            @if(filled($sdata['itempublic']->gov_pic))
                                @foreach($sdata['itempublic']->gov_pic as $pic)
                                    <li>
                                        <div>
                                            <img width="120" height="120" src="{!! $pic !!}" alt="加载失败">
                                            <input type="hidden" name="gov_pic[]" value="{!! $pic !!}">
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
    <script src="{{asset('laydate/laydate.js')}}"></script>
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script>
        $('.img-content').viewer('update');
    </script>

@endsection