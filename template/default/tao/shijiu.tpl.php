<?php
/**
 * ============================================================================
 * 版权所有 多多科技，保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('INDEX')){
	exit('Access Denied');
}

include(TPLPATH.'/header.tpl.php');
$url=DD_YUN_URL.'/index.php?g=Home&m=Shuju&a=jiu&ver=1.1&url='.urlencode(SITEURL).'&type=3&cururl='.urlencode(u(MOD,ACT));
$w=1000;

$html_url=url_html_cache('jiu',$url);
?>
<script>
setInterval("listenHash()", 500);
var pageTime = 0;
var adjustH=0;
function listenHash() {
    var url = location.href;
    url = url.split('#');
    if (url[1] != '') {
		var p=parseInt(url[1]);
		if(p<5000){
			if(adjustH==0){
				$('#ddiframediv iframe')[0].style.height=p+'px';
				adjustH=1;
			}
		}
        else{
			var pageTime_temp = p;
        	if (pageTime_temp > pageTime) {
            	window.scrollTo(0,$('#ddiframediv')[0].offsetTop);
            	pageTime = pageTime_temp;
        	}
		}
    } 
	else {
        pageTime = parseInt(Date.parse(new Date()));
    }
}
</script>
<div id="ddiframediv" style=" width:<?=$w?>px; border:#F36519 1px solid; margin:auto; margin-top:10px; padding-top:10px; background:#FFF">
<script>iframe('<?=$html_url?>',<?=$w?>,1950);</script>
</div>
<?php include(TPLPATH.'/footer.tpl.php');?>