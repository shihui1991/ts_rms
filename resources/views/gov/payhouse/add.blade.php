{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')


    <div class="widget-box widget-color-blue2">
        <div class="widget-header">
            <h4 class="widget-title lighter smaller">当前选择房源：</h4>
        </div>
        <div class="widget-body">
            <div class="widget-main padding-8">

                <form class="form-horizontal" role="form" action="{{route('g_payhouse_add',['item'=>$sdata['item']->id])}}" method="post" id="house-choose-form">
                    {{csrf_field()}}

                    <input type="hidden" name="reserve_id" value="{{$sdata['reserve']->id}}">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>地址</th>
                        <th>社区</th>
                        <th>房号</th>
                        <th>户型</th>
                        <th>面积</th>
                        <th>类型</th>
                        <th>市场价</th>
                        <th>优惠价</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody id="choose-house">

                    </tbody>
                </table>

                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="btn btn-info" type="button" onclick="sub(this)">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                                保存
                            </button>
                            &nbsp;&nbsp;&nbsp;
                            <button class="btn" type="reset">
                                <i class="ace-icon fa fa-undo bigger-110"></i>
                                重置
                            </button>
                        </div>
                    </div>

                </form>


                <div class="widget-container-col ui-sortable">
                    <div class="widget-box ui-sortable-handle">
                        <div class="widget-header">
                            <h5 class="widget-title">计算结果（有效产权调换房）</h5>

                            <div class="widget-toolbar">
                                <a href="#" data-action="collapse">
                                    <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main padding-8">
                                <table class="table table-hover table-bordered treetable" id="treetable">
                                    <thead>
                                    <tr>
                                        <th>地址</th>
                                        <th>社区</th>
                                        <th>房号</th>
                                        <th>户型</th>
                                        <th>面积</th>
                                        <th>类型</th>
                                        <th>市场价</th>
                                        <th>优惠价</th>
                                        <th>优惠房价</th>
                                        <th>优惠上浮</th>
                                        <th>房屋总价</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="2">补偿总额：{{number_format($sdata['reserve']->pay->total,2)}} 元</th>
                                        <th class="2">上浮面积：<span id="plus_area">0</span> ㎡</th>
                                        <th colspan="7">产权调换后结余：<span id="last_total">{{number_format($sdata['reserve']->pay->total,2)}}</span> 元（负数则表示被征收户需补交上浮房款）</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <h3 class="header smaller red">所有房源</h3>
    <div class="row" id="house-list">

    </div>
    <div>
        <p id="pagebar"></p>
    </div>

    
@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script>
        var houselist_temp=@json($sdata['houses']);
        var choose_houses=[];
        var choose_house_ids=[];

        houselist(houselist_temp,{page:1});

        // 选择房屋
        $('#house-list').on('click','input[name="house_list"]',function () {
            var checkbox=$(this);
            var index=checkbox.data('index');
            var house_id=checkbox.val();
            var house_temp=houselist_temp[index];
            if(checkbox.prop('checked')){
                if(!choose_house_ids || !choose_house_ids.length || $.inArray(house_id,choose_house_ids) == -1){
                    choose_houses.push(house_temp);
                    choose_house_ids.push(house_id);
                    var transit='';
                    if(house_temp.is_transit=='可作临时周转'){
                        transit='<label class="btn btn-white btn-bold"><input type="checkbox" name="transits[]" value="'+house_temp.id+'">&nbsp;选择作为临时周转房</label>';
                    }

                    var str='<tr id="house-'+house_temp.id+'">' +
                        '<td>'+house_temp.housecommunity.address+'</td>' +
                        '<td>'+house_temp.housecommunity.name+'</td>' +
                        '<td>'+ house_temp.building+ '栋'+house_temp.unit+'单元'+house_temp.floor+'楼'+house_temp.number+($.isNumeric(house_temp.number)?'号':'')+'</td>'+
                        '<td>'+house_temp.layout.name+'</td>' +
                        '<td>'+house_temp.area+'</td>' +
                        '<td>'+house_temp.is_real+'</td>' +
                        '<td>'+house_temp.itemhouseprice.market+'</td>' +
                        '<td>'+house_temp.itemhouseprice.price+'</td>' +
                        '<td><input type="hidden" name="house_ids[]" value="'+house_temp.id+'">' +
                        '<div class="btn-group">' +
                        transit+
                        '<button class="btn btn-xs" onclick="removeHouse('+house_id+');">删除</button>' +
                        '</div></td>' +
                        '</tr>';
                    $('#choose-house').append(str);
                }
            }else{
                if(choose_house_ids && choose_house_ids.length && $.inArray(house_id,choose_house_ids) != -1){
                    choose_houses.splice($.inArray(house_temp,houselist_temp),1);
                    choose_house_ids.splice($.inArray(house_id,choose_house_ids),1);
                }
                $('#house-'+house_temp.id).remove();
            }
            houseCalculate();
        });

        // 选择临时周转房
        $('#choose-house').on('click','input[name="transits[]"]',function () {
            houseCalculate();
        });

        // 计算
        function houseCalculate() {
            toastr.info('请稍等！计算中……');
            ajaxAct('{{route('g_payhouse_cal',['item'=>$sdata['item']->id,'reserve_id'=>$sdata['reserve']->id])}}',$('#house-choose-form').serialize(),'post');

            var plus_area=0;
            var last_total=0;
            var tr='';
            if(ajaxResp.code=='success'){
                plus_area=ajaxResp.sdata.plus_area;
                last_total=ajaxResp.sdata.last_total;
                $.each(ajaxResp.sdata.resettles,function (index,info) {
                    tr +='<tr>' +
                        '<td>'+info.housecommunity.address+'</td>' +
                        '<td>'+info.housecommunity.name+'</td>' +
                        '<td>'+ info.building+ '栋'+info.unit+'单元'+info.floor+'楼'+info.number+($.isNumeric(info.number)?'号':'')+'</td>'+
                        '<td>'+house_temp.area+'</td>' +
                        '<td>'+info.is_real+'</td>' +
                        '<td>'+info.itemhouseprice.market+'</td>' +
                        '<td>'+info.itemhouseprice.price+'</td>' +
                        '<td>'+info.amount+'</td>' +
                        '<td>'+info.amount_plus+'</td>' +
                        '<td>'+info.total+'</td>' +
                        '</tr>';
                });
            }else{
                toastr.error(ajaxResp.message);
            }
            $('#treetable').find('tbody').html(tr);
            $('#plus_area').html(plus_area);
            $('#last_total').html(last_total);
        }

        // 删除房屋
        function removeHouse(house_id) {
            $('#house-'+house_id).remove();
            choose_houses.splice($.inArray(house_id,choose_house_ids),1);
            choose_house_ids.splice($.inArray(house_id,choose_house_ids),1);
            houseCalculate();
        }

        // 获取
        function getHouses(data) {
            toastr.info('请稍等！处理中……');
            ajaxAct('{{route('g_payhouse_add',['item'=>$sdata['item']->id,'reserve_id'=>$sdata['reserve']->id])}}',data,'get');
            if(ajaxResp.code=='success'){
                houselist_temp=ajaxResp.sdata.houses;
                houselist(houselist_temp,data);
            }else{
                toastr.error(ajaxResp.message);
            }
        }

        // 生成列表
        function houselist(houses,data) {
            var house_list='';
            $.each(houses.data,function (index,info) {
                var checked='';
                if(choose_house_ids && choose_house_ids.length && $.inArray(info.id,choose_house_ids) >-1){
                    checked='checked';
                }
                house_list +='<div class="col-xs-6 col-sm-3 pricing-box">'+
                    '<div class="widget-box widget-color-green pricing-box-small">'+
                    '<div class="widget-header">'+
                    '<h5 class="widget-title bigger lighter">'+info.housecommunity.name+'</h5>'+
                    '</div>'+
                    '<div class="widget-body">'+
                    '<div class="widget-main">'+
                    '<ul class="list-unstyled spaced2">'+
                    '<li><i class="ace-icon fa fa-circle green"></i>'+ info.housecommunity.address+ '</li>'+
                    '<li><i class="ace-icon fa fa-circle green"></i>'+ info.building+ '栋'+info.unit+'单元'+info.floor+'楼'+info.number+($.isNumeric(info.number)?'号':'')+'</li>'+
                    '<li><i class="ace-icon fa fa-circle green"></i>'+ info.area+ ' ㎡</li>'+
                    '<li><i class="ace-icon fa fa-circle green"></i>'+ info.layout.name+ '</li>'+
                    '<li><i class="ace-icon fa fa-circle green"></i>'+ info.is_real+ '</li>'+
                    '<li><i class="ace-icon fa fa-circle green"></i>市场评估价：'+ info.itemhouseprice.market+ '</li>'+
                    '<li><i class="ace-icon fa fa-circle green"></i>安置优惠价：'+ info.itemhouseprice.price+ '</li>'+
                    '</ul>'+
                    '<hr>'+
                    '<div class="price checkbox">'+
                    '<label class="block">'+
                    '<input name="house_list" type="checkbox" class="ace input-lg" data-index="'+index+'" value="'+info.id+'" '+checked+'>'+
                    '<span class="lbl bigger-120"> 选择</span>'+
                    '</label>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>';
            });
            $('#house-list').html(house_list);
            $('#pagebar').pagination({
                totalData:houses.total,
                showData:houses.per_page,
                current:houses.current_page,
                jump:false,
                coping:true,
                homePage:'首页',
                endPage:'末页',
                prevContent:'上一页',
                nextContent:'下一页',
                callback:function(api){
                    var cur=api.getCurrent();
                    data.page=cur;
                    getHouses(data);
                }
            },function(api){
                var cur=api.getCurrent();
            });
        }

    </script>

@endsection