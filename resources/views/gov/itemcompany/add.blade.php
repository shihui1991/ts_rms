{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>
    </p>


    <form class="form-horizontal" role="form" action="{{route('g_itemcompany_add')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="item" id="item" value="{{$sdata['item_id']}}">
        <input type="hidden" name="type" id="type" value="{{$sdata['type']}}">

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="company_id"> @if($sdata['type']==0) 房产@else资产@endif评估机构： </label>
            <div class="col-sm-9">
                <select class="col-xs-5 col-sm-5" name="company_id" id="company_id">
                    <option value="">--请选择--</option>
                </select>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right"> <span class="btn"  data-toggle="modal"  data-target="#myModal">【查询被征户】</span> </label>
            <div class="col-sm-9">

            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th><input type="checkbox"></th>
                    <th>ID</th>
                    <th>地块</th>
                    <th>楼栋</th>
                    <th>位置</th>
                    <th>房产类型</th>
                    <th>是否需要资产评估</th>
                </tr>
                </thead>
                <tbody id="search_household">

                </tbody>
            </table>
            <p class="search_household">&nbsp; 请先查询被征收户</p>
            <input type="hidden" id="household_ids" value="">
        </div>
        <div class="space-4"></div>

        <div class="clearfix form-actions">
            <div class="col-md-offset-3 col-md-9">
                <button class="btn btn-info" type="button" onclick="sub_ajax(this)">
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
    {{--查询被征户--}}
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"><i class="ace-icon fa fa-search bigger-110"></i> 查询被征收户</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="land_id">  地块： </label>
                        <div class="col-sm-9">
                            <select class="col-xs-8 col-sm-8" name="land_id" id="land_id">
                                <option value="">--请选择--</option>
                                @foreach($sdata['itemland'] as $itemland)
                                    <option value="{{$itemland->id}}">{{$itemland->address}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <br/>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="building_id">  楼栋： </label>
                        <div class="col-sm-9">
                            <select class="col-xs-8 col-sm-8" name="building_id" id="building_id">
                                <option value="">--请选择--</option>
                                @foreach($sdata['itembuilding'] as $itembuilding)
                                    <option value="{{$itembuilding->id}}">{{$itembuilding->building}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="space-4"></div>

                </div>
                <div class="space-4"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary search_household_checked">查询</button>
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
        /*---------查询评估机构----------*/
       window.onload=function (ev) {
           var type = $('#type').val();
           if(!type){
               toastr.error('请先选择类型');
               return false;
           }
           var data = {
               'app':'app',
               'type':type
           };
           ajaxAct('{{route('g_company')}}',data,'post');
           if(ajaxResp.code=='error'){
               $("#company_id").html('<option value="">--暂无相关数据--</option>');
               toastr.error(ajaxResp.message);
           }else {
               $("#company_id").html('');
               var companyinfo = '<option value="">--请选择--</option>';
               $.each(ajaxResp.sdata,function (index,info) {
                   companyinfo+='<option value="'+info.id+'">--'+info.name+'--</option>';
               });
               $("#company_id").html(companyinfo);
           }
       };
        /*---------查询被征收户----------*/
        $(".search_household_checked").on('click',function(){
            var land_id = $('#land_id').val();
            var building_id = $('#building_id').val();
            var item = $('#item').val();
            if(!land_id){
                toastr.error('请先选择地块');
                return false;
            }
            var type = $('#type').val();
            if(type==1){
                var data = {
                    'item':item,
                    'land_id':land_id,
                    'has_assets':1,
                    'building_id':building_id,
                    'app':'app'
                };
            }else{
                var data = {
                    'item':item,
                    'land_id':land_id,
                    'building_id':building_id,
                    'app':'app'
                };
            }

            ajaxAct('{{route('g_householddetail')}}',data,'post');
            if(ajaxResp.code=='error'){
                toastr.error(ajaxResp.message);
            }else{
                var houseinfo = '';
                if(ajaxResp.sdata.length>0){
                    $('.search_household').html('');
                }
                var household_ids = $("#household_ids").val();
                var household_ids_arr = [];
                if(household_ids){
                  household_ids_arr = household_ids.split(",");
                }
                $.each(ajaxResp.sdata,function (index,info) {
                        if($.inArray(info.household_id.toString(),household_ids_arr) == -1){
                            household_ids_arr.push(info.household_id.toString());
                            var unit = info.household.unit?info.household.unit+'单元':'';
                            var building = info.household.building?info.household.building+'楼':'';
                            var floor = info.household.floor?info.household.floor+'层':'';
                            var number = info.household.number?info.household.number+'号':'';
                            houseinfo+=' <tr>\n' +
                                '                        <td><input type="checkbox" name="household_id[]" value="'+info.household_id+'"></td>\n'+
                                '                        <td>'+info.household_id+'</td>\n' +
                                '                        <td>'+info.itemland.address+'</td>\n' +
                                '                        <td>'+info.itembuilding.building+'</td>\n' +
                                '                        <td>'+unit+building+floor+number+'</td>\n' +
                                '                        <td>'+info.household.type+'</td>\n' +
                                '                        <td>'+info.has_assets+'</td>\n' +
                                '            </tr>';
                        }
                });
                $("#search_household").append(houseinfo);

                $("#household_ids").val(household_ids_arr.join(','));
            }
            $('#myModal').modal('hide');
        });

        /*---------添加----------*/
        function sub_ajax(obj) {
            var type = $('#type').val();
            if(!type){
                toastr.error('请先选择类型');
                return false;
            }
            var company_id = $('#company_id').val();
            if(!company_id){
                toastr.error('请先选择评估机构');
                return false;
            }
            var household_id = $('input[name="household_id[]"]:checked');
            var ids = '';
            for (var i = 0; i < household_id.length; i++) {
                ids += $(household_id[i]).val();
                if (i < household_id.length - 1) ids += ",";
            }
            if(!ids){
                toastr.error('请先勾选被征收户');
                return false;
            }
            sub(obj);
        }
    </script>

@endsection