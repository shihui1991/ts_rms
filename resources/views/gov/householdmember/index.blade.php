{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')


    <div class="well well-sm">
        <a class="btn" href="{{route('g_household',['item'=>$edata['item_id']])}}">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>
        <a href="{{route('g_householdmember_add',['item'=>$edata['item_id'],'household_id'=>$edata['household_id']])}}" class="btn">添加家庭成员</a>
    </div>

    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>姓名</th>
            <th>与户主关系</th>
            <th>身份证</th>
            <th>电话</th>
            <th>民族</th>
            <th>性别</th>
            <th>年龄</th>
            <th>是否享受特殊人群优惠</th>
            <th>权属类型</th>
            <th>权属分配比例</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            @if($code=='success')
                @foreach($sdata as $infos)
                    <tr>
                        <td>{{$infos->id}}</td>
                        <td>{{$infos->name}}</td>
                        <td>{{$infos->relation}}</td>
                        <td>{{$infos->card_num}}</td>
                        <td>{{$infos->phone}}</td>
                        <td>{{$infos->nation->name}}</td>
                        <td>{{$infos->sex}}</td>
                        <td>{{$infos->age}}</td>
                        <td>{{$infos->crowd}}</td>
                        <td>{{$infos->holder}}</td>
                        <td>{{$infos->portion}}</td>
                        <td>
                            <a href="{{route('g_householdmember_info',['id'=>$infos->id,'item'=>$edata['item_id']])}}" class="btn btn-sm">查看详情</a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script>

    </script>

@endsection