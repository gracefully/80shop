<?php
include('header.php');
include('../comm/phpzip.lib.php');

$utf8_name=$_GET['username'];
$gbk_name=iconv('utf-8','gb2312',$utf8_name);
$fxbname=iconv('utf-8','gb2312',$webset['fxb']['name']);

if($utf8_name==''||$utf8_name=='输入您的用户名'){
	error_html('没有输入用户名！');
}

$uid=$duoduo->select('user','id','ddusername="'.$utf8_name.'"');
if(!$uid){
    error_html('用户名无效！');
}
$duoduo->close();

$content="REGEDIT4
	
[HKEY_CURRENT_USER\Software\Microsoft\Internet Explorer\MenuExt]
	
[HKEY_CURRENT_USER\Software\Microsoft\Internet Explorer\MenuExt\\".$fxbname."]
	
@=\"http://".URL."/fanxianbao/fanxianbao.html?".$uid."\"";

$filename='fanxianbao.rar';
$ziper = new zipfile();
$ziper->addFile($content,"fanxianbao.reg");
$ziper->output($filename);

header("Content-Type: application/force-download");
header('Content-Disposition: attachment; filename='.basename($filename)); 
readfile($filename);