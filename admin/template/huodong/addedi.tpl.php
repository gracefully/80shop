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
$huan_arr=array(0=>'否',1=>'是');
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
    <td align="right">商城：</td>
    <td>&nbsp;<?=select($malls,$row['mall_id']?(int)$row['mall_id']:$mall_id,'mall_id')?></td>
  </tr>
  <tr>
    <td align="right">开始时间：</td>
    <td>&nbsp;<input class="timeinput" name="sdate" type="text" id="sdate" value="<?=$row['sdate']?>"/></td>
  </tr>
  <tr>
    <td align="right">结束时间：</td>
    <td>&nbsp;<input class="timeinput" name="edate" type="text" id="edate" value="<?=$row['edate']?>"/></td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?$row['sort']:0?>"  /> <span class="zhushi">数字越大越靠前</span></td>
  </tr>
  <tr>
    <td align="right">关联兑换：</td>
    <td>&nbsp;<label><input <?php if($row['relate_id']==0){?> checked="checked"<?php }?> name='relate_id' type='radio' value='0' /> 否</label>&nbsp;&nbsp;<label><input  <?php if($row['relate_id']>0){?> checked="checked"<?php }?> name='relate_id' type='radio' value='<?=$row['relate_id']?$row['relate_id']:0?>' /> 是</label>&nbsp;&nbsp;<?php if($row['relate_id']>0){?><a target="_blank" href="<?=u('huan_goods','addedi',array('id'=>$row['relate_id']))?>">查看</a><?php }?></td>
  </tr>
  <tr>
    <td align="right">简介：</td>
    <td>&nbsp;<input type="text" name="desc" id="desc" value="<?=$row['desc']?>" style="width:650px" /></td>
  </tr>
  <tr>
    <td align="right">内容：</td>
    <td>&nbsp;<textarea name="content" id="content"><?=$row['content']?></textarea></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input id="jump_url" type="hidden" name="jump_url" value="<?php if($row['relate_id']>0){?><?=u('huan_goods','addedi',array('id'=>$row['relate_id'],'relateid'=>'huodong@{$id}'))?><?php }?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<script>
ucOpen=<?=$webset['ucenter']['open']?>;
$(function(){
    $('input[name=relate_id]').eq(1).click(function(){
	    $('#jump_url').val('<?=u('huan_goods','addedi',array('relateid'=>'huodong@{$id}'))?>');
	});	
	$('input[name=relate_id]').eq(0).click(function(){
	    $('#jump_url').val('');
	});	
})
</script>
<?php include(ADMINTPL.'/footer.tpl.php');?>