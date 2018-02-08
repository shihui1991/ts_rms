{{-- 继承aceAdmin后台布局 --}}
@extends('gov.main')


{{-- 页面内容 --}}
@section('content')

    <div class="well">
        <a class="btn" href="{{route('g_itemuser')}}">
            <i class="ace-icon fa fa-arrow-left bigger-110"></i>
            返回
        </a>

        <a class="btn" data-toggle="modal" data-target="#model-itemuser" onclick="addUser()">
            <i class="ace-icon fa fa-plus bigger-110"></i>
            添加人员
        </a>
    </div>

    <p>
        <i class="ace-icon fa fa-hand-o-right bigger-110 blue"></i>
        {{$edata['process']->schedule->name}}
        <i class="ace-icon fa fa-angle-right bigger-110 "></i>
        {{$edata['process']->name}}
    </p>
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>姓名</th>
            <th>部门</th>
            <th>角色</th>
            <th></th>
        </tr>
        </thead>
        <tbody id="tbody-itemuser">
        @foreach($sdata as $itemuser)
            <tr>
                <td>{{$itemuser->user->name}}</td>
                <td>{{$itemuser->dept->name}}</td>
                <td>{{$itemuser->role->name}}</td>
                <td><a class="btn btn-xs" onclick="trRemove(this)" data-id="{{$itemuser->id}}" data-user="{{$itemuser->user_id}}">删除</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>


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
                                    @foreach($edata['depts'] as $dept)
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

        function addUser() {
            var data={
                "dept_id":null
                ,"name":null
                ,"page":null
            };

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
                        '<td><input type="radio" name="user" value="'+info.id+'" data-name="'+info.name+'" data-dept="'+info.dept.name+'" data-role="'+info.role.name+'"></td>' +
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
            var user=$('#tbody-users').find('input[name=user]:checked');
            var curUsers=$('#tbody-itemuser').find('[data-user]');
            var curUserIds=[];

            if(user.length){
                $.each(curUsers,function (index,user) {
                    curUserIds.push($(user).data('user'));
                });
                var userId=parseInt(user.val());

                if($.inArray(userId,curUserIds) == -1){
                    var data={
                        'process_id':'{{$edata['process']->id}}'
                        ,'user_id':userId
                    };
                    ajaxAct('{{route('g_itemuser_edit')}}',data,'post');
                    if(ajaxResp.code=='success'){
                        var str='<tr>' +
                            '<td>'+user.data('name')+ '</td>' +
                            '<td>'+user.data('dept')+'</td>' +
                            '<td>'+user.data('role')+'</td>' +
                            '<td><a class="btn btn-xs" onclick="trRemove(this)" data-id="'+ajaxResp.sdata.id+'" data-user="'+userId+'">删除</a></td>' +
                            '</tr>';
                        $('#tbody-itemuser').append(str);
                        toastr.success(ajaxResp.message);
                    }else{
                        toastr.error(ajaxResp.message);
                    }
                }else{
                    toastr.warning('已添加');
                }
            }
        });

        function trRemove(obj) {
            var that=$(obj);
            var id=that.data('id');
            ajaxAct('{{route('g_itemuser_del')}}',{'id':id},'get');
            if(ajaxResp.code=='success'){
                that.parents('tr:first').remove();
            }else{
                toastr.error(ajaxResp.message);
            }
        }
    </script>

@endsection