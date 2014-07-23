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
	$_POST['edate']=dd_strtotime($_POST['edate']);
	if(isset($_POST['sort']) && ($_POST['sort']=='' || $_POST['sort']==0)){$_POST['sort']=DEFAULT_SORT;}
	if($id==0){
		if(!isset($_POST['addtime']) || $_POST['addtime']==''){
			$_POST['addtime']=TIME;
		}
		trim_arr($_POST);
		$id=$duoduo->insert(get_mall_table_name(),$_POST);
		$word='保存';
	}
	else{
		if(array_key_exists('addtime',$_POST)){
		    unset($_POST['addtime']);
		}
		trim_arr($_POST);
		$duoduo->update(get_mall_table_name(),$_POST,'id="'.$id.'"');
		$word='修改';
	}
	jump(u(MOD,'list'),$word.'成功');
}
else{
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
    if($id==0){
	    $row=array();
	}
	else{
	    $row=$duoduo->select(get_mall_table_name(),'*','id="'.$id.'"');
		if(isset($row['edate']) && $row['edate']!=''){$row['edate']=dd_date($row['edate'],2);}
	}
}
?>