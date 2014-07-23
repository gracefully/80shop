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
* @name 活动列表
* @copyright duoduo123.com
* @example 示例huodong_list();
* @param $pagesize 每页数量12
* @param $field 字段
* @return $parameter 结果集合
*/
function act_huodong_list($pagesize=10,$field='a.id,a.sdate,a.edate,a.title,a.img,a.desc,a.mall_id,a.relate_id,b.title as mallname,b.fan,b.img as logo'){
	global $duoduo;
	$webset=$duoduo->webset;
	$dduser=$duoduo->dduser;
	$page = !($_GET['page'])?'1':intval($_GET['page']);
	$frmnum=($page-1)*$pagesize;
	
	$q=$_GET['title'];
	$total=$duoduo->count('huodong as a,mall as b','a.title like "%'.$q.'%" and a.mall_id=b.id');
	$huodong=$duoduo->select_all('huodong as a,mall as b',$field, "a.title like '%".$q."%' and a.mall_id=b.id order by a.sort asc,a.id desc limit $frmnum,$pagesize");
	
	foreach($huodong as $k=>$row){
		if($row['relate_id']>0){
			$huodong[$k]['goto']=u('huan','view',array('id'=>$row['relate_id']));
		}
		else{
			$huodong[$k]['goto']=u('huodong','view',array('id'=>$row['id']));
		}
	}
	
	$page_url=u(MOD,ACT);
	unset($duoduo);
	$parameter['total']=$total;
	$parameter['page']=$page;
	$parameter['pagesize']=$pagesize;
	$parameter['page_url']=$page_url;
	$parameter['huodong']=$huodong;
	$parameter['jifen_dh_status']=$jifen_dh_status;
	$parameter['jifenbao_dh_msg']=$jifenbao_dh_msg;
	$parameter['jifenbao_dh_status']=$jifenbao_dh_status;
	$parameter['id']=$id;
	return $parameter;
}