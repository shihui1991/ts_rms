{{-- 继承布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <div class="well">
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>
    </div>


    <div class="profile-user-info profile-user-info-striped">

        <div class="profile-info-row">
            <div class="profile-info-name"> 项目： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata['item']->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 资金类型： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata['funds']->fundscate->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 凭证号： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata['funds']->voucher}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 金额： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">
                    <strong>{{number_format(abs($sdata['funds']->amount),2)}}</strong>
                     &nbsp;人民币（大写）：{{bigRMB(abs($sdata['funds']->amount))}}
                </span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 进出： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">@if($sdata['funds']->amount>0) 收入 @else 支出 @endif</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 转账银行： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata['funds']->bank->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 银行账号： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata['funds']->account}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 账户姓名： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata['funds']->name}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 转账时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata['funds']->entry_at}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 款项说明： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata['funds']->infos}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 转账凭证： </div>
            <div class="profile-info-value">
                <ul class="ace-thumbnails clearfix img-content">
                    @foreach($sdata['funds']->picture as $pic)
                        <li>
                            <div>
                                <img width="120" height="120" src="{{$pic}}" alt="{{$pic}}">
                                <div class="text">
                                    <div class="inner">
                                        <a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 创建时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata['funds']->created_at}}</span>
            </div>
        </div>

        <div class="profile-info-row">
            <div class="profile-info-name"> 更新时间： </div>
            <div class="profile-info-value">
                <span class="editable editable-click">{{$sdata['funds']->updated_at}}</span>
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
    <script>
        $('.img-content').viewer();
    </script>

@endsection