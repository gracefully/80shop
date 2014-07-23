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

@set_time_limit(3600);

if(function_exists('ini_set')){
	ini_set('max_execution_time',3600);
}

if(isset($_GET['show']) && authcode($_GET['show'],'DECODE')==1){
    $admin=1;
}
else{
	$admin=0;
	if(TIME-authcode($code,'DECODE',DDKEY)>60){
        PutInfo('访问超时');
	    dd_exit();
    }
}
            
include(DDROOT.'/comm/ddTuan.class.php');
$tuan=new tuan();
$tuan->dbserver=$dbserver;
$tuan->dbuser=$dbuser;
$tuan->dbpass=$dbpass;
$tuan->dbname=$dbname;
$tuan->BIAOTOU=BIAOTOU;
$tuan->link=$duoduo->link;
$tuan->set=$duoduo->webset['tuan'];
$tuan->init();
$mall_id = $_GET['mallid'] ? $_GET['mallid'] : 0;

if($mall_id==0){
	$mall_id='';
	$sql='select id from '.BIAOTOU.'mall where cid="'.$webset['tuan']['mall_cid'].'" and api_url<>"" and api_url IS NOT NULL and api_rule<>"" and api_rule is not null order by sort desc';
	$query=$duoduo->query($sql);
	while($row=$duoduo->fetch_array($query)){
	    $mall_id.=$row['id'].',';
	}
	$mall_id=preg_replace('/,$/','',$mall_id);
}

$mall_id_i = $_GET['mall_id_i'] ? (int)$_GET['mall_id_i'] : 0;
$mall_id_row = explode(',', $mall_id);
$mall_id_row_count = count($mall_id_row);

if ($mall_id_i < $mall_id_row_count && $mall_id_row[0] > 0) {
	$encrypt_key = $_GET['key']?$_GET['key']:authcode('1','ENCODE');
	$tuan->mall_id_i=$mall_id_i;
	$tuan->mall_id_row=$mall_id_row;
	$re = $tuan->collect($encrypt_key);
} else {
	$re['word'] = "miss para";
	$re['url']='';
}

if($admin==1){
	if($re['word']=='采集完成') PutInfo($re['word']);
	PutInfo($re['word'],$re['url'].'&show='.urlencode(authcode(1,'ENCODE')));
}
else{
	if($re['word']=='采集完成') dd_exit();
	$url = $re['url'].'&code='.urlencode(authcode(TIME,'ENCODE',DDKEY));
	only_send($url);
}
unset($tuan);