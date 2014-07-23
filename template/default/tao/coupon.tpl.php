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

include(DDROOT.'/plugin/tao_coupon.php');

if(isset($_GET['id'])){
	$id = trim($_GET["id"]);
	$url="http://shop.m.taobao.com/shop/shop_index.htm?shop_id=$id";
	$html =file_get_contents($url);
	$preg = "#nick=(.*?)&amp#";
	preg_match_all( $preg, $html, $nick);//获取优惠券店铺名称
	$nick=$nick[1][0];
	$url="index.php?mod=tao&act=shop&nick=".$nick;
	jump($url);
}

include(TPLPATH.'/header.tpl.php');
$url=DD_YUN_URL.'/index.php?m=Coupon&a=index&url='.urlencode(SITEURL).'&q='.urlencode($_GET['q']);
$w=1002;

$html_url=url_html_cache('tao_coupon',$url);
?>
<div style=" width:<?=$w?>px; border:#D0210C 1px solid; background:#FFF; margin:auto; margin-top:10px;">
<script>iframe('<?=$html_url?>',<?=$w?>,1383);</script>
</div>
<?php include(TPLPATH.'/footer.tpl.php');?>