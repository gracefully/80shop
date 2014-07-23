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
	$duoduo->set_webset('DDYUNKEY',$_POST['DDYUNKEY']);
	//$duoduo->set_webset('zhidemai',$_POST['zhidemai']);
	$duoduo->set_webset('ddgoods',$_POST['ddgoods']);
	
	$alipay=$_POST['alipay'];
	$realname=$_POST['realname'];
	if ($realname == '') {
		jump(-1, '请填写你的真实姓名'); //支付宝格式错误
	}
	$alipay_pass = reg_alipay($alipay);
	if ($alipay_pass == 0) {
		jump(-1, 35); //支付宝格式错误
	}
	$re=dd_get_json(DD_U_URL.'/?g=Home&m=DdApi&a=getweb&type=game&key='.$_POST['DDYUNKEY'].'&url='.urlencode(CURURL).'&alipay='.$alipay.'&realname='.$realname);
	if($re['s']==0){
		jump(-1,$re['r']);
	}else{
		jump(-1,"修改成功");
	}
}