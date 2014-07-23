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
* @name 活动详情
* @copyright duoduo123.com
* @example 示例huodong_view();
* @param $field 字段
* @param $pagesize 每页数量12
* @return $parameter 结果集合
*/
function act_huodong_view($pagesize=10,$fields="*"){
	global $duoduo;
	$webset=$duoduo->webset;
	$dduser=$duoduo->dduser;
	$id=$_GET['id']?intval($_GET['id']):0;
	$zong_fen=0;
	$pjf='0.0';
	$x=0;
	
	$fanli_type=array(1=>'金额',2=>'积分');
	
	$huodong=$duoduo->select('huodong',$fields,'id="'.$id.'"');
	$mall=$duoduo->select('mall',$fields,'id="'.$huodong['mall_id'].'"');
	if($huodong['relate_id']>0){
		$jump=u('huan','view',array('hid'=>$huodong['relate_id']));
	}
	else{
		$jump=u('jump','huodong',array('hid'=>$id));
	}
	
	$mall_comment_total=$duoduo->count('mall_comment',"`mall_id` = '".$huodong['mall_id']."'");
	
	if($mall_comment_total>0){
		$zong_fen=$duoduo->sum('mall_comment','fen',"mall_id='".$huodong['mall_id']."'");
		$pjf=number_format($zong_fen/$mall_comment_total,1);
		$fen=round($zong_fen/$mall_comment_total,2);
	}
	unset($duoduo);
	$parameter['id']=$id;
	$parameter['fanli_type']=$fanli_type;
	$parameter['huodong']=$huodong;
	$parameter['mall']=$mall;
	$parameter['jump']=$jump;
	$parameter['mall_comment_total']=$mall_comment_total;
	$parameter['zong_fen']=$zong_fen;
	$parameter['pjf']=$pjf;
	$parameter['fen']=$fen;
	return $parameter;
}
?>