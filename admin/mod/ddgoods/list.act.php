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
	$duoduo->delete('ddgoods','endtime<'.time().' and code like "%'.$code.'%"');
	jump(u('ddgoods','list',array('code'=>$code)),'删除成功！');
}
if($_GET['update']=='sort'){
	$id=$_GET['id'];
	$sort=$_GET['v'];
	$ddgoods_class->update_sort($id,$sort);
}
else{
	$pagesize=20;
	$where='1';
	$page_arr=array();
	if($code!=''){
		$where.=' and code = "'.$code.'"';
		$page_arr['code']=$code;
	}
	if($_GET['reycle']==1){
		$reycle=1;
		$where.=' and `del`='.$reycle;
		$page_arr['reycle']=$reycle;
	}
	if($_GET['title']!=''){
		$title=$_GET['title'];
		$where.=' and title like "%'.$title.'%"';
		$page_arr['title']=$title;
	}
	if($_GET['cid']!=''){
		$cid=$_GET['cid'];
		$where.=' and cid = "'.$cid.'"';
		$page_arr['cid']=$cid;
	}
	$data=$ddgoods_class->admin_list($pagesize,$where);
	$zhidemai_data=$data['data'];
	$total=$data['total'];
	if($code!='zhuanxiang'){$cid_arr=$ddgoods_class->catname($code);}
}
