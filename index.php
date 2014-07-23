<?php
/**
 * ============================================================================
 * 版权所有 2008-2013 多多科技，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('INDEX',1);
//排错使用
function shutDownFunction() {
    $error = error_get_last();
    if ($error['type'] == 1) {
       var_dump($error);
    }
}
register_shutdown_function('shutdownFunction');
include ('comm/dd.config.php');
include (DDROOT.'/comm/checkpostandget.php');

spider_limit($webset['spider']);//蜘蛛限制

//if($webset['gzip']==1){ //gzip输出
//	ob_start('ob_gzip');
//}

if($webset['webclose']==1){
	$a=explode(',',$webset['webcloseallowip']);
	if(!in_array(get_client_ip(),$a)){
		include(DDROOT.'/data/webclose.php');
		exit;
	}
}

include (DDROOT . '/comm/Taoapi.php');
include (DDROOT . '/comm/ddTaoapi.class.php');
include (DDROOT . '/mod/header.act.php');

$wjt_mod_act_arr=dd_get_cache('wjt');
$alias_mod_act_arr=dd_get_cache('alias');

define('TPLPATH',DDROOT.'/template/'.MOBAN);
define('TPLURL','template/'.MOBAN);

if(MOD=='tao' || MOD=='index' || MOD=='ajax' || MOD=='jump' || MOD=='shop' || MOD=='cache'){ //只在淘宝,ajax和首页模块下实例化淘宝api
    $ddTaoapi = new ddTaoapi();
	
	if(!empty($user)){
	    $ddTaoapi->dduser=$dduser;
	}
	if(MOD=='tao' && ACT=='list' && isset($_GET['cid']) && !is_numeric($_GET['cid'])){ //list页面加密处理
	    $_GET['cid']=dd_decrypt($_GET['cid'],URLENCRYPT);
	}
	elseif(MOD=='tao' && ACT=='view' && isset($_GET['iid']) && !is_numeric($_GET['iid'])){  //view页面加密处理
	    $_GET['iid']=dd_decrypt($_GET['iid'],URLENCRYPT);
	}
}

if(MOD=='user'){ //user模块特别处理
	if($act=='login' || $act=='register' || $act=='getpassword' || $act=='jihuo'){
	    if($_COOKIE['userlogininfo']!=''){
            jump('index.php');
        }
	}
	else{
	    if($_COOKIE['userlogininfo']==''){
            jump(u('user','login'),'您还没有登陆或登录超时');
        }
	}
}

$mod_name=mod_name($mod,$act);

if($_GET['browser']==1 || browser()!=''){ //判断浏览器，节省淘宝api
    define('BROWSER',1);
}
else{
    define('BROWSER',0);
}

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	define('AJAX',1);
}
else{
	define('AJAX',0);
}

if(WJT==1 && isset($_GET['q'])){
	if(is_url($_GET['q'])==0){
		$_GET['q']=gbk2utf8($_GET['q']);
	}
}

$page_tag=dd_get_cache('page_tag');
if(isset($page_tag[MOD.'/'.ACT])){
	define('PAGETAG',$page_tag[MOD.'/'.ACT]);
}
else{
	define('PAGETAG',MOD);
}

if(file_exists(DDROOT . '/mod/'.MOD.'/fun.class.php')){
	include(DDROOT . '/mod/'.MOD.'/fun.class.php'); //引入模块库
	$dd_mod_class_name='dd_'.MOD.'_class';
	if(class_exists($dd_mod_class_name)){
		$$dd_mod_class_name=new $dd_mod_class_name($duoduo); //实例化，明明规则为 dd_模块名_class 如 dd_user_class
	}
}

if(file_exists(DDROOT . '/mod/'.$mod_name.'.act.php')){
	include(DDROOT . '/mod/'.$mod_name.'.act.php'); //引入模块
}

$tpl_dir_name=DDROOT . '/template/' . MOBAN . '/' . $mod_name . '.tpl.php';
if (file_exists($tpl_dir_name)) {
	if (isset ($webset['static'][MOD][ACT]) && $webset['static'][MOD][ACT] == 1) { //如果此模块有静态设置
		if(is_file(DDROOT.'/'.$mod_name . '.html')){ //如果存在此模块静态页
			$tpl_dir_name=DDROOT.'/'.$mod_name . '.html';
		}
	}
	include ($tpl_dir_name); //引入模板
	include(DDROOT.'/comm/cron.php'); //计划任务
}

$duoduo->close();
unset ($duoduo);
unset ($ddTaoapi);
unset ($webset);
?>