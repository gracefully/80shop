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
function getPinyin(){
    var title=$('#title').val();
	$.post('../<?=u('ajax','pinyin')?>',{title:title},function(data){
	    $('#pinyin').val(data);
		data=data.slice(0,1);
		$('#first_word').val(data);
	});
}
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">城市：</td>
    <td>&nbsp;<input name="title" onblur="getPinyin()" type="text" id="title" value="<?=$row['title']?>"/></td>
  </tr>
  <tr>
    <td width="115px" align="right">拼音：</td>
    <td>&nbsp;<input name="pinyin" type="text" id="pinyin" value="<?=$row['pinyin']?>"/>&nbsp;<input class="sub" type="button" value="获取拼音" onclick="getPinyin()" /></td>
  </tr>
  <tr>
    <td width="115px" align="right">首字母：</td>
    <td>&nbsp;<input name="first_word" type="text" id="first_word" value="<?=$row['first_word']?>"/></td>
  </tr>
  <tr>
    <td width="115px" align="right">状态：</td>
    <td>&nbsp;<?=html_radio($status,$r["hide"],'hide')?></td>
  </tr>
  <tr>
    <td width="115px" align="right">排序：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?>"/></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>