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

                <form class="form-horizontal" role="form" action="{{route('g_payreserve_house',['item'=>$sdata['item']->id])}}" method="post">
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

        $('#house-list').on('click','input[name="house_list"]',function () {
            var checkbox=$(this);
            var index=checkbox.data('index');
            var house_id=checkbox.val();
            var house_temp=houselist_temp[index];
            if(checkbox.prop('checked')){
                if(!choose_house_ids || !choose_house_ids.length || $.inArray(house_id,choose_house_ids) == -1){
                    choose_houses.push(house_temp);
                    choose_house_ids.push(house_id);
                }
            }else{
                if(choose_house_ids && choose_house_ids.length && $.inArray(house_id,choose_house_ids) != -1){
                    choose_houses.splice($.inArray(house_temp,houselist_temp),1);
                    choose_house_ids.splice($.inArray(house_id,choose_house_ids),1);
                }
            }
        });

        function getHouses(data) {
            ajaxAct('{{route('g_payreserve_house',['item'=>$sdata['item']->id,'reserve_id'=>$sdata['reserve']->id])}}',data,'get');
            if(ajaxResp.code=='success'){
                houselist_temp=ajaxResp.sdata.houses;
                houselist(houselist_temp,data);
            }else{
                toastr.error(ajaxResp.message);
            }
        }

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
                    '<li><i class="ace-icon fa fa-circle green"></i>'+ info.housecommunity.name+ '</li>'+
                    '<li><i class="ace-icon fa fa-circle green"></i>'+ info.building+ '栋'+info.unit+'单元'+info.floor+'楼'+info.number+($.isNumeric(info.number)?'号':'')+'</li>'+
                    '<li><i class="ace-icon fa fa-circle green"></i>'+ info.area+ ' ㎡</li>'+
                    '<li><i class="ace-icon fa fa-circle green"></i>'+ info.layout.name+ '</li>'+
                    '<li><i class="ace-icon fa fa-circle green"></i>'+ info.is_real+ '</li>'+
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