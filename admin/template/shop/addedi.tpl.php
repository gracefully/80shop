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

$tao_level=include(DDROOT.'/data/tao_level.php');
$tao_level[]='商城';

include(DDROOT.'/mod/tao/fun.class.php');
$dd_tao_class=new dd_tao_class($duoduo);
$row=$dd_tao_class->dd_tao_shops($row);

include(ADMINTPL.'/header.tpl.php');
?>
<script>
$(function(){
	$('#level').change(function(){
		var l=$(this).val();
		$('#level-img').attr('src',"../images/level_"+l+".gif");
	});
})
function getInfo(nick){
	$.getJSON('<?=u(MOD,ACT)?>&nick='+encodeURIComponent(nick)+'&shop_id=<?=(int)$id?>',function(data){
		if(data.s==0){
			if(data.r==1){
				alert('店铺不存在');
			}
			else if(data.r==2){
				alert('店铺已存在');
			}
		}
		else{
			$('#nick').val(data.r.seller_nick);
			$('#pic_path').val(data.r.pic_url);
			$('#uid').val(data.r.user_id);
			$('#title').val(data.r.shop_title);
		}
		
	});
}
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">掌柜名：</td>
    <td>&nbsp;<input type="text" name="nick" id="nick" value="<?=$row['nick']?>" /> <input onClick="getInfo($('#nick').val())" class="sub" type="button" value="获取店铺详情" /></td>
  </tr>
  <tr>
    <td width="115px" align="right">掌柜id：</td>
    <td>&nbsp;<input type="text" name="uid" id="uid" value="<?=$row['uid']?>" /></td>
  </tr>
  <tr>
    <td width="115px" align="right">店铺名称：</td>
    <td>&nbsp;<input type="text" name="title" id="title" value="<?=$row['title']?>" /></td>
  </tr>
  <tr>
    <td align="right">logo：</td>
    <td>&nbsp;<input type="text" name="pic_path" id="pic_path" value="<?=$row['logo']?>" style="width:300px" /></td>
  </tr>
  <tr>
    <td align="right">类别：</td>
    <td>&nbsp;<?=select($shop_type,$row['cid'],'cid')?></td>
  </tr>
  <tr>
    <td align="right">等级：</td>
    <td>&nbsp;<?=select($tao_level,$row["level"],'level')?> <img src="../images/level_<?=$row["level"]?>.gif" id="level-img" /></td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input type="text" name="sort" value="<?=(int)$row['sort']?>" /> <span class="zhushi">数字越小越靠前,1为最小值，优先级高于推荐</span></td>
  </tr>
  <tr>
    <td align="right">推荐位：</td>
    <td>&nbsp;<!--<label><input <?php if($row['index_top']==1){?> checked="checked"<?php }?> type="checkbox" value="1" name="index_top" />网站首页</label> --><label><input <?php if($row['tao_top']==1){?> checked="checked"<?php }?> type="checkbox" value="1" name="tao_top" />淘宝首页</label></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 确 认 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>