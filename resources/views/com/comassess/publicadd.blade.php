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


    <form class="form-horizontal" role="form" action="{{route('c_comassess_publicadd')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="item" id="item" value="{{$sdata['item_id']}}">

        <div class="form-group">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>序号</th>
                    <th>地块</th>
                    <th>名称</th>
                    <th>计量单位</th>
                    <th>数量</th>
                    <th>评估单价</th>
                </tr>
                </thead>
                <tbody >
                @if(filled($sdata['itempublics']))
                    @foreach($sdata['itempublics'] as $info)
                       <tr>
                          <input type="hidden" name="item_public_id[]" value="{{$info->id}}">
                          <td>{{$loop->iteration}}</td>
                          <td>{{$info->itemland->address}}</td>
                          <td>{{$info->name}}</td>
                          <td>{{$info->num_unit}}</td>
                          <td>{{$info->number}}</td>
                          <td><input type="text" name="price[{{$info->id}}]"></td>
                      </tr>
                   @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <div class="space-4"></div>

        <div class="widget-body">
            <div class="widget-main padding-8">

                <div class="form-group img-box">
                    <label class="col-sm-3 control-label no-padding-right">
                        评估报告：<br>
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

    </script>

@endsection