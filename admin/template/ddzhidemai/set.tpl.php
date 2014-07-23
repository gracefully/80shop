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
$top_nav_name=array(array('url'=>u('tuiguang','zhuce'),'name'=>'注册营销'),array('url'=>u('tuiguang','sign'),'name'=>'签到营销'),array('url'=>u('tuiguang','share'),'name'=>'会员激励'),array('url'=>u('ddzhidemai','set'),'name'=>'值得买奖励'));
$huobi_arr=array(1=>'金额',TBMONEY,'积分');
if($webset['zhidemai']['jiangli_huobi']==''){
	$webset['zhidemai']['jiangli_huobi']=1;
}
if($webset['zhidemai']['jiangli_value']==''){
	$webset['zhidemai']['jiangli_value']=0;
}
if($webset['zhidemai']['jiangli_bili']==''){
	$webset['zhidemai']['jiangli_bili']=0;
}

include(ADMINTPL.'/header.tpl.php');
?>

<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115" align="right">有效奖励：</td>
  	<td>&nbsp;<?=html_radio($huobi_arr,$webset['zhidemai']['jiangli_huobi'],'zhidemai[jiangli_huobi]')?> <input type="text" name="zhidemai[jiangli_value]" style="width:50px" value="<?=$webset['zhidemai']['jiangli_value']?>" /> <span class="zhushi">会员爆料审核通过后的奖励，0为不奖励</span></td>
  </tr>
  <tr>
    <td align="right">购物奖励：</td>
  	<td>&nbsp;<input type="text" name="zhidemai[jiangli_bili]" value="<?=$webset['zhidemai']['jiangli_bili']?>" style="width:50px" /> <span class="zhushi">其他会员通过值得买商品成功购物后，给报料人的奖励，购买人所得返利乘以设置比例，请设置小数，如0.1，不需要请写0</span></td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>