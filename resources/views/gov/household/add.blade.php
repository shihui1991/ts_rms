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


    <form class="form-horizontal" role="form" action="{{route('g_household_add')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="item" value="{{$sdata['item_id']}}">

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="land_id"> 地块： </label>
            <div class="col-sm-9">
                <select class="col-xs-5 col-sm-5" name="land_id" id="land_id">
                    <option value="">--请选择--</option>
                    @if($sdata['itemland'])
                        @foreach($sdata['itemland'] as $itemland)
                            <option value="{{$itemland->id}}">{{$itemland->address}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="building_id"> 楼栋： </label>
            <div class="col-sm-9">
                <select class="col-xs-5 col-sm-5" name="building_id" id="building_id">
                    <option value="">--请先选择地块--</option>
                </select>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="unit"> 单元号： </label>
            <div class="col-sm-9">
                <input type="number" id="unit" name="unit" value="{{old('unit')}}" class="col-xs-10 col-sm-5"  placeholder="请输入单元号" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="floor"> 楼层： </label>
            <div class="col-sm-9">
                <input type="number" id="floor" name="floor" value="{{old('floor')}}" class="col-xs-10 col-sm-5"  placeholder="请输入楼层" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="number"> 房号： </label>
            <div class="col-sm-9">
                <input type="number" id="number" name="number" value="{{old('number')}}" class="col-xs-10 col-sm-5"  placeholder="请输入房号" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="type"> 房产类型： </label>
            <div class="col-sm-9 radio">
                @foreach($edata->type as $key => $value)
                    <label>
                        <input name="type" type="radio" class="ace" value="{{$key}}" @if($key==0) checked @endif >
                        <span class="lbl">{{$value}}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="username"> 用户名： </label>
            <div class="col-sm-9">
                <input type="text" id="username" name="username" value="{{old('username')}}" class="col-xs-10 col-sm-5"  placeholder="请输入用户名" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="password"> 密码： </label>
            <div class="col-sm-9">
                <input type="text" id="password" name="password" value="{{old('password')}}" class="col-xs-10 col-sm-5"  placeholder="请输入密码" required>
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
        $('#land_id').on('change',function(){
            var _this = $(this).val();
            var data = {
                'land_id':_this,
                'item':'{{$sdata['item_id']}}',
                'app':'app'
            };
            ajaxAct('{{route('g_itembuilding')}}',data,'post');
            if(ajaxResp.code == 'error'){
                $('#building_id').html('<option value="0">--请先选择地块--</option>');
                toastr.error(ajaxResp.message);
            }else{
                $('#building_id').html('');
                if(ajaxResp.sdata.length!=0){
                    var building_info = '<option value="0">--请选择--</option>';
                    $.each(ajaxResp.sdata,function (index,info) {
                        building_info +='<option value="'+info.id+'">--'+info.building+'--</option>';
                    });
                    $('#building_id').html(building_info);
                }else{
                    $('#building_id').html('<option value="0">--请先选择地块--</option>');
                    toastr.error('暂无相关数据');
                }
            }
        });
    </script>

@endsection