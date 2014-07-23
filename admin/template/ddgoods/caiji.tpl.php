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

$caiji_title='';
foreach($webset['ddgoodslanmu'] as $k=>$v){
	if($k==$_GET['code']){
		$caiji_title=$v;
		break;
	}
}

if($caiji_title==''){
	jump(u(MOD,'lanmu'),'请先设置保存栏目信息');
}

include(ADMINTPL.'/header.tpl.php');
?>
<script>

</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>&code=<?=$_GET['code']?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115" align="right">采集栏目：</td>
  	<td>&nbsp;<?=$caiji_title?></td>
  </tr>
  <tr>
    <td width="115" align="right">采集页数：</td>
  	<td>&nbsp;<input class="required" name="max_page" type="text" id="max_page" style="width:50px" value="10"/></td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 开 始 采 集 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>