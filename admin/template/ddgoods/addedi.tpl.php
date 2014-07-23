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
$credit=include(DDROOT.'/data/tao_level.php');
$credit[21]='天猫商城';
?>
<script>
SITEURL="<?=SITEURL?>/";
CURURL="<?=CURURL?>/";
regTaobaoUrl = /(.*\.?taobao.com(\/|$))|(.*\.?tmall.com(\/|$))/i; 
function getTaoItem(url){
    if(url==''){
		alert('网址不能为空！');
		return false;
	}
	if (!url.match(regTaobaoUrl)){
		alert('这不是一个淘宝网址！');
		return false;
	}
	
	var url='../<?=u('ajax','ddgoods')?>&url='+encodeURIComponent(url)+'&t=<?=time()?>';
	$.getJSON(url,function(data){
		if(typeof data.title=='undefined'){
			alert('商品不存在或者没参加淘客');
			return false;
		}
		if(data.taoke!=1){
			alert('商品没参加淘客');
		}
		for(var i in data){
			$('#'+i).val(data[i]);
		}
	});
}
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>&code=<?=$code?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">商品网址：</td>
    <td>&nbsp;<input type="text" id="url" value="<?=$row['url']?>" style="width:300px" /> <input onClick="getTaoItem($('#url').val())" class="sub" type="button" value="获取商品信息" /></td>
  </tr>
  <?php if($code!='zhuanxiang'){?>
  <tr>
    <td align="right">分类：</td>
    <td>&nbsp;<?=select($cid_arr,$row['cid'],'cid')?></td>
  </tr>
  <?php }?>
  <tr>
    <td align="right">商品名称：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?>" style="width:300px" /></td>
  </tr>
  <tr>
    <td align="right">图片：</td>
    <td>&nbsp;<input name="img" type="text" id="img" value="<?=$row['img']?>" style="width:300px"  /> <span class="zhushi">使用网络地址 <a href="<?=SITEURL.'/'.$row['img']?>" target="_blank">查看</a></span></td>
  </tr>
  <tr>
    <td align="right">原价：</td>
    <td>&nbsp;<input name="price" type="text" id="price" value="<?=$row['price']?>" /></td>
  </tr>
  <tr>
    <td align="right">促销价：</td>
    <td>&nbsp;<input name="discount_price" type="text" id="discount_price" value="<?=$row['discount_price']?>" /></td>
  </tr>
  <?php if($code=='zhuanxiang'){?>
  <tr>
    <td align="right">专享价：</td>
    <td>&nbsp;<input name="shouji_price" type="text" id="shouji_price" value="<?=$row['shouji_price']?>" /></td>
  </tr>
  <?php }?>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?>" /> <span class="zhushi">数字越小越靠前</span></td>
  </tr>
  <tr>
    <td align="right">开始时间：</td>
    <td>&nbsp;<input name="starttime" type="text" id="sdatetime" value="<?=date('Y-m-d H:i:s',$row['starttime'])?>" /></td>
  </tr>
  <tr>
    <td align="right">结束时间：</td>
    <td>&nbsp;<input name="endtime" type="text" id="edatetime" value="<?=$row['endtime']>0?date('Y-m-d H:i:s',$row['endtime']):''?>" /></td>
  </tr>
  <tr>
    <td align="right">审核人：</td>
    <td>&nbsp;<input name="auditor" type="text" id="auditor" value="<?=$row['auditor']?>" /></td>
  </tr>
  <tr class="extend_line"><td colspan="2">高级设置（请点击）</td></tr>
  <tbody class="gaojiset">
  <tr>
    <td align="right">商品ID：</td>
    <td>&nbsp;<input name="iid" type="text" id="iid" value="<?=$row['iid']?>" /></td>
  </tr>
  <tr>
    <td align="right">几折：</td>
    <td>&nbsp;<input name="rate" type="text" id="rate" value="<?=$row['rate']?>" /></td>
  </tr>
  <tr>
    <td align="right">已售：</td>
    <td>&nbsp;<input name="sell" type="text" id="sell" value="<?=$row['sell']?>" /></td>
  </tr>
  <tr>
    <td align="right">掌柜：</td>
    <td>&nbsp;<input name="nick" type="text" id="nick" value="<?=$row['nick']?>" /></td>
  </tr>
  <tr>
    <td align="right">等级：</td>
    <td>&nbsp;<?=select($credit,$row['level'],'level')?></td>
  </tr>
  <tr>
    <td align="right">掌柜uid：</td>
    <td>&nbsp;<input name="user_id" type="text" id="user_id" value="<?=$row['user_id']?>" /></td>
  </tr>
  <tr>
    <td align="right">地区：</td>
    <td>&nbsp;<input name="diqu" type="text" id="diqu" value="<?=$row['diqu']?>" /></td>
  </tr>
  <tr>
    <td align="right">店铺logo：</td>
    <td>&nbsp;<input name="logo" type="text" id="logo" value="<?=$row['logo']?>" /></td>
  </tr>
  <tr>
    <td align="right">店铺名称：</td>
    <td>&nbsp;<input name="shopname" type="text" id="shopname" value="<?=$row['shopname']?>" /></td>
  </tr>
  <tr>
    <td align="right">店铺关键词：</td>
    <td>&nbsp;<input name="keywords" type="text" id="keywords" value="<?=$row['keywords']?>" /></td>
  </tr>
  <tr>
    <td align="right">发货速度：</td>
    <td>&nbsp;<input name="dsr_cas" type="text" id="dsr_cas" value="<?=$row['dsr_cas']?>" /></td>
  </tr>
  <tr>
    <td align="right">描述相符：</td>
    <td>&nbsp;<input name="dsr_mas" type="text" id="dsr_mas" value="<?=$row['dsr_mas']?>" /></td>
  </tr>
  <tr>
    <td align="right">服务态度：</td>
    <td>&nbsp;<input name="dsr_sas" type="text" id="dsr_sas" value="<?=$row['dsr_sas']?>" /></td>
  </tr>
  <tr>
    <td align="right">是否包邮：</td>
    <td>&nbsp;<?=html_radio($shifou_arr,$row['baoyou'],'baoyou')?></td>
  </tr>
  <tr>
    <td align="right">是否报名：</td>
    <td>&nbsp;<?=html_radio($shifou_arr,$row['baoming'],'baoming')?></td>
  </tr>
  <tr>
    <td align="right">下架：</td>
    <td>&nbsp;<?=html_radio($shifou_arr,$row['xiajia'],'xiajia')?></td>
  </tr>
  <tr>
    <td align="right">添加时间：</td>
    <td>&nbsp;<?=date('Y-m-d H:i:s',$row['addtime'])?></td>
  </tr>
  </tbody>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>