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

$id_arr=$_GET['ids'];
$ids=implode($id_arr,',');
$re=$duoduo->delete_id_in($ids);

if($re==1){
    jump('-1','删除完成');
}
else{
    echo "error";
}
?>