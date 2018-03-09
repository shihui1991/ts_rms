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


    <form class="form-horizontal" role="form" action="{{route('c_compublic_edit')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="item" id="item" value="{{$sdata['item_id']}}">
        <input type="hidden" name="id" id="id" value="{{$edata->id}}">
        <div class="widget-body">
            <div class="widget-main padding-8">

                <div class="form-group img-box">
                    <label class="col-sm-3 control-label no-padding-right">
                        评估报告：<br>
                        <span class="btn btn-xs">
                        <span>上传图片</span>
                            <input type="file" accept="image/*" class="hidden" data-name="picture[]" multiple  onchange="uplfile(this)">
                        </span>
                    </label>
                    <div class="col-sm-9">
                        <ul class="ace-thumbnails clearfix img-content viewer">
                            @if($edata->picture)
                                @foreach($edata->picture as $pic)
                                    <li>
                                        <div>
                                            <img width="120" height="120" src="{!! $pic !!}" alt="加载失败">
                                            <input type="hidden" name="picture[]" value="{!! $pic !!}">
                                            <div class="text">
                                                <div class="inner">
                                                    <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                                    <a onclick="removeimg(this)"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="space-4 header green"></div>

            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right"> <span class="btn"  data-toggle="modal"  data-target="#myModal">【查询公共附属物】</span> </label>
            <div class="col-sm-9">
                <label class="col-sm-6" style="line-height: 53px;"><span style="color: red;">温馨提示：仅会对勾选的公共附属物进行评估。</span></label>
            </div>
        </div>
        <div class="space-4"></div>

        <div class="form-group">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th><input type="checkbox"></th>
                    <th>序号</th>
                    <th>地块</th>
                    <th>名称</th>
                    <th>计量单位</th>
                    <th>数量</th>
                    <th>评估单价</th>
                </tr>
                </thead>
                <tbody id="search_public">
                    @foreach($sdata['compublicdetail'] as $info)
                        <tr>
                            <td><input type="checkbox" name="item_public_id[]" value="{{$info->item_public_id}}" checked></td>
                            <td>{{$info->item_public_id}}</td>
                            <td>{{$info->itemland->address}}</td>
                            <td>{{$info->itempublic->name}}</td>
                            <td>{{$info->itempublic->num_unit}}</td>
                            <td>{{$info->itempublic->number}}</td>
                            <td><input type="text" name="price[{{$info->item_public_id}}]" value="{{$info->price}}"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p class="search_public">&nbsp; </p>
            <input type="hidden" id="public_ids" value="{{$sdata['publicids']}}">
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
                    <h4 class="modal-title" id="myModalLabel"><i class="ace-icon fa fa-search bigger-110"></i> 查询公共附属物</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="land_id">  地块： </label>
                        <div class="col-sm-9">
                            <select class="col-xs-8 col-sm-8" name="land_id" id="land_id">
                                <option value="">--请选择--</option>
                                @foreach($sdata['companyhousehold'] as $itemland)
                                    <option value="{{$itemland->household->itemland->id}}">{{$itemland->household->itemland->address}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <br/>
                </div>
                <div class="space-4"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary search_public_checked">查询</button>
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
        /*---------查询被征收户----------*/
        $(".search_public_checked").on('click',function(){
            var land_id = $('#land_id').val();
            var item = $('#item').val();
            if(!land_id){
                toastr.error('请先选择地块');
                return false;
            }
            var data = {
                'item':item,
                'land_id':land_id,
                'app':app
            };
            ajaxAct('{{route('g_itempublic')}}',data,'post');
            if(ajaxResp.code=='error'){
                $('.search_public').html('&nbsp; 暂无对应公共附属物');
                toastr.error(ajaxResp.message);
            }else{
                var houseinfo = '';
                if(ajaxResp.sdata.length>0){
                    $('.search_public').html('');
                }
                var public_ids = $("#public_ids").val();
                var public_ids_arr = [];
                if(public_ids){
                  public_ids_arr = public_ids.split(",");
                }
                $.each(ajaxResp.sdata,function (index,info) {
                    if($.inArray(info.id.toString(),public_ids_arr) == -1){
                        public_ids_arr.push(info.id.toString());
                        houseinfo+=' <tr>\n' +
                            '                        <td><input type="checkbox" name="item_public_id[]" value="'+info.id+'"></td>\n'+
                            '                        <td>'+info.id+'</td>\n' +
                            '                        <td>'+info.itemland.address+'</td>\n' +
                            '                        <td>'+info.name+'</td>\n' +
                            '                        <td>'+info.num_unit+'</td>\n' +
                            '                        <td>'+info.number+'</td>\n' +
                            '                        <td><input type="text" name="price['+info.id+']"></td>\n' +
                            '            </tr>';
                    }
                });
                $("#search_public").append(houseinfo);

                $("#public_ids").val(public_ids_arr.join(','));
            }
            $('#myModal').modal('hide');
        });

        /*--------- 评估附属物 ----------*/
        function sub_ajax(obj) {
            var picture = $('input[name="picture[]"]');
            if(picture.length<=0){
                toastr.error('请先上传评估报告');
                return false;
            }
            var idss = $('input[name="item_public_id[]"]:checked');
            var ids = '';
            for (var i = 0; i < idss.length; i++) {
                ids += $(idss[i]).val();
                if (i < idss.length - 1) ids += ",";
            }
            if(!ids){
                toastr.error('请先勾选公共附属物');
                return false;
            }
            while($('input[name="item_public_id[]"]').not($('input[name="item_public_id[]"]:checked')).length>0){
                var public_ids = $("#public_ids").val();
                var public_ids_arr = [];
                if(public_ids){
                    public_ids_arr = public_ids.split(",");
                }
                public_ids_arr.splice($.inArray($('input[name="item_public_id[]"]').not($('input[name="item_public_id[]"]:checked')).val().toString(),public_ids_arr),1);
                $("#public_ids").val(public_ids_arr.join(','));
                $('input[name="item_public_id[]"]').not($('input[name="item_public_id[]"]:checked')).parents('tr:first').remove();
            }
            if(!ids){
                toastr.error('请先勾选公共附属物');
                return false;
            }
            sub(obj);
        }
    </script>

@endsection