<style>
    .btn {
        width: 100%;
        height: 100%;
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
<div class="no-print" style="position: fixed;top:20px;left:20px;width: 100px;height: 50px;">
    <button type="button" class="btn" onclick="print()">打印</button>
</div>

@if($sdata['pact']->cate_id==1)
    {!! $sdata['pact']->content['pay_pact'] !!}
    {!! $sdata['pact']->content['pay_table'] !!}
    @foreach($sdata['pact']->content['estate_pic'] as $estate)
        <img src="{{$estate}}" alt="">
    @endforeach
    @foreach($sdata['pact']->content['assets_pic'] as $assets)
        <img src="{{$estate}}" alt="">
    @endforeach
@else
    {!! $sdata['pact']->content !!}
@endif


<script src="{{asset('js/jquery-1.11.3.min.js')}}"></script>
<script src="{{asset('js/jquery.print.min.js')}}"></script>
<script>
    function print() {
        $('document').print({noPrintSelector: ".no-print"});
    }
</script>