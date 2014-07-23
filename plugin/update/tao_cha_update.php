<?php
/**
 * ============================================================================
 * 版权所有 2008-2013 多多科技，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('PLUGIN')){
	exit('Access Denied');
}

define('MY_PLUGIN_KEY','duoduo'); //插件加密key
define('MY_PLUGIN_CODE','tao_cha'); //插件标识码

$plugin=new plugin($duoduo);

if($do=='install'){
	$install_sql="";  //安装sql
	$plugin->install($install_sql);
	$alert_word='安装完成';
}
elseif($do=='uninstall'){
	$uninstall_sql="";  //卸载sql
	$plugin->uninstall($uninstall_sql);
	$alert_word='卸载完成';
}
else{
	dd_exit('error do');
}
jump(-1,$alert_word);
?>