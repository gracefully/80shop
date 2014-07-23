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
$top_nav_name=array(array('id'=>'zhuce','name'=>'注册营销'),array('id'=>'sign','name'=>'签到营销'),array('id'=>'share','name'=>'会员激励'),array('id'=>'zhidemai','name'=>'值得买奖励'));
include(ADMINROOT.'/mod/public/part_set.act.php');
include(ADMINTPL.'/header.tpl.php');
?>
<script>
$(function(){
	 $('#zhuce').show();
	 $('input[name="sign[open]"]').click(function(){
        if($(this).val()==1){
		    $('#s1').show();
			$('#s2').show();
			$('#s3').show();
		}
		else if($(this).val()==0){
		   $('#s1').hide();
			$('#s2').hide();
			$('#s3').hide();
		}
	});
	
	if(parseInt($('input[name="sign[open]"]:checked').val())==1){
		$('#s1').show();
			$('#s2').show();
			$('#s3').show();
	}
})
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  
  <tbody id="zhuce" class="from_table">
  <tr>
    <td align="right" width="115">注册送金额：</td>
    <td>&nbsp;<input name="user[reg_money]" value="<?=$webset['user']['reg_money']?>"/> 元</td>
  </tr>
  <tr>
    <td align="right">注册送<?=TBMONEY?>：</td>
    <td>&nbsp;<input name="user[reg_jifenbao]" value="<?=$webset['user']['reg_jifenbao']?>"/> 个</td>
  </tr>
  <tr>
    <td align="right">注册送积分：</td>
    <td>&nbsp;<input name="user[reg_jifen]" value="<?=$webset['user']['reg_jifen']?>"/> 个</td>
  </tr>
  <tr>
    <td align="right">注册送等级：</td>
    <td>&nbsp;<input name="user[reg_level]" value="<?=$webset['user']['reg_level']?>"/> 点</td>
  </tr>
  </tbody>
  <tbody id="sign" class="from_table">
   <tr>
    <td width="115px" align="right">签到开关：</td>
    <td>&nbsp;<label><input <?php if($webset['sign']['open']==1){?> checked="checked"<?php }?> name="sign[open]" type="radio" value="1"/> 开启</label>&nbsp;<label><input <?php if($webset['sign']['open']==0){?> checked="checked"<?php }?> name="sign[open]" type="radio" value="0"/> 关闭</label></td>
  </tr>
  <tr id="s1" style="display:none">
    <td align="right">签到送金额：</td>
    <td>&nbsp;<input name="sign[money]" value="<?=$webset['sign']['money']?>"/> 元 </td>
  </tr>
  <tr id="s2" style="display:none">
    <td align="right">签到送<?=TBMONEY?>：</td>
    <td>&nbsp;<input name="sign[jifenbao]" value="<?=$webset['sign']['jifenbao']?>"/> 个 </td>
  </tr>
  <tr id="s3" style="display:none">
    <td align="right">签到送积分：</td>
    <td>&nbsp;<input name="sign[jifen]" value="<?=$webset['sign']['jifen']?>"/> 个</td>
  </tr>
  </tbody>
   <tbody id="share" class="from_table">
  <tr>
    <td width="115px" align="right">晒单奖励积分：</td>
    <td>&nbsp;<input name="baobei[shai_jifen]" value="<?=$webset['baobei']['shai_jifen']?>"/> 个</td>
  </tr>
  <tr>
    <td align="right">分享奖励积分：</td>
    <td>&nbsp;<input name="baobei[share_jifen]" value="<?=$webset['baobei']['share_jifen']?>"/> 个</td>
  </tr>
  <tr>
    <td align="right">红心奖励积分：</td>
    <td>&nbsp;<input name="baobei[hart_jifen]" value="<?=$webset['baobei']['hart_jifen']?>"/> 个</td>
  </tr>
  <tr>
    <td width="115px" align="right">晒单奖励<?=TBMONEY?>：</td>
    <td>&nbsp;<input name="baobei[shai_jifenbao]" value="<?=$webset['baobei']['shai_jifenbao']?>"/> 个</td>
  </tr>
  <tr>
    <td align="right">分享奖励<?=TBMONEY?>：</td>
    <td>&nbsp;<input name="baobei[share_jifenbao]" value="<?=$webset['baobei']['share_jifenbao']?>"/> 个</td>
  </tr>
  <tr>
    <td align="right">红心奖励<?=TBMONEY?>：</td>
    <td>&nbsp;<input name="baobei[hart_jifenbao]" value="<?=$webset['baobei']['hart_jifenbao']?>"/> 个</td>
  </tr>
  
  <tr>
    <td align="right">分享购买奖励：</td>
    <td>&nbsp;<input type="hidden" id="baobei_jiangli_bili" name="baobei[jiangli_bili]" value="<?=$webset['zhidemai']['jiangli_bili']?>" /><input onblur="$('#baobei_jiangli_bili').val(parseInt($(this).val())/100)" value="<?=(float)$webset['baobei']['jiangli_bili']*100?>" style="width:30px"/>% <span class="zhushi">其他会员成功购买宝贝成交后，分享会员得到额外奖励比例，0为不奖励</span></td>
  </tr>
  </tbody>
   <tbody id="zhidemai" class="from_table">
   <tr>
    <td width="115" align="right">爆料奖励：</td>
  	<td>&nbsp;<?=html_radio($huobi_arr,$webset['zhidemai']['jiangli_huobi'],'zhidemai[jiangli_huobi]')?> <input type="text" name="zhidemai[jiangli_value]" style="width:50px" value="<?=$webset['zhidemai']['jiangli_value']?>" /> <span class="zhushi">每个有效爆料的奖励，0 为不奖励</span></td>
  </tr>
  <tr>
    <td align="right">推广奖励：</td>
  	<td>&nbsp;<input type="hidden" id="zhidemai_jiangli_bili" name="zhidemai[jiangli_bili]" value="<?=$webset['zhidemai']['jiangli_bili']?>" /><input onblur="$('#zhidemai_jiangli_bili').val(parseInt($(this).val())/100)" type="text" value="<?=(float)$webset['zhidemai']['jiangli_bili']*100?>" style="width:30px" />% <span class="zhushi">成交后额外奖励比例，0 为不奖励</span></td>
  </tr>
  </tbody>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  
  
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>