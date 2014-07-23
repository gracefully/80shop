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

function jiesuan_id($id){
	global $duoduo;
    $income=$duoduo->select('income','*','id="'.$id.'"');
    $data=array(array('f'=>'money','e'=>'+','v'=>$income['money']),array('f'=>'jifen','e'=>'+','v'=>$income['jifen']));
    $duoduo->update('user',$data,'id="'.$income['uid'].'"');
    $duoduo->delete('income','id="'.$income['id'].'"');
}

function jiesuan_user_id($uid){
	global $duoduo;
    $income_arr=$duoduo->select_all('income','*','uid="'.$uid.'"');
	foreach($income_arr as $row){
	    jiesuan_id($row['id']);
	}
}

if(!isset($_GET['id']) && !isset($_GET['ids']) && !isset($_GET['uid'])){
	jump(-1,'缺少必要参数！');
}

if(array_key_exists('id',$_GET) && $_GET['id']!=''){
    $id=$_GET['id'];
	jiesuan_id($id);
}
elseif(array_key_exists('uid',$_GET) && $_GET['uid']!=''){
    $uid=$_GET['uid'];
	jiesuan_user_id($uid);
}
elseif(array_key_exists('ids',$_GET) && $_GET['ids']!=''){
	$ids=$_GET['ids'];
    foreach($ids as $id){
	    jiesuan_id($id);
	}
}
jump(-1,'结算完成！');