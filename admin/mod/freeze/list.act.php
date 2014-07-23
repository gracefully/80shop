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
$where='1=1';
if(isset($_GET['uname']) && $_GET['uname']!=''){
	$uname=$_GET['uname'];
    $uid=$duoduo->select('user','id','ddusername="'.$uname.'"');
	$where='a.uid="'.$uid.'"';
}
if(isset($_GET['date']) && $_GET['date']!=''){
	$date=$_GET['date'];
    $where.=' and a.date="'.$date.'"';
}

$total=$duoduo->count('income as a',$where);
$row=$duoduo->select_all('income as a,user as b','a.*,b.ddusername',$where.' and a.uid=b.id order by id desc limit '.$frmnum.','.$pagesize);