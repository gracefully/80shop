<?php
header("Content-type: text/html; charset=utf-8");
error_reporting(0);
date_default_timezone_set('PRC');
define('DDROOT', str_replace(DIRECTORY_SEPARATOR,'/',dirname(dirname(__FILE__))));

if(!is_file(DDROOT.'/data/conn.php')){
    header('Location:install/index.php');
}

if(defined('PLUGIN')){
	$query=$_GET['plugin_query'];
	if($query!=''){
		$query_arr=explode('-',$query);
		$_GET['mod']=$query_arr[0];
		$_GET['act']=$query_arr[1];
		$plugin_query=str_replace($query_arr[0].'-'.$query_arr[1],'',$query);
		define('PLUGIN_QUERY',$plugin_query);
	}
}

$mod=isset($_GET['mod'])?$_GET['mod']:'index'; //当前模块
$act=isset($_GET['act'])?$_GET['act']:'index'; //当前行为

if(!preg_match('/^[\w-]+$/',$mod)){
	exit('error mod');
}

if(!preg_match('/^[\w-]+$/',$act)){
	exit('error act');
}

if(!defined('PLUGIN')){
	define('MOD',$mod);
	define('ACT',$act);
}

define('TODAY',date('Ymd'));

include (DDROOT . '/data/conn.php');
include (DDROOT . '/comm/lib.php');

$banben=include(DDROOT.'/data/banben.php');
define('BANBEN',$banben);

$duoduo = new duoduo();
$duoduo->dbserver=$dbserver;
$duoduo->dbuser=$dbuser;
$duoduo->dbpass=$dbpass;
$duoduo->dbname=$dbname;
$duoduo->BIAOTOU=BIAOTOU;
$duoduo_link=$duoduo->connect();
$errorData=include (DDROOT . '/data/error.php');
$duoduo->errorData=$errorData;

if(!defined('ADMIN')){
	$webset=dd_get_cache('webset');
	$constant=dd_get_cache('constant');
	
	if(empty($webset) || empty($constant)){  //个别网站配置文件没了
		$duoduo->webset();
		$webset=dd_get_cache('webset');
	}
	$duoduo->webset=$webset;
	
	foreach($constant as $k=>$v){
    	define($k,$v);
	}
}
else{
	$webset=$duoduo->webset(101);
	$duoduo->webset=$webset;
	$duoduo->errorData=$errorData;
}

define('SITEURL', 'http://'.URL);
define('CURURL', 'http://'.$_SERVER['HTTP_HOST'].URLMULU);
define('DOMAIN', get_domain());
define('TIME',$_SERVER['REQUEST_TIME']+$webset['corrent_time']);
$sj=date('Y-m-d H:i:s',TIME);
define('SJ',$sj);
define('CUR_URL','http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
define('WEBNICK',WEBNAME);

$plugin_include=dd_get_cache('plugin_include');
if(!empty($plugin_include)){
	foreach($plugin_include as $code){
		$dir=DDROOT.'/plugin/'.$code.'/comm.php';
		if(file_exists($dir)){
			include($dir);
		}
		else{
			if($code!=''){
				include(DDROOT.'/plugin/comm/'.$code.'.php');
			}
		}
	}
}
?>