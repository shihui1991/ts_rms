<style>
    .btn {
        width: 200px;
        height: 50px;
        color: #FFF!important;
        text-shadow: 0 -1px 0 rgba(0,0,0,.25);
        background-image: none!important;
        border: 5px solid #ABBAC3;
        border-radius: 0;
        box-shadow: none!important;
        -webkit-transition: background-color .15s,border-color .15s,opacity .15s;
        -o-transition: background-color .15s,border-color .15s,opacity .15s;
        transition: background-color .15s,border-color .15s,opacity .15s;
        vertical-align: middle;
        margin: 0;
        position: relative;
        background-color: #ABBAC3!important;
        cursor: pointer;
    }
    .btn:hover{
        background-color: #D15B47!important;
        border-color: #D15B47;
    }
</style>
<div class="no-print" style="position: fixed;top:20px;left:20px;">
    <button type="button" class="btn" onclick="print()">打印协议</button>
    @if($sdata['pact']->cate_id==1)
        <button type="button" class="btn" onclick="layerWin(this)" data-url="{{route('g_pay_table',['item'=>$sdata['pact']->item_id,'pact_id'=>$sdata['pact']->id])}}" data-title="兑付表">兑付表</button>

        <button type="button" class="btn" onclick="layerWin(this)" data-url="{{route('g_assess_pic',['item'=>$sdata['pact']->item_id,'pact_id'=>$sdata['pact']->id])}}" data-title="评估报告">评估报告</button>
    @endif
</div>

@if($sdata['pact']->cate_id==1)
    {!! $sdata['pact']->content['pay_pact'] !!}

@else
    {!! $sdata['pact']->content !!}
@endif


<script src="{{asset('js/jquery-1.11.3.min.js')}}"></script>
<script src="{{asset('js/jquery.print.min.js')}}"></script>
<script src="{{asset('layer/layer.js')}}"></script>
<script>
    function print() {
        $('document').print({noPrintSelector: ".no-print"});
    }

    function layerWin(obj) {
        var that=$(obj);
        var lay=layer.open({
            type: 2
            ,skin:'layui-layer-molv'
            ,title:that.data('title')
            ,area: ['500px', '300px']
            ,offset: ['100px', '50px']
            ,maxmin:true
            ,content: [that.data('url'),'yes']
        });
        layer.full(lay);
    }
</script>