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
?>
<script>
$(function(){
	if(parseInt($('input[name="moshi"]:checked').val())==0){
		$('.moshi2').hide();
	}
	$('input[name="moshi"]').click(function(){
        if($(this).val()==1){
		    $('.moshi2').show();
			$('.moshi1').hide();
		}
		else if($(this).val()==0){
		    $('.moshi1').show();
			$('.moshi2').hide();
		}
	});
});
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
<?php if($id>0){?>
  <tr>
    <td width="115px" align="right">广告ID：</td>
    <td>&nbsp;<input name="ad_id" type="text" id="ad_id" value="<?=$row['id']?>" readonly="readonly"/> <span class="zhushi">无特殊情况不要修改</span></td>
  </tr>
<?php }?>
  <tr>
    <td width="115px" align="right">广告标识：</td>
    <td>&nbsp;<input name="tag" type="text" id="tag" value="<?=$row['tag']?>" style="width:300px" /><span class="zhushi">填写标识后，广告以标识调用，不需要请不要填写</span></td>
  </tr>
  <tr>
    <td align="right">说明：</td>
    <td>&nbsp;<input name="adtype" type="text" id="adtype" value="<?=$row['adtype']?>" style="width:300px" /> <span class="zhushi">如：首页导航下</span></td>
  </tr>
  <tr>
    <td align="right">模式选择：</td>
    <td>&nbsp;<?=html_radio(array('常规模式','自定义模式'),$row['moshi'],'moshi')?> </td>
  </tr>
  <tr class="moshi1">
    <td width="115px" align="right">标题：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?>" style="width:300px" /></td>
  </tr>
  <tr class="moshi1">
    <td align="right">图片：</td>
    <td>&nbsp;<input name="img" type="text" id="img" value="<?=$row['img']?>" style="width:300px" /> <input type="button" value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'img','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">可直接添加网络地址</span></td>
  </tr>
  <tr class="moshi1">
    <td align="right">高度：</td>
    <td>&nbsp;<input name="height" type="text" id="height" value="<?=$row['height']?>" size="5" /> <span class="zhushi">px(单位：像素)</span></td>
  </tr>
  <tr class="moshi1">
    <td align="right">宽度：</td>
    <td>&nbsp;<input name="width" type="text" id="width" value="<?=$row['width']?>" size="5" /> <span class="zhushi">px(单位：像素)</span></td>
  </tr>
  <tr class="moshi1">
    <td align="right">背景色：</td>
    <td>&nbsp;<input name="bgcolor" type="text" id="bgcolor" value="<?=$row['bgcolor']?>" size="5" /><span class="zhushi">填写颜色代码，如：#f00</span></td>
  </tr>
  <tr class="moshi1">
    <td align="right">连接：</td>
    <td>&nbsp;<input name="link" type="text" id="link" value="<?=$row['link']?>" style="width:300px" /></td>
  </tr>
    <tr class="moshi2">
    <td align="right">自定义代码：</td>
    <td><div style="float:left">&nbsp;<textarea name="content" cols="40" rows="5" style="width:400px; height:120px;"><?=$row['content']?></textarea></div>
    <span class="zhushi"><div style="float:left; padding-top:20px; line-height:40px;">
    系统会自动去除换行，所以如果添加的是js代码，<br />不要有“//”，“&lt;!--”，“//--&gt;”等注视符。<br/></div></span></td>
  </tr>
  <tr>
    <td align="right">调用方式：</td>
    <td>&nbsp;<?=html_radio(array(1=>'js方式',2=>'php方式'),$row['type']?$row['type']:1,'type')?> <span class="zhushi">自定义代码的调用方式，js方式可站外调用，php方式兼容复杂代码</span></td>
  </tr>
  <tr>
    <td align="right">到期时间：</td>
    <td>&nbsp;<input name="edate" type="text" id="edate" value="<?=$row['edate']?date('Y-m-d',$row['edate']):date('Y-m-d',strtotime('+1 year'))?>" /> </td>
  </tr>
  <?php if($id>0){?>
  <tr>
    <td align="right">调用代码：</td>
    <td>&nbsp;<input type="text" value='&lt?=AD(<?=$row['tag']!=''?$row['tag']:$id?>)?&gt;' size="20" /> <span class="zhushi"><a href="javascript:copy('&lt?=AD(<?=$row['tag']!=''?$row['tag']:$id?>)?&gt;')">复制</a> 直接放在模板内即可</span></td>
  </tr>
  <?php }?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" name="sub" value=" 保 存 广 告 " /></td>
  </tr>
  <tr>
    <td align="right">使用说明：</td>
    <td><span class="zhushi"><ul>
    <li>1、标题作为图片广告的alt属性</li>
    <li>2、宽度和高度可以限制图片大小</li>
    <li>3、链接表示这个图片广告的链接</li>
    <li>4、说明在广告中不起到具体的作用,只是便于自己记忆广告位置</li>
    <li>5、自定义代码指的是，如果单纯的图片广告无法满足你的要求，可以自定义代码</li>
    <li>6、添加完成后，每个广告都会有一个调用代码，形如：&lt?=AD(1)?&gt;，其中的数字表示广告id</li>
    </ul></span></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>