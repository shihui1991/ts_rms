<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<style type="text/css">
    * {
        margin: 0;
        padding: 0;
        font-size: 30px;
        word-spacing: 10px;
        letter-spacing: 5px;
    }

    tr {
        line-height: 80px;
    }

    td {
        padding: 5px 10px;
    }
</style>

<body>
<div style="width: 1000px;margin: auto;">
    <h2 style="text-align: center;margin-top: 50px;margin-bottom: 50px;">入住通知单</h2>
    <table border="0" cellspacing="0" style="width: 100%;column-span: 0;margin: auto;">
        <tr>
            <td colspan="2" style="color: red;width: 30%;">{{$house_resettle->house->housecompany->name}}：</td>
        </tr>
        <tr>
            <td colspan="2">
                <span style="color: red;">{{$item->name}}</span>被征收人<span style="color: red; margin-right: 120px;">{{$member->name}}</span>前来办理
                <span style="color: red;margin-right: 200px;">
                    {{$house_resettle->house->housecommunity->name}}
                    {{$house_resettle->house->building}}栋
                    {{$house_resettle->house->unit}}单元
                    {{$house_resettle->house->floor}}楼
                    {{$house_resettle->house->number}}号
                    （面积 ：{{number_format($house_resettle->house->area,2)}}㎡）
                </span>安置房入住手续，请接洽.
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-top: 200px;text-align: right;">
                <span style="margin-right: 120px;">      <span>{{date('Y年m月d日',strtotime($act_at))}}</span> </span>
                <span>第     <span>{{$serial}}</span>   号</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-top: 50px;">
                <span style="margin-right: 200px;">签发人：                </span>
                <span style="margin-right: 200px;">经办人：                </span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-top: 30px;">
                <span style="margin-right: 168px;">被征收人： </span>
                <span>联系电话:</span>
            </td>
        </tr>
    </table>
</div>
</body>

</html>