{{-- 继承主体 --}}
@extends('gov.main')

{{-- 页面内容 --}}
@section('content')
    
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>序号</th>
            <th>地址</th>
            <th>公房单位</th>
            <th>补偿总额</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            @if(filled($sdata['pay_units']))
                @foreach($sdata['pay_units'] as $pay_unit)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$pay_unit->adminunit->address}}</td>
                        <td>{{$pay_unit->adminunit->name}}</td>
                        <td>{{number_format($pay_unit->unit_total,2)}}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{route('g_payunit_info',['unit_id'=>$pay_unit->unit_id,'item'=>$sdata['item']->id])}}" class="btn btn-sm">补偿详情</a>
                            </div>

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