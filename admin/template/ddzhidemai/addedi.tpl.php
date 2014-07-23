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
    <td width="115px" align="right">商品网址：</td>
    <td>&nbsp;<input type="text" id="url" name="url" value="<?=$row['url']?>" style="width:300px" /> <!--<input onClick="getTaoItem($('#url').val())" class="sub" type="button" value="获取商品信息" />--></td>
  </tr>
  <tr>
    <td align="right">分类：</td>
    <td>&nbsp;<?=select($cid_arr,$row['cid'],'cid')?></td>
  </tr>
  <tr>
    <td align="right">主标题：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?>" style="width:300px" /></td>
  </tr>
  <tr>
    <td align="right">副标题：</td>
    <td>&nbsp;<input name="subtitle" type="text" id="subtitle" value="<?=$row['subtitle']?>" style="width:300px"  /></td>
  </tr>
  <tr>
    <td align="right">图片：</td>
    <td>&nbsp;<input name="img" type="text" id="img" value="<?=$row['img']?>" style="width:300px" /> <span class="zhushi">使用网络地址 <a href="<?php if(strpos($row['img'],'http://')!==false){echo $row['img'];}else{echo SITEURL.'/'.$row['img'];}?>" target="_blank">查看</a></span></td>
  </tr>
  <tr>
    <td align="right">所属网站：</td>
    <td>&nbsp;<?=html_radio($web_arr,$row['web']?$row['web']:1,'web')?></td>
  </tr>
  <tr>
    <td align="right">属性：</td>
    <td>&nbsp;<?=html_radio($shuxing_arr,$row['shuxing'],'shuxing')?></td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?>" /> <span class="zhushi">数字越小越靠前</span></td>
  </tr>
  <tr>
    <td align="right">置顶：</td>
    <td>&nbsp;<?=html_radio($shifou_arr,$row['top'],'top')?></td>
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
    <td align="right">报料人：</td>
    <td>&nbsp;<input name="username" type="text" id="username" value="<?=$row['username']?>" /></td>
  </tr>
  <tr>
    <td align="right">推荐理由：</td>
    <td>&nbsp;<textarea id="content" name="content"><?=$row['content']?></textarea></td>
  </tr>
  <!--<tr>
    <td align="right">审核人：</td>
    <td>&nbsp;<input name="auditor" type="text" id="auditor" value="<?=$row['auditor']?>" /></td>
  </tr>-->
  <tr class="extend_line"><td colspan="2">高级设置（请点击）</td></tr>
  <tbody class="gaojiset">
  <tr>
    <td align="right">顶：</td>
    <td>&nbsp;<input name="ding" type="text" id="ding" value="<?=$row['ding']?>" /></td>
  </tr>
  <tr>
    <td align="right">踩：</td>
    <td>&nbsp;<input name="cai" type="text" id="cai" value="<?=$row['cai']?>" /></td>
  </tr>
  <tr>
    <td align="right">评论：</td>
    <td>&nbsp;<input name="pinglun" type="text" id="pinglun" value="<?=$row['pinglun']?>" /> <span class="zhushi"><a href="<?=u(MOD,'comment')?>">查看评论</a></span></td>
  </tr>
  <tr>
    <td align="right">商城（掌柜）：</td>
    <td>&nbsp;<input name="mallname" type="text" id="mallname" value="<?=$row['mallname']?>" /></td>
  </tr>
  <tr>
    <td align="right">是否报名：</td>
    <td>&nbsp;<?=html_radio($shifou_arr,$row['baoming'],'baoming')?></td>
  </tr>
  <!--<tr>
    <td align="right">原价：</td>
    <td>&nbsp;<input name="price" type="text" id="price" value="<?=$row['price']?>" /></td>
  </tr>
  <tr>
    <td align="right">促销价：</td>
    <td>&nbsp;<input name="discount_price" type="text" id="discount_price" value="<?=$row['discount_price']?>" /></td>
  </tr>
  <tr>
    <td align="right">几折：</td>
    <td>&nbsp;<input name="rate" type="text" id="rate" value="<?=$row['rate']?>" /></td>
  </tr>-->
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