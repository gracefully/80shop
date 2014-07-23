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
* @example 示例tuan_view();
* @param $field 字段
* @param $field2 字段
* @param $pagesize 每页显示多少
* @return $parameter 结果集合
*/
function act_tuan_view($field='a.id,a.url,a.city,a.title,a.cid,a.mall_id,a.img,a.sdatetime,a.edatetime,a.value,a.price,a.rebate,a.bought,b.title as mall_name,b.img as mall_logo,b.id as mall_id,b.fan,b.url as mall_url',$field2='a.title,a.price,a.id,b.title as mall_name,b.fan,b.id as mall_id'){
	global $duoduo,$ddTaoapi;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	include(DDROOT.'/mod/tuan/public.act.php');
	$id=empty($_GET['id'])?0:intval($_GET['id']);

	//商品数据
	$goods=$duoduo->select('tuan_goods as a,mall as b',$field,'a.id="'.$id.'" and a.mall_id=b.id');
	
	//当地团购
	$state_goods=$duoduo->select_all('tuan_goods as a,mall as b',$field2,'a.city="'.$goods['city'].'" and a.mall_id=b.id order by a.sort desc,a.salt desc limit 0,3');
	
	$goods['jump']='index.php?mod=jump&act=tuan&tid='.$goods['id'];
	unset($duoduo);
	$parameter['goods']=$goods;
	$parameter['state_goods']=$state_goods;
	$parameter['malls']=$malls;
	$parameter['tuan_cat']=$tuan_cat;
	$parameter['city_id']=$city_id;
	$parameter['city_title']=$city_title;
	return $parameter;
}