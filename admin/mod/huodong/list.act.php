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
$q=$_GET['q'];
$mall_id=(int)$_GET['mall_id'];
if($mall_id>0){
	$where=' and mall_id="'.$mall_id.'"';
}
else{
    $where='';
}

$by_field='edate';
if(isset($_GET[$by_field])){
    if($_GET[$by_field]!='desc' && $_GET[$by_field]!='asc'){
	    $_GET[$by_field]='asc';
	}
	$by=$by_field.' '.$_GET[$by_field].',';
}
else{
    $by='';
}
if($_GET[$by_field]=='desc'){
    $listorder='asc';
}
else{
    $listorder='desc';
}

$total=$duoduo->count(MOD,"`title` like '%$q%'".$where);
$row=$duoduo->select_all(MOD,'*','`title` like "%'.$q.'%"'.$where.' order by '.$by.' id desc limit '.$frmnum.','.$pagesize);

