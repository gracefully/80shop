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
$sort_arr=include(DDROOT.'/data/paipai_sort.php');
?>
<script>
$(function(){
	if(parseInt($('input[name="paipai[open]"]:checked').val())==1){
		$('#p1').show();
		$('#p2').show();
		$('#p3').show();
		$('#p4').show();
		$('#p5').show();
	}
	
		
	$('input[name="paipai[open]"]').click(function(){
		if(parseInt($(this).val())==1){
			$('#p1').show();
			$('#p2').show();
			$('#p3').show();
			$('#p4').show();
			$('#p5').show();;
		}
		else{
			$('#p1').hide();
			$('#p2').hide();
			$('#p3').hide();
			$('#p4').hide();
			$('#p5').hide();
		}
	});
})
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115" align="right">状态：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'开启'),$webset['paipai']['open'],'paipai[open]')?>&nbsp; <a  class="link_tz"  href="http://pop.paipai.com" target="_blank">注册拍拍开放平台</a> <a  class="link_tz" href="http://faq.duoduo123.com/v8/scr/16-1.html" target="_blank">在线教程</a></td>
  </tr>
  <tr id="p1" style="display:none">
    <td align="right">userId：</td>
    <td>&nbsp;<input name="paipai[userId]" value="<?=$webset['paipai']['userId']?>" style="width:230px"  />&nbsp;<span class="zhushi">拍拍联盟用户id</span></td>
  </tr>
  <tr id="p2" style="display:none">
    <td align="right">qq：</td>
    <td>&nbsp;<input name="paipai[qq]" value="<?=$webset['paipai']['qq']?>" style="width:230px" />&nbsp;<span class="zhushi">注册qq</span></td>
  </tr>
  <tr id="p3" style="display:none">
    <td align="right">appOAuthID：</td>
    <td>&nbsp;<input name="paipai[appOAuthID]" value="<?=$webset['paipai']['appOAuthID']?>" style="width:230px" />&nbsp;<span class="zhushi">拍拍开放平台appOAuthID</span></td>
  </tr>
  <tr id="p4" style="display:none">
    <td align="right">secretOAuthKey：</td>
    <td>&nbsp;<input name="paipai[secretOAuthKey]" value="<?=$webset['paipai']['secretOAuthKey']?>" style="width:230px" />&nbsp;<span class="zhushi">拍拍开放平台secretOAuthKey</span></td>
  </tr>
  <tr id="p5" style="display:none">
    <td align="right">accessToken：</td>
    <td>&nbsp;<input name="paipai[accessToken]" value="<?=$webset['paipai']['accessToken']?>" style="width:230px"  />&nbsp;<span class="zhushi">拍拍开放平台accessToken</span></td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>