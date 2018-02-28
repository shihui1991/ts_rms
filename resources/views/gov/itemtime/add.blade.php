{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="{{route('g_itemtime',['item'=>$sdata['item']->id])}}">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>
    </p>


    <form class="form-horizontal" role="form" action="{{route('g_itemtime_add',['item'=>$sdata['item']->id])}}" method="post">
        {{csrf_field()}}

        @foreach($sdata['schedules'] as $schedule)

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="data[{{$schedule->id}}][start_at]"> {{$schedule->name}}： </label>
                <div class="col-sm-9">
                    <input type="text" id="data[{{$schedule->id}}][start_at]" name="data[{{$schedule->id}}][start_at]" class="laydate" required>
                    -
                    <input type="text" name="data[{{$schedule->id}}][end_at]" class="laydate" required>
                </div>
            </div>
            <div class="space-4"></div>

        @endforeach

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

@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script src="{{asset('laydate/laydate.js')}}"></script>

    <script src="{{asset('js/func.js')}}"></script>
    <script>
        $('#name').focus();
    </script>

@endsection