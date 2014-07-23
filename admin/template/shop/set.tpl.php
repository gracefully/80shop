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
$shop_level=include(DDROOT.'/data/tao_level.php');
unset($shop_level[0]);
$shop_level[]='淘宝商城';
?>
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
  <tr>
    <td width="115px" align="right">店铺采集：</td>
    <td>&nbsp;<label><input <?php if($webset['shop']['open']==1){?> checked="checked"<?php }?> name="shop[open]" type="radio" value="1"/> 开启</label>&nbsp;<label><input <?php if($webset['shop']['open']==0){?> checked="checked"<?php }?> name="shop[open]" type="radio" value="0"/> 关闭</label></td>
  </tr>
  <tr>
    <td align="right">等级设置：</td>
    <td>&nbsp;<?=select($shop_level, $webset['shop']['slevel'],'shop[slevel]')?> : <?=select($shop_level, $webset['shop']['elevel'],'shop[elevel]')?></td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </form>
  <form action="index.php?mod=<?=MOD?>&act=batchdel" method="post" name="form1">
   <tr>
    <td align="right">删除店铺：</td>
    <td>&nbsp;<?=select($shop_level,'','slevel')?> : <?=select($shop_level,'','elevel')?></td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 删 除 店 铺 " /></td>
  </tr>
  </form>
</table>

<?php include(ADMINTPL.'/footer.tpl.php');?>