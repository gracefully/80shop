<?php
/**
 * ============================================================================
 * 版权所有 2008-2012 多多科技，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('INDEX')){
	exit('Access Denied');
}

define('MY_PLUGIN_KEY','duoduo'); //插件加密key
define('MY_PLUGIN_CODE','juhuasuan'); //插件标识码

$plugin_set=dd_get_cache('plugin');

include(DDROOT.'/plugin/plugin.class.php');

class juhuasuan extends plugin{
	function __construct($duoduo){
		parent::__construct($duoduo);
	}
}

if($plugin_set[MY_PLUGIN_CODE]==1){
	$juhuasuan=new juhuasuan($duoduo);
}
?>