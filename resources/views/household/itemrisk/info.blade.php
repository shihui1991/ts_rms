{{-- 继承布局 --}}
@extends('household.layout')


{{-- 页面内容 --}}
@section('content')


    <div class="well well-sm">
        @if (blank($sdata))
            <a href="{{route('h_itemrisk_add')}}" class="btn">添加社会稳定风险评估</a>
        @else
            <a href="{{route('h_itemrisk_edit',['id'=>$sdata->id])}}" class="btn">修改社会稳定风险评估</a>
        @endif

    </div>

@if(filled($sdata))

    <div class="profile-user-info profile-user-info-striped">

        <div class="profile-info-row">
            <div class="profile-info-name">被征户账号： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{session('household_user.user_name')}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name">征收态度： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->agree}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name">项目地块： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->land->address}}</span>
            </div>
        </div>


        <div class="profile-info-row">
            <div class="profile-info-name">楼栋： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->building->building}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">补偿方式： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->repay_way}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">房源单价： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->house_price}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">房源面积： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->house_area}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">房源户型： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->layout->name}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">房源数量： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->house_num}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">房源地址： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->house_addr}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">增加面积单价： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->more_price}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">过度方式： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->transit_way}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">搬迁方式： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->move_way}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">搬迁补偿： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->move_fee}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">装修补偿： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->decoration}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">设备拆迁费： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->device}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">停产停业损失补偿： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->business}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">创建时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->created_at}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">更新时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->updated_at}}</span>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name">删除时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->deleted_at}}</span>
            </div>
        </div>
    </div>
@endif
@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')
    @parent

@endsection