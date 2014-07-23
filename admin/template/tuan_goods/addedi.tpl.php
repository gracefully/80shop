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
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">标题：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?>" style="width:300px" /></td>
  </tr>
  <tr>
    <td align="right">图片：</td>
    <td>&nbsp;<input name="img" type="text" id="img" value="<?=$row['img']?>" style="width:300px" /> <input class="sub" type="button" value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'img','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">可直接添加网络地址</span></td>
  </tr>
  <tr>
    <td align="right">连接：</td>
    <td>&nbsp;<input name="url" type="text" id="url" value="<?=$row['url']?>" style="width:300px" /></td>
  </tr>
  <tr>
    <td align="right">城市：</td>
    <td>&nbsp;<input name="city" type="text" id="city" value="<?=$row['city']?>" /></td>
  </tr>
  <tr>
    <td align="right">类别：</td>
    <td>&nbsp;<?=select($cat,$row['cid'],'cid')?></td>
  </tr>
  <tr>
    <td align="right">网站：</td>
    <td>&nbsp;<?=select($malls,$row['mall_id'],'mall_id')?></td>
  </tr>
  <tr>
    <td align="right">购买人数：</td>
    <td>&nbsp;<input name="bought" type="text" id="bought" value="<?=$row['bought']?>" /></td>
  </tr>
  <tr>
    <td align="right">原价：</td>
    <td>&nbsp;<input name="value" type="text" id="value" value="<?=$row['value']?>" /></td>
  </tr>
  <tr>
    <td align="right">现价：</td>
    <td>&nbsp;<input name="price" type="text" id="price" value="<?=$row['price']?>" /></td>
  </tr>
  <tr>
    <td align="right">折扣：</td>
    <td>&nbsp;<input name="rebate" type="text" id="rebate" value="<?=$row['rebate']?>" /></td>
  </tr>
  <tr>
    <td align="right">开始时间：</td>
    <td>&nbsp;<input name="sdatetime" type="text" id="sdatetime" value="<?=$row['sdatetime']?>" /></td>
  </tr>
  <tr>
    <td align="right">结束时间：</td>
    <td>&nbsp;<input name="edatetime" type="text" id="edatetime" value="<?=$row['edatetime']?>" /></td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?$row['sort']:0?>"  /> <span class="zhushi">数字越小越靠前,1为最小值</span></td>
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