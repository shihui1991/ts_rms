;
$(function () {
    //信息提示
    toastr.options = {
        closeButton: true,
        debug: false,
        progressBar: true,
        positionClass: "toast-top-right",
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "1500",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut"
    };

    //下拉选框 带搜索功能
    if($('.chosen-select').length){
        $('.chosen-select').chosen({
            no_results_text:"没有匹配数据",
            placeholder_text:"请选择",
            search_contains:true,
            disable_search_threshold:10
        });
    }

    //时间插件
    if($('.laydate').length){
        var that=$('.laydate');
        $.each(that,function (index,info) {
            laydate.render({
                elem: info //指定元素
                ,type:$(info).data('type') || 'date'
                ,format:$(info).data('format') || 'yyyy-MM-dd'
            });
        });

    }

});