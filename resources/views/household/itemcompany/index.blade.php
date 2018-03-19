{{-- 继承aceAdmin后台布局 --}}
@extends('household.home')


{{-- 页面内容 --}}
@section('content')
    <div class="row">
        <div class="col-xs-12">
            @if($code=='success')
                @foreach($sdata as $value)
                    <div class="col-xs-6 col-sm-3 pricing-box">
                        <div class="widget-box widget-color-dark">
                            <div class="widget-header">
                                <h5 class="widget-title bigger lighter">{{$value->company->name}}</h5>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">

                                    <div class="profile-user-info profile-user-info-striped">

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 排名： </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{$loop->iteration}}</span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 基本信息： </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{$value->company->infos}}</span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> LOGO： </div>

                                            <div class="profile-info-value img-content">
                                                @if($value->company->logo)
                                                    <img width="120" height="120" src="{{$value->company->logo}}" alt="{{$value->company->logo}}">
                                                    <div class="text">
                                                        <div class="inner">
                                                            <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                                        </div>
                                                    </div>
                                                @else
                                                    暂无
                                                @endif
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 得票数： </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{$value->companyvotes_count}}</span>
                                            </div>
                                        </div>

                                    </div>



                                </div>
                                <div>
                                    <a href="{{route('h_company_info',['id'=>$value->company_id])}}" style="font-size: 15px" class="btn btn-block btn-inverse">查看详情 <i class="ace-icon fa fa-chevron-circle-right bigger-110"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else

                <div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert">
                        <i class="ace-icon fa fa-times"></i>
                    </button>
                    <strong>
                        <i class="ace-icon fa fa-exclamation-circle"></i>
                    </strong>
                    <strong class="resp-error">{{$message}}</strong>

                    <br>
                </div>

            @endif
        </div>
    </div>




@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script src="{{asset('js/func.js')}}"></script>
    <script>


    </script>
@endsection