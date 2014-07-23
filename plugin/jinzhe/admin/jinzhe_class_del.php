<?php 
	/**
	 * ============================================================================
	 * 版权所有 2008-2012 多多科技，并保留所有权利。
	 * 网站地址: http://soft.duoduo123.com；
	 * ----------------------------------------------------------------------------
	 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
	 * 使用；不允许对程序代码以任何形式任何目的的再发布。
	 * ============================================================================
	*/
	
	if(!defined('ADMIN')){
		exit('Access Denied');
	}
	
	$table_name='plugin_jinzhe_class';
	$id=intval($_GET['id']);
	$where='id='.$id;
	$res=$duoduo->delete($table_name,$where);
	if($res!=0){
		exit('<script language="javascript">alert("成功删除！");location.href="'.$_SERVER['HTTP_REFERER'].'";</script>');
	}else{
		exit('<script language="javascript">alert("删除失败！");location.href="'.$_SERVER['HTTP_REFERER'].'";</script>');
	}
?>