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

$sort=array (
  'default' => '默认排序',
  'price_desc' => '折扣价格从高到低',
  'price_asc'=>'折扣价格从低到高',
  'credit_desc'=>'信用等级从高到低',
  'credit_asc'=>'信用等级从低到高',
  'commissionRate_desc'=>'佣金比率从高到低',
  'commissionRate_asc'=>'佣金比率从低到高',
  'commissionVome_desc'=>'成交量成高到低',
  'commissionVome_asc'=>'成交量从低到高',
);

$coupon_rate=array(
    1000=>'10%',
	2000=>'20%',
	3000=>'30%',
	4000=>'40%',
	5000=>'50%',
	6000=>'60%',
	7000=>'70%',
	8000=>'80%',
	9000=>'90%',
);

$credit=array(
    '1heart'=>'一心',
	'2heart'=>'二心',
	'3heart'=>'三心',
	'4heart'=>'四心',
	'5heart'=>'五心',
	'1diamond'=>'一钻',
	'2diamond'=>'二钻',
	'3diamond'=>'三钻',
	'4diamond'=>'四钻',
	'5diamond'=>'五钻',
	'1crown'=>'一冠',
	'2crown'=>'二冠',
	'3crown'=>'三冠',
	'4crown'=>'四冠',
	'5crown'=>'五冠',
	'1goldencrown'=>'一皇冠',
	'2goldencrown'=>'二皇冠',
	'3goldencrown'=>'三皇冠',
	'4goldencrown'=>'四皇冠',
	'5goldencrown'=>'五皇冠',
);
?>
<script>
$(function(){
    $('.key').blur(function(){
		var id=$(this).attr('id');
	    $('#key'+id).attr('name','tao_zhe[category]['+$(this).val()+']');
	});
})
</script>
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
  <tr>
    <td width="140px" align="right">商品关键词：</td>
    <td>&nbsp;<input type="type" value="<?=$webset['tao_zhe']['keyword']?>" name="tao_zhe[keyword]" /> (关键词和分类必填一项) </td>
  </tr>
  <tr>
    <td align="right">商品分类：</td>
    <td>&nbsp;<input type="text" style="width:50px" name="tao_zhe[cid]" value="<?=$webset['tao_zhe']['cid']?>" /> (关键词和分类都填，以关键词为准)</td>
  </tr>
  <tr>
    <td align="right">促销分类：</td>
    <td>&nbsp;<input type="text" style="width:30px" name="tao_zhe[coupon_type]" value="<?=$webset['tao_zhe']['coupon_type']?>" /> (默认为1，暂时只有1分类)   </td>
  </tr>
  <tr>
    <td align="right">商品所属：</td>
    <td height="30" style="padding:5px;">
    <select name="tao_zhe[shop_type]">
                          <option <?php if($webset['tao_zhe']['shop_type']=='all'){?> selected="selected"<?php }?> value="all">全部</option>
                          <option <?php if($webset['tao_zhe']['shop_type']=='b'){?> selected="selected"<?php }?> value="b">商城</option>
                          <option <?php if($webset['tao_zhe']['shop_type']=='c'){?> selected="selected"<?php }?> value="c">集市</option>
                          </select>
    </td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<?=select($sort,$webset['tao_zhe']['sort'],'tao_zhe[sort]')?></td>
  </tr>
  <tr>
    <td align="right">折扣比例开始：</td>
    <td>&nbsp;<?=select($coupon_rate,$webset['tao_zhe']['start_coupon_rate'],'tao_zhe[start_coupon_rate]')?></td>
  </tr>
  <tr>
    <td align="right">折扣比例结束：</td>
    <td>&nbsp;<?=select($coupon_rate,$webset['tao_zhe']['end_coupon_rate'],'tao_zhe[end_coupon_rate]')?> (注：结束大于开始)  </td>
  </tr>
  <tr>
    <td align="right">卖家信用开始：</td>
    <td>&nbsp;<?=select($credit,$webset['tao_zhe']['start_credit'],'tao_zhe[start_credit]')?></td>
  </tr>
  <tr>
    <td align="right">卖家信用结束：</td>
    <td>&nbsp;<?=select($credit,$webset['tao_zhe']['end_credit'],'tao_zhe[end_credit]')?> (注：结束大于开始) </td>
  </tr>
  <tr>
    <td align="right">佣金比例开始：</td>
    <td>&nbsp;<?=select($coupon_rate,$webset['tao_zhe']['start_commission_rate'],'tao_zhe[start_commission_rate]')?></td>
  </tr>
  <tr>
    <td align="right">佣金比例结束：</td>
    <td>&nbsp;<?=select($coupon_rate,$webset['tao_zhe']['end_commission_rate'],'tao_zhe[end_commission_rate]')?> (注：结束大于开始) </td>
  </tr>
  <tr>
    <td align="right">累计推广量佣金开始：</td>
    <td>&nbsp;<input type="text" value="<?=$webset['tao_zhe']['start_commission_volume']?>" name="tao_zhe[start_commission_volume]" /></td>
  </tr>
  <tr>
    <td align="right">累计推广量佣金结束：</td>
    <td>&nbsp;<input type="text" value="<?=$webset['tao_zhe']['end_commission_volume']?>" name="tao_zhe[end_commission_volume]" /> (注：返回的数据是30天内累计推广佣金，开始于结束一起使用才有效) </td>
  </tr>
  <tr>
    <td align="right">累计推广量开始：</td>
    <td>&nbsp;<input type="text" value="<?=$webset['tao_zhe']['start_commission_num']?>" name="tao_zhe[start_commission_num]" /></td>
  </tr>
  <tr>
    <td align="right">累计推广量结束：</td>
    <td>&nbsp;<input type="text" value="<?=$webset['tao_zhe']['end_commission_num']?>" name="tao_zhe[end_commission_num]" /></td>
  </tr>
  <tr>
    <td align="right">交易量开始：</td>
    <td>&nbsp;<input type="text" value="<?=$webset['tao_zhe']['start_volume']?>" name="tao_zhe[start_volume]" /></td>
  </tr>
  <tr>
    <td align="right">交易量结束：</td>
    <td>&nbsp;<input type="text" value="<?=$webset['tao_zhe']['end_volume']?>" name="tao_zhe[end_volume]" /> (开始于结束一起使用才有效)</td>
  </tr>
  <tr>
    <td align="right">每页显示商品数量：</td>
    <td>&nbsp;<input type="text" value="<?=$webset['tao_zhe']['page_size']?>" name="tao_zhe[page_size]" /> (根据模板设置为4的倍数)</td>
  </tr>
  <tr>
    <td align="right">商品自动加载次数：</td>
    <td>&nbsp;<input type="text" value="<?=$webset['tao_zhe']['ajax_load_num']?>" name="tao_zhe[ajax_load_num]" /> </td>
  </tr>
  <!--<tr>
    <td align="right">栏目分类：</td>
    <td>&nbsp;<?php foreach($webset['tao_zhe']['category'] as $k=>$v){?><input type="text" style="width:35px" id="key<?=$k?>" value="<?=$v?>" name="tao_zhe[category][<?=$k?>]" />：cid <input class="key" id="<?=$k?>" type="text" style="width:80px" value="<?=$k?>" /> <br/>&nbsp;<?php }?> <br/>(确保类别cid在淘宝网是有效的)<br/></td>
  </tr>-->
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </form>
</table>

<?php include(ADMINTPL.'/footer.tpl.php');?>