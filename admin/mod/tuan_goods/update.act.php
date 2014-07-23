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

if(!defined('ADMIN')){
	exit('Access Denied');
}

if($_POST['sub']!=''){
	if($_POST['del']!=''){
    	$mallid=implode(',',$_POST['mallid']);
		$duoduo->delete('tuan_goods','mall_id in('.$mallid.')');
		jump('-1','删除完成');
	}
	
	if(empty($_POST['mallid'])){
	    jump(-1,'没有选择团购网站');
	}
    $mallid=implode(',',$_POST['mallid']);
	jump('../'.u('tuan','collect',array('mallid'=>$mallid,'show'=>authcode(1,'ENCODE'))),'开始采集');
}
else{
    $malls=$duoduo->select_2_field(get_mall_table_name(),'id,title','cid="'.$webset['tuan']['mall_cid'].'" and api_url<>"" and api_url is not null and api_rule<>"" and api_rule is not null ');
}
