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
* @name 宝贝列表
* @copyright duoduo123.com
* @example 示例baobei_list();
* @param $field 字段
* @param $pagesize 每页默认20篇
*/
function act_baobei_list($pagesize=24,$field='a.`id`,a.`title`,a.`img`,a.`price`,a.`commission`,a.`hart`,a.`hits`,a.`content`,a.`uid`,a.addtime,b.ddusername'){
	global $duoduo;
	$webset=$duoduo->webset;
	$dduser=$duoduo->dduser;
	$cat_arr=$webset['baobei']['cat'];
	$face_img=include(DDROOT.'/data/face_img.php');
	$face=include(DDROOT.'/data/face.php');
	
	$q=trim($_GET['q']);
	$cid=intval($_GET['cid']);
	$sort=$_GET['sort']?$_GET['sort']:'id';
	if($sort!='id' && $sort!='hart' && $sort!='price'){$sort='id';}
	
	if($cid>0){
		$where_cid="and cid='".$cid."'";
		$where_cid2="and a.cid='".$cid."'";
	}
	elseif($cid==0){
		$where_cid="";
		$where_cid2="";
	}
	
	$page = !($_GET['page'])?'1':intval($_GET['page']);
	$frmnum=($page-1)*$pagesize;
	$total=$duoduo->count('baobei as a,user as b',"a.`title` like '%$q%' and a.uid=b.id $where_cid and a.del=0");
	
	$baobei=$duoduo->select_all('baobei as a,user as b',$field,"a.`title` like '%$q%' and a.uid=b.id and a.del=0 $where_cid2 order by a.`".$sort."` asc limit $frmnum,$pagesize");
	$cur_baobei_num=count($baobei);
	
	
	for($i=0;$i<$cur_baobei_num;$i++){
		$baobei[$i]['content']=str_replace($face,$face_img,$baobei[$i]['content']);
	}
	
	if($dduser['id']<=0){
		$share_button_id='noLogin';
	}
	elseif($dduser['level']<$webset['share']['limit_level']){
		$share_button_id='noLevel';
	}
	else{
		$share_button_id='startShare';
	}
	$page_url=u(MOD,ACT,array('sort'=>'id','cid'=>$cid,'q'=>$q));
	$parameter['share_button_id']=$share_button_id;
	unset($duoduo);
	$parameter['baobei']=$baobei;
	$parameter['total']=$total;
	$parameter['pagesize']=$pagesize;
	$parameter['sort']=$sort;
	$parameter['cid']=$cid;
	$parameter['page_url']=$page_url;
	$parameter['cat_arr']=$cat_arr;
	$parameter['cur_baobei_num']=$cur_baobei_num;
	return $parameter;
}
?>