{{-- 继承主体 --}}
@extends('com.main')

{{-- 页面内容 --}}
@section('content')
    <form class="form-horizontal" role="form" action="{{route('c_comassess_publicadd')}}" method="get">
        {{csrf_field()}}
    <input type="hidden" name="item" value="{{$edata['item_id']}}">
    <div class="well well-sm">
        <button class="btn" type="submit" >评估公共附属物</button>
    </div>

    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th><input type="checkbox"></th>
            <th>序号</th>
            <th>地块地址</th>
            <th>土地性质</th>
            <th>土地来源</th>
            <th>土地权益状况</th>
            <th>面积</th>
        </tr>
        </thead>
        <tbody>
        @if($code=='success')
            @foreach($sdata as $infos)
                <tr>
                    <td><input type="checkbox" name="land_id[]" value="{{$infos->id}}"></td>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$infos->address}}</td>
                    <td>{{$infos->landprop->name}}</td>
                    <td>{{$infos->landsource->name}}</td>
                    <td>{{$infos->landstate->name}}</td>
                    <td>{{$infos->area}}</td>
                </tr>
            @endforeach
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

    </script>

@endsection