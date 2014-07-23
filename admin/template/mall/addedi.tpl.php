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

if($_GET['mall_url']!=''){
	$url=DD_U_URL.'/?g=Home&m=DdApi&a=mall_info&mall_url='.urlencode($_GET['mall_url']);
	$a=dd_get($url);
	echo $a;
	exit;
}

include(ADMINTPL.'/header.tpl.php');
?>
<style>
.tuan{ display:none}
</style>
<script>
lmArr=new Array();
<?php $m=0; foreach($lianmeng as $k=>$arr){?>
lmArr[<?=$k?>]=new Array();
lmArr[<?=$k?>]['title']='<?=$arr['title']?>';
lmArr[<?=$k?>]['code']='<?=$arr['code']?>';
lmArr[<?=$k?>]['helpurl']='<?=$arr['helpurl']?>';
<?php if($m==0){$cur_helpurl=$arr['helpurl'];$m++;} }?>
function getPinyin(){
    var title=$('#title').val();
	$.post('../<?=u('ajax','pinyin')?>',{title:title},function(data){
	    $('#pinyin').val(data);
	});
}

function openwinx(url,name,w,h)
{
	api_city=$('#api_city').val();
	id=$('#id').val();
	if(api_city==''){
	    alert('城市api连接不能为空');
	}
	else if(id==''){
	    alert('保存商城后从新打开再生成城市api');
	}
	else{
	    window.open(url,name,"top=100,left=400,width=" + w + ",height=" + h + ",toolbar=no,menubar=no,scrollbars=yes,resizable=no,location=no,status=no");
	}
}

function b(){
	<?php foreach($lianmeng as $k=>$arr){?>
    $('.<?=$arr['code']?>_tr').hide();
	<?php }?>
}

function c(lm){
    b();
	$('.'+lmArr[lm]['code']+'_tr').show();
	if(lm=='1' || lm=='5'){
		$('#getmallinfo').show();
	}
	else{
		$('#getmallinfo').hide();
	}
}

$(function(){
	$('#getddmallinfo_button').click(function(){
		var url='<?=u(MOD,ACT)?>&mall_url='+encodeURIComponent($('#url').val());
		$.getJSON(url,function(data){
			$('#url').val(data.url);
			$('#domain').val(data.domain);
			$('#title').val(data.title);
			$('#pinyin').val(data.pinyin);
			$('#fan').val(data.fan);
			$('#img').val(data.img);
			$('#edate').val($.trim(getLocalTime(data.edate)));
			$('#cid').val(data.cid);
			if($('#des').val()==''){
			    $('#des').val(data.des);
			}
			var c=editor.html().replace('<p>','').replace('</p>','').replace('&nbsp;',''); //编辑器人为清空还会有残留代码
			c=$.trim(c);
			if(c==''){
			    editor.html(data.content);
			}
		});
	})	   
	
	var lm = $('#lm').val();
	var catname = $('#cid').find("option:selected").text();
	if(catname.indexOf("团购")>=0){
		$('.tuan').show();
	}
	c(lm);
    $('#lm').change(function(){
	    var lm = $(this).val();
		$('#helpurl').attr('href',lmArr[lm]['helpurl']);
		c(lm);
	});
	$('#cid').change(function(){
	    catname=$(this).find("option:selected").text();
		if(catname.indexOf("团购")>=0){
		    $('.tuan').show();
		}
		else{
		    $('.tuan').hide();
		}
	});
	$('#tiqu').click(function(){
	    var url=$('#yiqifaurl').val();
		if(url==''){
		    alert('亿起发推广链接还未填写');
		}
		else{
		    var a= url.match(/&c=(\d+)&/);
		    $('#yiqifaid').val(a[1]);
		}
		return false;
	});
	
	$('#get_59miao_click_url').click(function(){
		var wujiumiaoid=$('#wujiumiaoid').val();
		if(wujiumiaoid==''){
			alert('59秒广告主id不能为空！');
		}
		else{
			$(this).attr('disabled','disabled');
			var button=$(this);
			$.ajax({
                url: '../<?=u('ajax','get_59miao_mall')?>',
				data:{sid:wujiumiaoid},
                type: 'POST',
                dataType: 'json',
                error: function(XMLHttpRequest,textStatus, errorThrown){
                    alert('链接不通');
					//alert(XMLHttpRequest.status);
                 //alert(XMLHttpRequest.readyState);
				 //alert(textStatus);
					return false;
                },
                success: function(data){
					button.attr('disabled',false);
					if (typeof  data.click_url=='undefined' || data==null){
					    alert('无此商城信息');
					    return false;
					}
					else{
					    $('#wujiumiaourl').val(data.click_url);
					}
                }
            });
		}
	});
	
	$('#getmallinfo_button').click(function(){
	    var url=$('#url').val();
		if(url==''){
			alert('网址必须填写');
			$('#url').focus();
		}
		else{
			if($('#lm').val()=='1'){
				var ajaxUrl='index.php?mod=ajax&act=chanet&do=get_info';
				var lianmeng='chanet';
			}
			else if($('#lm').val()=='5'){
				var ajaxUrl='index.php?mod=ajax&act=weiyi&do=get_info';
				var lianmeng='weiyi';
			}
			$(this).attr('disabled','disabled');
			var button=$(this);
			$.ajax({
                url: '../'+ajaxUrl,
				data:{url:url},
                type: 'POST',
                dataType: 'json',
                error: function(XMLHttpRequest,textStatus, errorThrown){
                    alert('链接不通');
					//alert(XMLHttpRequest.status);
                 //alert(XMLHttpRequest.readyState);
				 //alert(textStatus);
					$('#showmall a').html('<b style=" font-weight:blod; color:red">查看全部</b>');
					return false;
                },
                success: function(data){
					button.attr('disabled',false);
					if (typeof  data.url=='undefined' || data==null){
					    alert('无此商城信息');
					    $('#showmall a').html('<b style=" font-weight:blod; color:red">查看全部</b>');
					    return false;
					}
					else{
					    $('#url').val(data.url);
						$('#title').val(data.title);
						getPinyin();
						$('#fan').val(data.fan);
						if(lianmeng=='chanet'){
							$('#chanet_draftid').val(data.chanet_draftid);
							$('#chanetid').val(data.chanetid);
						}
						else if(lianmeng=='weiyi'){
							$('#weiyiid').val(data.weiyiid);
						}
						
						$('#img').val(data.img);
						$('#edate').val(data.edate);
						$('#cid').val(data.cid);
						if($('#des').val()==''){
						    $('#des').val(data.des);
						}
						var c=editor.html().replace('<p>','').replace('</p>','').replace('&nbsp;',''); //编辑器人为清空还会有残留代码
						c=$.trim(c);
						if(c==''){
						    editor.html(data.content);
						}
					}
                }
            });
		}
	});
});

function tSubmit(form){
	var lm = $('#lm').val();
	if(form.name.value==''){
		alert('请填写商城名！');
		form.name.focus();
		return false;
	}
	if(form.fan.value==''){
		alert('请填写最高返现额度！');
		form.fan.focus();
		return false;
	}
	if(form.logo.value==''){
		alert('请上传商城logo！');
		form.logo.focus();
		return false;
	}
	if(form.url.value==''){
		alert('请填写商城官网！');
		form.url.focus();
		return false;
	}
	if(lm=='linktech'){
	    if(form.merchant.value==''){
		    alert('请填写广告主账号！');
		    form.merchant.focus();
		    return false;
	    }
	}
	if(lm=='weiyi'){
	    if(form.weiyiid.value==''){
		    alert('请填写广告主账号！');
		    form.weiyiid.focus();
		    return false;
	    }
	}
	else if(lm=='yiqifa'){
	    if(form.yilink.value==''){
		    alert('请填写推广链接！');
		    form.yilink.focus();
		    return false;
	    }
        var a= form.yilink.value.match(pattern);
        if(a[1]>0){
		    form.yiqifaid.value=a[1];
		}
		if(form.yiqifaid.value=='' || form.yiqifaid.value==0){
		    alert('请填写亿起发广告id！');
		    form.yiqifaid.focus();
		    return false;
	    }
	}
	else if(lm=='duomai'){
	    if(form.duomaiid.value=='' || form.duomaiid.value==0){
		    alert('请填写多麦广告id！');
		    form.duomaiid.focus();
		    return false;
	    }
	}
	else if(lm=='chanet'){
	    if(form.chanetid.value=='' || form.chanetid.value==0){
		    alert('请填写成果广告id！');
		    form.chanetid.focus();
		    return false;
	    }
		if(form.chanet_draftid.value=='' || form.chanet_draftid.value==0){
		    alert('请填写成果原稿id！');
		    form.chanet_draftid.focus();
		    return false;
	    }
	}
	return true;
}

function getDomain($t){
	var url=$t.val();
	if(url==''){
		alert('网址不能为空');
	}
	else{
		$.get('../<?=u('ajax','get_domain')?>',{'url':url},function(data){
			$('#domain').val(data);
		});
	}
}

pattern = /(\w+)=(\w+)/ig;
</script>

<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
<?php if(DDMALL==1){?>
  <tr>
    <td width="115px" align="right">联盟：</td>
    <td>&nbsp;<?=select($lm,$row['lm'],'lm')?>&nbsp;&nbsp;&nbsp; <span class="zhushi"><a id="helpurl" target="_blank" href="<?=$row['lm']?$lianmeng[$row['lm']]['helpurl']:$arr['helpurl']?>">教程</a></span></td>
  </tr>
  <tr>
    <td  align="right">官网：</td>
    <td>&nbsp;<input name="url" url="y" type="text" id="url" class="required" value="<?=$row['url']?>" /> <span style="display:none" class="zhushi" id="getmallinfo"><input type="button" value="获取信息" id="getmallinfo_button" style="cursor:pointer" />(填写后点击可直接获取商城信息)</span></td>
  </tr>
  <?php }else{?>
  <tr>
    <td width="115px" align="right">官网：</td>
    <td>&nbsp;<input name="url" url="y" type="text" id="url" class="required" value="<?=$row['url']?>" /> <span id="getmallinfo" class="zhushi"><input type="button" value="获取信息" id="<?php if(DDMALL==1){?>getmallinfo_button<?php }else{?>getddmallinfo_button<?php }?>" style="cursor:pointer" />(填写后点击可直接获取商城信息)</span></td>
  </tr>
  <?php }?>
  <tr>
    <td  align="right">名称：</td>
    <td>&nbsp;<input name="title" type="text" onblur="getPinyin()" id="title" value="<?=$row['title']?>"/></td>
  </tr>
  <tr>
    <td align="right">拼音：</td>
    <td>&nbsp;<input name="pinyin" type="text" id="pinyin" value="<?=$row['pinyin']?>"/>&nbsp;<input  class="sub" type="button" value="获取拼音" onclick="getPinyin()" /></td>
  </tr>
  <tr>
    <td align="right">类别：</td>
    <td>&nbsp;<select id="cid" name="cid"><?php getCategorySelect($row['cid']?$row['cid']:$_GET['cid']);?></select></td>
  </tr>
  <tr>
    <td align="right">域名：</td>
    <td>&nbsp;<input name="domain" type="text" id="domain" class="required" value="<?=$row['domain']?>" /> </td>
  </tr>
  <tr>
    <td align="right">最高返：</td>
    <td>&nbsp;<input name="fan" type="text" id="fan" value="<?=$row['fan']?>" /> <span class="zhushi">前台显示，不参与返利计算</span></td>
  </tr>
  <tr>
    <td align="right">返利形式：</td>
    <td>&nbsp;<?=html_radio(array(1=>'金额',2=>'积分'),$row['type']==''?1:$row['type'],'type')?> </td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?>" /> <span class="zhushi">数字越小越靠前,1为最小值</span></td>
  </tr>
  
  <?php if(DDMALL==1){?>
  <tr class="duomai_tr">
    <td align="right">多麦广告主id：</td>
    <td>&nbsp;<input name="duomaiid" type="text" value="<?=$row['duomaiid']?>" id="duomaiid" /> <span class="zhushi">如选择多麦网，此项必填</span></td>
  </tr>
  
  <tr class="wujiumiao_tr">
    <td align="right">59秒广告主id：</td>
    <td>&nbsp;<input name="wujiumiaoid" type="text" value="<?=$row['wujiumiaoid']?$row['wujiumiaoid']:0?>" id="wujiumiaoid" /> <input type="button" value="获取推广网址" id="get_59miao_click_url" style="cursor:pointer" /> <span class="zhushi">如选择59秒，此项必填</span></td>
  </tr>
  <tr class="wujiumiao_tr">
    <td align="right">59秒推广url：</td>
    <td>&nbsp;<input name="wujiumiaourl" type="text" value="<?=$row['wujiumiaourl']?>" id="wujiumiaourl" style="width:300px" /> <span class="zhushi">如选择59秒，此项必填</span></td>
  </tr>
  
  <tr class="yiqifa_tr">
    <td align="right">亿起发推广网址：</td>
    <td>&nbsp;<input onblur="if(this.value==''){return false;}var a= this.value.match(pattern);if(a[1]>0){form.yiqifaid.value=a[1];}" name="yiqifaurl" type="text" style="width:300px" id="yiqifaurl" value="<?=$row['yiqifaurl']?>" /> <span class="zhushi">如选择亿起发网，此项必填</span></td>
  </tr>
  <tr class="yiqifa_tr">
    <td align="right">亿起发广告主id：</td>
    <td>&nbsp;<input name="yiqifaid" type="text" value="<?=$row['yiqifaid']?>" id="yiqifaid" /> <span class="zhushi">如选择亿起发，此项必填</span></td>
  </tr>
  <tr class="yiqifa_tr">
    <td align="right">亿起发商家分类id：</td>
    <td>&nbsp;<input name="merchantId" type="text" value="<?=$row['merchantId']?>" id="merchantId" /> <span class="zhushi">亿起发api使用</span></td>
  </tr>
  
  <tr class="linktech_tr">
    <td align="right">领客特广告主账号：</td>
    <td>&nbsp;<input name="merchant" type="text" value="<?=$row['merchant']?>" id="merchant" /> <span class="zhushi">如选择领克特，此项必填</span></td>
  </tr>
  
  <tr class="chanet_tr">
    <td align="right">成果原稿id：</td>
    <td>&nbsp;<input name="chanet_draftid" type="text" value="<?=$row['chanet_draftid']?>" id="chanet_draftid" /> <span class="zhushi">如选择成果网，此项必填</span> <span class="zhushi" id='showmall'><a href="http://demo.duoduo123.com/getchanet.php?act=all" target="_blank">查看全部</a></span></td>
  </tr>
  <tr class="chanet_tr">
    <td align="right">成果广告主id：</td>
    <td>&nbsp;<input name="chanetid" type="text" value="<?=$row['chanetid']?>"  id="chanetid" /> <span class="zhushi">如选择成果网，此项必填</span></td>
  </tr>
  <tr class="chanet_tr">
    <td align="right">成果广告主链接：</td>
    <td>&nbsp;<input name="chaneturl" type="text" value="<?=$row['chaneturl']?>" id="chanetid" /> <span class="zhushi">选填，如果此商城为团购网站并且采集团购商品，此项必填</span></td>
  </tr>
  <tr class="weiyi_tr">
    <td align="right">唯一广告主账号：</td>
    <td>&nbsp;<input name="weiyiid" type="text" value="<?=$row['weiyiid']?>" id="weiyiid" /> <span class="zhushi">如选择唯一联盟，此项必填(推广网址里m=joyo中的joyo)</span></td>
  </tr>
  <?php }?>
  <tr>
    <td align="right">logo：</td>
    <td>&nbsp;<input name="img" type="text" id="img" value="<?=$row['img']?>" style="width:300px" /> <input class="sub" type="button" value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'img','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">可直接添加网络地址</span></td>
  </tr>
  <tr>
    <td align="right">简介：</td>
    <td>&nbsp;<input name="des" type="text" id="des" value="<?=$row['des']?>" style="width:300px" /></td>
  </tr>
  <tr>
    <td align="right">服务：</td>
    <td>&nbsp;<input name="fuwu" type="text" id="fuwu" value="<?=$row['fuwu']?>" style="width:300px" /></td>
  </tr>
  <tr>
    <td align="right">到期时间：</td>
    <td>&nbsp;<input name="edate" type="text" id="edate" style="width:100px" value="<?=$row['edate']?>" /> </td>
  </tr>
  
  <tr>
    <td align="right">网站认证：</td>
    <td>&nbsp;<label><input type="radio" name="renzheng" value="1" <?php if($row['renzheng']==='1' || $row['renzheng']==''){?> checked="checked" <?php }?> />是</label> <label><input type="radio" name="renzheng" value="0" <?php if($row['renzheng']==='0'){?> checked="checked" <?php }?> />否</label></td>
  </tr>
  <tr>
    <td align="right">网站活动：</td>
    <td>&nbsp;<a href="<?=u('huodong','list',array('mall_id'=>$id))?>">查看活动</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=u('huodong','addedi',array('mall_id'=>$id))?>">添加活动</a></td>
  </tr>
  
  <tr class="tuan">
    <td align="right">商品api规则：</td>
    <td>&nbsp;<input name="api_rule" type="text" id="api_rule" value="<?=$row['api_rule']?>"/> <span class="zhushi">如：baidu/hao123（baidu和hao123是一样的），360</span></td>
  </tr>
  <tr class="tuan">
    <td align="right">商品api：</td>
    <td>&nbsp;<input name="api_url" type="text" id="api_url" value="<?=$row['api_url']?>" style="width:300px" /></td>
  </tr>
  <tr class="tuan">
    <td align="right">城市api：</td>
    <td>&nbsp;<input name="api_city" type="text" id="api_city" value="<?=$row['api_city']?>" style="width:300px" />&nbsp;<span class="zhushi"><a style="color:#F30" href="javascript:openwinx('index.php?mod=mall&act=addedi&mallid=<?=$row['id']?>&rule=<?=$row['api_rule']?>&api_city=<?=urlencode($row['api_city'])?>','upload','450','350')">生成城市缓存</a></span></td>
  </tr>
  
  <tr>
    <td align="right">介绍：</td>
    <td>&nbsp;<textarea id="content" name="content"><?=$row['content']?></textarea></td>
  </tr>
  
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>