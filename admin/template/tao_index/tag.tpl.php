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
<style type="text/css">
ul{ list-style:none; width:950px;margin:0px; padding:0px; margin-top:5px}
li{ list-style:none; margin:0px; padding:0px; margin-bottom:5px; height:20px; text-align:left}
li input.tag{font-family:宋体; width:250px}
</style>
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
  <tr>
    <td colspan="2" align="left" style="padding-left:10px; padding-top:5px">
	  <ul>
        <?php foreach($tag as $k=>$row){?>
        <li>标题：<input class="tag" type="text" name="<?=$k?>[title]" value="<?=$row['title']?>" /> 链接：<input class="tag" type="text" name="<?=$k?>[url]" value="<?=$row['url']?>" /></li>
        <?php }?>
      </ul>
      <div style="clear:both"></div>
    </td>  
  </tr>
  <tr>
     <td align="right" width="15px">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </form>
</table>

<?php include(ADMINTPL.'/footer.tpl.php');?>