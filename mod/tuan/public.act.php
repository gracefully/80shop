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

if($webset['tuan']['open']==0){
    jump(u('index'));
}

function tuan_url($key='',$val='',$usepage=0){
	global $cid;
	global $mall_id;
	global $city_id;
	global $sort;
	global $page;
	$param_arr=array('cid'=>$cid,'mall_id'=>$mall_id,'city_id'=>$city_id,'sort'=>$sort);
	if($usepage>0){
		$param_arr['page']=$page;
	}
	else{
		$param_arr['page']=1;
	}
	$param_arr[$key]=$val;
	
	if($usepage==1){//用在分页中
		unset($param_arr['page']);
	}
	
    return u('tuan','list',$param_arr);
}

function subnum($num){
	$s=sprintf("%2d",$num);
    if(strlen($s)>2){
	    return round($num);
	}
	else{
	    return $num;
	}
}

$city=dd_get_cache('city/city_sort');
$city_word_arr=dd_get_cache('city/city_word');

//全部团购商家
$malls=$duoduo->select_all('mall','id,fan,title','cid="'.$webset['tuan']['mall_cid'].'" and api_url<>"" and api_url is not null and api_rule<>"" and api_rule is not null order by sort desc');

//页面导航
$tuan_cat2=dd_get_cache('tuan_cat');
$tuan_cat1[0]=array('title'=>'全部');
$tuan_cat=$tuan_cat1+$tuan_cat2;

$city_id=(int)$_GET['city_id'];

//当前城市
if($city_id==0){
    $city_title=iptocity();
	$city_id=arr_get_key($city,$city_title);
	if($city_id<1){
	    $city_id=159;
		$city_title='全国'; //IP无对应城市，调用全国团购商品
	}
}
else{
    $city_title=$city[$city_id];
}