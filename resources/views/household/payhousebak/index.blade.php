{{-- 继承主体 --}}
@extends('household.home')





    {{-- 页面内容 --}}
@section('content')
    <div class="row">

        <div class="col-xs-9 col-sm-9">
            <div class="widget-container-col ui-sortable">
                <div class="widget-box ui-sortable-handle">
                    <div class="widget-header">
                        <h5 class="widget-title">有效选房</h5>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">

                            @if(filled($sdata['resettles']))
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>编号</th>
                                    <th>房源</th>
                                    <th>位置</th>
                                    <th>总楼层</th>
                                    <th>是否电梯房</th>
                                    <th>类型</th>
                                    <th>户型</th>
                                    <th>面积</th>
                                    <th>市场价</th>
                                    <th>安置单价</th>
                                    <th>安置价</th>
                                    <th>上浮房款</th>
                                    <th>补偿总价</th>
                                    <th>安置总价</th>
                                </tr>
                                </thead>
                                <tbody>

                                    @foreach($sdata['resettles'] as $object)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$object->housecommunity->name}}</td>

                                            <td>{{$object->building?$object->building.'栋':''}}
                                                {{$object->unit?$object->unit.'单元':''}}
                                                {{$object->floor?$object->floor.'层':''}}
                                                {{$object->number?$object->number.'号':''}}</td>
                                            <td>{{$object->total_floor}}</td>
                                            <td>{{$object->lift}}</td>
                                            <td>{{$object->is_real}}|{{$object->is_transit}}</td>
                                            <td>{{$object->layout->name}}</td>
                                            <td>{{$object->area}}</td>
                                            <td>{{$object->housepluses['market']}}</td>
                                            <td>{{$object->housepluses['price']}}</td>
                                            <td>{{$object->amount}}</td>
                                            <td>{{$object->amount_plus}}</td>
                                            <td>{{$object->amount_plus}}</td>
                                            <td style="font-weight: bold">{{$object->total}}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
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
                </div>
            </div>
        </div>
        <div class="col-xs-3 col-sm-3">
            <div class="widget-container-col ui-sortable">
                <div class="widget-box ui-sortable-handle">
                    <div class="widget-header">
                        <h5 class="widget-title">合计</h5>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            @if(filled($sdata['resettles']))
                                <table class="table table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th>安置总价</th>
                                        <th>安置后兑付金额</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{$sdata['resettle_total']}}</td>
                                            <td>{{$sdata['last_total']}}</td>
                                        </tr>

                                    </tbody>
                                </table>
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
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <div class="widget-container-col ui-sortable">
                <div class="widget-box ui-sortable-handle">
                    <div class="widget-header">
                        <h5 class="widget-title">所有选房</h5>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="profile-user-info">

                                @if($code=='success')
                                    @foreach($sdata['allhouse'] as $infos)
                                        <div class="col-xs-12 col-sm-3 pricing-box">
                                            <div class="widget-box widget-color-green">
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
                                                           style="font-size: 15px"  class="btn btn-block btn-success"> 查看详情 <i
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
                    </div>
                </div>
            </div>
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
        $('.img-content').viewer();
    </script>

@endsection

