{{-- 继承布局 --}}
@extends('household.layout')


{{-- 页面内容 --}}
@section('content')

    <div class="error-container">
        <div class="well">
            <h1 class="grey lighter smaller">
                <span class="blue bigger-125">
                    <i class="fa fa-spinner fa-spin fa-pulse"></i>
                    无法访问
                </span>
            </h1>

            <hr />
            <h3 class="lighter smaller">
                提示：
            </h3>

            @if(count($errors))
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        <strong>
                            <i class="ace-icon fa fa-times"></i>
                        </strong>
                        {{$error}}
                        <br>
                    </div>
                @endforeach
            @endif

            @if(session()->has('error'))
                <div class="alert alert-danger">
                    <strong>
                        <i class="ace-icon fa fa-times"></i>
                    </strong>
                    {{session()->get('error')}}
                    <br>
                </div>
            @endif

            @if($code=='error')
                <div class="alert alert-danger">
                    <strong>
                        <i class="ace-icon fa fa-times"></i>
                    </strong>
                    {{$message}}
                    <br>
                </div>
            @endif

            <hr />
            <div class="space"></div>

            <div class="center">
                <a href="javascript:history.back()" class="btn btn-grey">
                    <i class="ace-icon fa fa-arrow-left"></i>
                    返回
                </a>

                <a href="{{route('h_home')}}" class="btn btn-primary">
                    <i class="ace-icon fa fa-home"></i>
                    回到首页
                </a>
            </div>
        </div>
    </div>

@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')

    @parent

@endsection