<?php
/**
 * ============================================================================
 * 版权所有 2008-2012 多多科技，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('INDEX')){
	exit('Access Denied');
}

function tao_coupon_view($shop_title,$goods_price){
	$str='';
	$d = iconv("UTF-8","gbk//IGNORE",$shop_title);
	$e=urlencode($d);
	$url="http://taoquan.taobao.com/coupon/coupon_list.htm?key_word=".$e;
	$listcontent =iconv("gbk", "utf-8//IGNORE", dd_get($url));
	$preg = "/<p class=\"coupon-num\">&yen;(.*)元<\/p>/";
	preg_match_all( $preg, $listcontent, $num);//获取优惠券面值
	$preg = "/<p class=\"cond\">使用条件：订单满(.*).00元<\/p>/";
	preg_match_all( $preg, $listcontent, $cond);//获取使用条件
	$preg = "/a href=\"combo\/between.htm\?(.*)&shopTitle/";
	preg_match_all($preg,$listcontent,$url);  //获取优惠券地址码
	$a= $cond[1];
	arsort($a); 
	foreach($a as $k=>$v){
		$b=$cond[1][$k];
		$d=$num[1][$k];
		$u=$url[1][$k];  
	}
	
	$str='<div class="shopitem_main_r_5"><span>优&nbsp;惠&nbsp;券：';
	if($num[1][$k]>0){
		$str.='【<a style="color:#F60;" href="http://ecrm.taobao.com/shopbonusapply/buyer_apply.htm?'.$url[1][$k].'" target="_blank" title="点击免费领取优惠券后购买更便宜" >满'.$cond[1][$k].'减'.$num[1][$k].'元';
		if($goods_price<$cond[1][$k]){
			$str.='(需凑单)';
		}
		$str.='</a>】&nbsp;</span><a  href="'.u('tao','coupon',array('q'=>$shop_title)).'" target="_blank" title="查看该卖家更多优惠券">查看更多优惠券</a>  &nbsp;';
	}
	else{
		$str.='暂&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;无&nbsp;&nbsp;';
	}
	$str.='</span> </div>';
	return $str;
}
$plugin_set=dd_get_cache('plugin');
if($plugin_set['tao_coupon']==1){
	$tao_coupon_str=tao_coupon_view($shop['title'],$goods['price']);
}
?>