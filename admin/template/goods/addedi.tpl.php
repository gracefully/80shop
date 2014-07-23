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

if(isset($_GET['url'])){
	$url=$_GET['url'];
	include (DDROOT . '/comm/Taoapi.php');
	include (DDROOT . '/comm/ddTaoapi.class.php');
	$tao_id_arr = include (DDROOT.'/data/tao_ids.php');
	$iid=get_tao_id($url,$tao_id_arr); //获取商品id
	$ddTaoapi = new ddTaoapi();
	$goods=$ddTaoapi->taobao_tbk_items_detail_get($iid);
	if($goods==102){
		$goods=array('s'=>0);
	}
	else{
		$nick=$goods['nick'];
		$shop=$ddTaoapi->taobao_tbk_shops_detail_get($nick);
		$goods['user_id']=$shop['user_id'];
		$goods['shop_title']=$shop['shop_title'];
		$goods['logo']=$shop['pic_url'];
	}
	echo dd_json_encode($goods);
	exit;
}


include(ADMINTPL.'/header.tpl.php');
$type_arr=$duoduo->select_all('type','id,title','tag="'.MOD.'"');
foreach($type_arr as $info){
	$type[$info['id']]=$info['title'];
}
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
	
	var url='<?=u(MOD,ACT)?>&url='+encodeURIComponent(url)+'&t=<?=time()?>';
	$.getJSON(url,function(data){
		if(typeof data.title=='undefined'){
			alert('商品不存在或者没参加淘客');
			return false;
		}
		taobaokeItem=data;
		$('#title').val(taobaokeItem.title);
		$('#pic_url').val(taobaokeItem.pic_url);
		$('#iid').val(taobaokeItem.num_iid);
		$('#price').val(taobaokeItem.price);
		$('#nick').val(taobaokeItem.nick);
		$('#user_id').val(taobaokeItem.user_id);
		$('#volume').val(taobaokeItem.volume);
		$('#shop_title').val(taobaokeItem.shop_title);
		$('#logo').val(taobaokeItem.logo);
		//$('#click_url').val(taobaokeItem.click_url);
		$('#promotion_price').val(taobaokeItem.promotion_price);
	});
}
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<div class="explain-col" style="color:#F00"> 横线以上的内容可自动采集，横线以下的内容需要站长人工填写
  </div>
<br />
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">淘宝网址：</td>
    <td>&nbsp;<input type="text" id="url" value="<?=$row['iid']?'http://item.taobao.com/item.htm?id='.$row['iid']:''?>" style="width:300px" /> <input onClick="getTaoItem($('#url').val())" class="sub" type="button" value="获取商品详情" /></td>
  </tr>
  <tr>
    <td align="right">标题：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?>" style="width:300px" /></td>
  </tr>
  <tr>
    <td align="right">图片：</td>
    <td>&nbsp;<input name="pic_url" type="text" id="pic_url" pic="y" class="required" value="<?=$row['pic_url']?>" style="width:300px" /> <input class="sub" type="button" value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'pic_url','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">可直接添加网络地址</span></td>
  </tr>
  <tr>
    <td align="right">商品id：</td>
    <td>&nbsp;<input name="iid" type="text" id="iid" value="<?=$row['iid']?>" /></td>
  </tr>
  <tr>
    <td align="right">价格：</td>
    <td>&nbsp;<input name="price" type="text" id="price" value="<?=$row['price']?>" /></td>
  </tr>
  <tr>
    <td align="right">近期销量：</td>
    <td>&nbsp;<input name="volume" type="text" id="volume" value="<?=$row['volume']?>" /></td>
  </tr>
  <tr>
    <td align="right">掌柜：</td>
    <td>&nbsp;<input name="nick" type="text" id="nick" value="<?=$row['nick']?>" /></td>
  </tr>
  <tr>
    <td align="right">淘宝掌柜id：</td>
    <td>&nbsp;<input name="user_id" type="text" id="user_id" value="<?=$row['user_id']?$row['user_id']:0?>" /></td>
  </tr>
  <tr>
    <td align="right">店铺名：</td>
    <td>&nbsp;<input name="shop_title" type="text" id="shop_title" value="<?=$row['shop_title']?>" /></td>
  </tr>
  <tr>
    <td align="right">掌柜logo：</td>
    <td>&nbsp;<input name="logo" type="text" id="logo" value="<?=$row['logo']?>" style="width:300px" /> <input class="sub" type="button" value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'logo','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">可直接添加网络地址</span></td>
  </tr>
  <tr>
    <td align="right">促销价格：</td>
    <td>&nbsp;<input name="promotion_price" type="text" id="promotion_price" value="<?=$row['promotion_price']?>" />&nbsp;没填的话显示上面的价格</td>
  </tr>
  <tr><td colspan="2"><hr/></td></tr>
  <tr>
    <td align="right">分类：</td>
    <td>&nbsp;<?=select($type,$row['cid']?$row['cid']:$_GET['cid'],'cid')?></td>
  </tr>
  <tr>
    <td align="right">精品推荐：</td>
    <td>&nbsp;<?=html_radio(array(1=>'推荐',0=>'不推荐'),$row['tuijian'],'tuijian')?>&nbsp;&nbsp;<span class="zhushi">选择推荐之后显示在列表页和详情页面的“精品推荐”里，显示排序最高的5个</span></td>
  </tr>
  <tr>
    <td align="right">佣金：</td>
    <td>&nbsp;<input name="commission" type="text" id="commission" class="required" num="y" value="<?=$row['commission']?>" />（是商品促销价后的佣金）</td>
  </tr>
  
  <tr>
    <td align="right">卖家信用：</td>
    <td>&nbsp;<?=select($credit,$row['credit'],'credit')?></td>
  </tr>
  
  <tr>
    <td align="right">促销类型：</td>
    <td>&nbsp;<input name="promotion_name" type="text" id="promotion_name" value="<?=$row['promotion_name']?>" />&nbsp;<span class="zhushi">4个字描述；例：今日特价</span></td>
  </tr>
  <tr>
    <td align="right">是否包邮：</td>
    <td>&nbsp;<?=html_radio($shifou_arr,$row['baoyou'],'baoyou')?></td>
  </tr>
  <tr>
    <td align="right">推广连接：</td>
    <td>&nbsp;<input name="click_url" type="text" id="click_url" value="<?=$row['click_url']?>" style="width:300px" /> <span class="zhushi">推广连接默认为空即可，前台程序会自动计算。如填写了推广连接，前台会根据后台所填写的推广地址直接跳转</span></td>
  </tr>
  
  <!--<tr>
    <td align="right">淘宝店铺id：</td>
    <td>&nbsp;<input name="shop_id" type="text" id="shop_id" value="<?=$row['shop_id']?$row['shop_id']:0?>" /></td>
  </tr>-->
  

  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?$row['sort']:0?>"  /> <span class="zhushi">数字越小越靠前,1为最小值</span></td>
  </tr>
  <?php if($_POST['sub']!=''){?>
  <tr>
    <td align="right">添加时间：</td>
    <td>&nbsp;<input name="addtime" type="text" id="addtime" value="<?=date('Y-m-d H:i:s',$row['addtime'])?>"  /></td>
  </tr>
  <?php }?>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>