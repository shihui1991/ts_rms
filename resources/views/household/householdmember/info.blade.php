{{-- 继承主体 --}}
@extends('household.layout')

{{-- 页面内容 --}}
@section('content')

    <div class="row">
        <div class="well well-sm">
            <p>
                <a class="btn" href="javascript:history.back()">
                    <i class="ace-icon fa fa-arrow-left bigger-110"></i>返回
                </a>
            </p>

        </div>

        <div class="well-sm">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#itembuilding" aria-expanded="true">
                            <i class="green ace-icon fa fa-building bigger-120"></i>
                            家庭成员详情
                        </a>
                    </li>
                    @if($sdata->getOriginal('crowd')==1)
                        <li class="">
                            <a data-toggle="tab" href="#itempublic" aria-expanded="false">
                                <i class="green ace-icon fa fa-home bigger-120"></i>
                                特殊人群信息
                            </a>
                        </li>
                    @endif
                </ul>

                <div class="tab-content">
                    <div id="itembuilding" class="tab-pane fade active in">
                        <div class="profile-user-info profile-user-info-striped">

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 姓名： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->name}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 与户主关系： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->relation}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 身份证： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->card_num}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 电话： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->phone}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 民族： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->nation->name}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 性别： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->sex}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 年龄： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->age}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 是否享受特殊人群优惠： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->crowd}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 权属类型： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->holder}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 权属分配比例： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata->portion}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 身份证,户口本页： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">
                                        <ul class="ace-thumbnails clearfix img-content viewer">
                                              @if(isset($sdata->picture))
                                                @foreach($sdata->picture as $pic)
                                                    <li>
                                                        <div>
                                                            <img width="120" height="120" src="{!! $pic !!}" alt="加载失败">
                                                            <div class="text">
                                                                <div class="inner">
                                                                    <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </span>
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
                                <div class="profile-info-name"> 状态： </div>
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

                        </div>
                    </div>

                    @if($sdata->getOriginal('crowd')==1)
                    <div id="itempublic" class="tab-pane fade">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>名称</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($code=='success')
                                @foreach($edata as $info)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$info->crowd->name}}</td>
                                        <td>
                                            <a href="{{route('h_householdmembercrowd_info',['id'=>$info->id])}}" class="btn btn-sm">查看详情</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">共 @if($code=='success') {{ count($edata) }} @endif 条数据</div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- 样式 --}}
@section('css')
    <link rel="stylesheet" href="{{asset('viewer/viewer.min.css')}}" />
@endsection

{{-- 插件 --}}
@section('js')
    <script src="{{asset('js/func.js')}}"></script>
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script>
        $('.img-content').viewer('update');
    </script>
@endsection