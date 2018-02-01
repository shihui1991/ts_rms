
//左边一级导航开关控制
function leftNavToggle(e){
	var nav2H = $(e).find('li').length*37+37;//二级导航总高度
	if($(e).hasClass("open")){
		$(e).removeClass("open").find(".leftNav_2").stop().animate({height:'0px'},300);
	}else{
		$(e).addClass("open").siblings().removeClass("open").find(".leftNav_2").stop().animate({height:'0px'},300);
		$(e).find(".leftNav_2").stop().animate({height:nav2H+'px'},300);
	}
}
//左边二级导航管理
function leftSubNavManage(e,event){
	//背景控制
	$(".leftNav_2 li").removeClass("on");
	$(e).addClass("on");
	//打开页面
	var tab = $(".tabNav");//TAB
	var iframeCon = $(".rightIframeCon");//iframe容器
	var tabs = $(".tabNav li");//TAB集
	var iframes = $(".rightIframeCon .iframe");//iframe集
	var tit = $(e).attr("data-tit");//页面标题
	var hasTit = isOpenTitPage(tabs,tit) == undefined?false:true;//判断是否已打开过此标题页面
	var index = isOpenTitPage(tabs,tit) == undefined?0:isOpenTitPage(tabs,tit);//当前TABS索引
	if(hasTit){//已打开此页面
		$(tabs).eq(index).addClass("on").siblings().removeClass("on");
		$(iframes).eq(index).addClass("on").siblings().removeClass("on");
		
	}else{//未打开此页面
		var iframeSrc = $(e).attr("data-src");
		var li = '<li data-tit="'+tit+'" class="on" onmousedown="tabManage(this,event)"><img src="/static/system/img/file_extension_log.png"/>'+tit+'<span title="关闭当前窗口" onclick="closeIframe()"></span></li>';
		var iframeItem = '<iframe src="'+iframeSrc+'" data-tit="'+ tit +'" class="iframe on" id="'+iframeSrc+'"></iframe>';
		$(tabs).removeClass("on");
		$(tab).append(li);
		$(iframeCon).append(iframeItem);
	}
	/*event.stopPropagation();*/
    if ( event.stopPropagation ) {
        event.stopPropagation();
    } else {
        event.cancelBubble = true;
    }
}


//头部二级导航开关
function navToggle(){
	var navs = $(".nav>li");//头部导航集
	$(navs).each(function(index,e){
		$(e).hover(function(){
			var H = $(this).width();//当前导航项宽度
			var h = $(this).find(".navPopup").width();//子导航宽度
			$(this).find(".navPopup").css("margin-left",(H-h)/2+'px').show();
		},function(){
			$(this).find(".navPopup").hide();
		})
	})
}


//tab事件管理
function tabManage(e,event){
	var tabs = $(".tabNav li");//TAB集
	var iframes = $(".rightIframeCon .iframe");//iframe集
	var tit = $(e).attr("data-tit");//页面标题
	var index = isOpenTitPage(tabs,tit);//当前索引
	$(e).on("contextmenu", function(){//禁止浏览器默认右键菜单
	    return false;
	});

    if (event.type=='mousedown' && (2==event.button || 3==event.button)) {//右键为3   ie鼠标右键为2
        if(tit == '欢迎首页'){
            close_clickRight();
        }else{
            var x,y;
            x=event.clientX;
            y=event.clientY;
            $(".clickRight").css({top:y+'px',left:x+'px'}).show();

        }
        $(e).addClass("on").siblings().removeClass("on");
        $(iframes).eq(index).addClass("on").siblings().removeClass("on");
    }else if (event.type=='mousedown' && (0==event.button||1==event.button)) {//左键为1 ie9以上左键为0 ie8左键为1
        close_clickRight();
        $(e).addClass("on").siblings().removeClass("on");
        $(iframes).eq(index).addClass("on").siblings().removeClass("on");
    }
}
//获取当前TABS索引
function isOpenTitPage(tabs,tit){
	if(tit == null){
		for (var i=0; i < tabs.length; i++) {
			if($(tabs).eq(i).hasClass("on")){
				return i;
			}
		}
	}else{
		for (var i=0; i < tabs.length; i++) {
			if(tit == $(tabs).eq(i).attr("data-tit")){
				return i;
			}
		}
	}	
}
//关闭当前iframe页面
function closeIframe(){
	var tabs = $(".tabNav li");
	var iframes = $(".rightIframeCon .iframe");
	var index = isOpenTitPage(tabs);
	$(tabs).eq(index).remove();
	$(iframes).eq(index).remove();
	tabs = $(".tabNav li");
	iframes = $(".rightIframeCon .iframe");
	$(tabs).eq(tabs.length-1).addClass("on");
	$(iframes).eq(tabs.length-1).addClass("on");
	close_clickRight();
}
//关闭右键菜单
function close_clickRight(){
	$(".clickRight").hide();
}
//刷新当前iframe页面
function refreshIframe(){
	console.log("刷新")
	close_clickRight();
}
//关闭全部iframe页面
function closeIframeAll(){
	console.log("全部关闭")
	close_clickRight();
}
//除此之外，关闭全部iframe页面
function closeIframeAllOne(){
	console.log("除此之外全部关闭")
	close_clickRight();
}



$(function(){
	var nav2 = $(".leftNav_1>li.open .leftNav_2");
	var nav2H=nav2.find('li').length*37+37; //二级导航总高度
    nav2.height(nav2H);//设置左边二级导航高度
	navToggle();//头部二级导航
	
	//鼠标点击页面关闭自定义右键菜单
	$(document,'body').mousedown(function(event){
        var eve = event || window.event; //获取事件对象
        var objEle = eve.target || eve.srcElement; //获取document 对象的引用
		if(2 == eve.button){
			if($(objEle).parent()[0].className.indexOf("tabNav") < 0 && $(objEle).parent().parent()[0].className.indexOf("tabNav") < 0){
				close_clickRight();
			}
		}else{
			if($(objEle).parent()[0].className.indexOf("clickRight") < 0 && $(objEle).context.className.indexOf("clickRight") < 0){
				close_clickRight();
			}
		}
	})
	
	
})
