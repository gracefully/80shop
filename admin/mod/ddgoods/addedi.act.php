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
    $id=empty($_POST['id'])?0:(int)$_POST['id'];
	unset($_POST['id']);
	unset($_POST['sub']);
	$_POST['starttime']=strtotime($_POST['starttime']);
	if($_POST['endtime']=='' || $_POST['endtime']==0){
		$_POST['endtime']=0;
	}
	else{
		$_POST['endtime']=strtotime($_POST['endtime']);
	}
	if($_POST['sort']>0){
		$ddgoods_class->update_sort($id,$_POST['sort']);
	}
	$duoduo->update(MOD,$_POST,'id="'.$id.'"');
	jump(u(MOD,'list',array('code'=>$_GET['code'])),'修改完成');
}
else{
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
    if($id==0){
	    $row=array();
	}
	else{
	    $row=$duoduo->select(MOD,'*','id="'.$id.'"');
	}
}