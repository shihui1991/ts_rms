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


    <form class="form-horizontal" role="form" action="{{route('g_householdbuildingdeal_status')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$sdata['id']}}">
        <input type="hidden" name="item" value="{{$sdata['item_id']}}">
        <input type="hidden" name="household_id" value="{{$sdata['household_id']}}">
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="code">合法性认定：</label>
            <div class="col-sm-9">
                <select class="col-xs-5 col-sm-5" name="code" id="code">
                    <option value="92">-----合法------</option>
                    <option value="93">-----非法------</option>
                </select>
            </div>
        </div>
        <div class="space-4"></div>


        <div class="clearfix form-actions">
            <div class="col-md-offset-3 col-md-9">
                <button class="btn btn-info" type="button" onclick="sub(this)">
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    保存
                </button>
            </div>
        </div>
    </form>


@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script src="{{asset('js/func.js')}}"></script>
@endsection