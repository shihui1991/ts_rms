{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')

    <div class="row">
        <div class="well well-sm">
            <a class="btn" href="{{route('g_itemland_info',['id'=>$sdata['itembuilding']->land_id,'item'=>$sdata['item']->id])}}"><i class="ace-icon fa fa-arrow-left bigger-110"></i>返回</a>
            <a href="{{route('g_itembuilding_edit',['id'=>$sdata['itembuilding']->id,'item'=>$sdata['item']->id])}}" class="btn">修改楼栋信息</a>
            <a href="{{route('g_itempublic_add',['item'=>$sdata['item']->id,'land_id'=>$sdata['itembuilding']->land_id,'building_id'=>$sdata['itembuilding']->id])}}" class="btn">添加公共附属物信息</a>
        </div>

        <div class="well-sm">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#itembuilding" aria-expanded="true">
                            <i class="green ace-icon fa fa-building bigger-120"></i>
                            楼栋信息
                        </a>
                    </li>

                    <li class="">
                        <a data-toggle="tab" href="#itempublic" aria-expanded="false">
                            <i class="green ace-icon fa fa-home bigger-120"></i>
                            公共附属物信息
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="itembuilding" class="tab-pane fade active in">
                        <div class="profile-user-info profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> 地块： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['itembuilding']->itemland->address}}</span>
                                </div>
                            </div>
                            
                            <div class="profile-info-row">
                                <div class="profile-info-name"> 楼栋号： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['itembuilding']->building}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 总楼层： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['itembuilding']->total_floor}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 占地面积： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['itembuilding']->area}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 建造年份： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['itembuilding']->build_year}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 结构类型： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['itembuilding']->buildingstruct->name}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 描述： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['itembuilding']->infos}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 图片： </div>
                                <div class="profile-info-value">
                                    <ul class="ace-thumbnails clearfix img-content viewer">
                                        @if(filled($sdata['itembuilding']->gov_pic))
                                            @foreach($sdata['itembuilding']->gov_pic as $pic)
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
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 创建时间： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['itembuilding']->created_at}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 更新时间： </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click">{{$sdata['itembuilding']->updated_at}}</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div id="itempublic" class="tab-pane fade">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>名称</th>
                                <th>计量单位</th>
                                <th>数量</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(filled($sdata['itempublics']))
                                @foreach($sdata['itempublics'] as $public)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$public->name}}</td>
                                        <td>{{$public->num_unit}}</td>
                                        <td>{{$public->gov_num}}</td>
                                        <td>
                                            <a href="{{route('g_itempublic_info',['id'=>$public->id,'item'=>$sdata['item']->id])}}" class="btn btn-sm">查看详情</a>
                                            <a class="btn btn-sm" data-toggle="modal" onclick="del_data({{$public->id}})" data-target="#myModal">删除</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--删除确认弹窗--}}
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">删除确认</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="del_id" value="">
                    你确定要删除本条数据吗？
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary del_ok">确定</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
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
    <script src="{{asset('js/func.js')}}"></script>
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script>
        $('.img-content').viewer('update');

        /*---------弹出删除确认----------*/
        function del_data(id) {
            $('#del_id').val(id);
        }
        /*---------确认删除----------*/
        $('.del_ok').on('click',function(){
            $('#myModal').modal('hide');
            var del_id = $('#del_id').val();
            if(!del_id){
                toastr.error('请选择要删除的数据！');
                return false;
            }
            ajaxAct('{{route('g_itempublic_del')}}',{ id:del_id,item:'{{$sdata['item']->id}}'},'post');
            if(ajaxResp.code=='success'){
                toastr.success(ajaxResp.message);
                if(ajaxResp.url){
                    setTimeout(function () {
                        location.href=ajaxResp.url;
                    },1000);
                }else{
                    setTimeout(function () {
                        location.reload();
                    },1000);
                }
            }else{
                toastr.error(ajaxResp.message);
            }
            return false;
        });

    </script>
@endsection



