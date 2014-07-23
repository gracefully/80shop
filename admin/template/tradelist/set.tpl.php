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

if($_GET['ddyunpwd']!=''){
	$url=DD_YUN_URL.'/?g=Home&m=User&a=getweb&url='.urlencode(URL).'&pwd='.md5(md5($_GET['ddyunpwd']));
	$a=dd_get($url);
	echo $a;
	exit;
}
$top_nav_name=array(array('url'=>u('tradelist','set'),'name'=>'淘宝设置'),array('url'=>u('plugin','alimama'),'name'=>'淘宝联盟设置'));
include(ADMINTPL.'/header.tpl.php');

if(!defined('TAOTYPE')){
	define(TAOTYPE,1);
}
if(!defined('TAODATATPL')){
	define('TAODATATPL',1);
}
?>
<style>
<?php if(TAOTYPE==1){?>
.taoi-api-mod{ display:none}
<?php }else{?>
#auto_fanli{ display:none}
<?php }?>
</style>
<script>
$(function(){
	if(parseInt($('input[name="taoapi[freeze]"]:checked').val())==2){
		$('#djxz').show();
		$('#djsj').show();
	}
	
	if(parseInt($('input[name="taoapi[s8]"]:checked').val())==1){
		$('#s8_pid').show();
	}
	
	if(parseInt($('input[name="TAOTYPE:checked').val())==2){
		$('#key').show();
		$('#secret').show();
	}else{
		$('#key').hide();
		$('#secret').hide();
	}
	
		
	$('input[name="taoapi[s8]"]').click(function(){
		if(parseInt($(this).val())==1){
			$('#s8_pid').show();
		}
		else{
			$('#s8_pid').hide();
		}
	});
	
	$('input[name="taoapi[freeze]"]').click(function(){
		if(parseInt($(this).val())==2){
			$('#djxz').show();
			$('#djsj').show();
		}
		else{
			$('#djxz').hide();
			$('#djsj').hide();
		}
	});
	
	if(parseInt($('input[name="JIFENBAO"]:checked').val())==2){
		$('#jfbzdy').show();
	}
	
	$('input[name="JIFENBAO"]').click(function(){
		if(parseInt($(this).val())==2){
			$('#jfbzdy').show();
		}
		else{
			$('#jfbzdy').hide();
			$('#tb_money_name').val('集分宝');
			$('#tb_money_unit').val('个');
			$('#tb_money_bili').val('100');
			$('input[name="TBMONEYTYPE"]:eq(0)').attr("checked",'checked');
		}
	});
	
	if(parseInt($('input[name="taoapi[m2j]"]:checked').val())==1){
		$('.taoapim2j_close').show();
	}
	
	$('input[name="taoapi[m2j]"]').click(function(){
		if(parseInt($(this).val())==1){
			$('.taoapim2j_close').show();
		}
		else{
			$('.taoapim2j_close').hide();
		}
	});
	
	$('input[name="TAOTYPE"]').click(function(){
		if(parseInt($(this).val())==2){
			$('#key').show();
			$('#secret').show();
		}
		else{
			$('#key').hide();
			$('#secret').hide();
		}
		alert('注意，两种形式不要任意切换，你是有返利类api的就一直选择有返利类api，不要没事儿选择一会无api，一会有api，后果自负');
	});
	
	$('#getddshouquan').jumpBox({  
	    title: '获取云平台密钥（登录百宝箱的密码）',
		titlebg:1,
		height:140,
		width:450,
		contain:'<div id="ddform">平台登陆密码：<input id="ddyunpwd" type="password" name="ddyunpwd" value="" /> <input type="submit" onclick="shouquan($(this))" value="登录获取" /></div>',
		LightBox:'show'
    });
})

function shouquan($t){
	var ddyunpwd=$('#ddyunpwd').val();
	if(ddyunpwd==''){
		alert('登录密码不能为空');
		$('#ddopenpwd').focus();
		return false;
	}
	
	$t.attr('disabled','true');
	var url='<?=u(MOD,ACT)?>&ddyunpwd='+encodeURIComponent(ddyunpwd);
	$.getJSON(url,function(data){
		if(data.s==1){
            $('#DDYUNKEY').val(data.r.key);
			jumpboxClose();
		}
		else{
			alert('密码错误或者还未注册多多云平台');
			$t.attr('disabled',false);
		}
	});
}
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115" align="right">淘宝调用形式：</td>
    <td>&nbsp;<?=html_radio(array(1=>'无淘宝客返利类api',2=>'有淘宝客返利类api'),TAOTYPE,'TAOTYPE')?><span class="zhushi"> &nbsp;<a href="http://bbs.duoduo123.com/read.php?tid=158163&ds=1&page=1&toread=1#tpc" target="_blank">如何查看</a></span></td>
  </tr>
  <tr id="key" style="display:none">
    <td align="right">Appkey：</td>
    <td>&nbsp;<input name="taoapi[appkey]" value="<?=$webset['taoapi']['appkey']?>" style="width:250PX;" />&nbsp;</td>
  </tr>
  <tr  id="secret" style="display:none">
    <td align="right"> Secret：</td>
    <td>&nbsp;<input name="taoapi[secret]" value="<?=$webset['taoapi']['secret']?>" style="width:250PX;" />&nbsp;</td>
  </tr>
  <tr>
    <td align="right">淘宝返利形式：</td>
    <td>&nbsp;<?=html_radio(array(1=>'集分宝',2=>'自定义'),JIFENBAO,'JIFENBAO')?>&nbsp; </td>
  </tr>
  <tr id="jfbzdy" style="display:none">
    <td align="right">淘宝返利自定义：</td>
    <td>&nbsp;名称：<input type="text" id="tb_money_name" name="TBMONEY" value="<?=TBMONEY?>" style="width:50px;" />&nbsp;单位：<input type="text" id="tb_money_unit" name="TBMONEYUNIT" value="<?=TBMONEYUNIT?>" style="width:30px;" />&nbsp;比例：<input style="width:30px" type="text" id="tb_money_bili" name="TBMONEYBL" value="<?=TBMONEYBL?>" /> <?=TBMONEY?>与人民币的比例为<?=TBMONEYBL?>:1 &nbsp; 数据格式：<?=html_radio(array(1=>'整数',2=>'小数（两位有效数字）'),TBMONEYTYPE,'TBMONEYTYPE')?>	    </td>
  <tr>
    <td align="right">金额转<?=TBMONEY?>：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'开启'),$webset['taoapi']['m2j'],'taoapi[m2j]')?>&nbsp; <span class="taoapi[m2j]_close" style="display:none">手续费：<input class="required" num='y' style="width:50px;" type="text" name="JFB_FEE" value="<?=JFB_FEE?>" /> <span class="zhushi">例子：0.07，不需要会员支付手续费写0，不能为空！</span></span></td>
  </tr>
  <tr class="taoapim2j_close" style="display:none">
    <td align="right">转换手续费：</td>
    <td>&nbsp;<input class="required" num='y' style="width:50px;" type="text" name="JFB_FEE" value="<?=JFB_FEE?>" /> <span class="zhushi">例子：0.07，不需要会员支付手续费写0，不能为空！</span></td>
  </tr>
  <tr>
    <td align="right">淘宝找回订单审核：</td>
    <td>&nbsp;<?=html_radio(array(0=>'自动',1=>'人工'),$webset['taoapi']['trade_check'],'taoapi[trade_check]')?> <span class="zhushi">为了安全建议开启 人工</span></td>
  </tr>
  <tr>
    <td align="right">跳转方式：</td>
    <td>&nbsp;<?=html_radio(array(0=>'到淘宝',1=>'到本站'),WEBTYPE,'WEBTYPE')?> <span class="zhushi">用户点击商品列表时跳转方式</span></td>
  </tr>
  <tr id="auto_fanli">
    <td align="right">自动返利：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'开启'),$webset['taoapi']['auto_fanli'],'taoapi[auto_fanli]')?>&nbsp;<span class="zhushi">用于无淘宝客返利类api下订单自动跟踪会员 &nbsp;<a target="_blank" href="http://bbs.duoduo123.com/read-htm-tid-159430-ds-1.html">说明教程</a></span></td>
  </tr>
  <tr>
    <td align="right">冻结返利：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',/*1=>'按结算日解冻(当月返利会处在未结算状态)',*/2=>开启),$webset['taoapi']['freeze'],'taoapi[freeze]')?>&nbsp;</td>
  </tr>
  <tr id="djsj" style="display:none">
    <td align="right">冻结返利开始时间：</td>
    <td>&nbsp;<input type="text" name="taoapi[freeze_sday]" id="sdatetime" value="<?=$webset['taoapi']['freeze_sday']?$webset['taoapi']['freeze_sday']:date('Y-m-d H:i:s',TIME)?>" /> <span class="zhushi">冻结<?=TAO_FREEZE_DAY?>天设置的开始时间，要大于站内所有会员的提现时间</span></td>
  </tr>
  <tr id="djxz" style="display:none">
    <td align="right">冻结返利限制：</td>
    <td>&nbsp;<input style="width:150px" name="taoapi[freeze_limit]" value="<?=$webset['taoapi']['freeze_limit']?>" /> <span class="zhushi"><?=TBMONEY?> 大于等于此数值会冻结返利</span></td>
  </tr>
  <tr>
    <td align="right">S8搜索：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'开启'),$webset['taoapi']['s8'],'taoapi[s8]')?>&nbsp;<span class="zhushi">S8订单联盟没有明细报表</span> </td>
  </tr>
 <tr id="s8_pid" style="display:none">
    <td align="right" >S8搜索PID：</td>
    <td>&nbsp;<input name="taoapi[taobao_search_pid]" value="<?=$webset['taoapi']['taobao_chongzhi_pid']?>" style="width:250PX;" />&nbsp;<span class="zhushi">例：mm_16653469_23456789_34567890 <a href="http://bbs.duoduo123.com/read-htm-tid-178083.html" target="_blank">S8申请说明</a></span> </td>
  </tr>
  <!--<tr>
    <td align="right">充值框完整pid：</td>
    <td>&nbsp;<input name="taoapi[taobao_chongzhi_pid]" value="<?=$webset['taoapi']['taobao_chongzhi_pid']?>" style="width:250PX;"/>&nbsp;<span class="zhushi">例：mm_16653469_23456789_34567890（如无特别需求，填写淘点金pid即可）</span></td>
  </tr>-->
  <tr>
    <td align="right">淘点金设置：</td>
    <td><span class="zhushi">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="400" style="padding:5px 5px;"><textarea cols="60" rows="23" id="taodianjin"><?=$webset['taodianjin_pid']?$taodianjin_set:''?>
          </textarea></td>
          <td style=" line-height:30px; padding:5px 5px;">
          <a href="http://bbs.duoduo123.com/read-htm-tid-159578.html" target="_blank">淘点金代码获取教程</a></br>
          1、首次开通淘点金代码，大约需要1小时生效！（<a href="http://www.alimama.com" target="_blank">前往阿里妈妈</a>）</br>
          2、淘点金代码必须在你申请淘点金的域名下才可使用</br>
          3、<a data-type="1" biz-sellerid="263817957" data-tmpl="140x190" data-tmplid="3" data-rd="1" data-style="1" data-border="1" target="_blank" href="#">淘点金测试</a>（鼠标放在文字上，会出现一个带有“韩都衣舍”logo的浮动层，如果你没出现，说明你的淘点金代码是错误的，点击浮动层到达淘宝有pid，说明你的淘点金代码生效了。<a href="http://bbs.duoduo123.com/read-htm-tid-168561.html" target="_blank">查看详细说明</a>）</br>
          4、程序会提取你的阿里妈妈pid并且格式化代码，如果你需要修改淘点金代码，文件在comm/tdj_tpl.php</br>
          5、<a href="http://bbs.duoduo123.com/read-htm-tid-168865.html" target="_blank">淘点金代码本地化</a></br>
          </td>
        </tr>
      </table></span> </td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
     <input type="hidden" name="taodianjin_pid" id="taodianjin_pid" />
  </tr>
</table>
</form>
<script>
$(document).ready(function(){
  $("#taodianjin").focus();
}); 

$("#taodianjin").blur(function(){
	var patrn=/mm_[0-9]+_[0-9]+_[0-9]+/ig; 
	var pid=patrn.exec($("#taodianjin").val());
	$("#taodianjin_pid").val(pid);
});
</script>
<?=$taodianjin_set?>
<?php include(ADMINTPL.'/footer.tpl.php');?>