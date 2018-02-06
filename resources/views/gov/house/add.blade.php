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


    <form class="form-horizontal" role="form" action="{{route('g_house_add')}}" method="post">
        {{csrf_field()}}
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="company_id"> 房源管理机构： </label>
            <div class="col-sm-9">
                <select class="col-xs-5 col-sm-5" name="company_id" id="company_id">
                    <option value="0">--请选择--</option>
                    @foreach($sdata['housecompany'] as $company)
                        <option value="{{$company->id}}">{{$company->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="company_id"> 房源社区： </label>
            <div class="col-sm-9">
                <select class="col-xs-5 col-sm-5" name="company_id" id="company_id">
                    <option value="0">--请选择--</option>
                    @foreach($sdata['housecommunity'] as $community)
                        <option value="{{$community->id}}">{{$community->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="layout_id"> 房源户型： </label>
            <div class="col-sm-9">
                <select class="col-xs-5 col-sm-5" name="layout_id" id="layout_id">
                    <option value="0">--请选择--</option>
                    @foreach($sdata['layout'] as $layout)
                        <option value="{{$layout->id}}">{{$layout->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="layout_id"> 房源户型图：
                <button type="button" class="btn layout_select" style="background-color: #ABBAC3!important;border-color: #ABBAC3;width: 100px;"
                        data-toggle="modal">
                    选择户型图
                </button>
            </label>
            <div class="col-sm-9">

            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="unit"> 单元： </label>
            <div class="col-sm-9">
                <input type="number" id="unit" name="unit" value="{{old('unit')}}" class="col-xs-10 col-sm-5"  placeholder="请输入单元" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="building"> 楼栋： </label>
            <div class="col-sm-9">
                <input type="number" id="building" name="building" value="{{old('building')}}" class="col-xs-10 col-sm-5"  placeholder="请输入楼栋" required>
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
            <label class="col-sm-3 control-label no-padding-right" for="area"> 面积： </label>
            <div class="col-sm-9">
                <input type="number" id="area" name="area" value="{{old('area')}}" class="col-xs-10 col-sm-5"  placeholder="请输入面积" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="total_floor"> 总楼层： </label>
            <div class="col-sm-9">
                <input type="number" id="total_floor" name="total_floor" value="{{old('total_floor')}}" class="col-xs-10 col-sm-5"  placeholder="请输入面积" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="lift"> 是否电梯房： </label>
            <div class="col-sm-9 radio">
                @foreach($edata->lift as $key => $value)
                    <label>
                        <input name="lift" type="radio" class="ace" value="{{$key}}" @if($key==0) checked @endif >
                        <span class="lbl">{{$value}}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="is_real"> 房源类型： </label>
            <div class="col-sm-9 radio">
                @foreach($edata->is_real as $key => $value)
                    <label>
                        <input name="is_real" type="radio" class="ace" value="{{$key}}" @if($key==0) checked @endif >
                        <span class="lbl">{{$value}}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="is_buy"> 购置状态： </label>
            <div class="col-sm-9 radio">
                @foreach($edata->is_buy as $key => $value)
                    <label>
                        <input name="is_buy" type="radio" class="ace" value="{{$key}}" @if($key==0) checked @endif >
                        <span class="lbl">{{$value}}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="is_transit"> 可临时周转状况： </label>
            <div class="col-sm-9 radio">
                @foreach($edata->is_transit as $key => $value)
                    <label>
                        <input name="is_transit" type="radio" class="ace" value="{{$key}}" @if($key==0) checked @endif >
                        <span class="lbl">{{$value}}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="is_public"> 可项目共享状况： </label>
            <div class="col-sm-9 radio">
                @foreach($edata->is_public as $key => $value)
                    <label>
                        <input name="is_public" type="radio" class="ace" value="{{$key}}" @if($key==0) checked @endif >
                        <span class="lbl">{{$value}}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="delive_at"> 交付时间： </label>
            <div class="col-sm-9">
                <input type="text" id="delive_at" name="delive_at" value="{{old('delive_at')}}" class="col-xs-10 col-sm-5 laydate"  placeholder="请输入交付时间" required>
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


    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">选择户型图</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary">选中</button>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')
    <script src="{{asset('js/func.js')}}"></script>
    <script src="{{asset('laydate/laydate.js')}}"></script>
    <script>
        $('#name').focus();
        /*---------获取房源社区----------*/
        $('.company_id').on('click',function () {

        });

        $(".layout_select").on('click',function(){
            var layout_id = $('#layout_id').find('option:selected').val();
            if(layout_id==0){
                $(this).attr('data-target','');
                toastr.error('请先选择户型');
                return false;
            }
            $(this).attr('data-target','#myModal');
        })
    </script>

@endsection