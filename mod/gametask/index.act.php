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

if(!defined('INDEX')){
	exit('Access Denied');
}
$offer=$webset['gametask'];
$offer['siteid'] = $webset['siteid'];
if($dduser['id']==0 || empty($dduser['id'])){
	jump(u('user','login',array('form'=>p(MOD,'index'))),'请先登录');
}
if(empty($offer['siteid']) || $offer['siteid']<=0){
	jump('index.php','请联系站长设置信息');
}
if($offer['status']==0){
	jump(u('index'),'游戏返利未开启');
}

$memberid=urlencode($offer['siteid'].'|'.$dduser['id']);

$total=$duoduo->sum('gametask','point','memberid="'.$dduser['id'].'"');
$info=$duoduo->select_all('gametask as a,user as b','a.programname,a.point,b.ddusername','a.memberid=b.id order by addtime desc limit 0,12');
?>