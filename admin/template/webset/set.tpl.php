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
	$webnick=defined('WEBNAME')?WEBNAME:'';
	$url=DD_U_URL.'/?m=DdApi&a=getweb&url='.urlencode(URL).'&pwd='.md5(md5($_GET['ddyunpwd'])).'&webname='.urlencode($webnick).'&updatesite=1';
	$a=dd_get($url);
	echo $a;
	exit;
}

$ddyunkey=defined('DDYUNKEY')?DDYUNKEY:'';
$url=DD_U_URL.'/?g=Home&m=DdApi&a=getweb&key='.$ddyunkey.'&url='.urlencode(URL).'&webname='.urlencode($webnick);
$a=dd_get_json($url);

if($a['s']==1){
	$row=$a['r'];
}else{
	$row = array();
}
include(ADMINTPL.'/header.tpl.php');
?>
<script>
$(function(){
	$('#getddshouquan').jumpBox({  
	    title: '获取多多密钥（登录百宝箱的密码）',
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
			$('#alipay').val(data.r.alipay);
			$('#realname').val(data.r.realname);
			$('#DDYUNKEY').val(data.r.key);
			$('#siteid').val(data.r.site_id);
			jumpboxClose();
		}
		else{
			alert('密码错误或者还未注册多多云平台');
			$t.attr('disabled',false);
		}
	});
}
</script>

<script>
$(function(){
	KindEditor.options.filterMode = false;
	editor = KindEditor.create('#banquan');
	<?=radio_guanlian('webclose')?>
});

</script>
<form action="index.php?mod=webset&act=set" style="font-size:12px" method="post" name="form1">
<table id="addeditable"  align="center" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="110" align="right">网站开关：</td>
   	<td>&nbsp;
      <?=html_radio(array('0'=>'开启','1'=>'关闭'),$webset['webclose'],'webclose')?>
    </td>
  </tr>
  <tbody class="webclose_guanlian">
  <tr>
    <td align="right"  >关闭时显示的信息：</td>
   	<td style="padding:5px 13px;"><textarea name="webclosemsg" cols="40" rows="3" class="btn3" style="width:400px"><?=$webset['webclosemsg']?></textarea></td>
  </tr>
  <tr>
    <td align="right" >关闭后允许访问IP：</td>
   	<td >&nbsp;
    <input type="text" style="width:400px;" name="webcloseallowip" value="<?=$webset['webcloseallowip']?>" /> <span class="zhushi">可多个，用英文逗号分开。我的IP：<?=get_client_ip()?></span></td>
  </tr>
  </tbody>
  <tr>
    <td align="right">网站logo：</td>
    <td>&nbsp;
    <input name="LOGO" type="text" value="<?=LOGO?>" id="logo" class="btn3" style="width:400px" /> <input class="sub" type="button" value="上传logo" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'logo','do'=>'httpurl','sid'=>session_id()))?>','upload','450','350')" />
  <span class="zhushi">默认模板logo大小：232*79</span></td>
  </tr>
  <tr>
    <td align="right">网站名称：</td>
    <td>&nbsp;
    <input name="WEBNAME" type="text" value="<?=WEBNAME?>" class="btn3" style="width:400px" /> <span class="zhushi">建议不超过5个汉字</span>
  </td>
  </tr>
  <tr>
    <td align="right">网址（全）：</td>
    <td>&nbsp;
      <input name="URL" type="text" id="url" value="<?=URL?>" size="40" class="btn3" style="width:400px" /> <span class="zhushi">如 www.taobao.com 不带http:// 后面不带/ </span>
    </td>
  </tr>
  <tr>
    <td align="right">目录：</td>
    <td>&nbsp;
      <input name="URL_MULU" type="text" id="url_mulu" value="<?=defined('URLMULU')?URLMULU:str_replace($_SERVER['HTTP_HOST'],'',URL);?>" size="40" class="btn3" style="width:400px" /> <span class="zhushi">如果使用二级目建站，填写目录名称 如：/fan ，没有请留空</span>
    </td>
  </tr>
  <tr>
    <td align="right">通信密钥：</td>
    <td>&nbsp;
      <input class="required" name="DDYUNKEY" type="text" id="DDYUNKEY" value="<?=$ddyunkey?>"  <?php if($ddyunkey!=''){?>readonly="readonly" <?php }?>/> <button class="sub" id="getddshouquan">获取</button> <span class="zhushi">请勿泄露 &nbsp;&nbsp;&nbsp;<a href="<?=DD_U_URL?>/index.php?m=user&a=reg&name=<?=urlencode(URL)?>">注册</a></span>
    </td>
  </tr>
   <tr>
    <td align="right">站点id：</td>
    <td>&nbsp; <input name="siteid" type="text" id="siteid" value="<?=$webset['siteid']?>" style="width:150px" readonly="readonly"/><b style="color:#F60"></b></td>
  </tr>
  <tr>
    <td align="right">支付宝账号：</td>
    <td>&nbsp; <input type="text" id="alipay" name="alipay" value="<?=$row['alipay']?>" <?php if($row['alipay']!=''){?>readonly="readonly" <?php }?>/> <span class="zhushi">财务收款的支付宝账号</span>
    </td>
  </tr>
  <tr>
    <td align="right">支付宝名称：</td>
    <td>&nbsp;
     <input type="text" id="realname" name="realname" value="<?=$row['realname']?>" <?php if($row['realname']!=''){?>readonly="readonly" <?php }?>/> <span class="zhushi">设置支付宝的姓名或公司名称 </span>
    </td>
  </tr>
 <tr>
                        <td align="right">站长email：</td>
<td>&nbsp;
<input name="email" type="text" id="email" value="<?=$webset['email']?>"  class="btn3" style="width:150px" /></td>
                    </tr>
					   <tr>
                        <td align="right">站长qq：</td>
<td>&nbsp;
                          <input name="qq" type="text" id="qq" value="<?=$webset['qq']?>" class="btn3" style="width:150px" /></td>
                      </tr>
  <tr>
    <td align="right">网页压缩输出：</td>
    <td>&nbsp;
   <?=html_radio(array('1'=>'开启','0'=>'关闭'),$webset['gzip'],'gzip')?><span class="zhushi">先关闭此项，检测您的主机是否默认支持此功能，如果没有，再选择开启。<a target="_blank" href="http://gzip.zzbaike.com/">检测网站</a></span>
  </td>
  <tr>
    <td align="right">浏览记录：</td>
    <td>&nbsp;
   <?=html_radio(array('1'=>'开启','0'=>'关闭'),$webset['seelog'],'seelog')?><span class="zhushi">网站右侧是否显示浏览记录（此功能有违规风险，站长谨慎开启）</span>
  </td>
  </tr>
  <tr>
    <td height="50" align="right">底部版权：</td>
    <td height="50" style="padding:5px 13px;"><textarea name="banquan" id="banquan" style="width:680px;"><?=$webset['banquan']?></textarea></td>
  </tr>
    <tr>
    <td align="right">&nbsp;</td>
<td>&nbsp;
 <?php if($row['alipay']!='' && $row['realname']!=''){?>
  <input type="hidden" value="1" name="tijiao">
  <?php }?>
      <input type="submit" class="myself" name="sub" value=" 保 存 设 置 " /> 
      </td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>