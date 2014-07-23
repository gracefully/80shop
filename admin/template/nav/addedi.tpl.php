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
navArr=new Array();
<?php foreach($nav_tag as $k=>$v){?>
navArr[<?=$k?>]='<?=$v?>';
<?php }?>
$(function(){
	$('#pid').change(function(){
		$('#tag').val(navArr[$(this).val()]);
	});
	
	$('#sm').jumpBox({  
		height:200,
		width:600,
		contain:$('#mydiv').html()
    });	
})
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">名称：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?>" /></td>
  </tr>
  <tr>
    <td align="right">模块：</td>
    <td>&nbsp;<input name="mod" type="text" id="mod" value="<?=$row['mod']?>"/></td>
  </tr>
  <tr>
    <td align="right">行为：</td>
    <td>&nbsp;<input name="act" type="text" id="act" value="<?=$row['act']?>" /></td>
  </tr>
  <tr>
    <td align="right">导航标记：</td>
    <td>&nbsp;<input name="tag" type="text" id="tag" value="<?=$row['tag']?>"/> <span class="zhushi"><a style="color:#FF6600; cursor:pointer; text-decoration:underline" id="sm" >设置向导</a> 用于模板导航关联</span></td>
  </tr>
  <tr>
    <td align="right">目标：</td>
    <td>&nbsp;<?=html_radio($target,$row['target'],'target')?></td>
  </tr>
  <tr>
    <td align="right">是否隐藏：</td>
    <td>&nbsp;<?=html_radio($status,$row['hide'],'hide')?></td>
  </tr>
  <tr>
    <td align="right">是否是应用：</td>
    <td>&nbsp;<?=html_radio($shifou_arr,$row['plugin'],'plugin')?> <span class="zhushi">此导航是否是一个应用插件（注意，插件的适用版本大于<?=PLUGIN_2?>选择是，小于此日期的选择否）</span></td>
  </tr>
  <tr>
    <td align="right">状态：</td>
    <td>&nbsp;<?=html_radio($type,$row['type'],'type')?></td>
  </tr>
  <tr>
    <td align="right">自定义连接：</td>
    <td>&nbsp;<input name="url" type="text" id="url" value="<?=$row['url']?>" style="width:300px" /> <span class="zhushi">以http://开头，添加绝对地址</span></td>
  </tr>
  <tr>
    <td align="right">是否提示登陆：</td>
    <td>&nbsp;<?=html_radio(array(0=>'否',1=>'是'),$row['tip'],'tip')?> <span class="zhushi">用于自定义链接，当自定义链接为空是，此项无效</span></td>
  </tr>
  <tr>
    <td align="right">自定义字符：</td>
    <td>&nbsp;<input name="custom" type="text" id="custom" value="<?=$row['custom']?>" style="width:300px" /> <span class="zhushi">自定义代码，二次开发模板用</span></td>
  </tr>
  <tr>
    <td align="right">父导航：</td>
    <td>&nbsp;<?=select($nav_arr,$row['pid'],'pid')?> <span class="zhushi">选择父标签后，导航标记要与父导航标记相同</span></td>
  </tr>
  <tr>
    <td align="right">短说明：</td>
    <td>&nbsp;<input name="alt" type="text" id="alt" value="<?=$row['alt']?>" /> <span class="zhushi">只适用于子导航</span></td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?>" /> <span class="zhushi">数字越小越靠前,1为最小值</span></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<div id="mydiv" style="display:none; ">
<div  style="font-size:14px; color:#666666; font-family:'宋体'; line-height:20px">
<p>情况1：淘宝首页，淘宝列表页，淘宝详细页都是淘宝模块，当这三类页面打开时，导航的“淘宝返利”应该都是高亮显示，所以这三个的导航标记都是“tao”</p>
<p>情况2：九元购也是淘宝模块，如果作为单独的导航显示，导航标记就不能写“tao”，要写“jiu”</p>
</div>
</div>
<?php include(ADMINTPL.'/footer.tpl.php');?>