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


    <form class="form-horizontal" role="form" action="{{route('g_itemland_add')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="item" value="{{$sdata['item_id']}}">
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="address"> 地址： </label>
            <div class="col-sm-9">
                <input type="text" id="address" name="address" value="{{old('address')}}" class="col-xs-10 col-sm-5"  placeholder="请输入地址" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="land_prop_id"> 土地性质： </label>
            <div class="col-sm-9">
                <select class="col-xs-5 col-sm-5" name="land_prop_id" id="land_prop_id">
                    <option value="0">--请选择--</option>
                    @if($sdata['landprop'])
                        @foreach($sdata['landprop'] as $landprop)
                            <option value="{{$landprop->id}}">{{$landprop->name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="land_source_id"> 土地来源： </label>
            <div class="col-sm-9">
                <select class="col-xs-5 col-sm-5" name="land_source_id" id="land_source_id">
                    <option value="0">--请先选择土地性质--</option>
                </select>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="land_state_id"> 土地权益状况： </label>
            <div class="col-sm-9">
                <select class="col-xs-5 col-sm-5" name="land_state_id" id="land_state_id">
                    <option value="0">--请先选择土地来源--</option>
                </select>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="admin_unit_id"> 公产单位： </label>
            <div class="col-sm-9">
                <select class="col-xs-5 col-sm-5" name="admin_unit_id" id="admin_unit_id">
                    <option value="0">--请选择公产单位--</option>
                    @if($sdata['adminunit'])
                        @foreach($sdata['adminunit'] as $adminunit)
                            <option value="{{$adminunit->id}}">--{{$adminunit->name}}--</option>
                        @endforeach
                    @endif
                </select><span class="col-sm-5" style="color: red;line-height: 30px;">注：不选择则为私产</span>
            </div>

        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="area"> 占地面积： </label>
            <div class="col-sm-9">
                <input type="text" id="area" name="area" value="{{old('area')}}" class="col-xs-10 col-sm-5"  placeholder="请输入占地面积" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="infos">备注：</label>
            <div class="col-sm-9">
                <textarea id="infos" name="infos" class="col-xs-10 col-sm-5" placeholder="请输入备注" >{{old('infos')}}</textarea>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="widget-body">
            <div class="widget-main padding-8">

                <div class="form-group img-box">
                    <label class="col-sm-3 control-label no-padding-right">
                        地块图片：<br>
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
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script>
        /*-------获取土地来源-------*/
        $("#land_prop_id").on('change',function() {
            var _this = $(this).val();
            var data = {
                'prop_id':_this
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

        /*-------获取土地权益状况-------*/
        $("#land_source_id").on('change',function() {
            var _this = $(this).val();
            var land_prop_id = $('#land_prop_id').val();
            var data = {
                'prop_id':land_prop_id,
                'source_id':_this
            };
            ajaxAct('{{route('g_landstate')}}',data,'post');
            if(ajaxResp.code == 'error'){
                toastr.error(ajaxResp.message);
            }else{
                if(ajaxResp.sdata.landstate.length!=0){
                    $('#land_state_id').html('');
                    var land_state_info = '<option value="0">--请选择--</option>';
                    $.each(ajaxResp.sdata.landstate,function (index,info) {
                        land_state_info +='<option value="'+info.id+'">--'+info.name+'--</option>';
                    });
                    $('#land_state_id').html(land_state_info);
                }else{
                    $('#land_state_id').html('<option value="0">--请先选择土地来源--</option>');
                    toastr.error('暂无相关数据');
                }
            }
        });
    </script>

@endsection