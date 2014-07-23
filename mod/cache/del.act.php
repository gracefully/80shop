<?php
/**
 * ============================================================================
 * 版权所有 2008-2012 多多网络，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('INDEX')){
	exit('Access Denied');
}

define('STIME',$_SERVER['REQUEST_TIME']);
$do=$_GET['do']?$_GET['do']:'tao';
$word_arr=array('tao'=>'淘宝','yiqifa'=>'亿起发','paipai'=>'拍拍','wujiumiaoapi'=>'59秒','bijia'=>'比价','linshi'=>'临时');
$path_arr=array('tao'=>$ddTaoapi->ApiConfig->CachePath,'yiqifa'=>DDROOT.'/data/temp/yiqifaapi','wujiumiao'=>DDROOT.'/data/temp/wujiumiaoapi','paipai'=>DDROOT.'/data/temp/paipai','bijia'=>DDROOT.'/data/temp/bijia','linshi'=>DDROOT.'/data/temp/session');

function del_cache($dir,$do) {
	if (file_exists($dir)) {
		$a=dd_glob($dir);
		foreach($a as $file){
			if(!is_dir($file)){
				if(strpos($file, date('Ymd').'/sess_')>0 && $do=='linshi'){
					continue;
				}
				elseif($_GET['admin']==1){  //如果是后台执行
					if(time()-STIME>3){
						PutInfo('删除'.$word[$do].'缓存中。。。<br/><br/><img src="images/wait2.gif" />',u(MOD,ACT,array('admin'=>1,'do'=>$do)));
					}
				}
				else{
					if(BACKSTAGE==1 && time()-STIME>3){
						only_send(u(MOD,ACT,array('do'=>$do)));
					    dd_exit();
					}
				}
				unlink($file);
			}
			else{
				del_cache($file, $do);
			}
		}
		$b=dd_glob($dir);
		if(empty($b)){
			rmdir($dir);
		}
	}
}

if(is_dir($path_arr[$do])){
	del_cache($path_arr[$do],$do);
	if(!is_dir($path_arr[$do]) || $do=='linshi'){
		$script='alert("删除'.$word_arr[$do].'缓存完毕");window.close()';
		echo script($script);
	}
}
else{
	$script='alert("删除'.$word_arr[$do].'缓存完毕");window.close()';
	echo script($script);
}
?>