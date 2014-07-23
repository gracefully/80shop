<?php
/**
 * ============================================================================
 * 版权所有 多多网络，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}

$tao_goods=dd_get_cache('tao_goods','array');

function get_tao_goods_tag($tao_goods,$num_iid){
	foreach($tao_goods as $tag=>$row){
		foreach($row as $k=>$arr){
			if($arr['num_iid']==$num_iid){
				$a['tag']=$tag;
				$a['k']=$k;
				return $a;
			}
		}
	}
}

if(!empty($_POST)){
	$a=str_replace("'",'"',$_POST['a']);
	$a=json_decode($a,1);
	if(!empty($a)){
		foreach($a as $row){
			$row['fxje']=fenduan($row['commission'],$webset['fxbl'],0);
			$c=get_tao_goods_tag($tao_goods,$row['num_iid']);
			$b[$c['tag']][$c['k']]=$row;
			ksort($b[$c['tag']]);
		}
		dd_set_cache('tao_goods',$b,'array');
	}
	dd_exit('更新完毕');
}

//更新缓存
function del_session($dir) {
	if (!file_exists($dir)) {
		return false;
	} 
	if (!preg_match('#/data/temp/session/'.date('Ymd').'$#', $dir)) {
		if($dh = opendir($dir)){
			while ($file = readdir($dh)) {
				if ($file != "." && $file != "..") {
					$fullpath = $dir . "/" . $file;
					if (!is_dir($fullpath)) {
						unlink($fullpath);
					} else {
						del_session($fullpath);
					}
				}
			}
		closedir($dh);
		}
		if(judge_empty_dir($dir)==1){
			rmdir($dir);
			return true;
		}
		else {
			return false;
		} 
	}
}

/*$duoduo->set_webset('tao_report_time',TIME,0);
$duoduo->set_webset('paipai_report_time',TIME,0);
$duoduo->set_webset('tuan_goods_time',TIME,0);*/

$duoduo->webset();
define('UPDATECACHE',1);
include(ADMINROOT.'/mod/public/mod.update.php');
del_session(DDROOT.'/data/temp/session');

deldir(DDROOT.'/data/html');

$a=glob(DDROOT.'/data/css/*');
foreach($a as $v){
	$b=str_replace(DDROOT.'/data/css/','',$v);
	if(preg_match('/^index_index.*/',$b)){
		if($webset['static']['index']['index'] != 1){
			unlink($v);
		}
	}
	else{
		unlink($v);
	}
}

$a=glob(DDROOT.'/data/js/*');
foreach($a as $v){
	$b=str_replace(DDROOT.'/data/js/','',$v);
	if(preg_match('/^index_index.*/',$b)){
		if($webset['static']['index']['index'] != 1){
			unlink($v);
		}
	}
	else{
		unlink($v);
	}
}

set_cookie('liebiao','',0,0);

if (isset ($webset['static']['index']['index']) && $webset['static']['index']['index'] == 1) {
	unlink(DDROOT.'/index.html');
	$c=file_get_contents(SITEURL.'/index.php?browser=1');
	if($c!=''){
		file_put_contents(DDROOT.'/index.html',$c);
	}
}
else{
	if(file_exists(DDROOT.'/index.html')){
		unlink(DDROOT.'/index.html');
	}
}

if($webset['taoapi']['auto_fanli']==1){
	$del_buy_log_day=date("Ymd",strtotime("-".BUY_LOG_DAY." day"));
	$duoduo->delete('buy_log','day<"'.$del_buy_log_day.'"');
}

$attack_dir=DDROOT.'/data/temp/attack';
if(!file_exists($attack_dir.'/2010-01-01.txt')){
	deldir($attack_dir);
	MkdirAll($attack_dir);
	file_put_contents($attack_dir.'/2010-01-01.txt',1);
}

PutInfo('更新缓存完毕！',-1);
?>