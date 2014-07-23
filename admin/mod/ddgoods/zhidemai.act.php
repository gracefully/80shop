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

include(DDROOT.'/comm/zhidemai.class.php');
$zhidemai_class=new zhidemai($duoduo);
if($_GET['update']=='sort'){
	$id=$_GET['id'];
	$sort=$_GET['v'];
	$zhidemai_class->update_sort($id,$sort);
}
else{
	$pagesize=5;
	$where='';
	$url_arr=array();
	if($_GET['title']!=''){
		$title=$_GET['title'];
		$where.='title like "%'.$title.'%"';
		$url_arr['title']=$title;
	}
	if($_GET['ddusername']!=''){
		$ddusername=$_GET['ddusername'];
		$uid=(float)$duoduo->select('user','id','ddusername="'.$ddusername.'"');
		$where.='uid = "'.$uid.'"';
		$url_arr['ddusername']=$ddusername;
	}
	if($_GET['cid']!=''){
		$cid=$_GET['cid'];
		$where.='cid = "'.$cid.'"';
		$url_arr['cid']=$cid;
	}
	$data=$zhidemai_class->admin_list($pagesize,$where);
	$zhidemai_data=$data['data'];
	$total=$data['total'];
	$cid_arr=$zhidemai_class->catname();
}
