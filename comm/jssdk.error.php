<?php //多多
define('DDROOT', str_replace(DIRECTORY_SEPARATOR,'/',dirname(dirname(__FILE__))));
include('../data/conn.php');
include('comm.func.php');
include('dd.func.php');
$code=$_GET['code'];
$msg=$_GET['msg'];
$url=$_GET['url'];
$method=$_GET['method'];
$check=authcode($_GET['check'],'DECODE');
if($_SERVER['REQUEST_TIME']-$check>50){
	exit('timeout');
}

$msg='code:'.$code.'|'.'msg:'.$msg.'|'.'method:'.$method.'|'.'url:'.$url."\r\n";
create_file(DDROOT.'/data/temp/taoapi_error_log/'.date('Y-m-d').'.log',$msg,1,1);