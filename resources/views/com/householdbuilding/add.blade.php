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


    <form class="form-horizontal" role="form" action="{{route('c_household_buildingadd')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="item" value="{{$sdata['item_id']}}">
        <input type="hidden" name="household_id" value="{{$sdata['household']->id}}">
        <input type="hidden" name="land_id" value="{{$sdata['household']->land_id}}">
        <input type="hidden" name="building_id" value="{{$sdata['household']->building_id}}">

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="code"> 状态： </label>
            <div class="col-sm-9 radio">
                <label>
                    <input name="code" type="radio" class="ace" value="90">
                    <span class="lbl">合法登记</span>
                </label>
                <label>
                    <input name="code" type="radio" class="ace" value="91" checked >
                    <span class="lbl">待认定</span>
                </label>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="name"> 名称： </label>
            <div class="col-sm-9">
                <input type="text" id="name" name="name" value="{{old('name')}}" class="col-xs-10 col-sm-5"  placeholder="请输入名称" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="struct_id"> 结构： </label>
            <div class="col-sm-9">
                <select class="col-xs-5 col-sm-5" name="struct_id" id="struct_id">
                    <option value="">--请选择--</option>
                    @if($sdata['buildingstruct'])
                        @foreach($sdata['buildingstruct'] as $buildingstruct)
                            <option value="{{$buildingstruct->id}}">{{$buildingstruct->name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="reg_outer"> 登记建筑面积： </label>
            <div class="col-sm-9">
                <input type="text" id="reg_outer" name="reg_outer" value="{{old('reg_outer')}}" class="col-xs-10 col-sm-5"  placeholder="请输入登记建筑面积" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="balcony"> 阳台面积： </label>
            <div class="col-sm-9">
                <input type="text" id="balcony" name="balcony" value="{{old('balcony')}}" class="col-xs-10 col-sm-5"  placeholder="请输入阳台面积" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group dispute_state">
            <label class="col-sm-3 control-label no-padding-right" for="real_outer"> 实际建筑面积： </label>
            <div class="col-sm-9">
                <input type="text" id="real_outer" name="real_outer" value="{{old('real_outer')}}" class="col-xs-10 col-sm-5"  placeholder="请输入实际建筑面积" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="def_use"> 批准用途： </label>
            <div class="col-sm-9">
                <select class="col-xs-5 col-sm-5" name="def_use" id="def_use">
                    <option value="">--请选择--</option>
                    @if($sdata['defbuildinguse'])
                        @foreach($sdata['defbuildinguse'] as $buildinguse)
                            <option value="{{$buildinguse->id}}">{{$buildinguse->name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="real_use"> 实际用途： </label>
            <div class="col-sm-9">
                <select class="col-xs-5 col-sm-5" name="real_use" id="real_use">
                    <option value="">--请选择--</option>
                    @if($sdata['defbuildinguse'])
                        @foreach($sdata['defbuildinguse'] as $buildinguse)
                            <option value="{{$buildinguse->id}}">{{$buildinguse->name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="direct"> 朝向： </label>
            <div class="col-sm-9">
                <input type="text" id="direct" name="direct" value="{{old('direct')}}" class="col-xs-10 col-sm-5"  placeholder="请输入朝向" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="build_year"> 建造年份： </label>
            <div class="col-sm-9">
                <input type="number" id="build_year" name="build_year" data-type="year" data-format="yyyy" value="{{old('build_year')}}" class="col-xs-10 col-sm-5 laydate"  placeholder="请输入建造年份" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="floor"> 楼层： </label>
            <div class="col-sm-9">
                <input type="text" id="floor" name="floor" value="{{old('floor')}}" class="col-xs-10 col-sm-5"  placeholder="请输入楼层" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="layout_id"> 地块户型： </label>
            <div class="col-sm-9">
                <select class="col-xs-5 col-sm-5" name="layout_id" id="layout_id">
                    <option value="">--请选择--</option>
                    @if(filled($sdata['landlayouts']))
                        @foreach($sdata['landlayouts'] as $landlayouts)
                            <option value="{{$landlayouts->id}}">{{$landlayouts->name}}{{$landlayouts->area?'【'.$landlayouts->area.'㎡】':''}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
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

    </script>

@endsection