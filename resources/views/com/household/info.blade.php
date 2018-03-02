{{-- 继承布局 --}}
@extends('com.main')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>
        @if($edata['dispute_count'] == 0)
        <a class="btn" href="{{route('c_household_edit',['id'=>$sdata->id,'item'=>$sdata->item_id])}}">
            <i class="ace-icon fa fa-pencil-square-o bigger-110"></i>
            进行评估
        </a>
        @endif
    </p>

    <div class="well well-sm">
        入户摸底信息
    </div>

    <div class="well-sm">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#household" aria-expanded="true">
                        <i class="green ace-icon fa fa-building bigger-120"></i>
                        基本信息
                    </a>
                </li>
                @if($edata['type']==0)
                <li class="">
                    <a data-toggle="tab" href="#householdbuilding" aria-expanded="false">
                        <i class="green ace-icon fa fa-home bigger-120"></i>
                        房屋建筑信息
                    </a>
                </li>
                 @endif
            </ul>
            <div class="tab-content">
                <div id="household" class="tab-pane fade active in">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-row">
                            <div class="profile-info-name"> 地块地址： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->itemland->address}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 楼栋： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->itembuilding->building}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 单元号： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->unit}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 楼层： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->floor}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 房号： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->number}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 描述： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->infos}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="householdbuilding" class="tab-pane fade">
                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>面积争议</th>
                            <th>地块</th>
                            <th>楼栋</th>
                            <th>楼层</th>
                            <th>朝向</th>
                            <th>结构</th>
                            <th>是否登记</th>
                            <th>状态</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($code=='success')
                            @foreach($edata['householdbuilding'] as $infos)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$infos->dispute}}</td>
                                    <td>{{$infos->itemland->address}}</td>
                                    <td>{{$infos->itembuilding->building}}</td>
                                    <td>{{$infos->floor}}</td>
                                    <td>{{$infos->direct}}</td>
                                    <td>{{$infos->buildingstruct->name}}</td>
                                    <td>{{$infos->register}}</td>
                                    <td>{{$infos->state}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">共 @if($code=='success') {{ count($sdata) }} @else 0 @endif 条数据</div>
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

@endsection