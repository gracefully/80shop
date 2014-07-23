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
if($_GET['guoqi']==1){
	$duoduo->delete('ddzhidemai','endtime<'.time());
	jump(u('ddzhidemai','list'),'删除成功！');
}
if(isset($_GET['update']) && $_GET['update']=='sort'){
	$id=$_GET['id'];
	$sort=$_GET['v'];
	$zhidemai_class->update_sort($id,$sort);
	exit;
}
else{
	$pagesize=20;
	$where='1';
	$page_arr=array();
	if(isset($_GET['reycle']) && $_GET['reycle']==1){
		$reycle=1;
		$where.=' and `del`='.$reycle;
		$page_arr['reycle']=$reycle;
	}
	if(isset($_GET['title']) && $_GET['title']!=''){
		$title=$_GET['title'];
		$where.=' and title like "%'.$title.'%"';
		$page_arr['title']=$title;
	}
	if(isset($_GET['ddusername']) && $_GET['ddusername']!=''){
		$ddusername=$_GET['ddusername'];
		$uid=(float)$duoduo->select('user','id','ddusername="'.$ddusername.'"');
		$where.=' and uid = "'.$uid.'"';
		$page_arr['ddusername']=$ddusername;
	}
	else{
		$ddusername='';
	}
	if(isset($_GET['cid']) && $_GET['cid']!=''){
		$cid=$_GET['cid'];
		$where.=' and cid = "'.$cid.'"';
		$page_arr['cid']=$cid;
	}
	$data=$zhidemai_class->admin_list($pagesize,$where);
	$zhidemai_data=$data['data'];
	$total=$data['total'];
}
?>