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

$select_arr=array('title'=>'商品名','ddusername'=>'会员名');

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;
$q=$_GET['q'];
$q1=$q;
$se=$_GET['se']?$_GET['se']:'title';
$se1=$se;
if($se=='ddusername'){
    $se1='uid';
	$q1=$duoduo->select('user','id','ddusername="'.$q.'"');
}
$cid=(int)$_GET['cid'];
if($cid>0){
    $where=' and a.cid="'.$cid.'"';
}
else{
    $where='';
}
if($_GET['reycle']==1){
	$reycle=1;
	$where.=' and  a.`del`='.$reycle;
	$page_arr['reycle']=$reycle;
}else{
	$where.=' and a.`del`="0"';
}
$total=$duoduo->count('baobei as a',"`".$se1."` like '%$q1%'".$where);
$row=$duoduo->select_all('baobei as a,user as b','a.*,b.ddusername','a.`'.$se1.'` like "%'.$q1.'%" and a.uid=b.id '.$where.' order by id desc limit '.$frmnum.','.$pagesize);