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
    </p>


    <form class="form-horizontal" role="form" action="{{route('g_itemhouse_add')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="item" value="{{$sdata['item_id']}}">
        <div class="form-group">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th><input type="checkbox"></th>
                    <th>ID</th>
                    <th>管理机构</th>
                    <th>房源社区</th>
                    <th>户型</th>
                    <th>位置</th>
                    <th>面积</th>
                    <th>总楼层</th>
                    <th>是否电梯房</th>
                    <th>类型</th>
                    <th>交付日期</th>
                    <th>房源状态</th>
                </tr>
                </thead>
                <tbody id="search_house">

                </tbody>
            </table>
            <p class="search_house">&nbsp; 请先查询房源</p>
        </div>
        <div class="space-4"></div>

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

    {{--查询房源--}}
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"><i class="ace-icon fa fa-search bigger-110"></i> 查询房源</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="community_id">  所在房源社区： </label>
                        <div class="col-sm-9">
                            <select class="col-xs-5 col-sm-5" name="community_id" id="community_id">
                                <option value="">--请选择社区--</option>
                                @foreach($sdata['housecommunity'] as $housecommunity)
                                    <option value="{{$housecommunity->id}}">{{$housecommunity->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <br/>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="layout_id">  房屋户型： </label>
                        <div class="col-sm-9">
                            <select class="col-xs-5 col-sm-5" name="layout_id" id="layout_id">
                                <option value="">--请选择房屋户型--</option>
                                @foreach($sdata['layout'] as $layout)
                                    <option value="{{$layout->id}}">{{$layout->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="space-4"></div>
                </div><div class="space-4"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary search_house_checked">查询</button>
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
    <script src="{{asset('js/func.js')}}"></script>
    <script>
        /*---------查询房源----------*/
        $(".search_house_checked").on('click',function(){
            var community_id = $('#community_id').val();
            var layout_id = $('#layout_id').val();
            var data = {
                'community_id':community_id,
                'layout_id':layout_id,
                'state':0
            };
            ajaxAct('{{route('g_house')}}',data,'post');
            if(ajaxResp.code=='error'){
                $("#search_house").html('');
                toastr.error(ajaxResp.message);
            }else{
                $("#search_house").html('');
                console.log(ajaxResp.sdata.data);
                var houseinfo = '';
                $.each(ajaxResp.sdata.data,function (index,info) {
                    var unit = info.unit?info.unit+'单元':'';
                    var building = info.building?info.building+'楼':'';
                    var floor = info.floor?info.floor+'层':'';
                    var number = info.number?info.number+'号':'';
                    houseinfo+=' <tr>\n' +
                        '                    <td><input type="checkbox" name="house_id[]" value="'+info.id+'"></td>\n'+
                        '                        <td>'+info.id+'</td>\n' +
                        '                        <td>'+info.housecompany.name+'</td>\n' +
                        '                        <td>'+info.housecommunity.name+'</td>\n' +
                        '                        <td>'+info.layout.name+'</td>\n' +
                        '                        <td>'+unit+building+floor+number+'</td>\n' +
                        '                        <td>'+info.area+'</td>\n' +
                        '                        <td>'+info.total_floor+'</td>\n' +
                        '                        <td>'+info.lift+'</td>\n' +
                        '                        <td>'+info.is_real+'|'+info.is_buy+'|'+info.is_transit+'|'+info.is_public+'</td>\n' +
                        '                        <td>'+info.delive_at+'</td>\n' +
                        '                        <td>'+info.state+'</td>\n' +
                        '            </tr>'
                });
                $("#search_house").html(houseinfo);
            }
            $('#myModal').modal('hide');
        });
    </script>

@endsection