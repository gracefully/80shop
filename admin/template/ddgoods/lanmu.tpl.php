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

/*$url=DD_U_URL.'/index.php?g=Home&m=DdApi&a=goods_type&url='.urlencode(URL).'&key='.DDYUNKEY;
$a=dd_get_json($url);
if(isset($a['s']) && $a['s']==0){
	jump(u(MOD,'miyue'),'密钥错误，请从新设置');
}

if(count($webset['ddgoods'])!=count($a)){
	$webset['ddgoods']=$a;
}
*/

include(ADMINTPL.'/header.tpl.php');
?>
<?php include(ADMINROOT.'/template/'.MOD.'/top.tpl.php');?>
<iframe src="<?=DD_U_URL?>/index.php?g=alliance&m=goods&a=lanmu&url=<?=urlencode(URL)?>" frameborder="0" width="100%" height="1000px"></iframe>
<?php include(ADMINTPL.'/footer.tpl.php');exit;?>
<script>
$(function(){
	KindEditor.options.filterMode = false;
	<?php foreach($a as $row){?>
	<?=$row['code']?>Editor = KindEditor.create('#<?=$row['code']?>_content');
	<?php }?>
})

</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
<?php foreach($webset['ddgoods'] as $row){?>
  <tr>
    <td width="115" align="right">标题：</td>
  	<td>&nbsp;<input class="required" name="ddgoods[<?=$row['code']?>][title]" type="text" value="<?=$row['title']?>"/></td>
  </tr>
  <tr>
    <td width="115" align="right">介绍：</td>
  	<td><textarea name="ddgoods[<?=$row['code']?>][content]" id="<?=$row['code']?>_content" style="width:800px"><?=$row['content']?></textarea></td>
  </tr>
  <tr><td colspan="2"><hr/><input class="required" name="ddgoods[<?=$row['code']?>][code]" type="hidden" value="<?=$row['code']?>"/></td></tr>
<?php }?>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>