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

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;
$data_id=(int)$_GET['data_id'];
$where='1';
$page_arr=array();
if($data_id>0){
	$where.=' and a.data_id="'.$data_id.'"';
	$page_arr['data_id']=$data_id;
}
if($_GET['username']!=''){
	$username=$_GET['username'];
	$where.=' and a.username="'.$username.'"';
	$page_arr['username']=$username;
}

$total=$duoduo->count(MOD.' as a',$where);
$comment=$duoduo->select_all(MOD.' as a,ddzhidemai as b','b.title,a.*','a.data_id=b.data_id order by a.id desc limit '.$frmnum.','.$pagesize);