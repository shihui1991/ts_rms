{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <div class="well well-sm">
        <a href="javascript:history.back();" class="btn">返回</a>
    </div>

    <div class="profile-user-info profile-user-info-striped">

        <div class="profile-info-row">
            <div class="profile-info-name"> 补偿科目： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata['pay_subject']->subject->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 补偿说明： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata['pay_subject']->itemsubject->infos}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 补偿计算： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata['pay_subject']->calculate}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 补偿金额： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">
                    <strong>{{number_format($sdata['pay_subject']->amount,2)}}</strong>
                    人民币（大写）：
                    {{bigRMB($sdata['pay_subject']->amount)}}
                </span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 状态： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata['pay_subject']->state->name}}</span>
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
    <script src="{{asset('laydate/laydate.js')}}"></script>

@endsection