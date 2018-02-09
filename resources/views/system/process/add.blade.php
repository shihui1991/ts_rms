{{-- 继承布局 --}}
@extends('system.home')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="{{route('sys_process')}}">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>
    </p>


    <form class="form-horizontal" role="form" action="{{route('sys_process_add')}}" method="post">
        {{csrf_field()}}

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="schedule_id"> 项目进度： </label>
            <div class="col-sm-9">
                @if($sdata['id'])
                    <input type="text" id="schedule_id" value="{{$sdata['schedules'][$sdata['schedule_id']]}}" class="col-xs-10 col-sm-5" readonly>
                @else
                    <select name="schedule_id" id="schedule_id" class="col-xs-10 col-sm-5">
                        @foreach($sdata['schedules'] as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>

                @endif

            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="parent_id"> 上级流程： </label>
            <div class="col-sm-9">
                <input type="text" id="parent_id" value="{{$sdata['name']}}" class="col-xs-10 col-sm-5" readonly>
                <input type="hidden" name="parent_id" value="{{$sdata['id']}}">
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="name"> 名称： </label>
            <div class="col-sm-9">
                <input type="text" id="name" name="name" value="{{old('name')}}" class="col-xs-10 col-sm-5" required>
            </div>
        </div>
        <div class="space-4"></div>
        
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="type">操作类型：</label>
            <div class="col-sm-9 radio">
                @foreach($edata->type as $key => $value)
                    <label>
                        <input name="type" type="radio" class="ace" value="{{$key}}" @if($key==1) checked @endif >
                        <span class="lbl">{{$value}}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="sort"> 排序： </label>
            <div class="col-sm-9">
                <input type="number" min="0" id="sort" name="sort" value="{{old('sort')}}" class="col-xs-10 col-sm-5" required>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="infos">描述：</label>
            <div class="col-sm-9">
                <textarea id="infos" name="infos" class="col-xs-10 col-sm-5" >{{old('infos')}}</textarea>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right"> 关联菜单： </label>
            <div class="col-sm-9">
                <div class="col-xs-10 col-sm-5">
                    <table class="table table-hover table-bordered treetable">
                        <thead>
                        <tr>
                            <th>菜单</th>
                            <th>选择</th>
                        </tr>
                        </thead>
                        <tbody>
                        {!! $sdata['menu_tree'] !!}
                        </tbody>
                    </table>
                </div>
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
    <link rel="stylesheet" href="{{asset('treetable/jquery.treetable.theme.default.css')}}" />
@endsection

{{-- 插件 --}}
@section('js')

    <script src="{{asset('treetable/jquery.treetable.js')}}"></script>
    <script src="{{asset('js/func.js')}}"></script>
    <script>
        $('#name').focus();

        $(".treetable").treetable({
            expandable: true // 展示
            ,initialState :"collapsed"//默认打开所有节点
            ,stringCollapse:'关闭'
            ,stringExpand:'展开'
        });
    </script>

@endsection