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
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
  <tr>
    <td style="width:150px" align="right">晒单起始时间：</td>
    <td>&nbsp;<input name="baobei[shai_s_time]" value="<?=$webset['baobei']['shai_s_time']?>"/></td>
  </tr>
  <tr>
    <td align="right">宝贝评语：</td>
    <td>&nbsp;<input name="baobei[word_num]" value="<?=$webset['baobei']['word_num']?>"/> <span class="zhushi">(个字以内) 不要过多，否则页面容易错位</span></td>
  </tr>
  <tr>
    <td align="right">宝贝评论：</td>
    <td>&nbsp;<input name="baobei[comment_word_num]" value="<?=$webset['baobei']['comment_word_num']?>"/> <span class="zhushi">(个字以内) 不要过多，否则页面容易错位</span></td>
  </tr>
  <tr>
    <td align="right">分享等级限制：</td>
    <td>&nbsp;<input name="baobei[share_level]" value="<?=$webset['baobei']['share_level']?>"/> <span class="zhushi">会员等级大于此设置才可分享商品</span></td>
  </tr>
  <tr>
    <td align="right">评论等级限制：</td>
    <td>&nbsp;<input name="baobei[comment_level]" value="<?=$webset['baobei']['comment_level']?>"/> <span class="zhushi">会员等级大于此设置才可评论商品</span></td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="hidden" name="baobei[re_tao_cid]" value="<?=$webset['baobei']['re_tao_cid']?>" /><input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </form>
</table>

<?php include(ADMINTPL.'/footer.tpl.php');?>