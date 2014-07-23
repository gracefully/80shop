<?php
$weixin=dd_get_cache('plugin/weixin');
?>
<!DOCTYPE html PUBliC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="duoduo_v8.1(<?=BANBEN?>)" />
<?php if($webset['qq_meta']!=''){echo $webset['qq_meta']."\r\n";}?>
<?php if(is_file(DDROOT.'/data/title/'.$mod.'_'.$act.'.title.php')){?>
<?php include(DDROOT.'/data/title/'.$mod.'_'.$act.'.title.php');?>
<?php }else{?>
<title><?=TITLE?></title>
<meta name="keywords" content="<?php echo WEBNAME;?>" />
<meta name="description" content="<?php echo WEBNAME;?>" />
<?php }?>
<base href="<?=SITEURL?>/" />
<link rel="stylesheet" href="<?=PLUGIN_TPLURL?>css/weixin_css.css" />
</head>

<body>
<div class="wx-header">
	<div class="container">
		<div class="wx-logo clearfix"> <a href="<?=u('index')?>" class="ht logo"><img alt="<?=WEBNICK?>" src="<?=$weixin['logo']?>" width="136" height="55" /></a> <a href="<?=p(MOD,ACT)?>" class="ht logo-wx">官方微信介绍</a> </div>
		<a href="<?=u('index')?>" class="btn-back">返回首页</a> </div>
</div>
<div class="wx-body">
	<div class="container">
		<div class="wx-flag">
			<h2 class="ht">轻松一扫，无限精彩尽在掌中</h2>
		</div>
		<div class="wx-qrcode"> <img src="<?=$weixin['img']?>" alt="<?=WEBNICK?>官方微信二维码" width="245" height="245" /> </div>
		<div class="wx-info">
			<h4 class="t">关注方法：</h4>
			<p>打开微信 &gt; 朋友们 &gt; 添加朋友 &gt; 扫一扫</p>
			<p>或者直接搜索：<?=$weixin['user']?></p>
		</div>
	</div>
</div>
<div class="wx-follow">
	<div class="container">
		<h3 class="ht t">为什么关注我？<small>只推送给力休息，不会骚扰你</small></h3>
		<div class="wx-item">
			<p><img src="<?=PLUGIN_TPLURL?>images/img-1.png" alt="精选给力促销爆料" /></p>
			<h4>精选给力促销爆料</h4>
			<p>亚马逊200-100促销你错过了？关注<?=WEBNICK?>官方微信，我们只为你精选给力的促销爆料。</p>
		</div>
		<div class="wx-item">
			<p><img src="<?=PLUGIN_TPLURL?>images/img-2.png" alt="精致单品官方推荐" /></p>
			<h4>精致单品官方推荐</h4>
			<p>想知道最近什么流行吗？关注<?=WEBNICK?>官方微信，精致单品、创意宝贝，总有一款适合你。</p>
		</div>
		<div class="wx-item wx-item-last">
			<p><img src="<?=PLUGIN_TPLURL?>images/img-3.png" alt="<?=WEBNICK?>微信专属活动" /></p>
			<h4><?=WEBNICK?>微信专属活动</h4>
			<p>关注<?=WEBNICK?>官方微信即可参加只属于微信会员的专属活动，更有机会赢得缤纷豪礼。</p>
		</div>
		<div class="clear"></div>
		<div class="wx-footer">
			<p><?=$webset['banquan']?></p>
		</div>
	</div>
</div>
