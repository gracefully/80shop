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

if($_POST['sub']!=''){
	$code=$_GET['code'];
	$page=(int)$_GET['page'];
	if($page==0) $page=1;
	$url=DD_U_URL.'/index.php?m=DdApi&a=goods&url='.urlencode(URL).'&key='.md5(DDYUNKEY).'&code='.urlencode($code).'&page_size=40&page='.$page;
	$a=dd_get_json($url);
	print_r($a);
	exit;
	
	//PutInfo()
}
