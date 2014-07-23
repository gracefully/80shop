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

if($webset['ddgoodslanmu']=='' && ACT!='lanmu'){
	jump(u(MOD,'lanmu'),'请先设置栏目信息');
}
$u_url=DD_U_URL.'/?g=Alliance&m=Goods&a=index&url='.urlencode(URL).'&code=';

$code=$_GET['code'];
include(DDROOT.'/comm/ddgoods.class.php');
$ddgoods_class=new ddgoods($duoduo);
if($code!=''){
	$cid_arr=$ddgoods_class->catname($code);
}

if(ACT=='addedi'){
	unset($cid_arr['']);
}
?>