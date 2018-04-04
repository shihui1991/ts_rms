{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')

    <div class="widget-box widget-color-blue2">
        <div class="widget-header">
            <h4 class="widget-title lighter smaller">当前房源总数与初步预算：</h4>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                    展开/关闭
                </a>
            </div>
        </div>
        <div class="widget-body">
            <div class="widget-main padding-8">

                <div class="profile-user-info profile-user-info-striped">

                    <div class="profile-info-row">
                        <div class="profile-info-name"> 当前房源总数： </div>
                        <div class="profile-info-value">
                            <span class="editable editable-click">{{number_format($sdata['itemhouses']->total())}}</span>
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name"> 预算总房源数： </div>
                        <div class="profile-info-value">
                            <span class="editable editable-click">
                                <strong>{{number_format($sdata['init_budget']->house)}}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name"> 是否达到预算： </div>
                        <div class="profile-info-value">
                            <span class="editable editable-click">
                                @if($sdata['itemhouses']->total()>=$sdata['init_budget']->house)
                                    达到
                                    <a class="btn btn-danger" onclick="btnAct(this)" data-url="{{route('g_ready_house',['item'=>$sdata['item']->id])}}" data-method="post">
                                        <i class="ace-icon fa fa-check bigger-110"></i>
                                        提交准备完毕
                                    </a>
                                @else
                                    未达到
                                @endif
                                    <a href="{{route('g_itemhouse_add',['item'=>$sdata['item']->id])}}" class="btn">继续添加房源</a>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="widget-box widget-color-green2">
        <div class="widget-header">
            <h4 class="widget-title lighter smaller">项目冻结房源：</h4>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                    展开/关闭
                </a>
            </div>
        </div>
        <div class="widget-body">
            <div class="widget-main padding-8">
                <table class="table table-hover table-bordered treetable" >
                    <thead>
                    <tr>
                        <th>序号</th>
                        <th>管理机构</th>
                        <th>房源社区</th>
                        <th>户型</th>
                        <th>位置</th>
                        <th>面积</th>
                        <th>总楼层</th>
                        <th>是否电梯房</th>
                        <th>类型</th>
                        <th>交付日期</th>
                        <th>房源状态</th>
                        <th>添加时期</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(filled($sdata['itemhouses']))
                        @foreach($sdata['itemhouses'] as $infos)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$infos->house->housecompany->name}}</td>
                                <td>{{$infos->house->housecommunity->name}}</td>
                                <td>{{$infos->house->layout->name}}</td>
                                <td>
                                    {{$infos->house->building?$infos->house->building.'栋':''}}
                                    {{$infos->house->unit?$infos->house->unit.'单元':''}}
                                    {{$infos->house->floor?$infos->house->floor.'楼':''}}
                                    {{$infos->house->number?$infos->house->number.'号':''}}
                                </td>
                                <td>{{$infos->house->area}}</td>
                                <td>{{$infos->house->total_floor}}</td>
                                <td>{{$infos->house->lift}}</td>
                                <td>{{$infos->house->is_real}}|{{$infos->house->is_buy}}|{{$infos->house->is_transit}}|{{$infos->house->is_public}}</td>
                                <td>{{$infos->house->delive_at}}</td>
                                <td>{{$infos->house->state->name}}</td>
                                <td>{{$infos->type}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">共 @if(filled($sdata['itemhouses'])) {{ $sdata['itemhouses']->total() }} @else 0 @endif 条数据</div>
                    </div>
                    <div class="col-xs-6">
                        <div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
                            @if(filled($sdata['itemhouses'])) {{ $sdata['itemhouses']->links() }} @endif
                        </div>
                    </div>
                </div>
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
    <script>

    </script>

@endsection