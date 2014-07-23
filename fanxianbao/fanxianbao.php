<?php
include('header.php');
include '../comm/Taoapi.php';
include '../comm/ddTaoapi.class.php';
$tao_id_arr = include (DDROOT.'/data/tao_ids.php');
$virtual_cid=include (DDROOT.'/data/virtual_cid.php');

$ddTaoapi=new ddTaoapi;
$ddTaoapi->webset=$webset;

$url=$_GET['url'];
$uid=(int)$_GET['u']; 
$qkey=urldecode($_GET['qkey']);
$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;

if(is_url($url)==1){
	$is_url=1;
	$iid=(float)get_tao_id($url,$tao_id_arr);
	if(strpos($q,'tmall.com')!==false){
		$is_mall=1;
		$price_name='<b style="color:#a91029">天猫正品</b>';
	}
	if(strpos($q,'ju.taobao.com')!==false){
		$is_ju=1;
		$price_name='<img src="images/ju-icon.png" alt="聚划算" />';
	}
}
else{
    exit('url错误');
}
if($uid==0){
    exit('uid错误');
}

$dduser=$duoduo->select('user','id,ddusername as name,level','id="'.$uid.'"');

$data['iid']=$iid;
$data['outer_code']=$dduser['id'];
if($is_url==1){
	$data['all_get']=1; //商品没有返利也获取商品内容
}
$data['fields']='iid,detail_url,num_iid,title,nick,type,price,pic_url,shop_click_url,click_url,volume';
$the_goods=$ddTaoapi->items_detail_get($data,$url);
$the_goods['click_url']=spm($the_goods['click_url']);

if(strpos($qkey,'-tmall')!==false){
    $qkey=preg_replace('/-tmall(.*)/','',$qkey);
}

$Tapparams['keyword']=$the_goods['title']; 
$Tapparams['page_size']=$pagesize;
$Tapparams['outer_code']=$dduser['id'];
$Tapparams['seller']=1;
$Tapparams['total']=1;
$goods=$ddTaoapi->items_get($Tapparams);

//最多显示10页
if($goods['total']>$pagesize*10){
	$TotalResults=10*$pagesize;
}
else{
	$TotalResults=$goods['total'];
}

$goods=arr_diff($goods, array('total')); //因为返回的数组中包含个数total，需要去掉

$jssdk_items_convert['method']='taobao.taobaoke.widget.items.convert';
$jssdk_items_convert['outer_code']=(int)$dduser['id'];
$jssdk_items_convert['user_level']=(int)$dduser['level'];
$jssdk_items_convert['num_iids']=$the_goods['num_iid'];
$jssdk_items_convert['cid']=$the_goods['cid'];
$jssdk_items_convert['promotion_bl']=$the_goods['promotion_price']==0?1:$the_goods['promotion_price']/$the_goods['price'];
$jssdk_items_convert['tmall_fxje']=(float)$the_goods['tmall_fxje'];
$jssdk_items_convert['ju_fxje']=(float)$the_goods['ju_fxje'];
?>
<!DOCTYPE html PUBliC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta name="author" content="duoduo123.com" />
<TITLE>返现宝搜索结果 - 淘宝网购物返现</TITLE>
<script src="http://a.tbcdn.cn/apps/top/x/sdk.js?appkey=<?=$webset['taoapi']['jssdk_key']?>"></script>
<base href="http://<?=$_SERVER['HTTP_HOST'].URLMULU?>/" />
<LINK rel=stylesheet type=text/css href="fanxianbao/css/apisearch.css">
<?php
$js[]=TPLURL.'/js/jquery.js';
$js[]=TPLURL.'/js/fun.js';
$js[]='js/base64.js';
$js[]='js/fun.js';
$js[]='js/md5.js';
$js[]='js/jssdk.js';
echo js($js);
?>
</head>
<BODY topMargin=0>
<div class="right_pro" id="fanlibao" style="width:685px; margin:auto;">
<!--顶部-->
    <h4><span style="float:right; padding-right:10px;"><?php if($dduser['name']!=''){?>你所绑定的<?=WEBNICK?>账号<strong><?=$dduser['name']?></strong><?php }else{ ?>尚未<?=WEBNICK?>注册，请先<a href="<?=u('user','register')?>" target="blank">注册绑定</a>！否则无法自动返现！<?php } ?></span><strong>当前掌柜商品：</strong> (<?=$the_goods['nick']?>)</h4>
    <!--第一件商品开始-->
<?php if($the_goods['num_iid']>0){?>
<div class="right_sk">
	<h6><a href="<?=$the_goods['click_url']?>" target="_top"><?=$the_goods['title']?></a>
	</h6>
	<div class="pic"><a href="<?=$the_goods['click_url']?>" target="_top"><?=html_img($the_goods["pic_url"],1,$the_goods["name"])?></a>
	</div>
	<div class="icon_fan">
	</div>
    <?php if($the_goods['promotion_price']>0){?>
    <div class="right_price"><?=$the_goods['promotion_name']?>：<span><?=$the_goods['promotion_price']?></span>元<br />返现金：<span id="ddFxje">计算中</span>元</div>
    <?php }else{?>
	<div class="right_price"><?=$price_name?$price_name:'淘宝价'?>：<span><?=$the_goods['price']?></span>元<br />返现金：<span id="ddFxje">计算中</span>元</div>
    <?php }?>
	<div class="sk_submit"><a  target="_top" href="<?=$the_goods['click_url']?>&dduserid=<?=$uid?>">购物拿返现</a>
	</div>
</div>
<?php }else{?>
<!--第一件end-->
<!--如果没有推广商品显示页面-->
<div class="right_sk">
    <div class="right_no">
    对不起，此宝贝没有参加淘宝返现计划！<br><br>
    请查看该商品在其它商家的返现情况
    </div>
</div>
<?php }?>
<?php include(DDROOT.'/comm/jssdk.php');?>
<script>
function ddShowFxje(ddFxje){
	if(ddFxje>=0){
		$(".right_sk .right_price #ddFxje").html(ddFxje);
	}
}
<?php
if(in_array($jssdk_items_convert['cid'],$virtual_cid['goods'])){ //虚拟商品返利强制为0
	echo 'ddFxje=0;';
}
else{
	php2js_array($jssdk_items_convert,'parame');
	echo "taobaoTaobaokeWidgetItemsConvert(parame);";
}		
?>
</script>
<!--中间通长-->
<div class="othergood">
<!--其他相同商品-->
<div class="other_left"><strong>其它相同商品：</strong>还找到 <font><strong><?=$TotalResults?></strong></font> 件其它商家有返现的相同商品</div>
<!--END-->
<!--搜索开始-->
<!--搜索结束-->
<div style="clear:both"></div><!--清楚2边-->
</div>
<!--中间通长END-->
<p></p>
<!--列表1开始-->
<div style="width:680px; overflow:hidden;">

<?php if ($TotalResults==0){?>
  <div style="width:738px; height:100px; border:1px solid #ddd; line-height:30px; text-align:center; font-size:14px; color:#d00">没有找到相关的返现商品，请搜索下试试！</div>
<?php }else{foreach($goods as $row) {?>
  <ul>
	<li class="pic"><a href="<?=$row["jump"]?>" target="_blank"><?=html_img($row["pic_url"],1,$goods["name"])?></a></li>
	<li class="contain">
	<h6><a href="<?=$row["jump"]?>" target="_blank"><?=$row['title']?></a></h6>
	<div class="sx">掌柜：<a href="<?=$row["shop_click_url"]?>" target="_blank"><?=$row["nick"]?></a> <a target="_blank" href="http://amos1.taobao.com/msg.ww?v=2&uid=<?=$row["nick"]?>&s=2" ><img border="0" src="http://amos1.taobao.com/online.ww?v=2&uid=<?=$row["nick"]?>&s=2" align="middle" /></a></div>
	<div class="sx">　 区域：<?=$row['city']?></div><div class="sx">淘宝价：<span><?=$row['price']?></span> 元</div>
	<div  class="clear"></div>
 	<div class="sx">信誉：<img src="images/level_<?=$row["level"]?>.gif" />
 	</div>
 	<div class="sx">30天售：<?=$row["volume"]?> 件</div>
 	<div class="sx">返现金：<span><?=$row["fxje"]?></span> 元</div>
 	</li>
 	<li class="shop"><a href="<?=$row["jump"]?>&dduserid=<?=$uid?>" target="_blank">购物拿返现</a></li>
	</ul>
<?php }}?>
</div>
<!--列表1结束-->
<!--翻页开始-->
<div class="badoo"><?=pageft($TotalResults,$pagesize,"fanxianbao/fanxianbao.php?u=".$uid."&url=".urlencode($url)."&qkey=".urlencode($qkey));?></div>
<!--翻页结束-->
</div>
 </BODY></HTML>
<?php
$duoduo->close();
unset($duoduo);
unset($webset);
unset($Taoapi);
?>