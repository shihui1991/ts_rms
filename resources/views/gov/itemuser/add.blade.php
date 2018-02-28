{{-- 继承aceAdmin后台布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <p>
        <a class="btn" href="javascript:history.back()">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>
    </p>

    <form class="form-horizontal" role="form" action="{{route('g_itemuser_add',['item'=>$sdata['item']->id])}}" method="post">
        {{csrf_field()}}

        <table class="table table-hover table-bordered treetable" id="tree-itemuser">
            @foreach($sdata['processes'] as $schedule)
                <tr data-tt-id="schedule-{{$schedule->id}}" data-tt-parent-id="0">
                    <td colspan="4">{{$schedule->name}}</td>
                </tr>

                @foreach($schedule->processes as $process)
                    <tr data-tt-id="process-{{$process->id}}" data-tt-parent-id="schedule-{{$schedule->id}}">
                        <td colspan="3">{{$process->name}}</td>
                        <td><a class="btn btn-xs" data-toggle="modal" data-target="#model-itemuser" onclick="addUser({{$process->id}})">添加</a></td>
                    </tr>
                @endforeach
            @endforeach

        </table>

        <div class="clearfix form-actions">
            <div class="col-md-offset-3 col-md-9">
                <button class="btn btn-info" type="button" onclick="sub(this)">
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    保存
                </button>
                &nbsp;&nbsp;&nbsp;
                <button class="btn" type="reset">
                    <i class="ace-icon fa fa-undo bigger-110"></i>
                    重置
                </button>
            </div>
        </div>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="model-itemuser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加项目人员</h4>
                </div>
                <div class="modal-body">
                    <div class="well">
                        <form class="form-inline" role="form" action="{{route('g_user')}}" method="get" onchange="formSub()">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label class="control-label no-padding-right" for="dept_id"> 部门： </label>
                                <select name="dept_id" id="dept_id" class="form-control">
                                    <option value="">所有部门</option>
                                    @foreach($sdata['depts'] as $dept)
                                        <option value="{{$dept->id}}">{{$dept->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="control-label no-padding-right" for="name"> 姓名： </label>
                                <input type="text" class="form-control" id="name" name="name" value="">
                            </div>
                        </form>
                    </div>

                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>选择</th>
                            <th>姓名</th>
                            <th>部门</th>
                            <th>角色</th>
                        </tr>
                        </thead>
                        <tbody id="tbody-users">

                        </tbody>
                    </table>

                    <p id="pagebar"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" id="btn-set-itemuser">确定</button>
                </div>
            </div>
        </div>
    </div>

@endsection

{{-- 样式 --}}
@section('css')

    <link rel="stylesheet" href="{{asset('treetable/jquery.treetable.theme.default.css')}}">

@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script src="{{asset('treetable/jquery.treetable.js')}}"></script>
    <script src="{{asset('pagination/jquery.pagination.min.js')}}"></script>
    <script src="{{asset('js/func.js')}}"></script>

    <script>
        $("#tree-itemuser").treetable({
            expandable: true // 展示
            ,initialState :"collapsed"//默认打开所有节点
            ,stringCollapse:'关闭'
            ,stringExpand:'展开'
        });

        function addUser(ttid) {
            var data={
                "dept_id":null
                ,"name":null
                ,"page":null
            };

            $('#btn-set-itemuser').data('ttid',ttid);
            if( $('#tbody-users').children().length ==0){
                $('#tbody-users').html('');
                getUsers(data);
            }
        }

        function formSub() {
            var data={
                "dept_id":$('#dept_id').find('option:selected').val()
                ,"name":$('#name').val()
                ,"page":1
            };
            $('#tbody-users').html('');
            getUsers(data)
        }

        function getUsers(data) {
            ajaxAct('{{route('g_user')}}',data,'get');
            if(ajaxResp.code=='success'){
                var str='';
                $.each(ajaxResp.sdata.data,function (index,info) {
                    str +='<tr>' +
                        '<td><input type="checkbox" name="user" value="'+info.id+'" data-name="'+info.name+'" data-dept="'+info.dept.name+'" data-role="'+info.role.name+'"></td>' +
                        '<td>'+info.name+'</td>'+
                        '<td>'+info.dept.name+'</td>'+
                        '<td>'+info.role.name+'</td>'+
                        '</tr>';
                });
                $('#tbody-users').append(str);
                if(ajaxResp.sdata.current_page == ajaxResp.sdata.last_page){
                    $('#pagebar').html('');
                }else{
                    $('#pagebar').pagination({
                        totalData:ajaxResp.sdata.total,
                        showData:ajaxResp.sdata.per_page,
                        current:ajaxResp.sdata.current_page,
                        jump:false,
                        coping:true,
                        homePage:'首页',
                        endPage:'末页',
                        prevContent:'上一页',
                        nextContent:'下一页',
                        callback:function(api){
                            var cur=api.getCurrent();
                            if(cur>ajaxResp.sdata.current_page){
                                data.page=cur;
                                getUsers(data);
                            }
                        }
                    },function(api){
                        var cur=api.getCurrent();
                    });
                }

            }else{
                toastr.error(ajaxResp.message);
                $('#pagebar').html('');
            }
        }


        $('#btn-set-itemuser').on('click',function () {
            var that=$(this);
            var ttid=that.data('ttid');
            var treeObj= $("#tree-itemuser");
            var curUsers=treeObj.find('input[data-process='+ttid+']');
            var curUserIds=[];
            var users=$('#tbody-users').find('input[name=user]:checked');
            var str='';

            if(users.length){
                $.each(curUsers,function (index,user) {
                    curUserIds.push($(user).val());
                });

                $.each(users,function (index,user) {
                    var u=$(user);
                    var userId=u.val();
                    if($.inArray(userId,curUserIds) == -1){
                        str+='<tr data-tt-id="user-'+userId+'" data-tt-parent-id="process-'+ttid+'">' +
                            '<td>'+u.data('name')+
                            '<input type="hidden" name="itemusers['+ttid+'][]" value="'+userId+'" data-process="'+ttid+'">' +
                            '<input type="hidden" name="user_ids[]" value="'+userId+'">' +
                            '</td>' +
                            '<td>'+u.data('dept')+'</td>' +
                            '<td>'+u.data('role')+'</td>' +
                            '<td><a class="btn btn-xs" onclick="trRemove(this)">删除</a></td>' +
                            '</tr>';
                    }
                });

                treeObj.treetable("loadBranch", treeObj.treetable('node','process-'+ttid), str);// 插入子节点
                treeObj.treetable("expandNode", 'process-'+ttid);// 展开子节点
            }

            that.parents('.modal:first').modal('hide');
        });

        function trRemove(obj) {
            var nodeId=$(obj).parents('tr:first').data('tt-id');
            $("#tree-itemuser").treetable('removeNode',nodeId);
        }

    </script>

@endsection