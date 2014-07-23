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
<div class="explain-col"> 温馨提示：返现宝（右键浏览器插件版）已被淘宝认定是非法插件，一经发现，封冻阿里妈妈账号，请慎重使用！
  </div>
<br />
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">状态：</td>
    <td>&nbsp;<?=html_radio($open_arr,$webset['fxb']['open'],'fxb[open]')?> </td>
  </tr>
  <tr>
    <td align="right">返现宝名称：</td>
    <td>&nbsp;<input type="text" name="fxb[name]" value="<?=$webset['fxb']['name']?>" /></td>
  </tr>
  <tr>
    <td align="right"></td>
    <td>&nbsp;<input type="submit" name="sub" class="sub" value=" 提 交 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>