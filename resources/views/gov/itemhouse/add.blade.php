{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>
        <span class="btn" data-toggle="modal"  data-target="#myModal">
            <i class="ace-icon fa fa-search bigger-110"></i>
            查询房源
        </span>
        <button class="btn btn-info" type="button" id="btn-choose-house">
            <i class="ace-icon fa fa-check bigger-110"></i>
            保存
        </button>
    </p>

    <div class="widget-box widget-color-green2">
        <div class="widget-header">
            <h4 class="widget-title lighter smaller">当前选择：</h4>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                    展开/关闭
                </a>
            </div>
        </div>
        <div class="widget-body">
            <div class="widget-main padding-8">
                <form class="form-horizontal" role="form" action="{{route('g_itemhouse_add',['item'=>$sdata['item_id']])}}" method="post" id="form-choose-house">
                    {{csrf_field()}}
                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>房源ID</th>
                            <th>管理机构</th>
                            <th>房源社区</th>
                            <th>户型</th>
                            <th>位置</th>
                            <th>面积</th>
                            <th>总楼层</th>
                            <th>是否电梯房</th>
                            <th>类型</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="choose-house">

                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>

    {{--查询房源--}}
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"><i class="ace-icon fa fa-search bigger-110"></i> 查询房源</h4>
                </div>
                <div class="modal-body">
                    <div class="well">
                        <form action="{{route('g_house')}}" role="form" method="get" class="form-inline" id="form-search-house">
                            {{csrf_field()}}
                            <input type="hidden" name="page" value="1" id="current-page">
                            <input type="hidden" name="code" value="150">
                            <div class="form-group">
                                <label for="community_id">小区：</label>
                                <select class="form-control" name="community_id" id="community_id">
                                    <option value="">--全部--</option>
                                    @if(filled($sdata['communitys']))
                                    @foreach($sdata['communitys'] as $community)
                                        <option value="{{$community->id}}">{{$community->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="layout_id">户型：</label>
                                <select class="form-control" name="layout_id" id="layout_id">
                                    <option value="">--全部--</option>
                                    @if(filled($sdata['layouts']))
                                    @foreach($sdata['layouts'] as $layout)
                                        <option value="{{$layout->id}}">{{$layout->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="area_start">面积：</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="area_start" name="area_start">
                                <label for="area_end"> - </label>
                                <input type="number" step="0.01" min="0" class="form-control" id="area_end" name="area_end">
                            </div>
                            <button type="button" class="btn btn-info btn-sm" id="btn-search-house">查询</button>
                        </form>
                    </div>
                    <table class="table table-hover table-bordered" id="table-search-house">
                        <thead>
                        <tr>
                            <th><input type="checkbox"></th>
                            <th>房源ID</th>
                            <th>房源社区</th>
                            <th>户型</th>
                            <th>面积</th>
                            <th>总楼层</th>
                            <th>是否电梯房</th>
                            <th>类型</th>
                        </tr>
                        </thead>
                        <tbody id="search-house">

                        </tbody>
                    </table>
                    <div id="pagebar">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">确定</button>
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
    <script src="{{asset('pagination/jquery.pagination.min.js')}}"></script>
    <script>
        // 数据保存
        $('#btn-choose-house').on('click',function () {
            var btn=$(this);
            var form=$('#form-choose-house');
            if(btn.data('loading')||btn.hasClass('disabled')){
                return false;
            }
            btn.data('loading',true).addClass('disabled');
            toastr.info('请稍等！处理中……');
            ajaxAct(form.attr('action'),form.serialize(),'post');
            if(ajaxResp.code=='success'){
                toastr.success(ajaxResp.message);
                setTimeout(function () {
                    location.href=ajaxResp.url;
                },1000);
            }else{
                toastr.error(ajaxResp.message);
                btn.data('loading',false).removeClass('disabled');
            }
            return false;
        });
        // 查询房源
        $('#btn-search-house').on('click',function () {
            var btn=$(this);
            var form=$('#form-search-house');
            if(btn.data('loading')||btn.hasClass('disabled')){
                return false;
            }
            btn.data('loading',true).addClass('disabled');
            toastr.info('请稍等！查询中……');
            $('#current-page').val(1);
            getHouse(form);
            btn.data('loading',false).removeClass('disabled');
        });
        // 选择房源
        var choose_house_ids=[];
        var choose_houses=[];
        $('#table-search-house').on('change',function () {
            var checkboxes=$(this).find('tbody').find('input[type="checkbox"]');
            if(checkboxes && checkboxes.length){
                var tr='';
                $.each(checkboxes,function (index,obj) {
                    var checkbox=$(obj);
                    var house_id=checkbox.val();
                    var pos=$.inArray(house_id,choose_house_ids);
                    if(checkbox.prop('checked')){
                        if(pos == -1){
                            var info=ajaxResp.sdata.data[index];
                            choose_house_ids.push(house_id);
                            choose_houses.push(info);

                            var building = info.building ? info.building + '栋' : '';
                            var unit = info.unit ? info.unit + '单元' : '';
                            var floor = info.floor ? info.floor + '楼' : '';
                            var number = info.number ? info.number + '号' : '';
                            tr += ' <tr id="house-'+info.id+'">' +
                                '<td><input type="hidden" name="house_ids[]" value="'+info.id+'">' + info.id + '</td>' +
                                '<td>' + info.housecompany.name + '</td>' +
                                '<td>' + info.housecommunity.name + '</td>' +
                                '<td>' + info.layout.name + '</td>' +
                                '<td>' + building+ unit + floor + number + '</td>' +
                                '<td>' + info.area + '</td>' +
                                '<td>' + info.total_floor + '</td>' +
                                '<td>' + info.lift + '</td>' +
                                '<td>' + info.is_real + '|' + info.is_buy + '|' + info.is_transit + '|' + info.is_public + '</td>' +
                                '<td><a class="btn btn-sm" onclick="removeHouse('+house_id+')">删除</a></td>' +
                                '</tr>';
                        }
                    }else{
                        if(pos>-1){
                            removeHouse(house_id);
                        }
                    }

                });
                $('#choose-house').append(tr);
            }
        });
        // 删除选择
        function removeHouse(house_id) {
            var pos=$.inArray(house_id.toString(),choose_house_ids);
            if(pos>-1){
                choose_house_ids.splice(pos,1);
                choose_houses.splice(pos,1);
                $('#house-'+house_id).remove();
            }
        }
        // 获取房源
        function getHouse(form) {
            ajaxAct(form.attr('action'),form.serialize(),'get');
            var tr='';
            if(ajaxResp.code=='success'){
                toastr.success('获取到 '+ajaxResp.sdata.data.length+' 条数据');
                $.each(ajaxResp.sdata.data,function (index,info) {

                    var checked='';
                    if($.inArray(info.id.toString(),choose_house_ids)>-1){
                        checked='checked';
                    }
                    tr += ' <tr>' +
                        '<td><input type="checkbox" value="' + info.id + '" '+checked+'></td>' +
                        '<td>' + info.id + '</td>' +
                        '<td>' + info.housecommunity.name + '</td>' +
                        '<td>' + info.layout.name + '</td>' +
                        '<td>' + info.area + '</td>' +
                        '<td>' + info.total_floor + '</td>' +
                        '<td>' + info.lift + '</td>' +
                        '<td>' + info.is_real + '|' + info.is_transit + '</td>' +
                        '</tr>';
                });
                $('#pagebar').pagination({
                    totalData:ajaxResp.sdata.total,
                    showData:ajaxResp.sdata.per_page,
                    current:ajaxResp.sdata.current_page,
                    jump:false,
                    coping:true,
                    homePage:'首页',
                    endPage:'末页',
                    prevContent:'上一页',
                    nextContent:'下一页',
                    callback:function(api){
                        var cur=api.getCurrent();
                        $('#current-page').val(cur);
                        getHouse(form);
                    }
                },function(api){
                    var cur=api.getCurrent();
                    $('#current-page').val(cur);
                });
            }else{
                toastr.error(ajaxResp.message);
                $('#pagebar').html('');
                $('#current-page').val(1);
            }
            $('#search-house').html(tr);
        }

    </script>

@endsection