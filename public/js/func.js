;

// 表单保存
function sub(obj) {
    toastr.info('请稍等！处理中……');
    ajaxFormSub(obj);
    if(ajaxResp.code=='success'){
        toastr.success(ajaxResp.message);
        setTimeout(function () {
            location.href=ajaxResp.url;
        },1000);
    }else{
        toastr.error(ajaxResp.message);
        $('#name').focus();
    }
    return false;
}

// 图片上传
function uplfile(obj) {
    var that=$(obj);
    var imgcontenter=that.parents('.img-box:first').find('.img-content');
    var name=that.data('name');
    var imgs='';

    if(that.data('loading') || that.prop('disabled')){
        return false;
    }

    that.data('loading',true).prop('disabled',true);
    toastr.info('请稍等！处理中……');

    if(obj.files && obj.files.length){
        $.each(obj.files,function (index,file) {
            var formdata=new FormData();

            formdata.append('file',file);
            ajaxUpd(updUrl,formdata);
            if(ajaxResp.code=='success'){
                imgs +='<li>'+
                    '<div>'+
                    '<img width="120" height="120" src="'+ajaxResp.sdata.path+'" alt="'+ajaxResp.sdata.path+'">'+
                    '<input type="hidden" name="'+name+'" value="'+ajaxResp.sdata.path+'">'+
                    '<div class="text">'+
                    '<div class="inner">'+
                    '<a onclick="preview(this)"><i class="fa fa-search-plus"></i></a>'+
                    '<a onclick="removeimg(this)"><i class="fa fa-trash"></i></a>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</li>';

                toastr.info('【'+file.name+'】 上传成功！');
            }else{
                toastr.warning('【'+file.name+'】上传失败！('+ajaxResp.message+')' );
            }
        });
        if(!that.prop('multiple') && ajaxResp.code=='success'){
            imgcontenter.html('');
        }
        imgcontenter.append(imgs).viewer('update');
    }

    that.data('loading',false).prop('disabled',false).val('');
}

// 图片预览
function preview(obj) {
    var that=$(obj);
    that.parents('li:first').find('img:first').click();
}

// 删除图片
function removeimg(obj) {
    var that=$(obj);
    var imgcontenter=that.parents('.img-content:first');
    that.parents('li:first').remove();
    imgcontenter.viewer('update');
}


// 树形列表复选框 选中冒泡与取消捕获
function upDown(obj) {
    var _this=obj,
        _id=_this.data('id'),
        parent_id=_this.data('parent-id'),
        parent_obj=$('#id-'+parent_id),
        child_obj=$('input[data-parent-id='+_id+']');
    if(_this.prop('checked') && parent_id){
        parent_obj.prop("checked", true);
        upDown(parent_obj);
    }else if(!_this.prop('checked') && child_obj.length){
        $.each(child_obj,function (index,info) {
            $(info).prop('checked',false);
            upDown($(info));
        })
    }
}

// 按钮异步请求
function btnAct(obj) {
    var btn=$(obj);
    var url=btn.data('url');
    var datas=btn.data('datas');
    var method=btn.data('method')?btn.data('method'):'get';
    if(btn.data('loading') || btn.hasClass('disabled')){
        return false;
    }
    btn.data('loading',true).addClass('disabled');
    toastr.info('请稍等！处理中……');
    ajaxAct(url,datas,method);
    if(ajaxResp.code=='success'){
        toastr.success(ajaxResp.message);
        if(ajaxResp.url){
            setTimeout(function () {
                location.href=ajaxResp.url;
            },1000);
        }else{
            setTimeout(function () {
                location.reload();
            },1000);
        }
    }else{
        toastr.error(ajaxResp.message);
        if(ajaxResp.url){
            setTimeout(function () {
                location.href=ajaxResp.url;
            },1000);
        }else{
            btn.data('loading',false).removeClass('disabled');
        }
    }
    return false;
}