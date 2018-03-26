{{-- 继承主体 --}}
@extends('household.layout')


{{-- 页面内容 --}}
@section('content')

    <h3 class="header smaller green">有效选房</h3>
    @if(filled($sdata))
        <div class="row">
            @if(filled($sdata['resettles']))
                <div class="col-xs-12 col-sm-12">
                    <div class="widget-container-col ui-sortable">
                        <div class="widget-box ui-sortable-handle">
                            <div class="widget-header">
                                <h5 class="widget-title">安置房</h5>

                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse">
                                        <i class="ace-icon fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
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
                                            <th>优惠价</th>
                                            <th>优惠总价</th>
                                            <th>上浮房款</th>
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
                                                <td>{{$object->is_real}}</td>
                                                <td>{{$object->layout->name}}</td>
                                                <td>{{$object->area}}</td>
                                                <td>{{$object->housepluses['market']}}</td>
                                                <td>{{$object->housepluses['price']}}</td>
                                                <td>{{number_format($object->amount,2)}}</td>
                                                <td>{{number_format($object->amount_plus,2)}}</td>
                                                <td style="font-weight: bold">{{number_format($object->total,2)}}</td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th colspan="3">可调换安置房的补偿总额：{{number_format($sdata['resettle_total'],2)}} 元</th>
                                            <th colspan="3">上浮面积：<span id="plus_area">{{$sdata['plus_area']}}</span> ㎡</th>
                                            <th colspan="7">
                                                产权调换后结余补偿款：
                                                <span id="last_total">{{number_format($sdata['last_total'],2)}}</span> 元（负数则表示被征收户需补交上浮房款）
                                            </th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert">
                        <i class="ace-icon fa fa-times"></i>
                    </button>
                    <strong>
                        <i class="ace-icon fa fa-exclamation-circle"></i>
                    </strong>
                    <strong class="resp-error">暂未选择安置房</strong>

                    <br>
                </div>
            @endif

                <div class="col-xs-12 col-sm-12">

                    <div class="widget-container-col ui-sortable">
                        <div class="widget-box ui-sortable-handle">
                            <div class="widget-header">
                                <h5 class="widget-title">临时周转房</h5>

                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse">
                                        <i class="ace-icon fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            @if(filled($sdata['transit_house']))
                            <div class="widget-body">
                                <div class="widget-main">


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
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($sdata['transit_house'] as $object)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$object->house->housecommunity->name}}</td>

                                                <td>{{$object->house->building?$object->house->building.'栋':''}}
                                                    {{$object->house->unit?$object->house->unit.'单元':''}}
                                                    {{$object->house->floor?$object->house->floor.'层':''}}
                                                    {{$object->house->number?$object->house->number.'号':''}}</td>
                                                <td>{{$object->house->total_floor}}</td>
                                                <td>{{$object->house->lift}}</td>
                                                <td>{{$object->house->is_real}}</td>
                                                <td>{{$object->house->layout->name}}</td>
                                                <td>{{$object->house->area}}</td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            @else
                                <div class="alert alert-warning">
                                    <button type="button" class="close" data-dismiss="alert">
                                        <i class="ace-icon fa fa-times"></i>
                                    </button>
                                    <strong>
                                        <i class="ace-icon fa fa-exclamation-circle"></i>
                                    </strong>
                                    <strong class="resp-error">暂未选择临时周转房</strong>

                                    <br>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

        </div>
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
    <h3 class="header smaller red">所有选房</h3>
    @if(filled($sdata['allhouse']))
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <div class="widget-container-col ui-sortable">
                    <div class="widget-box ui-sortable-handle">
                        <div class="widget-header">
                            <h5 class="widget-title">所有选房</h5>

                            <div class="widget-toolbar">
                                <a href="#" data-action="collapse">
                                    <i class="ace-icon fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main">


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
                                        <th>选房用途</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($sdata['allhouse'] as $object)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$object->house->housecommunity->name}}</td>

                                            <td>{{$object->house->building?$object->house->building.'栋':''}}
                                                {{$object->house->unit?$object->house->unit.'单元':''}}
                                                {{$object->house->floor?$object->house->floor.'层':''}}
                                                {{$object->house->number?$object->house->number.'号':''}}</td>
                                            <td>{{$object->house->total_floor}}</td>
                                            <td>{{$object->house->lift}}</td>
                                            <td>{{$object->house->is_real}}|{{$object->house->is_transit}}</td>
                                            <td>{{$object->house->layout->name}}</td>
                                            <td>{{$object->house->area}}</td>
                                            <td>
                                                @if($object->house_type==1)安置房
                                                @else临时周转房
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('h_itemhouse_info',['id'=>$object->house_id])}}"
                                                   class="btn btn-sm">查看详情</a>
                                                <a onclick="removeHouse({{$object->house_id}})" href=""
                                                   class="btn btn-sm">移除</a>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
        function removeHouse(house_id) {
            var data = {house_id: house_id};
            ajaxAct('{{route('h_payhousebak_remove')}}', data, 'post');
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

