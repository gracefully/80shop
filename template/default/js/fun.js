function postForm(action,input){
	var postForm = document.createElement("form");
    postForm.method="post" ;
    postForm.action = action ;
	var k;
    for(k in input){
		if(input[k]!=''){
			var htmlInput = document.createElement("input");
			htmlInput.setAttribute("name", k) ;
            htmlInput.setAttribute("value", input[k]);
            postForm.appendChild(htmlInput) ;
		}
	}
	document.body.appendChild(postForm) ;
    postForm.submit() ;
    document.body.removeChild(postForm) ;
}

function u(mod,act,arr){
	if(!arguments[2]){
	    var arr = new Array()
	}
	var mod_act_url='';
	if(act=='' && mod=='index'){
	    mod_act_url='?';
	}
	else if(act==''){
	    mod_act_url="?mod="+mod+"&act=index";
	}
	else{
	    mod_act_url="?mod="+mod+"&act="+act+arr2param(arr);
	}
    return mod_act_url;
}

function arr2param(arr){
	var param='';
	var k;
    for(k in arr){
		if(arr[k]!=''){
		    param+='&'+k+'='+arr[k];
		}
	}
	return param;
}

function AddFavorite(sURL, sTitle){
 try{
  window.external.addFavorite(sURL, sTitle);
  }
 catch (e){
  try{
   window.sidebar.addPanel(sTitle, sURL, "");
   }
  catch (e)
  {
   alert("加入收藏失败，您的浏览器不允许，请使用Ctrl+D进行添加");
  }
 }
}

function showLogin()
{
    $('#menu_weibo_login').toggle();
}

function showHide(id)
{
    $('#'+id).toggle();
}

function zhidemaiLazyLoad($t){
	$t=$t||$('#zhidemaiDiv');
	var $obj=$t.find("img.lazy");
	var $cobj=$t.find('.J-item-content-inner');
	$obj.lazyload({
		threshold:20,
		failure_limit:50,
		effect : "fadeIn"
	});
	
	$cobj.each(function(){
		var $t=$(this).parent('.nodelog-detail');
		if($(this).height()>200){
			$t.next('.item-toggle').find('a').show();
		}
	});
}

function jiuLazyLoad($t){
	$t=$t||$('#jiuDiv');
	var $obj=$t.find("img.lazy");
	$obj.lazyload({
		threshold:20,
		failure_limit:50,
		effect : "fadeIn"
	});
}

function shijiuLazyLoad($t){
	$t=$t||$('#shijiuDiv');
	var $obj=$t.find("img.lazy");
	$obj.lazyload({
		threshold:20,
		failure_limit:50,
		effect : "fadeIn"
	});
}

function tejiaLazyLoad($t){
	$t=$t||$('#tejiaDiv');
	var $obj=$t.find("img.lazy");
	$obj.lazyload({
		threshold:20,
		failure_limit:50,
		effect : "fadeIn"
	});
}

/*function zhanneiLazyLoad($t){
	$t=$t||$('#zhanneiDiv');
	var $obj=$t.find("img.lazy");
	$obj.lazyload({
		threshold:20,
		failure_limit:50,
		effect : "fadeIn"
	});
}*/

function zhuanxiangLazyLoad($t){
	if($t){
		var $imgObj=$t.find("img.lazy");
		var $menuLiObj=$t;
		var $cellObj=$t;
	}
	else{
		$t=$('#zhuanxiangDiv');
		var $imgObj=$t.find("img.lazy");
		var $menuLiObj=$t.find("li");
		var $cellObj=$t.find(".cell");
	}
	
	$imgObj.lazyload({
		threshold:20,
		failure_limit:50,
		effect : "fadeIn"
	});

	$menuLiObj.hover(function () {
		var $this = $(this);
		$menuLiObj.removeClass("on");
		$this.addClass("on");
    },function(){
		$menuLiObj.removeClass("on");
	});
	
	$cellObj.jumpBox({  
		LightBox:'show',
		height:220,
		width:380,
		defaultContain:1,
		closeFun:1,
		jsCode:'shoujiBuy($(this))'
    });
}

function zhanneiLazyLoad($t){
	if($t){
		var $imgObj=$t.find("img.lazy");
		if($t.hasClass('cell')){
			var $cellObj=$t;
		}
	}
	else{
		$t=$('#zhanneiDiv');
		var $imgObj=$t.find("img.lazy");
		var $cellObj=$t.find(".cell");
	}
	
	$imgObj.lazyload({
		threshold:20,
		failure_limit:50,
		effect : "fadeIn"
	});
	
	if($cellObj){
		$cellObj.jumpBox({  
			LightBox:'show',
			height:220,
			width:380,
			defaultContain:1,
			jsCode:'shoujiBuy($(this))'
		});
	}
}

function shoujiBuy($t){
	var id=$t.attr('id');
	var url=$t.attr('url');
	var youhui=$t.attr('youhui');
	var $jumpbox=$('#jumpbox');
	$jumpbox.find('.erweima-pic').attr('src','images/blank.png');
	$jumpbox.find('.youhui').html('——');
	$jumpbox.find('.url').attr('href','');
	$jumpbox.find('.erweima-pic').attr('src',erweima_api(id));
	$jumpbox.find('.youhui').html(youhui);
	$jumpbox.find('.url').attr('href',url);
}