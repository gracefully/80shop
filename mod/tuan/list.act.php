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
* @example 示例tuan_list();
* @param $field 字段
* @param $field2 字段
* @param $pagesize 每页显示多少
* @param $field 字段
* @return $parameter 结果集合
*/
function act_tuan_list($pagesize=0,$field='a.id,a.url,a.city,a.title,a.cid,a.img,a.sdatetime,a.edatetime,a.value,a.price,a.rebate,a.bought,b.title as mall_name,b.id as mall_id,b.fan',$field2='a.id,a.url,a.city,a.title,a.cid,a.img,a.sdatetime,a.edatetime,a.value,a.price,a.rebate,a.bought,b.title as mall_name,b.id as mall_id,b.fan'){
	global $duoduo,$ddTaoapi;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	include(DDROOT.'/mod/tuan/public.act.php');
	$page = !($_GET['page'])?'1':intval($_GET['page']);
	$pagesize=$pagesize>0?$pagesize:$webset['tuan']['listnum'];
	$frmnum=($page-1)*$pagesize;
	
	$mall_id=intval($_GET['mall_id']);
	
	$cid=intval($_GET['cid']);
	$sort=trim($_GET['sort']);
	$q=trim($_GET['q']);
	
	if($sort==''){
		$sort='sort';
	}
	elseif($sort!='edatetime' && $sort!='bought' && $sort!='price'){
		$sort='edatetime';
	}
	switch($sort){
		case 'edatetime':
		$sort_arr=array('edatetime'=>'时间','bought'=>'销量','price'=>'价格');
		break;
		case 'sort':
		$sort_arr=array('edatetime'=>'时间','bought'=>'销量','price'=>'价格');
		break;
		case 'bought':
		$sort_arr=array('bought'=>'销量','edatetime'=>'时间','price'=>'价格');
		break;
		case 'price':
		$sort_arr=array('price'=>'价格','edatetime'=>'时间','bought'=>'销量');
		break;
	}
	
	if($mall_id>0){
		$where_mall_id=' and a.mall_id="'.$mall_id.'"';
	}
	else{
		$where_mall_id='';
	}
	
	if($sort=='sort'){
		$desc = 'asc';
	}else{
		$desc = 'desc';
	}
	/*if($city_title!='全国'){
		$goods_num=$duoduo->count('tuan_goods','city="'.$cur_city.'"'); //如果此城市没有商品，则默认全国
		if($goods_num<1){
			$city_id=159;
			$city_title='全国'; //IP无对应城市，调用全国团购商
		}
	}*/
	
	if($cid>0){
		$row=$duoduo->select_all('tuan_goods as a,mall as b',$field,'a.edatetime>"'.TIME.'" and a.del=0 and (a.city ="'.$city_title.'" or a.city="全国") and a.cid="'.$cid.'" '.$where_mall_id.' and a.mall_id=b.id order by a.'.$sort.' '.$desc.',a.salt desc limit '.$frmnum.','.$pagesize);//echo "<hr/>";
		$goods[$cid]=$row;
		$total=$duoduo->count('tuan_goods as a',' a.edatetime>"'.TIME.'" and a.del=0 and (a.city ="'.$city_title.'" or a.city="全国") '.$where_mall_id.' and a.cid="'.$cid.'"');
	}
	else{
		foreach($tuan_cat2 as $k=>$v){
			$limit=$webset['tuan']['shownum'];	
			$row=$duoduo->select_all('tuan_goods as a,mall as b',$field2,'a.edatetime>"'.TIME.'" and a.del=0 and (a.city ="'.$city_title.'" or a.city="全国") and a.cid="'.$k.'" '.$where_mall_id.' and a.title like "%'.$q.'%" and a.mall_id=b.id order by a.'.$sort.' '.$desc.',a.salt desc limit 0,'.$limit,0);//echo "<hr/>";
			if(!empty($row)){$goods[$k]=$row;}
		}
		$total=$duoduo->count('tuan_goods as a',' a.edatetime>"'.TIME.'" and a.del=0 '.$where_mall_id.' and (a.city ="'.$city_title.'" or a.city="全国") and a.title like "%'.$q.'%"');
	}
	$page_url=u(MOD,ACT,array('cid'=>$cid,'mall_id'=>$mall_id));
	unset($duoduo);
	$parameter['mall_id']=$mall_id;
	$parameter['cid']=$cid;
	$parameter['sort']=$sort;
	$parameter['q']=$q;
	$parameter['sort_arr']=$sort_arr;
	$parameter['goods']=$goods;
	$parameter['page_url']=$page_url;
	$parameter['pagesize']=$pagesize;
	$parameter['total']=$total;
	$parameter['page']=$page;
	
	$parameter['malls']=$malls;
	$parameter['tuan_cat']=$tuan_cat;
	$parameter['city_id']=$city_id;
	$parameter['city_title']=$city_title;
	$parameter['city']=$city;
	$parameter['city_word_arr']=$city_word_arr;
	return $parameter;

}?>