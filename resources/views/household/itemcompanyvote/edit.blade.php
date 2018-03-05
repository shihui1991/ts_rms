{{-- 继承布局 --}}
@extends('household.home')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>
    </p>


    <form class="form-horizontal" role="form" action="{{route('h_itemcompanyvote_edit')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$sdata->id}}"/>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="name">被征户账号：</label>
            <div class="col-sm-9">
                <input type="text" id="username" name="username" value="{{session('household_user.user_name')}}" class="col-xs-10 col-sm-5" readonly>
            </div>
        </div>
        <div class="space-4"></div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="land_id">项目：</label>
            <div class="col-sm-9">
                <input type="text" id="item_name" name="item_name" value="{{$sdata->item->name}}" class="col-xs-10 col-sm-5" readonly>
            </div>
        </div>
        <div class="space-4"></div>


        <div class="form-group house-repay">
            <label class="col-sm-3 control-label no-padding-right" for="layout_id">评估机构：</label>
            <div class="col-sm-9 radio">
                <select name="company_id" id="company_id" class="col-xs-10 col-sm-5">
                    @foreach($sdata->company as $key => $value)
                        <option value="{{$key}}" @if($key==$sdata->company_id) selected @endif >{{$value}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="space-4 house-repay"></div>


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


{{-- 插件 --}}
@section('js')
    @parent
    <script src="{{asset('js/func.js')}}"></script>
    <script>

    </script>

@endsection
