<?php
define('INDEX',1);
if(!isset($_GET['mod'])) $_GET['mod']='fxb';
if(!isset($_GET['act'])) $_GET['act']='index';
include ('../comm/dd.config.php');
include ('../comm/checkpostandget.php');
include ('../mod/header.act.php');

define('TPLPATH',DDROOT.'/template/'.MOBAN);
define('TPLURL','template/'.MOBAN);
define('PAGETAG','fxb');
$mod=MOD;
$act=ACT;

if(MOD!=='fxb' || ACT!='index'){
	dd_exit('error mod act');
}

if($webset['fxb']['open']==0 && $dduser['fxb']==0){
    jump('../index.php');
}

$shoucang_code="javascript:void((function(d){var c=window.location.href;h=window.location.host;window.location.href='".SITEURL."/index.php?mod=tao&act=view&host='+h+'&q='+encodeURIComponent(c)+'&uid=".$dduser['id']."'})(document));";
?>