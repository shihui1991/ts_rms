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


    <div class="profile-user-info profile-user-info-striped">

        <div class="profile-info-row">
            <div class="profile-info-name">被征户账号： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->household->username}}</span>
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
                <span class="editable editable-click"></span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name">户型： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata->layout->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name">楼栋： </div>
            <div class="profile-info-value">
                <span class="editable editable-click"></span>
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

@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')


@endsection