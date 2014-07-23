<?php //多多
if(!defined('INDEX')){
	exit('Access Denied');
}

include(TPLPATH.'/header.tpl.php');
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
		var pageTime_temp = p;
        if (pageTime_temp > pageTime) {
           	window.scrollTo(0,0);
           	pageTime = pageTime_temp;
        }
    } 
	else {
        pageTime = parseInt(Date.parse(new Date()));
    }
}
</script>
<div style="width:1000px; margin:auto; margin-top:10px" id="ddiframediv"><iframe src="<?=$url?>" style=" width:1000px; height:3000px;overflow-x:hidden;overflow-y:auto" frameborder="0"></iframe></div>
<?php
include(TPLPATH.'/footer.tpl.php');
?>
