{{-- 继承aceAdmin后台布局 --}}
@extends('system.home')

{{-- 页面内容 --}}
@section('content')
    <form action="{{isset($infos)?route('sys_menu_edit',['id'=>$infos->id]):route('sys_menu_add')}}" method="post">
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">  模 块  </label>
            <div class="col-sm-9">
                @if(isset($infos))
                    <label>
                        <input name="module" type="radio" class="ace" value="0" @if($infos->getOriginal('module')==0)checked @endif>
                        <span class="lbl">征收部门</span>
                    </label>
                    <label>
                        <input name="module" type="radio" class="ace" value="1" @if($infos->getOriginal('module')==1)checked @endif>
                        <span class="lbl">评估机构</span>
                    </label>
                    <label>
                        <input name="module" type="radio" class="ace" value="2" @if($infos->getOriginal('module')==2)checked @endif>
                        <span class="lbl">被征收户</span>
                    </label>
                    <label>
                        <input name="module" type="radio" class="ace" value="3" @if($infos->getOriginal('module')==3)checked @endif>
                        <span class="lbl">触摸屏</span>
                    </label>
                @else
                    @if(isset($module))
                        <label>
                            <input name="module" type="radio" class="ace" value="0" @if($module==0)checked @endif>
                            <span class="lbl">征收部门</span>
                        </label>
                        <label>
                            <input name="module" type="radio" class="ace" value="1" @if($module==1)checked @endif>
                            <span class="lbl">评估机构</span>
                        </label>
                        <label>
                            <input name="module" type="radio" class="ace" value="2" @if($module==2)checked @endif>
                            <span class="lbl">被征收户</span>
                        </label>
                        <label>
                            <input name="module" type="radio" class="ace" value="3" @if($module==3)checked @endif>
                            <span class="lbl">触摸屏</span>
                        </label>
                    @else
                        <label>
                            <input name="module" type="radio" class="ace" value="0" checked>
                            <span class="lbl">征收部门</span>
                        </label>
                        <label>
                            <input name="module" type="radio" class="ace" value="1">
                            <span class="lbl">评估机构</span>
                        </label>
                        <label>
                            <input name="module" type="radio" class="ace" value="2">
                            <span class="lbl">被征收户</span>
                        </label>
                        <label>
                            <input name="module" type="radio" class="ace" value="3">
                            <span class="lbl">触摸屏</span>
                        </label>
                    @endif
                @endif
            </div>
        </div>
        <div class="space-4"></div><br/><br/>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 上级菜单 </label>
            <div class="col-sm-5">
                @if(isset($infos))
                    @if($infos->parent_id!=0)
                        --{{$parent['name']}}--
                    @else
                        --作为一级菜单--
                    @endif
                @else
                    <select class="form-control" name="parent_id" id="form-field-select-1">
                        @if(isset($parent) and $parent['id']!=0)
                            <option value="{{$parent['id']}}">--{{$parent['name']}}--</option>
                        @else
                            <option value="0">--作为一级菜单--</option>
                        @endif
                    </select>
                @endif
            </div>
        </div>
        <div class="space-4"></div><br/><br/>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">菜单名称</label>
            <div class="col-sm-9">
                <input type="text" name="name" id="form-field-1" value="{{$infos->name??''}}" placeholder="请输入菜单名称" class="col-xs-10 col-sm-5">
            </div>
        </div>
        <div class="space-4"></div><br/><br/>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">路由地址</label>
            <div class="col-sm-9">
                <input type="text" name="url" id="form-field-1" value="{{$infos->url??''}}" placeholder="请输入路由地址" class="col-xs-10 col-sm-5">
            </div>
        </div>
        <div class="space-4"></div><br/><br/>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">请求方式</label>
            <div class="col-sm-9">
                <input type="text" name="method" id="form-field-1" value="{{$infos->method??''}}" placeholder="请输入请求方式" class="col-xs-10 col-sm-5">
            </div>
        </div>
        <div class="space-4"></div><br/><br/>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 限制登陆访问 </label>
            <div class="col-sm-9">
                @if(isset($infos))
                    <label>
                        <input name="login" type="radio" class="ace" value="1" @if($infos->getOriginal('login')==1)checked @endif>
                        <span class="lbl">是</span>
                    </label>
                    <label>
                        <input name="login" type="radio" class="ace" value="0" @if($infos->getOriginal('login')==0)checked @endif>
                        <span class="lbl">否</span>
                    </label>
                @else
                    <label>
                        <input name="login" type="radio" class="ace" value="1">
                        <span class="lbl">是</span>
                    </label>
                    <label>
                        <input name="login" type="radio" class="ace" value="0" checked>
                        <span class="lbl">否</span>
                    </label>
                @endif

            </div>
        </div>
        <div class="space-4"></div><br/>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 限制操作访问 </label>
            <div class="col-sm-9">
                @if(isset($infos))
                    <label>
                        <input name="auth" type="radio" class="ace" value="1" @if($infos->getOriginal('auth')==1)checked @endif>
                        <span class="lbl">是</span>
                    </label>
                    <label>
                        <input name="auth" type="radio" class="ace" value="0" @if($infos->getOriginal('auth')==0)checked @endif>
                        <span class="lbl">否</span>
                    </label>
                @else
                    <label>
                        <input name="auth" type="radio" class="ace" value="1">
                        <span class="lbl">是</span>
                    </label>
                    <label>
                        <input name="auth" type="radio" class="ace" value="0" checked>
                        <span class="lbl">否</span>
                    </label>
                @endif
            </div>
        </div>
        <div class="space-4"></div><br/>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 状态 </label>
            <div class="col-sm-9">
                @if(isset($infos))
                    <label>
                        <input name="display" type="radio" class="ace" value="1" @if($infos->getOriginal('display')==1)checked @endif>
                        <span class="lbl">是</span>
                    </label>
                    <label>
                        <input name="display" type="radio" class="ace" value="0" @if($infos->getOriginal('display')==0)checked @endif>
                        <span class="lbl">否</span>
                    </label>
                @else
                    <label>
                        <input name="display" type="radio" class="ace" value="1">
                        <span class="lbl">是</span>
                    </label>
                    <label>
                        <input name="display" type="radio" class="ace" value="0" checked>
                        <span class="lbl">否</span>
                    </label>
                @endif
            </div>
        </div>
        <div class="space-4"></div><br/>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">排序</label>
            <div class="col-sm-9">
                <input type="text" name="sort" id="form-field-1" value="{{$infos->sort??'0'}}" placeholder="请输入排序" class="col-xs-10 col-sm-5">
            </div>
        </div>
        <div class="space-4"></div><br/><br/>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-8">描述</label>
            <textarea class="form-control" name="infos" id="form-field-8" placeholder="请输入描述">{{$infos->infos??''}}</textarea>
        </div>

        <div class="clearfix form-actions">
            <div class="col-md-offset-3 col-md-9">
                <button class="btn btn-info" type="button" onclick="modify(this)">
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    提交
                </button>
                <input type="hidden" name="sub_type" value="{{$sub_type??''}}">
                &nbsp; &nbsp; &nbsp;
                <a href="{{$sub_type?route('sys_menu_all'):route('sys_menu')}}">
                <button class="btn" type="button">
                    <i class="ace-icon fa fa-undo bigger-110"></i>
                    返回
                </button>
                </a>
            </div>
        </div>
    </form>
@endsection

{{-- 样式 --}}
@section('css')

@endsection

{{-- 插件 --}}
@section('js')
    @parent
    <script>
        function modify(obj) {
            ajaxFormSub(obj);
            console.log(ajaxResp);
            if(ajaxResp.code=='success'){
                toastr.success(ajaxResp.message);
                // setTimeout(function () {
                //     location.href=ajaxResp.url;
                // },1000);
            }else{
                toastr.error(ajaxResp.message);
            }
            return false;
        }
    </script>

@endsection