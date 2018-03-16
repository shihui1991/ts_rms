{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="{{route('g_householdbuildingdeal',['item'=>$edata['item_id']])}}">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>

    </p>


    <div class="profile-user-info profile-user-info-striped">

        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>序号</th>
                <th>建筑状态</th>
                <th>名称</th>
                <th>地块</th>
                <th>楼栋</th>
                <th>批准用途</th>
                <th>实际用途</th>
                <th>结构类型</th>
                <th>楼层</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @if($code=='success')
                @foreach($sdata as $infos)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$infos->code}}</td>
                        <td>{{$infos->name}}</td>
                        <td>{{$infos->itemland->address}}</td>
                        <td>{{$infos->itembuilding->building}}</td>
                        <td>{{$infos->buildinguse->name}}</td>
                        <td>{{$infos->buildinguses->name}}</td>
                        <td>{{$infos->buildingstruct->name}}</td>
                        <td>{{$infos->floor}}</td>
                        <td>
                            @if($infos->getOriginal('code') == 91)
                                <a href="{{route('g_householdbuildingdeal_status',['id'=>$infos->id,'item'=>$infos->item_id,'household_id'=>$infos->household_id])}}" class="btn btn-sm">合法性认定</a>
                            @endif

                            @if($infos->getOriginal('code')==93)
                                <a href="{{route('g_householdbuildingdeal_add',['household_building_id'=>$infos->id,'item'=>$infos->item_id,'household_id'=>$infos->household_id])}}" class="btn btn-sm">违建处理</a>
                            @endif

                            @if($infos->getOriginal('code') == 94 || $infos->getOriginal('code') == 95)
                                 <a href="{{route('g_householdbuildingdeal_info',['item'=>$infos->item_id,'household_id'=>$infos->household_id])}}" class="btn btn-sm">处理详情</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        <div class="row">
            <div class="col-xs-6">
                <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">共 @if($code=='success') {{ count($sdata) }} @else 0 @endif 条数据</div>
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
    <script src="{{asset('viewer/viewer.min.js')}}"></script>
    <script src="{{asset('js/func.js')}}"></script>
    <script>
        $('.img-content').viewer('update');
    </script>
@endsection