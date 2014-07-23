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
$shifou_arr=array('1'=>'是','0'=>'否','2'=>'全部');
?>
<style>
.numWidth{ width:60px}
</style>
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <form action="index.php" method="get" name="form1">
  <tr>
    <td width="150px" align="right">群发类型：</td>
    <td>&nbsp;<?=html_radio($qunfa_arr,$do,'do')?> &nbsp;<span class="zhushi"><a href="<?=u(MOD,'list',array('do'=>$do))?>">群发列表</a></span></td>
  </tr>
  <tr>
    <td align="right">用户名：</td>
    <td>&nbsp;<input type="text" name="ddusername" id="ddusername" value="<?=$_GET['ddusername']?>" /><span class="zhushi">（模糊查询用此格式【%关键字%】）</span></td>
  </tr>
  <tr>
    <td align="right">会员ID：</td>
    <td>&nbsp;<input type="text" name="sid" value="" class="numWidth" />- <input type="text" name="eid" value="" class="numWidth" /><span class="zhushi">（包含本身）</span></td>
  </tr>
  <tr>
    <td align="right">金额范围：</td>
    <td>&nbsp;<input type="text" name="smoney" value="" class="numWidth" />- <input type="text" name="emoney" value="" class="numWidth" />元 <span class="zhushi">（包含本身）</span></td>
  </tr>
  <tr>
    <td align="right"><?=TBMONEY?>范围：</td>
    <td>&nbsp;<input type="text" name="sjifenbao" value="" class="numWidth" />- <input type="text" name="ejifenbao"  value="" class="numWidth" />个<span class="zhushi">（包含本身）</span></td>
  </tr>
  <tr>
    <td align="right">已提现金额：</td>
    <td>&nbsp;<input type="text" name="syitixian" value="" class="numWidth" />- <input type="text" name="eyitixian" value="" class="numWidth" />元 <span class="zhushi">（包含本身）</span></td>
  </tr>
  <tr>
    <td align="right">已提现<?=TBMONEY?>：</td>
    <td>&nbsp;<input type="text" name="stbyitixian" value="" class="numWidth" />- <input type="text" name="etbyitixian"  value="" class="numWidth" />个<span class="zhushi">（包含本身）</span></td>
  </tr>
  <tr>
    <td align="right">等级范围：</td>
    <td>&nbsp;<input type="text" name="slevel" value="" class="numWidth"/>- <input type="text" name="elevel" value="" class="numWidth"/><span class="zhushi">（包含本身）</span></td>
  </tr>
  <tr>
    <td align="right">注册日期：</td>
    <td>&nbsp;<input name="sregtime" type="text" id="sdate" style="width:100px" value="" />- <input name="eregtime" type="text" id="edate" style="width:100px" value="" /></td>
  </tr>
  <tr>
    <td align="right">最后登陆时间：</td>
    <td>&nbsp;<input name="slastlogintime" type="text" id="sdatetime" style="width:100px" value="" />- <input name="elastlogintime" type="text" id="edatetime" style="width:100px" value="" /></td>
  </tr>
  <tr>
    <td align="right">每轮检索个数：</td>
    <td>&nbsp;<input type="text" name="pagesize" id="pagesize" value="100" class="numWidth" /><span class="zhushi">（默认100，根据服务器性能自行调整）</span></td>
  </tr>
  <tr>
    <td align="right">手机已验证：</td>
    <td>&nbsp;<?=html_radio($shifou_arr,'2','mobile_test')?></td>
  </tr>
  <tr>
    <td align="right"><?=TBMONEY?>提现中：</td>
    <td>&nbsp;<?=html_radio($shifou_arr,'2','tbtxstatus')?></td>
  </tr>
  <tr>
    <td align="right">金额提现中：</td>
    <td>&nbsp;<?=html_radio($shifou_arr,'2','txstatus')?></td>
  </tr>
  <tr>
    <td align="right">手机号不为空：</td>
    <td>&nbsp;<input type="radio" checked="checked" />是 <span class="zhushi">（短信群发必备条件）</span></td>
  </tr>
  <tr>
    <td align="right">群发内容：</td>
    <td><table border="0">
  <tr>
    <td>&nbsp;<textarea class="required" name="content" cols="60" rows="5"><?=$webset['sms']['content']?></textarea></td>
    <td>&nbsp;<span class="zhushi">{name}会替换为会员名，群发短信最好带上{name}，否则可能会因为短信内容相同造成发送失败</span></td>
  </tr>
</table></td>
  </tr>

  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="<?=ACT?>" /><input type="hidden" name="do" value="<?=$do?>" /><input type="submit" id="sub" name="sub" value=" 检 索 会 员 " /></td>
  </tr>
  </form>
</table>
<script>
var v=$('input[name=do]').val();
<?php if($webset['sms']['open']!=1){?>
if(v=='sms'){
	$('#sub').attr('disabled','disabled').after('&nbsp;&nbsp;<a href="<?=u('sms','set')?>">开启短信发送</a>');
	alert('您还没有开启短信发送！');
}
<?php }?>
$('input[name=do]').click(function(){
	
});
</script>
<?php include(ADMINTPL.'/footer.tpl.php');?>