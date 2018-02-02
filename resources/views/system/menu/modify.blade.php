{{-- 继承基础模板 --}}
@extends('system.public.base')

{{-- 布局 --}}
@section('body')
    <form action="{{isset($infos)?route('sys_menu_edit',['id'=>$infos->id]):route('sys_menu_add')}}" method="post" class="js-ajax-form" onsubmit="return false;">
        <div class="layerCon bg_f">
            <input type="hidden" name="sub_type" value="{{$sub_type??''}}" >
            <table class="layerTable" border="0">
                <tr class="h50">
                    <td><label for="name">菜单名称：</label></td>
                    <td>
                        <input id="name" class="must" type="text" name="name" value="{{isset($infos)?$infos->name:''}}" required placeholder="输入唯一名称"/>
                    </td>
                    <td><label for="parent_id">上级菜单：</label></td>
                    <td>
                        @if(isset($infos))
                            @if(isset($infos->father->id) and $infos->father->id != 0)
                                --{{$infos->father->name}}--
                            @else
                                --作为一级菜单--
                            @endif
                        @else
                            <select name="parent_id" id="parent_id" class="chosen" data-no_results_text="没有匹配数据" data-placeholder="请选择上级菜单">
                                @if(isset($parent) and $parent['id']!=0)
                                    <option value="{{$parent['id']}}">--{{$parent['name']}}--</option>
                                @elseif(isset($parent) and $parent['id']==0)
                                    <option value="0">--作为一级菜单--</option>
                                @endif
                            </select>
                        @endif
                    </td>
                </tr>
                <tr class="h50">
                    <td><label for="url">路由地址：</label></td>
                    <td>
                        <input id="url" class="must" type="text" name="url" value="{{isset($infos)?$infos->url:''}}" placeholder="请输入路由地址" required/>
                    </td>
                    <td><label for="sort">显示排序：</label></td>
                    <td>
                        <input id="sort" type="number" name="sort" value="{{isset($infos)?$infos->sort:0}}" />
                    </td>
                </tr>
                <tr class="h50">
                    <td>模块：</td>
                    <td>
                        @if(isset($infos))
                            <label><input class="va_m" name="module" type="radio"  value="0" @if($infos->getOriginal('module') == 0) checked @endif>征收部门</label>
                            <label><input class="va_m" name="module" type="radio"  value="1" @if($infos->getOriginal('module')  == 1) checked @endif>评估机构</label>
                            <label><input class="va_m" name="module" type="radio"  value="2" @if($infos->getOriginal('module')  == 2) checked @endif>被征收户</label>
                            <label><input class="va_m" name="module" type="radio"  value="3" @if($infos->getOriginal('module')  == 3) checked @endif>触摸屏</label>
                        @else
                            @if(isset($module))
                                <label><input class="va_m" name="module" type="radio"  value="0" @if($module == 0) checked @endif>征收部门</label>
                                <label><input class="va_m" name="module" type="radio"  value="1" @if($module == 1) checked @endif>评估机构</label>
                                <label><input class="va_m" name="module" type="radio"  value="2" @if($module == 2) checked @endif>被征收户</label>
                                <label><input class="va_m" name="module" type="radio"  value="3" @if($module == 3) checked @endif>触摸屏</label>
                            @else
                                <label><input class="va_m" name="module" type="radio"  value="0" checked>征收部门</label>
                                <label><input class="va_m" name="module" type="radio"  value="1">评估机构</label>
                                <label><input class="va_m" name="module" type="radio"  value="2">被征收户</label>
                                <label><input class="va_m" name="module" type="radio"  value="3">触摸屏</label>
                            @endif
                         @endif
                    </td>
                    <td>限制登录访问：</td>
                    <td>
                        @if(isset($infos))
                            <label><input class="va_m" name="login" type="radio"  value="0" @if($infos->getOriginal('login') == 0) checked @endif>否</label>
                            <label><input class="va_m" name="login" type="radio"  value="1" @if($infos->getOriginal('login') == 1) checked @endif>是</label>
                        @else
                            <label><input class="va_m" name="login" type="radio"  value="0" checked>否</label>
                            <label><input class="va_m" name="login" type="radio"  value="1">是</label>
                        @endif
                    </td>
                </tr>
                <tr class="h50">
                    <td>限制操作访问：</td>
                    <td>
                        @if(isset($infos))
                            <label><input class="va_m" name="auth" type="radio"  value="0" @if($infos->getOriginal('auth') == 0) checked @endif>否</label>
                            <label><input class="va_m" name="auth" type="radio"  value="1" @if($infos->getOriginal('auth') == 1) checked @endif>是</label>
                        @else
                            <label><input class="va_m" name="auth" type="radio"  value="0" checked>否</label>
                            <label><input class="va_m" name="auth" type="radio"  value="1">是</label>
                        @endif
                    </td>
                    <td>状态：</td>
                    <td>
                        @if(isset($infos))
                            <label><input class="va_m" name="display" type="radio"  value="0" @if($infos->getOriginal('display') == 0) checked @endif>隐藏</label>
                            <label><input class="va_m" name="display" type="radio"  value="1" @if($infos->getOriginal('display') == 1) checked @endif>显示</label>
                        @else
                            <label><input class="va_m" name="display" type="radio"  value="0" checked>隐藏</label>
                            <label><input class="va_m" name="display" type="radio"  value="1">显示</label>
                        @endif
                    </td>
                </tr>
                <tr class="h50">
                    <td rowspan="2"><label for="icon">菜单图标：</label></td>
                    <td colspan="3">
                        <textarea id="icon" name="icon">{{isset($infos)?$infos->icon:''}}</textarea>
                    </td>
                </tr>
                <tr class="h25">
                    @if(isset($infos))
                    <td colspan="3" style="text-align: left;">当前图标： {!!$infos->icon!!} ,代码{{$infos->icon}}</td>
                    @else
                    <td colspan="3" style="text-align: left;">填图标代码，如<img src="/system/img/house.png"/>填入&lt;img src=&quot;/system/img/house.png&quot;/&gt;</td>
                    @endif
                </tr>
                <tr class="h50">
                    <td><label for="infos">菜单描述：</label></td>
                    <td colspan="3">
                        <textarea id="infos" name="infos">{{isset($infos)?$infos->infos:''}}</textarea>
                    </td>
                </tr>

                @if(isset($infos))
                <tr class="h50">
                    <td>操作时间：</td>
                    <td colspan="3">
                        创建于：{{$infos->created_at}}<br/>
                        更新于：{{$infos->updated_at}}<br/>
                        @if(isset($infos) and $infos->deleted_at)
                        删除于：{{$infos->deleted_at}}
                        @endif
                    </td>
                </tr>
                @endif
            </table>
            <div class="layerBtns">
                <a class="btn js-ajax-form-btn" data-layer="true" onclick="modify(this)">立即提交</a>
                <button class="btn" type="reset">重置</button>
            </div>
        </div>
    </form>
@endsection


{{-- js --}}
@section('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function modify(obj) {
            ajaxFormSub(obj);
            if(ajaxResp.code == 'success'){
                toastr.success(ajaxResp.message);
                if(ajaxResp.url){
                    parent.location.href=ajaxResp.url;
                }
            }
            if(ajaxResp.code == 'error'){
                toastr.error(ajaxResp.message);
            }

        }
    </script>

@endsection