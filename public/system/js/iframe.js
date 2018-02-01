//多选操作
function checkBoxOp(e){
	var op = $(".table input[type='checkbox']");//多选按钮集
	var isAll = $(e).attr("data-falg") == 'allCheck'?true:false;//是否全选按钮
	var isCheck = $(e).prop("checked");//是否选中
	if(isAll){//全选按钮
		if(isCheck){
			$(op).prop("checked","checked");
		}else{
			$(op).prop("checked","");
		}
	}else{//非全选按钮
		if(isCheck){
			var num = 0;
			for (var i = 0; i < op.length; i++) {
				if($(op).eq(i).prop("checked")){
					num += 1;
				}
			}
			if(num == op.length-1){
				$(op).eq(0).prop("checked","checked");
			}
		}else{
			$(op).eq(0).prop("checked","");
		}
	}
}

//layer询问层
function layerConfirm(cont){
	//询问框
	layer.confirm(cont, {
		skin: 'new-layer',
		title: '提示',
	  	btn: ['确定','取消'] //按钮
	}, function(index){
	  	layer.close(index);
	});
}


//layer页面层
function layerPage(tit,Dom){
	var width=arguments[2]?arguments[2]:800,
		height=arguments[3]?arguments[3]:450;
    if(window.screen.width<1080 && width>=800){
        width=750;
    }
    if(window.screen.height<1080 && height>450){
        height=450;
    }
	layer.open({
		type: 1,
        skin: 'new-layer',
	  	title: tit,
	  	shadeClose: true,
	  	area: [width+'px', height+'px'],
        maxmin: true, //开启最大化最小化按钮
	  	content: Dom,
	  	yes: function(index,layero){
	  		layer.close(index);
	  	}
	});
}

// iframe窗
function layerIfWindow(tit,url){

    var width=arguments[2]?arguments[2]:800,
        height=arguments[3]?arguments[3]:450,
		is_full=arguments[4]?arguments[4]:false;
    if(window.screen.width<1080 && width>=800){
        width=750;
    }
    if(window.screen.height<1080 && height>450){
        height=450;
	}
	var index=layer.open({
        type: 2,
        skin: 'new-layer',
        title: tit,
        shadeClose: false,
        shade: 0.5,
        maxmin: true, //开启最大化最小化按钮
        area: [width+'px', height+'px'],
        content: [url, 'yes'], //iframe的url，no代表不显示滚动条
        yes: function(index,layero){
            layer.close(index);
        }
	});
	if(is_full){
		layer.full(index);
	}
}

//图片放大
function bigerimg(obj){
    var width,
        height,
        imgsrc=obj.src,
        dom='<img style="width:100%;height:99%;" src="'+imgsrc+'"/>',
        imgobj=document.createElement('img');
    imgobj.src=imgsrc;

    width=document.body.clientWidth<imgobj.width?parseInt(document.body.clientWidth/1.05):imgobj.width;
    height=document.body.clientHeight<imgobj.height+42?parseInt(document.body.clientHeight/1.05):imgobj.height+42;
    layer.open({
        type:1,
        skin: 'layui-layer-nobg', //没有背景色
        area:[width+'px',height+'px'],//宽高
        fix:false,
        shadeClose:true,
        maxmin: true, //开启最大化最小化按钮
        title:imgobj.src,
        resize:true,
        content:dom
    });
}

/* 权限树的冒泡与捕获 */
function checkbox_change(obj) {
    var _this=obj,
        _id=_this.data('id'),
        parent_id=_this.data('parent-id'),
        parent_obj=$('#id-'+parent_id),
        child_obj=$('input[data-parent-id='+_id+']');
    if(_this.prop('checked') && parent_id){
        parent_obj.prop("checked", true);
        checkbox_change(parent_obj);
    }else if(!_this.prop('checked') && child_obj.length){
        $.each(child_obj,function (index,info) {
            $(info).prop('checked',false);
            checkbox_change($(info));
        })
    }
}

$(function(){
	//关闭右键菜单
	$(document,'body').mousedown(function(event){
		parent.close_clickRight();
	});
	//设置table高度
	$(".tableCon").height($("body").height()-101);
	//table 点击背景
	$(".table td").click(function(){
		if(!$(this).find("input").hasClass("va_m")){
			$(this).addClass("on").siblings().addClass("on");
			$(this).parent().siblings().find("td").removeClass("on");
		}		
	});
	
	//拉伸时禁用复制
	document.onselectstart = function(event){
        var eve = event || window.event; //获取事件对象
        var objEle = eve.target || eve.srcElement; //获取document 对象的引用
		if($(objEle).parents().hasClass("noSelect") || $(objEle).parent().hasClass("noSelect") || $(objEle).hasClass("xian")){
			return false
		}
	};
	
	//table拉伸
	var stretch = $(".table th .stretch");//拉伸点
	var xian = $(".tableCon>.xian");//对比线
	var oldX = 0,newX = 0;
	var oldW = 0,newW = 0;
	var this_ = null;
	for (var i = 0; i < stretch.length; i++) {//初始化设置th宽度最小40
		var thW = $(stretch).eq(i).parents("th").width() < 35?35:$(stretch).eq(i).parents("th").width();
		$(stretch).eq(i).parents("th").width(thW);
	}
	$(stretch).mousedown(function(event){
		this_ = this;
		oldW = $(this_).parents("th").width()-2;
		oldX = event.pageX;//拉伸前的th位置
		$(xian).css("left",event.pageX+"px").show();			
	});
	
	$("body").mousemove(function(event){
		newX = event.pageX;//拉伸后的th位置
		newW = newX - oldX + oldW;
		var xianX = $(this_).parents("th").offset() + 35;//宽度最小时线的位置
		if(newW < 35){
			$(xian).css("left",xianX+"px");
			newW = 35;
			if(newX < 30){
				$(this_).parents(".table").width($(this_).parents(".table").width() + newW - oldW);
				$(this_).parents("th").width(newW);
				$(xian).hide();
				this_ = null;
			}
		}else{
			$(xian).css("left",event.pageX+"px");
		}		
	});
	
	$("body").mouseup(function(event){
		$(this_).parents(".table").width($(this_).parents(".table").width() + newW - oldW);
		$(this_).parents("th").width(newW);
		$(xian).hide();
		this_ = null;
	});
	
	
	//首页TAB切换
	var tabs_a = $(".homeTab li a");//首页TAB链接集
	var tabs_li = $(".homeTab li");//首页TAB选项集
	var tabs = tabs_a.length?tabs_a:tabs_li;//首页TAB集
	var tabCon = $(".homeCon table");//首页TAB内容集
    var tabConPage = $(".homeCon .tabPage");//TAB内容集
	$(tabs).each(function(index,e){
		$(e).click(function(){
			$(this).addClass("on").siblings().removeClass("on");
			$(tabCon).eq(index).addClass("on").siblings().removeClass("on");
            $(tabConPage).eq(index).addClass("on").siblings().removeClass("on");
		})
	})

});


