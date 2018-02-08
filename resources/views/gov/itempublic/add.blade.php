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


    <form class="form-horizontal" role="form" action="{{route('g_itempublic_add')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="item_id" value="{{$sdata['item_id']}}">
        <input type="hidden" name="land_id" value="{{$sdata['land_id']}}">
        @if($sdata['building'])
            <input type="hidden" name="building_id" value="0">
            @else
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="building_id"> 楼栋号： </label>
            <div class="col-sm-9">
                <select class="col-xs-5 col-sm-5" name="building_id" id="building_id">
                    <option value="">--请先选择地块--</option>
                </select>
            </div>
        </div>
        <div class="space-4"></div>
        @endif

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="name"> 名称： </label>
            <div class="col-sm-9">
                <input type="text" id="total_floor" name="name" value="{{old('name')}}" class="col-xs-10 col-sm-5"  placeholder="请输入名称" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="num_unit"> 计量单位： </label>
            <div class="col-sm-9">
                <input type="text" id="num_unit" name="num_unit" value="{{old('num_unit')}}" class="col-xs-10 col-sm-5"  placeholder="请输入计量单位" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="number"> 数量： </label>
            <div class="col-sm-9">
                <input type="text" id="number" name="number" value="{{old('number')}}" class="col-xs-10 col-sm-5"  placeholder="请输入计量单位" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="infos">描述：</label>
            <div class="col-sm-9">
                <textarea id="infos" name="infos" class="col-xs-10 col-sm-5" placeholder="请输入描述" >{{old('infos')}}</textarea>
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
    <script src="{{asset('js/func.js')}}"></script>
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script>
        /*-------获取楼栋-------*/
        $("#land_id").on('change',function() {
            var _this = $(this).val();
            var data = {
                'land_id':_this
            };
            ajaxAct('{{route('g_landsource')}}',data,'post');
            if(ajaxResp.code == 'error'){
                toastr.error(ajaxResp.message);
            }else{
                if(ajaxResp.sdata.landsource.length!=0){
                    $('#land_source_id').html('');
                    var land_source_info = '<option value="0">--请选择--</option>';
                    $.each(ajaxResp.sdata.landsource,function (index,info) {
                        land_source_info +='<option value="'+info.id+'">--'+info.name+'--</option>';
                    });
                    $('#land_source_id').html(land_source_info);
                }else{
                    $('#land_source_id').html('<option value="0">--请先选择土地性质--</option>');
                    $('#land_state_id').html('<option value="0">--请先选择土地来源--</option>');
                    toastr.error('暂无相关数据');
                }
            }

        });
    </script>

@endsection