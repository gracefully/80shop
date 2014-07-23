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
* @name 文章页面首页
* @copyright duoduo123.com
* @example 示例about_index();
* @param $field 字段
* @param $limit 每个栏目显示多少篇
* @return $parameter['articles'] 所有符合的文章
* @return $parameter['hotnews'] 热门文章
*/
function act_article_index($limit=10,$field='id,title,addtime'){
	global $duoduo;
	$i=0;
	$article_category=$duoduo->select_2_field('type',$field,'tag="article" and id<>26 and id<>27 and id<>28 order by sort asc,id desc');
	foreach($article_category as $k=>$v){
		$arr=$duoduo->select_all('article',$field,"cid='".$k."' and del=0 order by sort asc,id desc limit 0,".$limit);
		if(!empty($arr)){
			$articles[$k]=$arr;
		}
	}
	//热门文章
	$hotnews=$duoduo->select_all('article',$field,'del=0 order by sort asc ,id desc limit 0,'.$limit);
	unset($duoduo);
	$parameter['articles']=$articles;
	$parameter['hotnews']=$hotnews;
	$parameter['article_category']=$article_category;
	return $parameter;
}
?>