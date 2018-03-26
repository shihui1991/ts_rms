{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')
    <div class="well well-sm">
        <a class="btn" href="{{route('g_buildingrelated',['item'=>$edata['item']->id,'household_id'=>$edata['item']])}}">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>
    </div>
    <form class="form-horizontal" role="form" action="{{route('g_buildingrelated_com')}}" method="post">
        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>名称</th>
                <th>地块</th>
                <th>楼栋</th>
                <th>楼层</th>
                <th>朝向</th>
                <th>结构</th>
                <th>实际建筑面积</th>
                <th>实际用途</th>
                <th>状态</th>
            </tr>
            </thead>
            <tbody>
            @if($code=='success')
                <tr>
                    <td>{{$sdata->name}}</td>
                    <td>{{$sdata->itemland->address}}</td>
                    <td>{{$sdata->itembuilding->building}}</td>
                    <td>{{$sdata->floor}}</td>
                    <td>{{$sdata->direct}}</td>
                    <td>{{$sdata->buildingstruct->name}}</td>
                    <td>{{$sdata->real_outer}}</td>
                    <td>{{$sdata->realbuildinguse->name}}</td>
                    <td>{{$sdata->state->name}}</td>
                </tr>
            @endif
            </tbody>
        </table>
    </form>



@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script src="{{asset('js/func.js')}}"></script>
    <script>
        function sub_ajax(obj) {
            var _this = $('input[name=id]:checked').val();
            if(!_this){
                toastr.error('请先勾选建筑信息');
                return false;
            }
           sub(obj);
        }
    </script>

@endsection