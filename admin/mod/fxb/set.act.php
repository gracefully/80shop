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
    $diff_arr=array('sub');
	$_POST=logout_key($_POST, $diff_arr);
	foreach($_POST as $k=>$v){
		if(is_array($v)){$v=serialize($v);}
		$data=array('val'=>$v);
	    $duoduo->update('webset',$data,'var="'.$k.'"');
	}
	$duoduo->webset(); //配置缓存

	echo '<script language="javascript" src="'.SITEURL.'/fanxianbao/fanxianbao.html.php"></script>';
	echo '<script language="javascript" src="'.SITEURL.'/fanxianbao/fanxianbao.js.php"></script>';
	echo '<script language="javascript" src="'.SITEURL.'/fanxianbao/fanxianbao.gbk.js.php"></script>';
	echo '<script language="javascript" src="'.SITEURL.'/fanxianbao/fanxianbao.utf8.js.php"></script>';
	
	jump('-1','保存成功');
}
else{
    $open_arr=array(0=>'关闭',1=>'开启');
}