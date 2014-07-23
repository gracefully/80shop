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
/**
* @name 帮助首页
* @copyright duoduo123.com
* @example 示例help_index();
* @param $field 字段
* @return $parameter 结果集合
*/
function act_help_index($field='*'){
	global $duoduo;
	$help_type=$duoduo->select_2_field('type','id,title','pid=1');
	foreach($help_type as $k=>$v){
		$cid=$k;
		break;
	}
	if((int)$_GET['cid']>0){
		$cid=(int)$_GET['cid'];
	}
	$article=$duoduo->select_all('article',$field,'cid="'.$cid.'" order by id asc');
	foreach($article as $k=>$row){
		$article[$k]['content']=dd_tag_replace($article[$k]['content']);
	}
	unset($duoduo);
	$parameter['help_type']=$help_type;
	$parameter['article']=$article;
	$parameter['cid']=$cid;
	return $parameter;
}
?>