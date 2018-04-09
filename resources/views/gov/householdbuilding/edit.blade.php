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


    <form class="form-horizontal" role="form" action="{{route('g_householdbuilding_edit')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$sdata->id}}">
        <input type="hidden" name="item" value="{{$edata['item_id']}}">
        <input type="hidden" name="household_id" value="{{$edata['household']->id}}">

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="code"> 状态： </label>
            <div class="col-sm-9 radio">
                <label>
                    <input name="status" type="radio" class="ace" value="90" @if(90==$sdata->code) checked @endif >
                    <span class="lbl">合法登记</span>
                </label>
                <label>
                    <input name="status" type="radio" class="ace" value="91" @if(91==$sdata->code) checked @endif >
                    <span class="lbl">待认定</span>
                </label>
                <label>
                    <input  type="radio" class="ace" value="92" @if(92==$sdata->code) checked @endif disabled>
                    <span class="lbl">认定合法</span>
                </label>
                <label>
                    <input  type="radio" class="ace" value="93" @if(93==$sdata->code) checked @endif disabled>
                    <span class="lbl">认定非法</span>
                </label>
                <label>
                    <input  type="radio" class="ace" value="94" @if(94==$sdata->code) checked @endif disabled>
                    <span class="lbl">自行拆除</span>
                </label>
                <label>
                    <input type="radio" class="ace" value="95" @if(95==$sdata->code) checked @endif disabled>
                    <span class="lbl">转为合法</span>
                </label>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="name"> 名称： </label>
            <div class="col-sm-9">
                <input type="text" id="name" name="name" value="{{$sdata->name}}" class="col-xs-10 col-sm-5"  placeholder="请输入名称" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="struct_id"> 结构： </label>
            <div class="col-sm-9">
                <select class="col-xs-5 col-sm-5" name="struct_id" id="struct_id">
                    <option value="">--请选择--</option>
                    @if($edata['buildingstruct'])
                        @foreach($edata['buildingstruct'] as $buildingstruct)
                            <option value="{{$buildingstruct->id}}" @if($sdata->struct_id == $buildingstruct->id) selected @endif>{{$buildingstruct->name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="reg_outer"> 登记建筑面积： </label>
            <div class="col-sm-9">
                <input type="text" id="reg_outer" name="reg_outer" value="{{$sdata->reg_outer}}" class="col-xs-10 col-sm-5"  placeholder="请输入登记建筑面积" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="balcony"> 阳台面积： </label>
            <div class="col-sm-9">
                <input type="text" id="balcony" name="balcony" value="{{$sdata->balcony}}" class="col-xs-10 col-sm-5"  placeholder="请输入阳台面积" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group dispute_state">
            <label class="col-sm-3 control-label no-padding-right" for="real_outer"> 实际建筑面积： </label>
            <div class="col-sm-9">
                <input type="text" id="real_outer" name="real_outer" value="{{$sdata->real_outer}}" class="col-xs-10 col-sm-5"  placeholder="请输入实际建筑面积" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="def_use"> 批准用途： </label>
            <div class="col-sm-9">
                <select class="col-xs-5 col-sm-5" name="def_use" id="def_use">
                    <option value="">--请选择--</option>
                    @if($edata['defbuildinguse'])
                        @foreach($edata['defbuildinguse'] as $buildinguse)
                            <option value="{{$buildinguse->id}}" @if($sdata->def_use == $buildinguse->id) selected @endif>{{$buildinguse->name}}</option>
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
                    @if($edata['defbuildinguse'])
                        @foreach($edata['defbuildinguse'] as $buildinguse)
                            <option value="{{$buildinguse->id}}" @if($sdata->real_use == $buildinguse->id) selected @endif>{{$buildinguse->name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="direct"> 朝向： </label>
            <div class="col-sm-9">
                <input type="text" id="direct" name="direct" value="{{$sdata->direct}}" class="col-xs-10 col-sm-5"  placeholder="请输入朝向" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="build_year"> 建造年份： </label>
            <div class="col-sm-9">
                <input type="number" id="build_year" name="build_year" data-type="year" data-format="yyyy" value="{{$sdata->build_year}}" class="col-xs-10 col-sm-5 laydate"  placeholder="请输入建造年份" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="floor"> 楼层： </label>
            <div class="col-sm-9">
                <input type="text" id="floor" name="floor" value="{{$sdata->floor}}" class="col-xs-10 col-sm-5"  placeholder="请输入楼层" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="layout_id"> 地块户型： </label>
            <div class="col-sm-9">
                <select class="col-xs-5 col-sm-5" name="layout_id" id="layout_id">
                    <option value="">--请选择--</option>
                    @if(filled($edata['landlayouts']))
                        @foreach($edata['landlayouts'] as $landlayouts)
                            <option value="{{$landlayouts->id}}" @if($sdata->layout_id==$landlayouts->id) selected @endif>{{$landlayouts->name}}{{$landlayouts->area?'【'.$landlayouts->area.'㎡】':''}}</option>
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
                        图片及证件：<br>
                        <span class="btn btn-xs">
                            <span>上传图片</span>
                            <input type="file" accept="image/*" class="hidden" data-name="picture[]" multiple  onchange="uplfile(this)">
                        </span>
                    </label>
                    <div class="col-sm-9">
                        <ul class="ace-thumbnails clearfix img-content viewer">
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
                        </ul>
                    </div>
                </div>
                <div class="space-4 header green"></div>
            </div>
        </div>

        @if($sdata->getOriginal('code')==90 or $sdata->getOriginal('code')==91)
        <div class="clearfix form-actions">
            <div class="col-md-offset-3 col-md-9">
                <button class="btn btn-info" type="button" onclick="sub_ajax(this)">
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
        @endif
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
        $('.img-content').viewer('update');
        window.onload=function () {
            var dispute = '{{$sdata->getOriginal('dispute')}}';
            if(dispute==1){
                $('.dispute_state').css('display','block');
            }else{
                $('.dispute_state').css('display','none');
            }
        };

        /*-------- 是否存在争议 -----------*/
        $('.dispute_val').on('click',function(){
            var dispute = $('input[name=dispute]:checked').val();
            if(dispute==1){
                $('.dispute_state').css('display','block');
            }else{
                $('.dispute_state').css('display','none');
            }
        });
        /*-------- 修改 -----------*/
        function sub_ajax(obj) {
            var dispute = $('input[name=dispute]:checked').val();
            var reg_inner = $('#reg_inner').val();
            var reg_outer = $('#reg_outer').val();
            $('.dispute_state').css('display','block');
            if(dispute==0){
                $('#real_inner').val(reg_inner);
                $('#real_outer').val(reg_outer);
            }
            sub(obj);
        }
    </script>

@endsection