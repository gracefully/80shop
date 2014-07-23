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

if(isset($_GET['nick']) && $_GET['nick']!=''){
	$nick=trim($_GET['nick']);
	$shop_id=(int)$_GET['shop_id'];
	if($shop_id==0){
		$id=(int)$duoduo->select('shop','id','nick="'.$nick.'"');
		if($id>0){
			$data=array('s'=>0,'r'=>2);
			echo dd_json_encode($data);
			exit;
		}
	}
	
	include (DDROOT . '/comm/Taoapi.php');
	include (DDROOT . '/comm/ddTaoapi.class.php');
	$ddTaoapi = new ddTaoapi;
	
	$shop=$ddTaoapi->taobao_tbk_shops_detail_get($nick);
	if(is_array($shop) && $shop['user_id']>0){
		$data=array('s'=>1,'r'=>$shop);
		echo dd_json_encode($data);
	}
	else{
		$data=array('s'=>0,'r'=>1);
		echo dd_json_encode($data);
	}
	exit;
}

if(isset($_POST['sub'])){
	$_POST['hits']=(int)$_POST['hits'];
	$_POST['sort']=(int)$_POST['sort'];
	$_POST['tao_top']=(int)$_POST['tao_top'];
	$_POST['index_top']=(int)$_POST['index_top'];
	
	if((int)$_POST['id']==0){
		$id=(int)$duoduo->select('shop','id','nick="'.trim($_POST['nick']).'"');
		if($id>0){
			jump(-1,'店铺已存在');
		}
	}
}

include(ADMINROOT.'/mod/public/addedi.act.php');
?>