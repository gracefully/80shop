<?php
if(!defined('INDEX')){
	exit('Access Denied');
}

function act_zhidemai_view($duoduo){
	include_once(DDROOT.'/comm/zhidemai.class.php');
	$zhidemai_class=new zhidemai($duoduo);
	$id=(int)$_GET['id'];
	$data=$zhidemai_class->view($id);
	$zhidemai=$data['zhidemai'];
	$seelog=array('type'=>'zhidemai','id'=>$zhidemai['id'],'pic'=>$zhidemai['img'],'title'=>$zhidemai['title'],'subtitle'=>$zhidemai['subtitle']);
	set_browsing_history($seelog);
	$comment=$data['comment'];
	
	if($_GET['jump']==1){
		jump($zhidemai['jump']);
	}
	
	$around=$zhidemai_class->around($id);

	$parameter['zhidemai']=$zhidemai;
	$parameter['last_zdm']=$around['last_zdm'];
	$parameter['next_zdm']=$around['next_zdm'];
	$parameter['zhidemai_class']=$zhidemai_class;
	return $parameter;
}