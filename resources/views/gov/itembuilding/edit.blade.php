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


    <form class="form-horizontal" role="form" action="{{route('g_itembuilding_edit',['item'=>$sdata['item']->id])}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$sdata['itembuilding']->id}}">

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="land_id"> 地块： </label>
            <div class="col-sm-9">
                <input type="text" id="land_id"  value="{{$sdata['itembuilding']->itemland->address}}" class="col-xs-10 col-sm-5"  readonly>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="building"> 楼栋号： </label>
            <div class="col-sm-9">
                <input type="number" id="building" name="building" value="{{$sdata['itembuilding']->building}}" class="col-xs-10 col-sm-5"  placeholder="请输入楼栋号" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="total_floor"> 总楼层： </label>
            <div class="col-sm-9">
                <input type="number" id="total_floor" name="total_floor" value="{{$sdata['itembuilding']->total_floor}}" class="col-xs-10 col-sm-5"  placeholder="请输入总楼层" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="area"> 占地面积： </label>
            <div class="col-sm-9">
                <input type="text" id="area" name="area" value="{{$sdata['itembuilding']->area}}" class="col-xs-10 col-sm-5"  placeholder="请输入占地面积" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="build_year"> 建造年份： </label>
            <div class="col-sm-9">
                <input type="number" id="build_year" name="build_year" data-type="year" data-format="yyyy" value="{{$sdata['itembuilding']->build_year}}" class="col-xs-10 col-sm-5 laydate"  placeholder="请输入建造年份" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="struct_id"> 结构类型： </label>
            <div class="col-sm-9">
                <select class="col-xs-5 col-sm-5" name="struct_id" id="struct_id">
                    <option value="0">--请选择--</option>
                    @if($sdata['buildingstructs'])
                        @foreach($sdata['buildingstructs'] as $buildingstruct)
                            <option value="{{$buildingstruct->id}}" @if($sdata['itembuilding']->struct_id == $buildingstruct->id) selected @endif>{{$buildingstruct->name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="infos">描述：</label>
            <div class="col-sm-9">
                <textarea id="infos" name="infos" class="col-xs-10 col-sm-5" placeholder="请输入描述" >{{$sdata['itembuilding']->infos}}</textarea>
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
                            @if(filled($sdata['itembuilding']->gov_pic))
                                @foreach($sdata['itembuilding']->gov_pic as $pic)
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