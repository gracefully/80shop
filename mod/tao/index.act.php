<?php //淘宝首页
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
* @name 淘宝首页
* @copyright duoduo123.com
* @example 示例tao_index();
* @param $field 字段
* @param $field2 字段
* @param $limit 显示多少店铺
* @return $parameter 结果集合
*/
function act_tao_index($limit=7,$field='img,url,title',$field2="*"){
	global $duoduo,$dd_tao_class,$ddTaoapi;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;

	$goods_type=$dd_tao_class->get_type('goods');
	
	//幻灯片
	$slides=$duoduo->select_all('slides',$field,'hide=0 and cid=2 order by sort asc limit 0,10');
	
	$shops=$duoduo->select_all('shop',$field2,'del=0 order by tao_top desc, sort asc limit '.$limit);
	$shops=$dd_tao_class->dd_tao_shops($shops);
	
	$parameter['slides']=$slides;
	if(TAOTYPE==2){
		$tag=dd_get_cache('tao_index.tag');
		$parameter['tag']=$tag;
	}
	$parameter['shops']=$shops;
	$parameter['goods_type']=$goods_type;
	
	unset($duoduo);
	return $parameter;
}
?>