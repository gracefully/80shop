<?php
if(!defined('INDEX')){
	exit('Access Denied');
}
$css[]=TPLURL."/css/view.css";
$js[]="js/md5.js";
$js[]="js/jssdk.js";
$js[]="js/jQuery.autoIMG.js";
include(TPLPATH.'/header.tpl.php');
?>
<div class="mainbody">
	<div class="mainbody1000">
    <div style=" width:998px; border:#D0210C 1px solid; background:#FFF; margin:auto; margin-top:10px; padding-bottom:10px">
    
    <div style="width:720px; margin:auto; margin-top:10px">
        <table style="width:100%">
  <tr>
    <td><a data-type="0" biz-itemid="<?=$iid?>" data-tmpl="628x100" data-tmplid="7" data-rd="1" data-style="2" data-border="1" href=""></a></td>
    <td align="right" style="color:#F00; font-weight:bold; font-size:14px;">该商品<br/>无返利</td>
  </tr>
</table>


      <div style="margin-top:20px; font-size:14px; font-family:宋体">推荐商品</div>
      <div style="width:720px; margin:auto; margin-top:5px">
        <a data-type="10" biz-itemid="<?=$iid?>" data-tmpl="720x220" data-tmplid="143" data-rd="1" data-style="2" data-border="1" href=""></a>
      </div>
    </div>
    
    </div>
    </div>
</div>
<?php include(TPLPATH.'/footer.tpl.php');?>