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

define('PLUGIN',1);

include ('../comm/dd.config.php');
include(DDROOT.'/plugin/plugin.class.php');

$code=$_GET['code'];
$do=authcode($_GET['do'],'DECODE');
if($do!='install' && $do!='uninstall'){
	dd_exit('no');
}

$dir=DDROOT.'/plugin/update/'.$code.'_update.php';
if(file_exists($dir)){
	include($dir);
}
else{
	jump(-1,'安装文件不存在，请先下载上传');
}
?>