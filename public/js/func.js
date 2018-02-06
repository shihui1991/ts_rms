;

// 表单保存
function sub(obj) {
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

    if(obj.files && obj.files.length){
        $.each(obj.files,function (index,file) {
            var formdata=new FormData();

            formdata.append('file',file);
            ajaxUpd('/gov/upl',formdata);
            if(ajaxResp.code=='success'){
                imgs +='<li>'+
                    '<div>'+
                    '<img width="120" height="120" src="'+ajaxResp.sdata.path+'" alt="a">'+
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
                toastr.warning('【'+file.name+'】 上传失败！');
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