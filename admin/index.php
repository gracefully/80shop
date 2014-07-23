<?php
/**
 * ============================================================================
 * 版权所有 2008-2013 多多科技，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('ADMIN',1);
//排错使用
function shutDownFunction() {
    $error = error_get_last();
    if ($error['type'] == 1) {
       var_dump($error);
    }
}
register_shutdown_function('shutdownFunction');
include ($_SERVER['DOCUMENT_ROOT'].'/comm/dd.config.php');
include (DDROOT.'/comm/checkpostandget.php');
define('ADMINROOT',DDROOT."/admin");
define('TBMONEYBL',1000);

dd_session_start();

//if($webset['gzip']==1){ //gzip输出
//	ob_start('ob_gzip');
//}
include (DDROOT . '/comm/Taoapi.php');
include (DDROOT . '/comm/ddTaoapi.class.php');

define('ADMINTPL',DDROOT.'/admin/template/');
function mod_name_admin($mod,$act){
	if($mod=='ajax' || $mod=='jump' || $mod=='check'){
	    $mod_name=$mod;
	}
    else{
	    $mod_name=$mod.'/'.$act;
	}
	return $mod_name;
}
$mod_name=mod_name_admin($mod,$act);

//引入菜单
$sql = "select * from ".BIAOTOU."menu order by parent_id asc";
$res = mysql_query($sql);
$menu_arr = array();
$parent_menu = array();
while($row = mysql_fetch_assoc($res)){
	if($row['parent_id'] !=0){
		if(!empty($menu_arr[$row['node']])) {
			$menu_arr[$row['node']][] = $row;
		}else{
			$menu_arr[$row['node']][] = $row;
		} 
	}else{
		if(!empty($parent_menu[$row['node']])) {
			$parent_menu[$row['node']] = $row;
		}else{
			$parent_menu[$row['node']] = $row;
		} 
	}
}
//go_mod
if(!$_GET['go_mod']){
	$_GET['go_mod'] = 'webset';
	$_GET['go_act'] = 'center';
}
//判断是否登录
if($mod!='login1' && !$_SESSION['ddadmin']['name']){
	header("Location:/admin/index.php?mod=login1&act=login");
	exit;
}
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	define('AJAX',1);
}
else{
	define('AJAX',0);
}
//加载类
include (DDROOT . '/comm/zhidemai.class.php');
include (DDROOT . '/comm/ddgoods.class.php');
include (DDROOT . '/comm/ddtuan.class.php');
$zhidemai_class = new zhidemai($duoduo);
$ddgoods_class = new ddgoods($duoduo);

if(file_exists(ADMINROOT . '/mod/'.$mod_name.'.act.php')){
	include(ADMINROOT . '/mod/'.$mod_name.'.act.php'); //引入模块
}
$tpl_dir_name=ADMINROOT . '/template/' . '' . '/' . $mod_name . '.tpl.php';
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