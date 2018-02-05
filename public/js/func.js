;

// 表单保存
function sub(obj) {
    ajaxFormSub(obj);
    console.log(ajaxResp);
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