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

if(!defined('ADMIN')){
	exit('Access Denied');
}
$get['url']=URL;
$get['a']=$_GET['a'];
$get['code']=$_GET['code'];
$get['type']=$_GET['type'];
$get['curl_url']=u(MOD,ACT,array('a'=>$_GET['a'],'code'=>$_GET['code'],'type'=>$_GET['type']));
$query=http_build_query($get);

if($get['a']=='lanmu'){
	$top_nav_name=array(array('id'=>'a','name'=>'商家平台'));
}
if($get['code']=='zhidemai'){
	$top_nav_name=array(array('id'=>'a','name'=>'值得买'));
}

include(ADMINTPL.'/header.tpl.php');
?>
<iframe src="<?=DD_U_URL?>/index.php?g=alliance&m=zhidemai&<?=$query?>" frameborder="0" width="100%" height="1000px"></iframe>
<?php include(ADMINTPL.'/footer.tpl.php');?>