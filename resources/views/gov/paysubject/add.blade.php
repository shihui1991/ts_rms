{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <div class="well well-sm">
        <a href="javascript:history.back();" class="btn">返回</a>
    </div>

    <div class="row">
        <div class="col-sm-7 col-xs-12">
            <div class="widget-container-col ui-sortable">
                <div class="widget-box ui-sortable-handle">
                    <div class="widget-header">
                        <h5 class="widget-title">添加补偿科目</h5>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">

                            <form class="form-horizontal" role="form" action="{{route('g_paysubject_add',['item'=>$sdata['item']->id])}}" method="post">
                                {{csrf_field()}}

                                <input type="hidden" name="pay_id" value="{{$sdata['pay']->id}}">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="subject_id"> 补偿科目： </label>
                                    <div class="col-sm-9 ">
                                        <select name="subject_id" id="subject_id" class="col-xs-10 col-sm-10">
                                            <option value="">请选择补偿科目</option>
                                            @foreach($sdata['subjects'] as $subject)
                                                <option value="{{$subject->id}}" data-index="{{$loop->index}}">{{$subject->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="infos"> 补偿说明： </label>
                                    <div class="col-sm-9 ">
                                        <textarea name="infos" id="infos" readonly placeholder="请选择补偿科目" class="col-xs-10 col-sm-10"></textarea>
                                    </div>
                                </div>
                                <div class="space-4"></div>

                                <div class="clearfix form-actions" id="form-actions">
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
            </div>
        </div>
        <div class="col-sm-5 col-xs-12">
            <div class="widget-container-col ui-sortable">
                <div class="widget-box ui-sortable-handle">
                    <div class="widget-header">
                        <h5 class="widget-title">被征收户</h5>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="profile-user-info profile-user-info-striped">

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 项目： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['item']->name}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 地址： </div>
                                    <div class="profile-info-value">
                                        <span class="editable editable-click">{{$sdata['household']->itemland->address}}</span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 房号： </div>
                                    <div class="profile-info-value">
                                <span class="editable editable-click">
                                    {{$sdata['household']->itembuilding->building}}栋{{$sdata['household']->unit}}单元{{$sdata['household']->floor}}楼{{$sdata['household']->number}}@if(is_numeric($sdata['household']->number))号@endif
                                </span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 类型： </div>
                                    <div class="profile-info-value">
                                    <span class="editable editable-click">
                                        @if($sdata['household']->getOriginal('type'))
                                            公产（{{$sdata['household']->itemland->adminunit->name}}）
                                        @else
                                            私产
                                        @endif
                                    </span>
                                    </div>
                                </div>

                            </div>
                        </div>
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
    <script src="{{asset('laydate/laydate.js')}}"></script>
    <script>
        var subjects=@json($sdata['subjects']);
        $('#subject_id').on('change',function () {
            var option=$(this).find('option:selected');
            var infos='';
            var subject_id=option.val();
            var items='';
            if(subject_id){
                infos=subjects[option.data('index')].infos;
            }
            switch (subject_id){
                case '7':
                case '8':
                case '10':
                case '17':
                    items='<div class="form-group items">' +
                        '    <label class="col-sm-3 control-label no-padding-right" for="calculate"> 补偿计算公式： </label>' +
                        '    <div class="col-sm-9 ">' +
                        '        <textarea name="calculate" id="calculate" class="col-xs-10 col-sm-10"></textarea>' +
                        '    </div>' +
                        '</div>' +
                        '<div class="space-4 items"></div>' +
                        '<div class="form-group items">' +
                        '    <label class="col-sm-3 control-label no-padding-right" for="amount"> 补偿金额： </label>' +
                        '    <div class="col-sm-9 ">' +
                        '        <input type="number" min="0" step="0.01" name="amount" id="amount" class="col-xs-10 col-sm-10">' +
                        '    </div>' +
                        '</div>' +
                        '<div class="space-4 items"></div>';
                    break;

                case '11':
                case '12':
                    items='<div class="form-group items">' +
                        '    <label class="col-sm-3 control-label no-padding-right" for="sign_at"> 签约时间： </label>' +
                        '    <div class="col-sm-9 ">' +
                        '        <input type="text" name="sign_at" id="sign_at" class="col-xs-10 col-sm-10 laydate">' +
                        '    </div>' +
                        '</div>' +
                        '<div class="space-4 items"></div>';
                    break;

                case '13':
                    items='<div class="form-group items">' +
                        '    <label class="col-sm-3 control-label no-padding-right" for="transit_at"> 临时安置时间： </label>' +
                        '    <div class="col-sm-9 ">' +
                        '        <input type="text" name="transit_at" id="transit_at" class="col-xs-10 col-sm-10 laydate" data-type="month" data-format="yyyy-MM">' +
                        '    </div>' +
                        '</div>' +
                        '<div class="space-4 items"></div>';
                    break;

            }
            $('.items').remove();
            $('#form-actions').before(items);
            if($('.laydate').length){
                var that=$('.laydate');
                $.each(that,function (index,info) {
                    laydate.render({
                        elem: info //指定元素
                        ,type:$(info).data('type') || 'date'
                        ,format:$(info).data('format') || 'yyyy-MM-dd'
                    });
                });

            }
            $('#infos').val(infos);

        });
    </script>

@endsection