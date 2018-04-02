{{-- 继承aceAdmin后台布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')
    <div class="well well-sm">
        <a href="{{route('g_company_add',['type'=>0])}}" class="btn">添加房产评估机构</a>
        <a href="{{route('g_company_add',['type'=>1])}}" class="btn">添加资产评估机构</a>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="widget-box widget-color-blue2">
                <div class="widget-header">
                    <h4 class="widget-title lighter smaller">房产评估机构：</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main padding-8">

                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>机构名称</th>
                                <th>地址</th>
                                <th>电话</th>
                                <th>传真</th>
                                <th>联系人</th>
                                <th>手机号</th>
                                <th>状态</th>
                                <th>描述</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($code=='success')
                                @foreach($sdata as $infos)
                                    @if($infos->getOriginal('type')==0)
                                    <tr>
                                        <td>【房产】{{$infos->name}}</td>
                                        <td>{{$infos->address}}</td>
                                        <td>{{$infos->phone}}</td>
                                        <td>{{$infos->fax}}</td>
                                        <td>{{$infos->contact_man}}</td>
                                        <td>{{$infos->contact_tel}}</td>
                                        <td>{{$infos->code}}</td>
                                        <td>{{$infos->infos}}</td>
                                        <td>
                                            <a href="{{route('g_company_info',['id'=>$infos->id])}}" class="btn btn-sm">查看详情</a>
                                            <a href="{{route('g_companyuser',['company_id'=>$infos->id])}}" class="btn btn-sm">操作员</a>
                                            <a href="{{route('g_companyvaluer',['company_id'=>$infos->id])}}" class="btn btn-sm">评估师</a>
                                            <a class="btn btn-sm" data-toggle="modal" onclick="del_data({{$infos->id}})" data-target="#myModal">删除</a>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">共 @if($code=='success') {{ $edata['typecount'] }} @else 0 @endif 条数据</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="widget-box widget-color-green2">
                <div class="widget-header">
                    <h4 class="widget-title lighter smaller">资产评估机构：</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main padding-8">

                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>机构名称</th>
                                <th>地址</th>
                                <th>电话</th>
                                <th>传真</th>
                                <th>联系人</th>
                                <th>手机号</th>
                                <th>状态</th>
                                <th>描述</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($code=='success')
                                @foreach($sdata as $infos)
                                    @if($infos->getOriginal('type')==1)
                                    <tr>
                                        <td>【资产】{{$infos->name}}</td>
                                        <td>{{$infos->address}}</td>
                                        <td>{{$infos->phone}}</td>
                                        <td>{{$infos->fax}}</td>
                                        <td>{{$infos->contact_man}}</td>
                                        <td>{{$infos->contact_tel}}</td>
                                        <td>{{$infos->code}}</td>
                                        <td>{{$infos->infos}}</td>
                                        <td>
                                            <a href="{{route('g_company_info',['id'=>$infos->id])}}" class="btn btn-sm">查看详情</a>
                                            <a href="{{route('g_companyuser',['company_id'=>$infos->id])}}" class="btn btn-sm">操作员</a>
                                            <a href="{{route('g_companyvaluer',['company_id'=>$infos->id])}}" class="btn btn-sm">评估师</a>
                                            <a class="btn btn-sm" data-toggle="modal" onclick="del_data({{$infos->id}})" data-target="#myModal">删除</a>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">共 @if($code=='success') {{ $edata['typecounts'] }} @else 0 @endif 条数据</div>
                            </div>
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
            }
            ajaxAct('{{route('g_company_del')}}',{ id:del_id},'post');
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
                if(ajaxResp.url){
                    setTimeout(function () {
                        location.href=ajaxResp.url;
                    },1000);
                }else{
                    setTimeout(function () {
                        location.reload();
                    },1000);
                }
            }
            return false;
        });
    </script>
@endsection