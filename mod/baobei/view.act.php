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
* @name 用户宝贝页面
* @copyright duoduo123.com
* @example 示例baobei_user();
* @param  $field字段
* @param  $field2字段
* @param  $field3字段
* @param  $pagesize每页数量
* @return $parameter 结果集合
*/
function act_baobei_view($pagesize=500,$field='a.`img`,a.id,a.`hart`,a.`content`,a.`cid`,a.`uid`,a.keywords,a.addtime,a.price,a.title,a.commission,a.tao_id,a.click_url,a.hart,b.id as uid,b.ddusername,b.hart as user_hart',$field2='a.*,b.ddusername',$field3='id,title,img'){
	global $duoduo;
	$webset=$duoduo->webset;
	$dduser=$duoduo->dduser;
	$id=$_GET['id']?intval($_GET['id']):0;
	if($id==0){
		jump(u('baobei','list'));
	}
	$page = !($_GET['page'])?'1':intval($_GET['page']);
	$frmnum=($page-1)*$pagesize;
	
	$cat_arr=$webset['baobei']['cat'];
	$face_img=include(DDROOT.'/data/face_img.php');
	$face=include(DDROOT.'/data/face.php');
	$face=include('data/face.php');
	
	$duoduo->update('baobei',array('f'=>'hits','e'=>'+','v'=>1),'id="'.$id.'"'); //点击
	
	$baobei=$duoduo->select('baobei as a,user as b',$field,'a.uid=b.id and a.id="'.$id.'"');
	$baobei['content']=str_replace($face,$face_img,$baobei['content']);
	
	$user['id']=$baobei['uid'];
	$user['ddusername']=$baobei['ddusername'];
	$user['hart']=$baobei['user_hart'];
	
	$total=$duoduo->count('baobei',"uid='".$baobei['uid']."'");
	
	$baobei['jump']=u('jump','goods',array('iid'=>$baobei['tao_id'],'fuid'=>$baobei['uid'],'mall'=>2,'code'=>'share','shuju_id'=>$id,'goods_id'=>$baobei['tao_id']));
	$baobei['fxje']=jfb_data_type(fenduan($baobei['commission'],$webset['fxbl'],$dduser['level'],TBMONEYBL));
	
	$comment_total=$duoduo->count('baobei_comment','baobei_id="'.$baobei['id'].'"');
	$comment_arr=$duoduo->select_all('baobei_comment as a,user as b',$field2,'a.baobei_id="'.$baobei['id'].'" and a.uid=b.id order by id desc limit '.$frmnum.','.$pagesize);
	
	$orther_baobei=$duoduo->select_all('baobei',$field3,'id<>"'.$id.'" order by id desc limit 4');
	
	if($dduser['id']<=0){
		$comment_id='noComment';
	}
	elseif($dduser['level']<$webset['baobei']['limit_level']){
		$comment_id='noLevelComment';
	}
	else{
		$comment_id='StartComment';
	}
	
	$seelog=array('type'=>'share','id'=>$baobei['id'],'pic'=>$baobei['img'].'_100x100.jpg','title'=>$baobei['title'],'price'=>$baobei['price']);
	set_browsing_history($seelog);
	
	$page_url=u(MOD,ACT,array('id'=>$id));
	unset($duoduo);
	$parameter['cat_arr']=$cat_arr;
	$parameter['face_img']=$face_img;
	$parameter['face']=$face;
	$parameter['baobei']=$baobei;
	$parameter['user']=$user;
	$parameter['comment_total']=$comment_total;
	$parameter['total']=$total;
	$parameter['comment_arr']=$comment_arr;
	$parameter['orther_baobei']=$orther_baobei;
	$parameter['comment_id']=$comment_id;
	$parameter['page_url']=$page_url;
	$parameter['id']=$id;
	return $parameter;
}
?>