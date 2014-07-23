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
* @name 淘宝卖家
* @copyright duoduo123.com
* @example 示例tao_shop();
* @param $pagesize 每页多少
* @param $nick 指定店铺卖家
* @return $parameter 结果集合
*/
function act_tao_shop(){
	global $duoduo,$ddTaoapi;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	$nick=gbk2utf8(trim($_GET['nick']));
	jump(SITEURL.'/index.php?mod=shop&act=list&nick='.urlencode($nick));
	if(empty($pagesize)){
		$pagesize=PAGESIZE;
	}
	if(empty($nick)){
		$nick=empty($_GET['nick']) ? 'yipin520' : $_GET['nick'];
	}
	$nick=gbk2utf8($nick);
	$list=(int)$_GET['list'];  //注意全局变量
	$liebiao=(int)get_cookie('liebiao',0);
	if($list==0){
		if($liebiao>0){
			$list=$liebiao;
		}
		else{
			$list=$webset['liebiao'];
		}
	}
	set_cookie('liebiao', $list, 12000,0);
	
	include(DDROOT.'/mod/tao/shopinfo.act.php'); //店铺信息
	if($shop['nick']==''){
		error_html('该掌柜未参加淘宝返利！<a style=" text-decoration:underline; font-size:14px;" target="_blank" href="http://shopsearch.taobao.com/search?v=shopsearch&q='.urlencode(iconv('utf-8','gbk',$nick)).'">去淘宝看看</a>',-1,1);
	}
	elseif(in_array($shop['cid'],$ddTaoapi->virtual_cid)){
		error_html('该店铺无返利！',-1,1);
	}
	
	$show_parameter=array('nick'=>$nick,'list'=>$list);
	$showpic_list1=u(MOD,ACT,arr_replace($show_parameter,'list',1)); //小图显示
	$showpic_list2=u(MOD,ACT,arr_replace($show_parameter,'list',2)); //大图显示
	unset($show_parameter['page']);
	
	$show_page_url=u(MOD,ACT,$show_parameter);
	unset($duoduo);
	$parameter['goods']=array();
	$parameter['nick']=$nick;
	$parameter['list']=$list;
	$parameter['liebiao']=$liebiao;
	$parameter['show_parameter']=$show_parameter;
	$parameter['showpic_list1']=$showpic_list1;
	$parameter['showpic_list2']=$showpic_list2;
	$parameter['show_page_url']=$show_page_url;
	return $parameter;
}
?>