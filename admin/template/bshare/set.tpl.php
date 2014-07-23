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

include(ADMINTPL.'/header.tpl.php');
?>
<?php
if($webset['bshare']['uuid']!='' && $_GET['do']!='set'){jump(u(MOD,'count'));}
?>
<div class="explain-col">请您注册或登录bShare，以便享用bShare强大的数据统计功能！ <a href="<?=u(MOD,'set',array('do'=>'set'))?>">填写账号</a> <a href="<?=u(MOD,'code')?>">设置代码</a> <a href="<?=u(MOD,'count')?>">查看统计</a> <a href="http://www.bshare.cn" target="_blank">官网</a>
  </div>
<br />
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr width="150px">
    <td align="right">登录类型：</td>
    <td>&nbsp;<label><input name="bindtype" type="radio" value="0" checked="checked" />新注册</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input name="bindtype" type="radio" value="1" />已有账号</label></td>
  </tr>
  <tr>
    <td align="right">网站域名：</td>
    <td>&nbsp;<input type="text" name="bshare[url]" /> <span class="zhushi">在bshare注册的域名，不带http://，如www.duoduo123.com</span></td>
  </tr>
  
  <tr>
    <td align="right">用户名：</td>
    <td>&nbsp;<input name="bshare[user]" id="user" type="text" value="" /> <span class="zhushi">(E-mail)</span></td>
  </tr>
  <tr>
    <td align="right">密码：</td>
    <td>&nbsp;<input name="bshare[pwd]" id="pwd" type="password" value="" /> </td>
  </tr>
  <tr id="repwd">
    <td align="right">确认密码：</td>
    <td>&nbsp;<input name="bshare[pwd2]" id="pwd2" type="password" value="" /> </td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="do" value="login" /><input type="submit" class="sub" id="sub" name="sub" value=" 注 册 " /></td>
  </tr>
</table>
</form>
<script>
$(function(){
	$("input[name=bindtype]:radio").click(function(){  
		if($(this).val() ==1){
			$("#repwd").hide();
			$("#sub").val('登 录');	
		}else{
			$("#repwd").show();
			$("#sub").val('注 册');
		}
	});
	
	$("form").submit(function(){
		if(!$("#user").val().match(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/)){
			alert('请输入正确的邮箱地址！');
			$("#user").focus();
			return false;
		}
		if($("#pwd").val() == ''){
			alert('请输入密码！');
			$("#pwd").focus();
			return false;
		}
		if($("#pwd").val().length<6){
			alert('密码最少6位数！');
			$("#pwd").focus();
			return false;
		}		
		if($("input[name=bindtype][type='radio']:checked").val() == 0 && $("#pwd").val() != $("#pwd2").val()){
			alert('密码需要保持一致！');
			$("#pwd2").focus();
			return false;
		}
	    return true;
	});
})
</script>
<?php include(ADMINTPL.'/footer.tpl.php');?>