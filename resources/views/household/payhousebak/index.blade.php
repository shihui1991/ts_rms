{{-- 继承主体 --}}
@extends('household.home')





    {{-- 页面内容 --}}
@section('content')
    <div class="row">
        <div class="col-xs-12">
            @if($code=='success')
                @foreach($sdata as $infos)
                    <div class="col-xs-6 col-sm-3 pricing-box">
                        <div class="widget-box widget-color-dark">
                            <div class="widget-header">
                                <h5 class="widget-title bigger lighter">{{$infos->house->housecommunity->name}}</h5>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">

                                    <div class="profile-user-info profile-user-info-striped">

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 管理机构：</div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{$infos->house->housecompany->name}}</span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 位置：</div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click"> {{$infos->house->building?$infos->building.'栋':''}}
                                                    {{$infos->house->unit?$infos->unit.'单元':''}}
                                                    {{$infos->house->floor?$infos->floor.'层':''}}
                                                    {{$infos->house->number?$infos->number.'号':''}}</span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 面积：</div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{$infos->house->area}}</span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 总楼层：</div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{$infos->house->total_floor}}</span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 是否电梯房：</div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{$infos->house->lift}}</span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 类型：</div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{$infos->house->is_real}}
                                                    |{{$infos->house->is_transit}}</span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 户型：</div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{$infos->house->layout->name}}</span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 户型图：</div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <a href="{{route('h_itemhouse_info',['id'=>$infos->house_id])}}"
                                       style="font-size: 15px"  class="btn btn-block btn-inverse"> 查看详情 <i
                                                class="ace-icon fa fa-chevron-circle-right bigger-110"></i>
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
    <link rel="stylesheet" href="{{asset('viewer/viewer.min.css')}}"/>
@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script src="{{asset('js/func.js')}}"></script>
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script>
        function selectHouse(house_id) {
            var data = {house_id: house_id};
            ajaxAct('{{route('h_payhousebak_add')}}', data, 'post');
            console.log(ajaxResp);
            if (ajaxResp.code == 'success') {
                toastr.success(ajaxResp.message);
                setTimeout(function () {
                    location.href = ajaxResp.url;
                }, 1000);
            } else {
                toastr.error(ajaxResp.message);
            }
            return false;
        }

        $('.img-content').viewer();
    </script>

@endsection

