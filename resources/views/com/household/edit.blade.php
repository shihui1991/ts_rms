{{-- 继承布局 --}}
@extends('com.main')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>
    </p>

    <div class="well well-sm">
        评估信息
    </div>

    <div class="well-sm">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#household" aria-expanded="true">
                        <i class="green ace-icon fa fa-building bigger-120"></i>
                        评估基本信息
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#assess" aria-expanded="false">
                        <i class="green ace-icon fa fa-home bigger-120"></i>
                        开始评估
                    </a>
                </li>
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
                <div id="assess" class="tab-pane fade">
                    @if($edata['type']==0)
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">共 @if($code=='success') {{ count($edata['estatebuilding']) }} @else 0 @endif 条数据</div>
                            </div>
                        </div>
                        <form class="form-horizontal" role="form" action="{{route('c_household_edit')}}" method="post">
                            <input type="hidden" name="item" value="{{$edata['item_id']}}">
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>地块</th>
                                    <th>楼栋</th>
                                    <th>楼层</th>
                                    <th>朝向</th>
                                    <th>结构类型</th>
                                    <th>实际建筑面积</th>
                                    <th>实际用途</th>
                                    <th>评估单价</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($code=='success')
                                    @foreach($edata['estatebuilding'] as $infos)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$infos->itemland->address}}</td>
                                            <td>{{$infos->itembuilding->building}}</td>
                                            <td>{{$infos->floor}}</td>
                                            <td>{{$infos->direct}}</td>
                                            <td>{{$infos->buildingstruct->name}}</td>
                                            <td>{{$infos->real_outer}}</td>
                                            <td>{{$infos->realuse->name}}</td>
                                            <td><input type="text" name="price[{{$infos->id}}]" value=""></td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="valuer_id"> 评估师： </label>
                                <div class="col-sm-9">
                                    <select class="col-xs-5 col-sm-5" name="valuer_id" id="valuer_id">
                                        <option value="">--请选择--</option>
                                        @foreach($edata['valuer'] as $valuer)
                                            <option value="{{$valuer->id}}">{{$valuer->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="space-4"></div>
                            <div class="widget-body">
                                <div class="widget-main padding-8">

                                    <div class="form-group img-box">
                                        <label class="col-sm-3 control-label no-padding-right">
                                            评估报告：<br/>
                                            <span class="btn btn-xs">
                                                <span>上传图片</span>
                                                <input type="file" accept="image/*" class="hidden" data-name="picture[]" multiple  onchange="uplfile(this)">
                                            </span>
                                        </label>
                                        <div class="col-sm-9">
                                            <ul class="ace-thumbnails clearfix img-content viewer">

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="space-4 header green"></div>
                                </div>
                            </div>
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <button class="btn btn-info" type="button" onclick="sub(this)">
                                        <i class="ace-icon fa fa-check bigger-110"></i>
                                        提交评估
                                    </button>
                                    &nbsp;&nbsp;&nbsp;
                                    <button class="btn" type="reset">
                                        <i class="ace-icon fa fa-undo bigger-110"></i>
                                        重置
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else

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
    @parent
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script src="{{asset('js/func.js')}}"></script>
    <script>
        $('.img-content').viewer('update');
    </script>
@endsection