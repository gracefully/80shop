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
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">key：</td>
    <td>&nbsp;<input name="key" type="text" id="key" value="<?=$row['key']?>" style="width:300px" /></td>
  </tr>
  <tr>
    <td align="right">secret ：</td>
    <td>&nbsp;<input name="secret" type="text" id="secret" value="<?=$row['secret']?>" style="width:300px" /></td>
  </tr>
  <tr>
    <td align="right">调用量：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?>" style="width:300px" /> <span class="zhushi">(多少)次/每分钟</span></td>
  </tr>
  <tr>
    <td align="right">特别说明：</td>
    <td>&nbsp;appkey列表中第一个key（id数字最小的那个就是第一个）成为网站的主key，<a href="http://bbs.duoduo123.com/read-htm-tid-161036.html" target="_blank">关于主key的说明</a></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>