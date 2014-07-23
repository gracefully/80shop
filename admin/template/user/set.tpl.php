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
$top_nav_name=array(array('url'=>u('user','set'),'name'=>'会员设置'),array('url'=>u('api','list'),'name'=>'账号通设置'));
include(ADMINTPL.'/header.tpl.php');
if($webset['smtp']['host']=='' || $webset['smtp']['name']=='' || $webset['smtp']['pwd']==''){
	$smtp_tip=1;
}
?>
<script>
$(function(){
    $('input[name="yinxiangma[open]"]').click(function(){
        if($(this).val()==1){
		    $('.yinxiangmakey').show();
		}
		else if($(this).val()==0){
		    $('.yinxiangmakey').hide();
		}
	});
	
	var w='邮件激活注册开启时必须进行邮件服务器必要设置！';
	if(parseInt($('input[name="user[jihuo]"]:checked').val())==1){
		 smtpSetTip('smtpset',w,<?=$smtp_tip?>);
	}
	
	$('input[name="user[jihuo]"]').click(function(){
        if($(this).val()==1){
		    smtpSetTip('smtpset',w,<?=$smtp_tip?>);
		}
	});
	
	$('form[name=form_user]').submit(function(){
		var s='邮件激活注册开启时第三方登陆请选择第二种方案"需要完善相关信息"！';
		if(parseInt($('input[name="user[jihuo]"]:checked').val())==1 && parseInt($('input[name="user[autoreg]"]:checked').val())==1){
			alert(s);
			$('#disanfang').show();
			return false;
		}else{
			var token='<?=$_SESSION['token']?>';
			var method=$(this).attr('method');
			if(method.toLowerCase()=='post'){
				var action=$(this).attr('action');
				if(action=='') action='index.php';
				$(this).attr('action',action+'&token='+token);
			}
			var $sub=$(this).find('input[type=submit]');
			$sub.attr('disabled','true');
			$sub.val('提交中...');
			$sub.after('<input type="hidden" name="sub" value="1" />');
			return true;
		}
	});
})
</script>
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form_user">
  <tr>
    <td align="right">会员等级设置：</td>
    <td>&nbsp;
      <?php
      $level_c=count($webset['level']);
      if($level_c<WEB_USER_LEVEL){
          for($i=0;$i<WEB_USER_LEVEL-$level_c;$i++){
              $web_user_level[$i]='会员等级';
          }
          $webset['level']=$web_user_level+$webset['level'];
      }
      ?>
    <?php foreach($webset['level'] as $k=>$v){?>
    <input type="text" name="level_name[]" value="<?=$v?>" style="width:60px; font-family:'宋体'" />：<input name="level_dengji[]" type="text"  value="<?=$k?>"  class="required" num="y" style="width:30px; font-family:'宋体'" />
    <?php }?>
   <span class="zhushi">（一次成功的交易积1点等级）</span></td>
    </tr>
  <tr>
    <td width="150" align="right">邮件激活注册：</td>
    <td>&nbsp;<?=html_radio(array('0'=>'关闭','1'=>'开启'),$webset['user']['jihuo'],'user[jihuo]');?> <span class="zhushi"><a style="display:none; font-weight:bold" id="smtpset" href="<?=u('smtp','set')?>">请先设置邮件服务器</a></span></td>
  </tr>
  <tr>
    <td align="right">注册可选字段：</td>
    <td>&nbsp;<label><input value="1" <?php if($webset['user']['need_alipay']==1){?> checked="checked"<?php }?> type="checkbox" name="user[need_alipay]" />支付宝</label> <label><input value="1" <?php if($webset['user']['need_qq']==1){?> checked="checked"<?php }?> type="checkbox" name="user[need_qq]" />QQ</label> <label><input value="1" <?php if($webset['user']['need_tbnick']==1){?> checked="checked"<?php }?> type="checkbox" name="user[need_tbnick]" />淘宝帐号</label> <label><input value="1" <?php if($webset['user']['need_tjr']==1){?> checked="checked"<?php }?> type="checkbox" name="user[need_tjr]" />推荐人</label></td>
  </tr>
    <tr>
    <td align="right">印象码验证：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'开启'),$webset['yinxiangma']['open'],'yinxiangma[open]')?> <span class="zhushi">（注册验证码的另一种表现形式）<a href="http://www.yinxiangma.com/server/register.php?refer=m43rcw" style="text-decoration:underline" target="_blank">官网</a> （请使用本链接注册，作为多多会员可享受更多的优惠）</span></td>
  </tr>
  <tr class="yinxiangmakey" <?php if($webset['yinxiangma']['open']==0){?> style="display:none"<?php }?>>
    <td align="right">印象码PRIVATE_KEY：</td>
    <td>&nbsp;<input name="yinxiangma[private_key]" value="<?=$webset['yinxiangma']['private_key']?>"/> </td>
  </tr>
  <tr class="yinxiangmakey" <?php if($webset['yinxiangma']['open']==0){?> style="display:none"<?php }?>>
    <td align="right">印象码PUBLIC_KEYY：</td>
    <td>&nbsp;<input name="yinxiangma[public_key]" value="<?=$webset['yinxiangma']['public_key']?>"/> </td>
  </tr>
  <tr>
    <td align="right">第三方登陆：</td>
    <td height="30" style="padding:6px;"><label><input <?php if($webset['user']['autoreg']==1){?> checked="checked"<?php }?> name="user[autoreg]" type="radio" value="1"/></label>      
     <span class="zhushi">会员使用第三方登陆返回网站后，不需要完善相关信息。 <br/>
     <label><input <?php if($webset['user']['autoreg']==0){?> checked="checked"<?php }?> name="user[autoreg]" type="radio" value="0"/></label> 
    会员使用第三方登陆返回网站后，需要完善相关信息。<a style="display:none; font-weight:bold;color:red" id="disanfang">邮件激活注册开启时请选择第二种方案</a></span></td>
  </tr>
  <tr>
    <td align="right">头像上传：</td>
    <td>&nbsp;<?=html_radio(array(1=>'基本模式（兼容性强）',2=>'高级模式（可实现在线裁剪图片的功能）'),$webset['user']['up_avatar'],'user[up_avatar]')?></td>
  </tr>
    <tr>
    <td width="150" align="right">登陆提醒：</td>
    <td>&nbsp;<label><input <?php if($webset['user']['login_tip']==1){?> checked="checked"<?php }?> name="user[login_tip]" type="radio" value="1"/> 开启</label>&nbsp;<label><input <?php if($webset['user']['login_tip']==0){?> checked="checked"<?php }?> name="user[login_tip]" type="radio" value="0"/> 关闭</label> 
    <span class="zhushi">（跳转到淘宝/商城前，判断是否登陆并提醒）</span></td>
  </tr>
   <tr>
    <td align="right">注册限制：</td>
    <td>&nbsp;<input name="user[reg_between]" value="<?=$webset['user']['reg_between']?>"/>小时内可注册1个。<span class="zhushi">（以IP作为判断依据，0为不限制）</span></td>
  </tr>
  <tr>
    <td align="right">注册起始id：</td>
    <td>&nbsp;<?=limit_input('user[auto_increment]',$auto_increment,150,0)?> <span class="zhushi">会员注册的id以此数值为起点，如果不懂，别瞎写，就当这个不存在，建议在千万之内</span></td>
  </tr>
  <tr>
    <td align="right">登录验证码：</td>
    <td>&nbsp;<input name="MAX_ERROR_LOGIN_NUM" value="<?=(int)MAX_ERROR_LOGIN_NUM?>"/> <span class="zhushi">登录帐号密码错误几次后显示验证码，如果需要每次都输入验证码，请填写0，如果不需要，请填写999</span></td>
  </tr>
  <tr>
    <td align="right">评论间隔：</td>
    <td>&nbsp;<input name="comment_interval" type="text" id="comment_interval" value="<?=$webset['comment_interval']?>" class="btn3" />单位[秒] <span class="zhushi">会员对网站评价间隔时间（商城，分享）</span></td>
  </tr>
  <tr>
    <td align="right">会员禁用IP：</td>
    <td>
      <table border="0">
        <tr>
          <td><textarea style="width:150px; height:150px" name="user[limit_ip]"><?=$webset['user']['limit_ip']?></textarea></td>
          <td><span class="zhushi">禁止登录注册，多个IP可用空格，回车或者逗号隔开。<br/><br/>支持IP段格式，如127.0.*.*</span></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </form>
</table>
<?php include(ADMINTPL.'/footer.tpl.php');?>