<?php
/**
 * ============================================================================
 * 版权所有 2008-2012 多多科技，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('INDEX')){
	exit('Access Denied');
}

include(DDROOT.'/plugin/juhuasuan.php');

include(TPLPATH.'/header.tpl.php');
$url=DD_YUN_URL.'/index.php?m=shuju&a=index&url='.urlencode(SITEURL);
$w=1000;

$html_url=url_html_cache('juhuasuan',$url);
?>
<div style=" width:<?=$w?>px; border:#D0210C 1px solid; margin:auto; margin-top:10px;">
<script>iframe('<?=$html_url?>',<?=$w?>,3050);</script>
</div>
<?php include(TPLPATH.'/footer.tpl.php');?>