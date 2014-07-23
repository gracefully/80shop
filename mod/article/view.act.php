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
* @example 示例article_view();
* @param $cid 文章栏目分类id
* @param $pagesize 每页默认20篇
* @param $field 字段
* @param $limit 限制
*/
function act_article_view($pagesize=20,$limit=10,$field='*'){
	global $duoduo;
	if($_GET['id']){
		$id=intval($_GET['id']);
	}
	
	$data=array('f'=>'hits','e'=>'+','v'=>1);
	$duoduo->update('article',$data,'id="'.$id.'"');
	
	$article=$duoduo->select('article',$field,'id="'.$id.'"');
	$article['content']=dd_tag_replace($article['content']);
	
	$type_all=dd_get_cache('type');
	$type=$type_all['article'];

	if($article['id']<=0){
		error_html('文章不存在');
	}
	
	$last_article=$duoduo->select('article',$field,'id<"'.$id.'" order by id desc');
	$next_article=$duoduo->select('article',$field,'id>"'.$id.'" order by id asc');
	
	//热门文章
	$hotnews=$duoduo->select_all('article',$field,'1=1 order by sort desc  limit 0,'.$limit);
	unset($duoduo);
	$parameter['hotnews']=$hotnews;
	$parameter['next_article']=$next_article;
	$parameter['last_article']=$last_article;
	$parameter['article']=$article;
	$parameter['type']=$type;
	return $parameter;
}
?>