{{-- 继承aceAdmin后台布局 --}}
@extends('household.home')


{{-- 页面内容 --}}
@section('content')
    @if(filled($sdata['companyvote']))
    <div class="well well-sm">
        <a href="{{route('h_itemcompanyvote_info',['id'=>$sdata['companyvote']->id])}}" class="btn">我的投票</a>
    </div>
    @endif

    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>排名</th>
            <th>名称</th>
            <th>基本信息</th>
            <th>票数</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @if(filled($edata))
            @if(filled($sdata['companyvote']))
                @foreach($edata as $company)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$company->name}}</td>
                        <td>{{$company->infos}}</td>
                        <td>{{$company->companyvotes_count}}</td>
                        <td>  <div class="btn-group">
                            @if($company->companyvotes_count)
                                <a href="javascript:;" class="btn btn-xs">已投</a>
                            @endif
                                <a href="{{route('h_company_info',['id'=>$company->id])}}" class="btn btn-xs">查看详情</a>  </div>
                        </td>
                    </tr>
                @endforeach
                @else
                @foreach($edata as $company)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$company->name}}</td>
                        <td>{{$company->infos}}</td>
                        <td>{{$company->companyvotes_count}}</td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-xs" onclick="vote({{$company->id}})" >投票</a>
                                <a href="{{route('h_company_info',['id'=>$company->id])}}" class="btn btn-xs">查看详情</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        @endif
        </tbody>
    </table>
    <div class="row">
        <div class="col-xs-6">
            <div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">共 @if($code=='success') {{ $edata->total() }} @else 0 @endif 条数据</div>
        </div>
        <div class="col-xs-6">
            <div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
                @if($code=='success') {{ $edata->links() }} @endif
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
    <script src="{{asset('js/func.js')}}"></script>
    <script>
       function vote(company_id) {
          var data={company_id:company_id};
           ajaxAct('{{route('h_itemcompanyvote_add')}}',data,'post');
           console.log( ajaxResp);
           if(ajaxResp.code=='success'){
               toastr.success(ajaxResp.message);
               setTimeout(function () {
                   location.href=ajaxResp.url;
               },1000);
           }else{
               toastr.error(ajaxResp.message);
           }
           return false;
       }
    </script>
@endsection