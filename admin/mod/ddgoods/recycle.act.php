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

if($_GET['update']=='sort'){
	$id=$_GET['id'];
	$sort=$_GET['v'];
	$ddgoods_class->update_sort($id,$sort);
}
else{
	$pagesize=20;
	$where='`del`=1';
	$url_arr=array();
	if($code!=''){
		$where.=' and code = "'.$code.'"';
		$url_arr['code']=$code;
	}
	if($_GET['title']!=''){
		$title=$_GET['title'];
		$where.=' and title like "%'.$title.'%"';
		$url_arr['title']=$title;
	}
	if($_GET['cid']!=''){
		$cid=$_GET['cid'];
		$where.=' and cid = "'.$cid.'"';
		$url_arr['cid']=$cid;
	}
	$data=$ddgoods_class->admin_list($pagesize,$where);
	$zhidemai_data=$data['data'];
	$total=$data['total'];
	if($code!='zhuanxiang'){$cid_arr=$ddgoods_class->catname($code);}
}