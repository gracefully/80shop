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
$by = 'sum(a.jifenbao)';
$t = 'sum(a.jifenbao)';
$class1="class=current";

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;

$uid_arr = $duoduo->select_1_field('baobei','uid');
$uid_arr = array_unique($uid_arr);
$total = count($uid_arr);

$sql='select a.uid,'.$t.' as sum,b.ddusername from `'.BIAOTOU.'baobei` as a left join `'.BIAOTOU.'user` as b on a.uid = b.id group by a.`uid` order by '.$by.' desc limit '.$frmnum.','.$pagesize;
$row_2 = $duoduo->sql_to_array($sql);
?>