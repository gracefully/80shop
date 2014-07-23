var fanUser = document.getElementById('xiufanxianbao').src.split('?')[1];
var xiuMouseAble = false;
var xiuMouseX = 0;
var xiuMouseY = 0;
var xiuClientX = 0;
var xiuClientY = 0;
var xiuStrIframeUrl = "http://localhost/duoduo/v8-1/fanxianbao/fanxianbao.php?u="+fanUser+"";
function mouseDown(obj, evt) {
	e = evt?evt:window.event;
	if (!window.captureEvents) {
		obj.setCapture();
	} else {
		window.captureEvents(event.mousemove|event.mouseup);
	}
	var fanWin = document.getElementById("fanWin");
	xiuClientX = e.clientX;
	xiuClientY = e.clientY;
	xiuMouseX = parseInt(fanWin.style.left);
	xiuMouseY = parseInt(fanWin.style.top);
	xiuMouseAble=true;
}
function mouseMove(obj, evt) {
	e = evt?evt:window.event;
	if (xiuMouseAble) { 
		var fanWin = document.getElementById("fanWin");
		fanWin.style.left = xiuMouseX+e.clientX-xiuClientX;
		fanWin.style.top = xiuMouseY+e.clientY-xiuClientY;
	}
}
function mouseUp(obj, evt) {
	if (xiuMouseAble) {
		if (!window.captureEvents){
			obj.releaseCapture();
	   	} else {
			window.releaseEvents(event.mousemove|event.mouseup);
		}
		xiuMouseAble = false;
	}
}
function closeDiv(str) {
	document.getElementById(str).style.display="none";
}
function colseTips() {
	document.getElementById('closeTips').style.display="block";
}
function writeDocument(strIframe) {
	var strHtml = "<div style=\"width:712px;border:6px solid #c2c2c2;background:#fff;height:462px;\"><div style=\"background:#b10000;height:30px;color:#fff;font-size:14px;font-weight:bold;text-indent:3px;\"><em style=\"float:right; margin-right:10px; margin-top:8px;width:16px;height:14px;display:block;cursor:pointer;background:url(images/bao_gif.gif) no-repeat;\" title=\"关闭，无法拿返现！\" onclick=\"closeDiv('fanWin')\" onmouseover=\"colseTips()\"></em><span id=\"closeTips\" style=\"float:right;width:125px;height:30px;line-height:30px;font-size:12px;display:none\">关闭将无法拿返现-></span><span style=\"width:525px;height:30px;line-height:30px;display:block;cursor:move;\" onmousedown=\"mouseDown(this,event)\" onmousemove=\"mouseMove(this,event)\" onmouseup=\"mouseUp(this)\">淘白米省钱(TaoByMe.com)</span></div><div style=\"margin:5px;height:400px;\"><iframe src='"+strIframe+"' id='iframeFan' name='iframeFan' width=700 height=400 frameborder=0 scrolling=auto></iframe></div><div style=\"text-align:right;margin-right:5px;font-size:14px;font-weight:bold;\"><a href=\"javascript:;\" title=\"关闭，无法拿返现！\" onclick=\"closeDiv('fanWin')\" onmouseover=\"colseTips()\">关闭</a></div></div>";
	document.getElementById("fanWin").style.zIndex = 10000;
	document.getElementById("fanWin").style.position = 'absolute';
	document.getElementById("fanWin").style.display="block";
	document.getElementById("fanWin").innerHTML=strHtml;
	xiuMouseX = doc.scrollTop+doc.clientHeight/2-document.getElementById("fanWin").offsetHeight/2;
	xiuMouseY = doc.scrollLeft+doc.clientWidth/2-document.getElementById("fanWin").offsetWidth/2;
	document.getElementById("fanWin").style.top = xiuMouseX+"px";
	document.getElementById("fanWin").style.left = xiuMouseY+"px";
}

var doc = (document.compatMode!="BackCompat")?document.documentElement:document.body;
xiuKeyText = document.selection.createRange().text;
xiuStrUrl = document.URL;

var taobao=0;
var tmall=0;

if(xiuStrUrl.indexOf("taobao.com")>=0){
    taobao=1;
}
if(xiuStrUrl.indexOf("tmall.com")>=0){
    tmall=1;
}

if(taobao==1 || tmall==1){
    if(xiuKeyText==''){
	    if(taobao==1){
			splitWord='-淘宝网';
		}
		if(tmall==1){
		    splitWord='-tmall.com天猫';
		}
		xiuKeyText = document.getElementsByTagName("title")[0].innerHTML.split(splitWord)[0];//@
	}
	var fanWin=document.createElement('div');
	fanWin.id = 'fanWin';
	xiuKeyText = xiuKeyText;
	document.getElementsByTagName('body')[0].insertBefore(fanWin, document.getElementsByTagName('body')[0].firstChild)
	writeDocument("http://localhost/duoduo/v8-1/fanxianbao/fanxianbao.php?u="+encodeURI(fanUser)+"&url="+encodeURIComponent(xiuStrUrl)+"&qkey="+encodeURI(xiuKeyText));
}
else{
    alert('此商品已下架或不是商品页');
}
