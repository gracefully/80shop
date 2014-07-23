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

if($dduser['id']==0){
	jump(u('user','login',array('from'=>u('zhidemai','baoliao'))));
}

$data=array('site_url'=>SITEURL,'username'=>$dduser['name'],'uid'=>$dduser['id'],'password'=>$dduser['ddpassword'],'cur_url'=>u(MOD,ACT));
$url=DD_U_URL.'/index.php?g=alliance&m=baoliao&a=add&'.http_build_query($data);