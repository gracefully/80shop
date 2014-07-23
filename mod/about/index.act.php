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
* @name 关于页面首页
* @copyright duoduo123.com
* @example 示例about_index();
* @param $id 指定文章id
* @param $field 字段
* @param $cid 文章栏目
* @return $parameter['articles'] 所有符合的文章
* @return $parameter['article'] 文章内容
*/
function act_about_index($cid=28,$field='id,title,content'){
	global $duoduo;
	$id=$id?$id:(int)$_GET['id'];
	$articles=$duoduo->select_all('article',$field,'cid='.$cid.' order by sort desc');
	if($id==0){
		$id=$articles[0]['id'];
	}
	$article=$duoduo->select('article',$field,'id="'.$id.'"');
	$article['content']=dd_tag_replace($article['content']);
	unset($duoduo);
	$parameter['articles']=$articles;
	$parameter['article']=$article;
	$parameter['id']=$id;
	return $parameter;
}
?>