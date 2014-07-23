<?php
if($_POST){
	$_POST['id'] = intval($_POST['id']);
	$id = $_POST['id']>0 ? $_POST['id'] : 0;
	if($_POST['id']>0){
		unset($_POST['sub']);
		unset($_POST['id']);
		unset($_POST['qq_meta']);
		$duoduo->update(MOD,$_POST,'id="'.$id.'"');
		jump(u(MOD,'list'),'修改完成');
	}else{
		
	}
}else{
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
	if($id==0){
		$row=array();
	}
	else{
		$row=$duoduo->select(MOD,'*','id="'.$id.'"');
	}
}
?>