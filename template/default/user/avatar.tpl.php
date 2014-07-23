<?php
$css[]=TPLURL."/css/usercss.css";
include(TPLPATH."/header.tpl.php");
?>
<script type="text/javascript">
var BROWSER = {};
var USERAGENT = navigator.userAgent.toLowerCase();
if(BROWSER.safari) {
	BROWSER.firefox = true;
}
BROWSER.opera = BROWSER.opera ? opera.version() : 0;

HTMLNODE = document.getElementsByTagName('head')[0].parentNode;
if(BROWSER.ie) {
	BROWSER.iemode = parseInt(typeof document.documentMode != 'undefined' ? document.documentMode : BROWSER.ie);
	HTMLNODE.className = 'ie_all ie' + BROWSER.iemode;
}

function AC_FL_RunContent() {
	var str = '';
	var ret = AC_GetArgs(arguments, "clsid:d27cdb6e-ae6d-11cf-96b8-444553540000", "application/x-shockwave-flash");
	if(BROWSER.ie && !BROWSER.opera) {
		str += '<object ';
		for (var i in ret.objAttrs) {
			str += i + '="' + ret.objAttrs[i] + '" ';
		}
		str += '>';
		for (var i in ret.params) {
			str += '<param name="' + i + '" value="' + ret.params[i] + '" /> ';
		}
		str += '</object>';
	} else {
		str += '<embed ';
		for (var i in ret.embedAttrs) {
			str += i + '="' + ret.embedAttrs[i] + '" ';
		}
		str += '></embed>';
	}
	return str;
}

function AC_GetArgs(args, classid, mimeType) {
	var ret = new Object();
	ret.embedAttrs = new Object();
	ret.params = new Object();
	ret.objAttrs = new Object();
	for (var i = 0; i < args.length; i = i + 2){
		var currArg = args[i].toLowerCase();
		switch (currArg){
			case "classid":break;
			case "pluginspage":ret.embedAttrs[args[i]] = 'http://www.macromedia.com/go/getflashplayer';break;
			case "src":ret.embedAttrs[args[i]] = args[i+1];ret.params["movie"] = args[i+1];break;
			case "codebase":ret.objAttrs[args[i]] = 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0';break;
			case "onafterupdate":case "onbeforeupdate":case "onblur":case "oncellchange":case "onclick":case "ondblclick":case "ondrag":case "ondragend":
			case "ondragenter":case "ondragleave":case "ondragover":case "ondrop":case "onfinish":case "onfocus":case "onhelp":case "onmousedown":
			case "onmouseup":case "onmouseover":case "onmousemove":case "onmouseout":case "onkeypress":case "onkeydown":case "onkeyup":case "onload":
			case "onlosecapture":case "onpropertychange":case "onreadystatechange":case "onrowsdelete":case "onrowenter":case "onrowexit":case "onrowsinserted":case "onstart":
			case "onscroll":case "onbeforeeditfocus":case "onactivate":case "onbeforedeactivate":case "ondeactivate":case "type":
			case "id":ret.objAttrs[args[i]] = args[i+1];break;
			case "width":case "height":case "align":case "vspace": case "hspace":case "class":case "title":case "accesskey":case "name":
			case "tabindex":ret.embedAttrs[args[i]] = ret.objAttrs[args[i]] = args[i+1];break;
			default:ret.embedAttrs[args[i]] = ret.params[args[i]] = args[i+1];
		}
	}
	ret.objAttrs["classid"] = classid;
	if(mimeType) {
		ret.embedAttrs["type"] = mimeType;
	}
	return ret;
}
</script>
<div class="mainbody">
	<div class="mainbody1000">
    <?php include(TPLPATH."/user/top.tpl.php");?>
    	<div class="adminmain">
        	<div class="adminleft">
                <?php include(TPLPATH."/user/left.tpl.php");?>
            </div>
        	<div class="adminright">
              <div style="float:left; padding-left:30px">
<p style="line-height:30px">请选择一个新照片进行上传编辑。</p>
<?php if($webset['user']['up_avatar']==2){?>
<p style="line-height:30px">头像保存后，您可能需要刷新一下本页面(按F5键)，才能查看最新的头像效果</p> 
<script type="text/javascript">document.write(AC_FL_RunContent('width','450','height','253','scale','exactfit','src','images/camera.swf?nt=1&inajax=1&input=<?=$a?>&agent=d41d8cd98f00b204e9800998ecf8427e&ucapi=<?=urlencode(u('user','up_avatar',array('uploadSize'=>1024)))?>','id','mycamera','name','mycamera','quality','high','bgcolor','#ffffff','wmode','transparent','menu','false','swLiveConnect','true','allowScriptAccess','always'));</script>
</div>
<?php }else{?>
<p style="line-height:30px">头像保存后，您可能需要刷新一下本页面(按F5键)，才能查看最新的头像效果</p> 
<div class="up_avatar_bg">
<form method="post" enctype="multipart/form-data">
<a class="btn_addPic"><input size="3" type="file"  title="支持jpg、jpeg、gif、png格式，文件小于2M" class="filePrew" name="up_pic" /></a>
<div class="img-button"><p><input type="submit" value="上 传" name="sub" class="ShiftClass" onclick="if($('.filePrew').val()==''){alert('未选择上传图片！');return false;}" /></p></div>
</form>
</div>
</div>
<?php }?>

<div style=" width:250px; float:left;">
<img style="margin-top:60px; margin-left:10px"  src="<?=a($dduser['id'], $size = 'big')?>" />
</div>
            </div>
        
        </div>
  </div>
</div>
</div>


<?php
include(TPLPATH."/footer.tpl.php");
?>