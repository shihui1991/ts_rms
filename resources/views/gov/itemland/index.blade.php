{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')
    <div class="well well-sm">
        <a href="{{route('g_itemland_add',['item'=>$edata['item_id']])}}" class="btn">添加项目地块</a>
    </div>
    <div class="row">
        <div class="col-xs-12">
            @if($code=='success')
                @foreach($sdata as $infos)
                    <div class="col-xs-6 col-sm-3 pricing-box">
                        <div class="widget-box widget-color-dark">
                            <div class="widget-header">
                                <h5 class="widget-title bigger lighter">{{$infos->address}}</h5>
                                <div class="widget-toolbar" >
                                    <a href=""  data-target="#myModal" onclick="del_data({{$infos->id}})" data-toggle="modal" class="orange2">
                                        <i class="fa fa-trash-o fa-lg"></i>
                                        删除
                                    </a>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">

                                    <div class="profile-user-info profile-user-info-striped">

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 土地性质： </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{$infos->landprop->name}}</span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 土地来源： </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{$infos->landsource->name}}</span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 土地权益状况： </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{$infos->landstate->name}}</span>
                                            </div>
                                        </div>

                                        @if($infos->adminunit->name)
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 公房单位： </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{$infos->adminunit->name}}</span>
                                            </div>
                                        </div>
                                            @else
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> 类型： </div>
                                                <div class="profile-info-value">
                                                    <span class="editable editable-click">私产单位</span>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> 面积： </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click">{{$infos->area}}</span>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div>
                                    <a href="{{route('g_itemland_info',['id'=>$infos->id,'item'=>$infos->item_id])}}" class="btn btn-block btn-inverse">
                                        <span>进入地块</span>
                                        <i class="ace-icon fa fa-chevron-circle-right bigger-110"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="row">
            <div class="col-xs-6">
                <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">共 @if($code=='success') {{ $sdata->total() }} @else 0 @endif 条数据</div>
            </div>
            <div class="col-xs-6">
                <div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
                    @if($code=='success') {{ $sdata->links() }} @endif
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
                    <input type="hidden" id="del_url" value="">
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

@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script>
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
            ajaxAct('{{route('g_itemland_del')}}',{ id:del_id,item:'{{$infos->item_id}}'},'post');
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