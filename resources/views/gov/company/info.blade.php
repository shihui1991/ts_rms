{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>

        <a class="btn" href="{{route('g_company_edit',['id'=>$sdata->id])}}">
            <i class="ace-icon fa fa-pencil-square-o bigger-110"></i>
            修改评估机构信息
        </a>
    </p>

    <div class="well-sm">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#company" aria-expanded="true">
                        <i class="green ace-icon fa fa-building bigger-120"></i>
                        评估机构信息
                    </a>
                </li>

                <li class="">
                    <a data-toggle="tab" href="#companyuser" aria-expanded="false">
                        <i class="green ace-icon fa fa-building bigger-120"></i>
                        操作员
                    </a>
                </li>

                <li class="">
                    <a data-toggle="tab" href="#companyvaluer" aria-expanded="false">
                        <i class="green ace-icon fa fa-home bigger-120"></i>
                        评估师
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="company" class="tab-pane fade active in">
                    <div class="profile-user-info profile-user-info-striped">

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 机构状态： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->code}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 类型： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->type}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 名称： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->name}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 地址： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->address}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 电话： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->phone}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 传真： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->fax}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 联系人： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->contact_man}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 手机号： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->contact_tel}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 描述： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->infos}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 简介： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->content}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 创建时间： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->created_at}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 更新时间： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->updated_at}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 数据状态： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click"> @if($sdata->deleted_at) 已删除 @else 启用中 @endif</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 删除时间： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->deleted_at}}</span>
                            </div>
                        </div>
                        <br/>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> 操作人员姓名： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->companyuser->name}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 操作人员电话： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->companyuser->phone}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 操作人员账号： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->companyuser->username}}</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name"> 最近操作时间： </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click">{{$sdata->companyuser->action_at}}</span>
                            </div>
                        </div>

                    </div>
                </div>

                <div id="companyuser" class="tab-pane fade">
                    <div class="col-xs-12">
                    @if($edata['companyusers'])
                        @foreach($edata['companyusers'] as $infos)
                            <div class="col-xs-6 col-sm-3 pricing-box">
                                <div class="widget-box widget-color-dark">
                                    <div class="widget-header">
                                        <h5 class="widget-title bigger lighter">@if($infos->id == $sdata->user_id) 管理账号@else 普通账号@endif</h5>
                                    </div>

                                    <div class="widget-body">
                                        <div class="widget-main">

                                            <div class="profile-user-info profile-user-info-striped">

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> 名称： </div>
                                                    <div class="profile-info-value">
                                                        <span class="editable editable-click">{{$infos->name}}</span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> 电话： </div>
                                                    <div class="profile-info-value">
                                                        <span class="editable editable-click">{{$infos->phone}}</span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> 用户名： </div>
                                                    <div class="profile-info-value">
                                                        <span class="editable editable-click">{{$infos->username}}</span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> 最近操作时间： </div>
                                                    <div class="profile-info-value">
                                                        <span class="editable editable-click">{{$infos->action_at}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">共 @if($code=='success') {{ count($edata['companyusers']) }} @else 0 @endif 条数据</div>
                        </div>
                    </div>
                </div>

                <div id="companyvaluer" class="tab-pane fade">
                    <div class="col-xs-12">
                        @if($edata['companyvaluers'])
                            @foreach($edata['companyvaluers'] as $info)
                                <div class="col-xs-6 col-sm-3 pricing-box">
                                    <div class="widget-box widget-color-dark">
                                        <div class="widget-header">
                                            <h5 class="widget-title bigger lighter">评估师【@if($info->valid_at>=date('Y-m-d'))有效@else过期@endif】</h5>
                                        </div>

                                        <div class="widget-body">
                                            <div class="widget-main">

                                                <div class="profile-user-info profile-user-info-striped">

                                                    <div class="profile-info-row">
                                                        <div class="profile-info-name"> 名称： </div>
                                                        <div class="profile-info-value">
                                                            <span class="editable editable-click">{{$info->name}}</span>
                                                        </div>
                                                    </div>

                                                    <div class="profile-info-row">
                                                        <div class="profile-info-name"> 电话： </div>
                                                        <div class="profile-info-value">
                                                            <span class="editable editable-click">{{$info->phone}}</span>
                                                        </div>
                                                    </div>

                                                    <div class="profile-info-row">
                                                        <div class="profile-info-name"> 注册号： </div>
                                                        <div class="profile-info-value">
                                                            <span class="editable editable-click">{{$info->register}}</span>
                                                        </div>
                                                    </div>

                                                    <div class="profile-info-row">
                                                        <div class="profile-info-name"> 有效期： </div>
                                                        <div class="profile-info-value">
                                                            <span class="editable editable-click">{{$info->valid_at}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">共 @if($code=='success') {{ count($edata['companyvaluers']) }} @else 0 @endif 条数据</div>
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