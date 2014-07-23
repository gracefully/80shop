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

$lianmeng_arr=array();
if(DDMALL==1){
	$i=1;
	foreach($lianmeng as $k=>$arr){
		if($i==1){$first=$k;}
		if($webset[$arr['code']]['status']==1){
			$lianmeng_arr[$k]=$arr['title'];
		}
		$i++;
	}
}

include(ADMINTPL.'/header.tpl.php');
?>
<script>
$(function(){
	$('input[name="lianmeng"]').click(function(){
		var v=$(this).val();
		$('#postform').attr('action','index.php?mod=<?=MOD?>&act=<?=ACT?>&do='+$(this).val());
		$('#lmtip').html(lianmengTip[v]);
	});
});
var lianmengTip=new Array();
<?php foreach($lianmeng as $k=>$arr){?>
lianmengTip['<?=$k?>']='<?=$arr['gettip']?>';
<?php }?>
</script>
<div class="explain-col">
提示：请选择获取交易的时间段。
<b style="color:red" id="lmtip"></b>
<br />已经获取过的交易不会覆盖原有的数据，获取过程将自动忽略。时间必须为8位，并且开始时间小于结束时间，否则将无法获取成功！<br />
</div>
<br />
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>&do=<?=$first?>" name="form1" method="post" id="postform">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <?php if(DDMALL==1){?>
  <tr>
    <td width="115px" align="right">选择联盟：</td>
    <td>&nbsp;<?=html_radio($lianmeng_arr,$first,'lianmeng')?></td>
  </tr>
  <?php }?>
  <tr>
    <td width="115px" align="right">时间范围：</td>
    <td>&nbsp;<input name="sday" type="text" id="sday" size="10" maxlength="8" value="<?=date('Ymd')?>" /> 到 <input name="eday" type="text" id="eday" size="10" maxlength="8" value="<?=date('Ymd')?>" /></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="submit" class="sub" name="sub" value="获取交易记录" /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>